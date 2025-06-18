<?php

namespace App\Services;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class HealthReportService
 * @package App\Services
 */
class HealthReportService
{
    public function generateHealthReport($company_id, $time_range, $params)
    {
        /**
         * Bảng báo cáo thống kê khám sức khỏe chia page
         **/
        // B1: Xử lý thông tin đầu vào của function
        [$from, $to] = explode('-', $time_range);
        $time = [
            'from' => Carbon::createFromFormat('d/m/Y', trim($from))->format('Y-m-d'),
            'to' => Carbon::createFromFormat('d/m/Y', trim($to))->format('Y-m-d'),
        ];

        // B2: Lấy tất cả các cột/ Danh sách Dịch vụ
        $services_list = $this->getHealthServicesList($company_id, $time['from'], $time['to']);
        $services_array = []; // Initialize an empty array

        foreach ($services_list as $service_item) {
            $service_type = $service_item["service_type"];

            // Check if the service_type already exists in the array
            if (!isset($services_array[$service_type])) {
                $services_array[$service_type] = []; // Initialize a new array for this service_type
            }

            // Add the service_code to the appropriate service_type array
            $services_array[$service_type][] = $service_item["service_code"];
        }

        // B3: Lấy chi tiết kết quả xét nghiệm cơ bản
        // ketquakham_Danhsachdakham_chitiet
        $detailed_examination_list = $this->DetailedExaminationList($company_id, $time['from'], $time['to'], $params);
        if ($detailed_examination_list->isEmpty()) {
            return ["services_list" => $services_list, "detailed_examination_list" => []];
        }

        // B4: Lấy chi tiết kết quả xét nghiệm của từng người khám
        foreach ($detailed_examination_list as $key => $detailed_examination_item) {
            $health_checkup_id = $detailed_examination_item['id'];
            foreach ($services_array as $key => $service_item) {
                switch ($key) {
                    case "1":
                        $get_health_checkup_details = $this->getHealthCheckupDetails($health_checkup_id, $service_item);
                        if (!empty($get_health_checkup_details)) {
                            foreach ($get_health_checkup_details as $key => $service_result) {
                                $detailed_examination_item[$key . "_" . $service_result->service_code] = $service_result->examination_results;
                            }
                        }
                        break;
                    case "2":
                        $get_test_details = $this->getTestDetails($health_checkup_id, $service_item);
                        if (!empty($get_test_details)) {
                            foreach ($get_test_details as $key => $service_result) {
                                $detailed_examination_item[$key . "_" . $service_result->service_code] = $service_result->results . " " . $service_result->unit;
                            }
                        }
                        break;
                    case "3":
                        $get_imaging_results = $this->getImagingResults($health_checkup_id, $service_item);
                        if (!empty($get_imaging_results)) {
                            foreach ($get_imaging_results as $key => $service_result) {
                                $detailed_examination_item[$key . "_" . $service_result->service_code] = $service_result->diag_imaging_result;
                            }
                        }
                        break;
                    default:
                        break;
                }
            }
        }
        return ["services_list" => $services_list, "detailed_examination_list" => $detailed_examination_list];
    }

    public function getHealthServicesList($company_id, $start_date, $end_date)
    {
        // Baocao_DangsacDVkham
        $medical_services_list = $this->getMedicalServicesList($company_id, $start_date, $end_date);
        $services_list = $this->addDatasetTable([], $medical_services_list, 1);
        // ketquakham_DanhsachDVxetnghiem
        $laboratory_test_list = $this->getLaboratoryTestingList($company_id, $start_date, $end_date);
        $services_list = $this->addDatasetTable($services_list, $laboratory_test_list, 2);
        // ketquakham_DanhsachDVchandoanhinhanh
        $diagnostic_imaging_services = $this->getDiagnosticImagingServices($company_id, $start_date, $end_date);

        $services_list = $this->addDatasetTable($services_list, $diagnostic_imaging_services, 3);
        return $services_list ?? [];
    }

    private function addDatasetTable($ds, $list, $service_type)
    {
        foreach ($list as $row) {
            $row->service_type = $service_type;
            $ds[] = (array) $row;
        }
        return $ds;
    }

    // ketquakham_DanhsachDVkham ~ Baocao_DangsacDVkham
    public function getMedicalServicesList($company_id, $start_date, $end_date)
    {
        // Step 1: Retrieve distinct medical services within the specified date range for a specific company
        $results = DB::table('tbl_customer')
            ->join('tbl_health_account', 'tbl_customer.id', '=', 'tbl_health_account.customer_id')
            ->join('tbl_health_checkup_information', 'tbl_health_account.id', '=', 'tbl_health_checkup_information.health_account_id')
            ->join('tbl_hospital', 'tbl_health_checkup_information.hospital_id', '=', 'tbl_hospital.id')
            ->join('tbl_information_insurance', 'tbl_customer.id', '=', 'tbl_information_insurance.customer_id')
            ->join('tbl_province', 'tbl_customer.province_id', '=', 'tbl_province.id')
            ->join('tbl_company', 'tbl_province.id', '=', 'tbl_company.province_id')
            ->join('tbl_health_reports', 'tbl_health_checkup_information.id', '=', 'tbl_health_reports.health_checkup_information_id')
            ->join('tbl_specialty', 'tbl_health_reports.specialty_id', '=', 'tbl_specialty.id')
            ->where('tbl_information_insurance.active', 1)
            ->where('tbl_health_checkup_information.active', 1)
            ->where('tbl_company.id', $company_id)
            ->whereBetween(DB::raw("CONVERT(datetime, CONVERT(nvarchar(11), tbl_health_checkup_information.checkup_date), 102)"), [
                DB::raw("CONVERT(datetime, CONVERT(nvarchar(11), '$start_date'), 102)"),
                DB::raw("CONVERT(datetime, CONVERT(nvarchar(11), '$end_date'), 102)"),
            ])
            ->select(
                'tbl_specialty.id as service_code',
                'tbl_specialty.specialty_name as service_name'
            )
            ->distinct()
            ->get();
        return $results;
    }

    // ketquakham_DanhsachDVxetnghiem ~ Baocao_DangsacDVxetnghiem
    public function getLaboratoryTestingList($company_id, $start_date, $end_date)
    {
        // Step 1: Retrieve distinct laboratory services (test details) within the specified date range for a specific company
        $results = DB::table('tbl_customer')
            ->join('tbl_health_account', 'tbl_customer.id', '=', 'tbl_health_account.customer_id')
            ->join('tbl_health_checkup_information', 'tbl_health_account.id', '=', 'tbl_health_checkup_information.health_account_id')
            ->join('tbl_hospital', 'tbl_health_checkup_information.hospital_id', '=', 'tbl_hospital.id')
            ->join('tbl_information_insurance', 'tbl_customer.id', '=', 'tbl_information_insurance.customer_id')
            ->join('tbl_province', 'tbl_customer.province_id', '=', 'tbl_province.id')
            ->join('tbl_company', 'tbl_province.id', '=', 'tbl_company.province_id')
            ->join('tbl_test_results_detail', 'tbl_health_checkup_information.id', '=', 'tbl_test_results_detail.health_checkup_information_id')
            ->join('tbl_test_detail', 'tbl_test_results_detail.test_detail_id', '=', 'tbl_test_detail.id')
            ->join('tbl_test_catalogue', 'tbl_test_detail.test_catalogue_id', '=', 'tbl_test_catalogue.id')
            ->where('tbl_information_insurance.active', 1)
            ->where('tbl_health_checkup_information.active', 1)
            ->where('tbl_company.id', $company_id)
            ->whereBetween(DB::raw("CONVERT(datetime, CONVERT(nvarchar(11), tbl_health_checkup_information.checkup_date), 102)"), [
                DB::raw("CONVERT(datetime, CONVERT(nvarchar(11), '$start_date'), 102)"),
                DB::raw("CONVERT(datetime, CONVERT(nvarchar(11), '$end_date'), 102)"),
            ])
            ->select(
                'tbl_test_detail.id as service_code',
                DB::raw('tbl_test_detail.test_detail_name + CHAR(13) + tbl_test_detail.normal_index as service_name'),
                'tbl_test_catalogue.id'
            )
            ->distinct()
            ->orderBy('tbl_test_catalogue.id')
            ->get();

        return $results;
    }

    // ketquakham_DanhsachDVchandoanhinhanh ~ Baocao_DangsacDV_chandoanhinhanh
    public function getDiagnosticImagingServices($company_id, $start_date, $end_date)
    {
        // Step 1: Retrieve distinct diagnostic imaging services within the specified date range for a specific company
        $results = DB::select(
            "
                SELECT DISTINCT
                    tbl_diag_imaging_category.diag_imaging_name AS service_name,
                    tbl_diag_imaging_category.id AS service_code,
                    tbl_diag_imaging_class.id
                FROM tbl_diag_imaging_result_detail
                INNER JOIN tbl_diag_imaging_category
                    ON tbl_diag_imaging_result_detail.diag_imaging_category_id = tbl_diag_imaging_category.id
                INNER JOIN tbl_health_checkup_information
                    ON tbl_diag_imaging_result_detail.health_checkup_information_id = tbl_health_checkup_information.id
                INNER JOIN tbl_health_account
                    ON tbl_health_checkup_information.health_account_id = tbl_health_account.id
                INNER JOIN tbl_customer
                    ON tbl_health_account.customer_id = tbl_customer.id
                INNER JOIN tbl_hospital
                    ON tbl_health_checkup_information.hospital_id = tbl_hospital.id
                INNER JOIN tbl_information_insurance
                    ON tbl_customer.id = tbl_information_insurance.customer_id
                INNER JOIN tbl_province
                    ON tbl_customer.province_id = tbl_province.id
                INNER JOIN tbl_company
                    ON tbl_province.id = tbl_company.province_id
                INNER JOIN tbl_diag_imaging_class
                    ON tbl_diag_imaging_category.diag_imaging_class_id = tbl_diag_imaging_class.id
                WHERE tbl_information_insurance.active = 1
                    AND tbl_health_checkup_information.active = 1
                    AND tbl_company.id = :company_id
                    AND CONVERT(
                        datetime,
                        CONVERT(nvarchar(11), tbl_health_checkup_information.checkup_date, 102),
                        102
                    ) BETWEEN CONVERT(
                        datetime,
                        CONVERT(nvarchar(11), :start_date, 102),
                        102
                    ) AND CONVERT(
                        datetime,
                        CONVERT(nvarchar(11), :end_date, 102),
                        102
                    )
                ORDER BY tbl_diag_imaging_class.id
            ",
            [
                'company_id' => $company_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]
        );
        return $results;
    }

    // ketquakham_Danhsachdakham_chitiet
    public function DetailedExaminationList($company_id, $start_date, $end_date, $params)
    {
        $results = Customer::select([
            'tbl_information_insurance.card_number',
            'tbl_customer.full_name',
            DB::raw('YEAR(tbl_customer.birth_year) AS birth_year'),
            'tbl_customer.gender',
            DB::raw("FORMAT(tbl_health_checkup_information.checkup_date, 'dd/MM/yyyy') AS examination_date"),
            'tbl_health_checkup_information.id',
            'tbl_hospital.hospital_name',
            'tbl_family_status.single',
            'tbl_family_status.married',
            'tbl_family_status.divorced',
            'tbl_health_checkup_information.height',
            'tbl_health_checkup_information.weight',
            'tbl_health_checkup_information.blood_pressure',
            'tbl_health_checkup_information.respiration_rate',
            'tbl_health_checkup_information.chest_circumference',
            'tbl_health_checkup_information.bmi',
            'tbl_health_checkup_information.disease_code',
            'tbl_health_checkup_information.disease_name',
            'tbl_health_checkup_information.solution_direction',
            'tbl_health_checkup_information.health_type',
            'tbl_customer_type.type_name',
        ])
            ->distinct()
            ->join('tbl_health_account', 'tbl_customer.id', '=', 'tbl_health_account.customer_id')
            ->join('tbl_health_checkup_information', 'tbl_health_account.id', '=', 'tbl_health_checkup_information.health_account_id')
            ->join('tbl_hospital', 'tbl_health_checkup_information.hospital_id', '=', 'tbl_hospital.id')
            ->join('tbl_information_insurance', 'tbl_customer.id', '=', 'tbl_information_insurance.customer_id')
            ->join('tbl_province', 'tbl_customer.province_id', '=', 'tbl_province.id')
            ->join('tbl_company', 'tbl_province.id', '=', 'tbl_company.province_id')
            ->join('tbl_family_status', 'tbl_health_account.family_status_id', '=', 'tbl_family_status.id')
            ->join('tbl_customer_type', 'tbl_customer.customer_type_id', '=', 'tbl_customer_type.id')
            ->where('tbl_information_insurance.active', 1)
            ->where('tbl_health_checkup_information.active', 1)
            ->where('tbl_company.id', $company_id)
            ->whereBetween(DB::raw("CONVERT(datetime, CONVERT(nvarchar(11), tbl_health_checkup_information.checkup_date), 102)"), [
                DB::raw("CONVERT(datetime, CONVERT(nvarchar(11), '{$start_date}'), 102)"),
                DB::raw("CONVERT(datetime, CONVERT(nvarchar(11), '{$end_date}'), 102)"),
            ])
            ->where('tbl_customer_type.active', 1)
            ->orderBy('tbl_customer.full_name')
            ->orderBy('examination_date')
            ->paginate(PER_PAGE_SMALL)
            ->setPath(route('healthReport.index', $params));

        return $results;
    }

    function getHealthCheckupDetails($health_checkup_information_id, $service_codes)
    {
        $results = DB::table('tbl_health_checkup_information')
            ->distinct()
            ->select('tbl_health_reports.specialty_id as service_code', 'tbl_health_reports.examination_conclusion', 'tbl_health_reports.examination_results')
            ->join('tbl_health_reports', 'tbl_health_checkup_information.id', '=', 'tbl_health_reports.health_checkup_information_id')
            ->where('tbl_health_checkup_information.id', $health_checkup_information_id)
            ->whereIn('tbl_health_reports.specialty_id', $service_codes) // Using whereIn for an array of service codes
            ->where('tbl_health_reports.active', 1)
            ->get();

        return $results;
    }

    function getTestDetails($health_checkup_information_id, $service_codes)
    {
        $results = DB::table('tbl_health_checkup_information')
            ->distinct()
            ->select('tbl_test_results_detail.test_detail_id as service_code', 'tbl_health_checkup_information.id', 'tbl_test_detail.unit', 'tbl_test_results_detail.results')
            ->join('tbl_test_results_detail', 'tbl_health_checkup_information.id', '=', 'tbl_test_results_detail.health_checkup_information_id')
            ->join('tbl_test_detail', 'tbl_test_results_detail.test_detail_id', '=', 'tbl_test_detail.id')
            ->where('tbl_health_checkup_information.id', $health_checkup_information_id)
            ->whereIn('tbl_test_results_detail.test_detail_id', $service_codes) // Using whereIn for an array of service codes
            ->where('tbl_test_results_detail.active', 1)
            ->get();

        return $results;
    }

    function getImagingResults($health_checkup_information_id, $service_codes)
    {
        $results = DB::table('tbl_health_checkup_information')
            ->distinct()
            ->select('tbl_diag_imaging_result_detail.diag_imaging_category_id as service_code', 'tbl_health_checkup_information.id', 'tbl_diag_imaging_result_detail.diag_imaging_result')
            ->join('tbl_diag_imaging_result_detail', 'tbl_health_checkup_information.id', '=', 'tbl_diag_imaging_result_detail.health_checkup_information_id')
            ->join('tbl_diag_imaging_category', 'tbl_diag_imaging_result_detail.diag_imaging_category_id', '=', 'tbl_diag_imaging_category.id')
            ->where('tbl_health_checkup_information.id', $health_checkup_information_id)
            ->whereIn('tbl_diag_imaging_result_detail.diag_imaging_category_id', $service_codes) // Using whereIn for an array of service codes
            ->where('tbl_diag_imaging_result_detail.active', 1)
            ->get();

        return $results;
    }
}

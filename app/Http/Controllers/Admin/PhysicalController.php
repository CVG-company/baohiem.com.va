<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CompanyService;
use App\Services\ContractService;
use App\Services\HealthReportService;
use App\Services\PeriodService;
use App\Services\PhysicalService;
use Illuminate\Http\Request;

class PhysicalController extends Controller
{
    protected $companyService;
    protected $periodService;
    protected $contractService;
    protected $physicalService;
    protected $healthReportService;

    public function __construct(
        CompanyService $companyService,
        PeriodService $periodService,
        ContractService $contractService,
        PhysicalService $physicalService,
        HealthReportService $healthReportService,
    ) {
        $this->companyService = $companyService;
        $this->periodService = $periodService;
        $this->contractService = $contractService;
        $this->physicalService = $physicalService;
        $this->healthReportService = $healthReportService;
    }
    // Xong view thống kê
    public function index(Request $request)
    {
        $params = $request->query();
        // Lấy danh sách công ty
        $companyList = $this->companyService->getCompanyByContract();

        // Lấy danh sách niên hạn
        if (!isset($params['company'])) {
            $params['company'] = $companyList->first()->id;
        }
        $periodList = $this->periodService->getPeriodActiveByCompany($params['company']);
        // Lấy danh sách hợp đồng
        if (!isset($params['period'])) {
            $params['period'] = $periodList->first()->id;
        }
        $contractList = $this->contractService->getContractByPeriod($params['period']);
        if (!isset($params['contract'])) {
            $params['contract'] = $contractList->first()->id;
        }

        //Khoảng thời gian kiểm tra
        if (!isset($params['time_range'])) {
            $params['time_range'] = date('01/01/Y') . ' - ' . date('d/m/Y');
        }

        $physicalList = !isset($params['date_added'])
            ? $this->physicalService->getPhysical($companyList->first()->id, $params['time_range'], $params)
            : $this->physicalService->getPhysicalDateAdded($companyList->first()->id, $params['time_range'], $params);

        return view('admin.physical.index', compact(['companyList', 'periodList', 'contractList', 'physicalList']));
    }

    // Khamsuckhoedinhky.aspx
    public function periodic(Request $request)
    {
        $params = $request->query();
        $companyList = $this->companyService->getCompanyByContract();
        if (!isset($params['company'])) {
            $params['company'] = $companyList->first()->id;
        }
        $periodList = $this->periodService->getPeriodActiveByCompany($params['company']);
        if (!isset($params['period'])) {
            $params['period'] = $periodList->first()->id;
        }
        $contractList = $this->contractService->getContractByPeriod($params['period']);
        if (!isset($params['contract'])) {
            $params['contract'] = $contractList->first()->id;
        }

        if (!isset($params['keyword'])) {
            $params['keyword'] = "";
        }
        $physicalList = [];
        // Kiểm tra thực hiện search hay load
        if (isset($params['submit']) and $params['submit'] == "search") {
            $keyword = trim($params['keyword']);
            if ($keyword != "") {
                if (strlen($keyword) > 5) {
                    $physicalList = $this->physicalService->getPeriodicPhysical($keyword, $params) ?? [];
                } else {
                    echo "<script>alert('Thông tin tìm kiếm có ít nhất 6 ký tự!');</script>";
                }
            } else {
                echo "<script>alert('Vui lòng nhập thông tin tìm kiếm!');</script>";
            }
        } else {
            $physicalList = $this->physicalService->show_customer($params['contract']) ?? [];
        }
        // Cưu long joc 2 -20067
        // Cưu long joc 2 (o) -20058
        // truong son - 20059
        // pvfcco - 49
        // talisman -20066
        // gas south - 20068
        return view('admin.physical.periodic', compact(['companyList', 'periodList', 'contractList', 'physicalList']));
    }
    public function detail()
    {
        return view('admin.physical.detail');
    }
    // baocaokhamsuckhoe.aspx
    public function healthReport(Request $request)
    {
        $params = $request->query();
        $companyList = $this->companyService->getCompanyByContract();
        if (!isset($params['company'])) {
            $params['company'] = $companyList->first()->id;
        }
        $periodList = $this->periodService->getPeriodActiveByCompany($params['company']);
        if (!isset($params['period'])) {
            $params['period'] = $periodList->first()->id;
        }
        $contractList = $this->contractService->getContractByPeriod($params['period']);
        if (!isset($params['contract'])) {
            $params['contract'] = $contractList->first()->id;
        }
        if (!isset($params['time_range'])) {
            $params['time_range'] = date('01/01/Y') . ' - ' . date('d/m/Y');
        }
        $healthReportList = $this->healthReportService->generateHealthReport($companyList->first()->id, $params['time_range'], $params);
        return view('admin.physical.health_report', compact(['healthReportList', 'companyList', 'periodList', 'contractList']));
    }
}

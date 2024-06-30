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
    public function index(Request $request)
    {
        $params = $request->query();
        // Lấy danh sách công ty
        $companyList = $this->companyService->getCompanyActiveSortByOrder();

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

        //Khoảng thời gian kiểm tra
        if (!isset($params['time_range'])) {
            $params['time_range'] = date('01/01/Y') . ' - ' . date('d/m/Y');
        }
        if (!isset($params['checkup_date'])) {
            $physicalList = $this->physicalService->getPhysicalDateAdded($companyList->first()->id, $params['time_range'], $params);
        } else {
            $physicalList = $this->physicalService->getPhysical($companyList->first()->id, $params['time_range'], $params);
        }

        return view('admin.physical.index', compact(['companyList', 'periodList', 'contractList', 'physicalList']));
    }
    public function detail()
    {
        return view('admin.physical.detail');
    }
    public function periodic(Request $request)
    {
        $params = $request->query();
        if (!isset($params['time_range'])) {
            $params['time_range'] = date('01/01/Y') . ' - ' . date('d/m/Y');
        }
        $companyList = $this->companyService->getCompanyActiveSortByOrder();
        $periodList = $this->periodService->getPeriodActiveByCompany($companyList->first()->id);
        $contractList = $this->contractService->getContractByPeriod($periodList->first()->id);
        $physicalList = $this->physicalService->getPhysical($companyList->first()->id, $params['time_range'], $params);
        return view('admin.physical.periodic', compact(['companyList', 'periodList', 'contractList', 'physicalList']));
    }
    public function healthReport(Request $request)
    {
        $params = $request->query();
        if (!isset($params['time_range'])) {
            $params['time_range'] = date('01/01/Y') . ' - ' . date('d/m/Y');
        }
        $companyList = $this->companyService->getCompanyActiveSortByOrder();
        $periodList = $this->periodService->getPeriodActiveByCompany($companyList->first()->id);
        $contractList = $this->contractService->getContractByPeriod($periodList->first()->id);
        $healthReportList = $this->healthReportService->getHealthReportList($companyList->first()->id, $params['time_range'], $params);
        return view('admin.physical.health_report', compact(['healthReportList', 'companyList', 'periodList', 'contractList']));
    }
}

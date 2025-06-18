<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Services\DiaryService;
use App\Services\HospitalService;
use App\Services\UserHospitalService;
use App\Services\CustomerService;
use App\Services\CompanyService;
use App\Services\ContractService;
use App\Services\PeriodService;
use App\Services\DepartmentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    
    protected $diaryService;
    protected $userHospitalService;
    protected $customerService;
    protected $companyService;
    protected $periodService;
    protected $contractService;
    protected $departmentService;
    protected $hospitalService;

    public function __construct(
        HospitalService $hospitalService,
        DiaryService $diaryService,
        CustomerService $customerService,
        CompanyService $companyService, 
        PeriodService $periodService, 
        ContractService $contractService,
        DepartmentService $departmentService,
    ) {
        $this->hospitalService = $hospitalService;
        $this->diaryService = $diaryService;
        $this->customerService = $customerService;
        $this->periodService = $periodService;
        $this->contractService = $contractService;
        $this->companyService = $companyService;
        $this->departmentService = $departmentService;
    }
  
    public function employeeDiary(){
        $employeeDiaryList = $this->diaryService->getEmployeeDiary();
        $departmentList = $this->departmentService->getActiveDepartments();
        $userListByDepartment = $this->departmentService->getUserByDepartments($departmentList->first()->id);
        
        return view('admin.diary.employee', compact(['employeeDiaryList', 'departmentList', 'userListByDepartment']));
    }
  
    public function hospitalDiary(){
        $hospitalList = $this->hospitalService->getHospital();

        $hospitalDiaryList = $this->diaryService->getHospitalDiary();
        return view('admin.diary.hospital', compact(['hospitalDiaryList', 'hospitalList']));
    }
  
    public function customerDiary(Request $request){
        $params = $request->query();
        if (!isset($params['time_range'])) {
            $params['time_range'] = date('01/01/Y') . ' - ' . date('d/m/Y');
        }
        $params = $request->query();
        $companyList = $this->companyService->getCompanyByContract();

        // Lấy danh sách niên hạn
        if (!isset($params['company'])) {
            $params['company'] = $companyList->first()->id;
        }
        $periodList = $this->periodService->getPeriodActiveByCompany($params['company']);

        // Lấy danh sách hợp đồng
        if (!isset($params['period'])) {
            $params['period'] = $periodList->first() ? $periodList->first()->id : 0;
        }
        $contractList = $this->contractService->getContractByPeriod($params['period']);
        if (!isset($params['contract'])) {
            $params['contract'] = $contractList->first() ? $contractList->first()->id : 0;
        }
        $customerDiaryList = $this->diaryService->getCustomerDiary();
        return view('admin.diary.customer',compact(['customerDiaryList', 'companyList', 'periodList', 'contractList']));
    }
}

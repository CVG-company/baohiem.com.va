<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CustomerGroupService;
use App\Services\CompanyService;
use App\Services\ContractService;
use App\Services\CustomerService;
use App\Services\PeriodService;
use App\Services\AccountService;
use App\Services\VaccinationClassificationService;
use App\Services\VaccinationService;
use App\Services\VaccinationScheduleService;
use App\Services\HospitalService;
use App\Services\InsuranceExpensesService;
use App\Services\PaymentTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InsuranceExpensesController extends Controller
{
    protected $customerGroupService;
    protected $companyService;
    protected $periodService;
    protected $contractService;
    protected $accountService;
    protected $customerService;
    protected $hospitalService;
    protected $paymentTypeService;
    protected $insuranceExpensesService;
    protected $vaccinationClassificationService;
    protected $vaccinationService;
    protected $vaccinationScheduleService;

    public function __construct(CompanyService $companyService, PeriodService $periodService, ContractService $contractService, CustomerGroupService $customerGroupService, CustomerService $customerService, AccountService $accountService, HospitalService $hospitalService, PaymentTypeService $paymentTypeService, InsuranceExpensesService $insuranceExpensesService, VaccinationClassificationService $vaccinationClassificationService, VaccinationService $vaccinationService, VaccinationScheduleService $vaccinationScheduleService)
    {
        $this->customerGroupService = $customerGroupService;
        $this->companyService = $companyService;
        $this->periodService = $periodService;
        $this->contractService = $contractService;
        $this->customerService = $customerService;
        $this->accountService = $accountService;
        $this->hospitalService = $hospitalService;
        $this->paymentTypeService = $paymentTypeService;
        $this->insuranceExpensesService = $insuranceExpensesService;
        $this->vaccinationClassificationService = $vaccinationClassificationService;
        $this->vaccinationService = $vaccinationService;
        $this->vaccinationScheduleService = $vaccinationScheduleService;
    }

    public function index(Request $request)
    {
        $data = $this->prepareData($request);
        $params = $request->query();
        $hospitalList = $this->hospitalService->getHospital();
        $paymentTypeList = $this->paymentTypeService->getPaymentTypeList();
        $accountList = isset($params['keyword']) && !empty($params['keyword']) ? $this->customerService->getCustomerByKeyword($params) : [];
        return view('admin.insurance-expenses.index', array_merge($data, compact(['accountList', 'hospitalList', 'paymentTypeList'])));
    }

    public function detail(Request $request)
    {
        $params = $request->query();
        $customer = $this->customerService->getCustomerByCustomerId($params['id'], $params['periodId']);
        $customerPay = $this->customerService->getListCustomersPayForInsuranceByCustomerId($params['id']);
        $amountSpent = $this->customerService->getMoneyAmountSpent($params['id'], $params['periodId']);
        $paymentTypeList = $this->paymentTypeService->getPaymentTypeList();
        $vaccinationClassificationList = $this->vaccinationClassificationService->getActiveClassifications();
        $vaccinationList = $this->vaccinationService->getVaccinationByClassification($vaccinationClassificationList->first() ? $vaccinationClassificationList->first()->id : 0);

        $vaccinationScheduleList = $this->vaccinationScheduleService->getVaccinationScheduleByVaccinationIdAndCustomerId($vaccinationList->first() ? $vaccinationList->first()->id : 0, $params['id']);

        $hospitalList = $this->hospitalService->getHospital();

        if ($request->isMethod('post')) {
            $params = $request->post();
            $check = $this->insuranceExpensesService->InsuranceExpensesInsert($params);
            if ($check) {
                $this->saveLog(Auth::user()->id, 'Thêm chi trả thành công.');
                return redirect()->back()->with('success', 'Thêm chi trả thành công.');
            } else {
                $this->saveLog(Auth::user()->id, 'Thêm chi trả thất bại.');
                return redirect()->back()->with('error', 'Thêm chi trả thất bại.');
            }
        }
        return view('admin.insurance-expenses.detail', compact(['customer', 'customerPay', 'amountSpent', 'hospitalList', 'paymentTypeList', 'vaccinationClassificationList', 'vaccinationList', 'vaccinationScheduleList']));
    }

    public function create(Request $request)
    {
        $params = $request->query();
        $customer = $this->customerService->getCustomerByCustomerId($params['id'], $params['periodId']);
        $customerPay = $this->customerService->getListCustomersPayForInsuranceByCustomerId($params['id']);
        $amountSpent = $this->customerService->getMoneyAmountSpent($params['id'], $params['periodId']);
        $paymentTypeList = $this->paymentTypeService->getPaymentTypeList();
        $vaccinationClassificationList = $this->vaccinationClassificationService->getActiveClassifications();
        $vaccinationList = $this->vaccinationService->getVaccinationByClassification($vaccinationClassificationList->first() ? $vaccinationClassificationList->first()->id : 0);
        $vaccinationScheduleList = $this->vaccinationScheduleService->getVaccinationScheduleByVaccinationIdAndCustomerId($vaccinationList->first() ? $vaccinationList->first()->id : 0, $params['id']);
        $hospitalList = $this->hospitalService->getHospital();
        if ($request->isMethod('post')) {
            $params = $request->post();
            $check = $this->insuranceExpensesService->InsuranceExpensesInsert($params);
            if ($check) {
                $this->saveLog(Auth::user()->id, 'Thêm chi trả thành công.');
                return redirect()->back()->with('success', 'Thêm chi trả thành công.');
            } else {
                $this->saveLog(Auth::user()->id, 'Thêm chi trả thất bại.');
                return redirect()->back()->with('error', 'Thêm chi trả thất bại.');
            }
        }
        return view('admin.insurance-expenses.create', compact(['customer', 'customerPay', 'amountSpent', 'hospitalList', 'paymentTypeList', 'vaccinationClassificationList', 'vaccinationList', 'vaccinationScheduleList']));
    }

    public function update(Request $request)
    {
        $params = $request->query();
        $customer = $this->customerService->getCustomerByCustomerId($params['id'], $params['periodId']);
        $customerPay = $this->customerService->getListCustomersPayForInsuranceByCustomerId($params['id']);
        $amountSpent = $this->customerService->getMoneyAmountSpent($params['id'], $params['periodId']);
        $paymentTypeList = $this->paymentTypeService->getPaymentTypeList();
        $hospitalList = $this->hospitalService->getHospital();
        return view('admin.insurance-expenses.detail', compact(['customer', 'customerPay', 'amountSpent', 'hospitalList', 'paymentTypeList']));
    }

    public function insuranceDay(Request $request)
    {
        $data = $this->prepareData($request);
        return view('admin.insurance-expenses.insurance-day', $data);
    }

    public function insuranceHospital(Request $request)
    {
        $data = $this->prepareData($request);
        // Khai code đầu xuân
        $hospitalList = $this->hospitalService->getHospital();
        return view('admin.insurance-expenses.insurance-hospital', $data, compact(['hospitalList']));
    }

    public function insuranceDiary(Request $request)
    {
        $data = $this->prepareData($request);
        return view('admin.insurance-expenses.insurance-diary', $data);
    }

    public function checkPeriod(Request $request)
    {
        $params = $request->query();
        $account_detail_id = DB::table('tbl_account_detail')
            ->where('active', 1)
            ->where('customer_id', $params['customer_id'])
            ->max('id');
        $time_end = $this->insuranceExpensesService->getTimeEnd($params, $account_detail_id);
        if (strtotime($params['payment_date']) > strtotime($time_end)) {
            return ['message' => 'Ngày chi không đúng. Vui lòng kiểm tra lại thông tin!', 'status' => 0];
        } else {
            return ['status' => 1];
        }
    }

    private function prepareData(Request $request)
    {
        $params = $request->query();
        $customerGroupList = $this->customerGroupService->getCustomerGroupActive();
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
        $contractDetail = $this->contractService->getContractDetail($params['contract']);

        // Trả về một mảng chứa dữ liệu đã chuẩn bị
        return compact('customerGroupList', 'companyList', 'periodList', 'contractList', 'contractDetail');
    }
}

<?php

namespace App\Services;

use App\Models\PaymentDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class InsuranceExpensesService
 * @package App\Services
 */
class InsuranceExpensesService
{
    // KhachhangChiBH_loadtheomachitiet
    public function getInsuranceDetail($detailId)
    {
        $results = DB::table('tbl_customer')
            ->select(
                'tbl_customer.id',
                'tbl_customer.full_name',
                'tbl_customer.images',
                'tbl_customer.folder',
                'tbl_customer.birth_year',
                'tbl_customer.address',
                'tbl_customer.identity_card_number',
                'tbl_customer.issue_date',
                'tbl_customer.issue_place',
                'tbl_customer.contact_phone',
                'tbl_customer.email',
                'tbl_customer.gender',
                'tbl_customer.images',
                'tbl_information_insurance.card_number',
                'tbl_contract.effective_time',
                'tbl_contract.end_time',
                'tbl_account_package.package_price',
                'tbl_account_package.package_name',
                'tbl_customer_group.group_name',
                'tbl_contract.id as contract_id',
                'tbl_account_detail.account_holder',
                'tbl_contract.contract_name',
                'tbl_period.period_name',
                'tbl_company.company_name',
                'tbl_account.active',
                'tbl_payment_detail.amount_paid',
                DB::raw("convert(nvarchar, tbl_payment_detail.payment_date, 103) as payment_date"),
                DB::raw("convert(nvarchar, tbl_payment_detail.examination_date, 103) as examination_date"),
                'tbl_payment_detail.id as payment_detail_id',
                'tbl_customer.locked',
                'tbl_payment_detail.note',
                'tbl_payment_detail.approved',
                'tbl_payment_detail.hospital_id',
                'tbl_hospital.hospital_name',
                'tbl_payment_detail.payment_type_id',
                'tbl_payment_type.payment_type_name',
                'tbl_payment_detail.expected_payment',
                'tbl_payment_detail.rejected_amount'
            )
            ->distinct()
            ->join('tbl_information_insurance', 'tbl_customer.id', '=', 'tbl_information_insurance.customer_id')
            ->join('tbl_account_detail', 'tbl_customer.id', '=', 'tbl_account_detail.customer_id')
            ->join('tbl_account', 'tbl_account_detail.account_id', '=', 'tbl_account.id')
            ->join('tbl_account_package', 'tbl_account.account_package_id', '=', 'tbl_account_package.id')
            ->join('tbl_contract', 'tbl_account.contract_id', '=', 'tbl_contract.id')
            ->join('tbl_payment_detail', 'tbl_payment_detail.account_detail_id', '=', 'tbl_account_detail.id')
            ->join('tbl_customer_group', 'tbl_customer_group.id', '=', 'tbl_customer.customer_group_id')
            ->join('tbl_hospital', 'tbl_payment_detail.hospital_id', '=', 'tbl_hospital.id')
            ->join('tbl_period_detail', 'tbl_contract.period_id', '=', 'tbl_period_detail.id')
            ->join('tbl_company', 'tbl_period_detail.company_id', '=', 'tbl_company.id')
            ->join('tbl_period', 'tbl_period_detail.period_id', '=', 'tbl_period.id')
            ->join('tbl_payment_type', 'tbl_payment_detail.payment_type_id', '=', 'tbl_payment_type.id')
            ->where('tbl_payment_detail.id', '=', $detailId)
            ->first();

        return $results;
    }

    // KhachhangChiBH_Insert
    // Chibaohiem_insert
    public function InsuranceExpensesInsert($params)
    {
        try {
            DB::beginTransaction();

            $insertBatch = [];
            foreach ($params['payment_type_id'] as $key => $value) {
                $insertBatch[] = [
                    'payment_type_id' => $value,
                    'amount_paid' => (int)str_replace('.', '', $params['amount_paid'][$key]),
                    'expected_payment' => (int)str_replace('.', '', $params['expected_payment'][$key]),
                    'rejected_amount' => (int)str_replace('.', '', $params['rejected_amount'][$key]),
                    'note' => (string)$params['note'][$key],
                ];
            }

            $account_detail_id = DB::table('tbl_account_detail')
                ->where('active', 1)
                ->where('customer_id', $params['customer_id'])
                ->max('id');

            $time_end = $this->getTimeEnd($params, $account_detail_id);

            if (strtotime($params['payment_date']) <= strtotime($time_end)) {
                foreach ($insertBatch as $key => $value) {
                    PaymentDetail::create([
                        'user_id' => Auth::user()->id,
                        'account_detail_id' => $account_detail_id,
                        'hospital_id' => $params['hospital'],
                        'amount_paid' => $value['amount_paid'],
                        'note' => $value['note'],
                        'approved' => 1,
                        'payment_type_id' => $value['payment_type_id'],
                        'expected_payment' => $value['expected_payment'],
                        'rejected_amount' => $value['rejected_amount'],
                        'vaccine_result_code' => 0,
                        'payment_date' => Carbon::createFromFormat('d/m/Y', $params['payment_date'])->format('Y-m-d H:i:s'),
                        'examination_date' => Carbon::createFromFormat('d/m/Y', $params['checkup_date'])->format('Y-m-d H:i:s'),

                    ]);
                }

                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function getTimeEnd($params, $account_detail_id)
    {
        $account_id = DB::table('tbl_account_detail')->where('active', 1)->where('id', $account_detail_id)->max('account_id');

        return DB::table('tbl_contract')
            ->join('tbl_period_detail', 'tbl_contract.period_id', '=', 'tbl_period_detail.id')
            ->join('tbl_package_detail', 'tbl_period_detail.period_id', '=', 'tbl_package_detail.period_id')
            ->join('tbl_account_detail_detail', 'tbl_package_detail.id', '=', 'tbl_account_detail_detail.package_detail_id')
            ->where('tbl_account_detail_detail.account_id', $account_id)
            ->where('tbl_period_detail.period_id', $params['period_id'])
            ->where('tbl_contract.id', $params['contract_id'])
            ->value('tbl_contract.end_time');
    }

    // KhachhangChiBH_UPDATE
    public function updateInsuranceExpense(array $params, $paymentDetailId = 0)
    {
        $userId = Auth::user()->id;
        try {
            DB::beginTransaction();
            DB::table('tbl_payment_detail')
                ->where('id', $paymentDetailId)
                ->update([
                    'user_id'           => $userId,
                    'hospital_id'       => $params['hospital'],
                    'amount_paid'       => (int)str_replace('.', '', $params['amount_paid'][0]),
                    'note'              => isset($params['note'][0]) ? $params['note'][0] : '',
                    'payment_date'      => Carbon::createFromFormat('d/m/Y', $params['payment_date'])->format('Y-m-d H:i:s'),
                    'examination_date'  => Carbon::createFromFormat('d/m/Y', $params['checkup_date'])->format('Y-m-d H:i:s'),
                    'approved'          => 1,
                    'payment_type_id'   => isset($params['payment_type_id'][0]) ? $params['payment_type_id'][0] : 0,
                    'expected_payment'  => (int)str_replace('.', '', $params['expected_payment'][0]),
                    'rejected_amount'   => (int)str_replace('.', '', $params['rejected_amount'][0]),
                ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function deleteInsuranceExpense($paymentDetailId = 0)
    {
        try {
            DB::beginTransaction();
            PaymentDetail::where('id', $paymentDetailId)->update(['active' => 0]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function test(Request $request)
    {
        $remainAmount = (int) str_replace('.', '', $request->input('remain_amount', 0));
        $amountPaid = (int) str_replace('.', '', (is_array($request->input('amount_paid')) ? ($request->input('amount_paid')[0] ?? 0) : $request->input('amount_paid')));
        $expectedPayment = (int) str_replace('.', '', (is_array($request->input('expected_payment')) ? ($request->input('expected_payment')[0] ?? 0) : $request->input('expected_payment')));

        // Kiểm tra nếu số tiền chi vượt quá ước chi
        if ($amountPaid > $expectedPayment && $expectedPayment > 0) {
            return [
                'status' => true,
                'message' => 'Chú ý: Số tiền chi vượt quá ước chi. Thông tin vẫn ghi nhận!',
            ];
        }

        // Kiểm tra nếu tổng số duyệt chi vượt quá giới hạn còn lại
        if ($amountPaid > $remainAmount) {
            return [
                'status' => true,
                'message' => 'Số tiền chi vượt quá giới hạn. Vui lòng kiểm tra lại thông tin, thông tin vẫn được lưu!',
            ];
        }

        return [
            'status' => true,
            'message' => 'Hiệu chỉnh chi trả thành công.',
        ];
    }
}

@extends('layouts.master')

@section('title', 'Tổng hợp bảo hiểm')
@section('style')
<link rel="stylesheet" href="/assets/css/dataTables.bootstrap5.min.css">
@endsection
@section('content')
    @include('partial.breadcrumb', ['breadcrumbTitle' => 'Tổng hợp bảo hiểm'])
    <div class="system font-weight-medium shadow-none position-relative overflow-hidden mb-4">
        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <ul class="mb-3 nav nav-pills user-profile-tab mt-2 bg-primary-subtle rounded-2 rounded-top-0" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('revenue.generalInsurance')}}" class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6" >
                                <span class="d-none d-md-block">Tổng hợp bảo hiểm</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('revenue.detailReport')}}" class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6">
                                <span class="d-none d-md-block">Báo cáo chi tiết chi bảo hiểm sức khỏe</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('revenue.reportByHospital')}}" class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6">
                                <span class="d-none d-md-block">Báo cáo chi theo bệnh viện</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('revenue.reportByContent')}}" class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6">
                                <span class="d-none d-md-block">Báo cáo chi theo nội dung</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('revenue.reportByHealth')}}" class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6">
                                <span class="d-none d-md-block">Báo cáo tổng hợp sức khỏe</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('revenue.reportByAccount')}}" class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6 active">
                                <span class="d-none d-md-block">Báo cáo kết quả tài khoản khách hàng</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <form action="">
                            <div class="row mb-2">
                                <div class="col-11">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-xl-3">
                                            @include('common/select-company', [
                                                'companyId' => isset($_GET['company']) ? $_GET['company'] : 0,
                                                'companyList' => $companyList,
                                            ])
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-xl-3">
                                            @include('common/select-period', [
                                                'periodId' => isset($_GET['period']) ? $_GET['period'] : 0,
                                                'periodList' => $periodList,
                                                'attr' => [
                                                    'data-time-start' => isset($periodDetail->from_year)
                                                        ? date('01/01/' . $periodDetail->from_year)
                                                        : date('01/01/Y'),
                                                ],
                                            ])
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-xl-3">
                                            @include('common/select-contract', [
                                                'contractId' => isset($_GET['contract']) ? $_GET['contract'] : 0,
                                                'contractList' => $contractList,
                                            ])
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-xl-3">
                                            @include('common/input-time-range', [
                                                'time_range' => (isset($periodDetail->from_year) ? date('01/01/' . $periodDetail->from_year) : date('01/01/Y')) . ' - ' . date('d/m/Y')
                                            ])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 d-flex flex-column-reverse">
                                    <button class="btn btn-primary w-100" type="submit">Tìm kiếm</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="system-table table-responsive">
                                    <table id="simpletable"
                                        class="table border text-nowrap customize-table mb-0 align-middle mb-3">
                                        <thead>
                                            <tr>
                                                <th class="text-center">STT</th>
                                                <th>Số thẻ Bảo hiểm</th>
                                                <th class="text-center">Họ tên</th>
                                                <th>Giới hạn đầu kỳ</th>
                                                <th>Chi trong kỳ</th>
                                                <th>Giới hạn còn lại</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($accountReport as $key => $value)
                                            <tr data-id="{{ $value->id }}">
                                                <td class="text-center">{{ ++$key }}</td>
                                                <td>{{ $value->card_number }}</td>
                                                <td>{{ $value->full_name }}</td>
                                                <td>{{ number_format($value->data['moneyStartPeriod']) }}</td>
                                                <td>{{ number_format($value->data['totalAmountSpent']) }}</td>
                                                <td>{{ number_format($value->data['theRemainingAmount']) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {!! $accountReport->onEachSide(1)->render('pagination::bootstrap-5') !!}
                                </div>
                            </div>
                        </div>
                        <div class="btn-export text-center"><a class="btn btn-primary" href="{{ route('export.accountListResult') }}">Xuất báo cáo</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="/assets/js/datetimepicker/moment.min.js"></script>
    <script src="/assets/js/datetimepicker/daterangepicker.js"></script>
    <script src="/assets/js/datetimepicker/daterangepicker-init.js"></script>
    <script src="/assets/js/datetimepicker/bootstrap-datepicker.min.js"></script>
    <script src="/assets/js/datetimepicker/datepicker-init.js"></script>
    <script>
        function updateTable() {
            $('#simpletable').show();
        }
        $('#companySelect,#hospital ,#periodSelect, #contractSelect, #dateInput').on('change', updateTable);
    </script>

@endsection



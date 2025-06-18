@extends('layouts.master')

@section('title', __('Chi tiết thông tin khách hàng'))

@section('style')
    <link rel="stylesheet" href="{{ asset('/assets/libs/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')
    @include('partial.breadcrumb', ['breadcrumbTitle' => __('Chi tiết thông tin khách hàng')])
    <div class="edit-info-page">
        <div class="row note-has-grid">
            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card w-100 position-relative overflow-hidden mb-0">
                    <div class="card-body p-4 single-note-item">
                        <span class="side-stick"></span>
                        <h5 class="card-title fw-semibold">Thông tin cá nhân khách hàng</h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">Họ tên khách hàng:</label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control input-modal-account" name="TENHO" value="{{ $detailAccount ? $detailAccount->full_name : '' }}"disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="col-form-label">Điện thoại liên lạc:</label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control input-modal-account" value="{{ $detailAccount ? $detailAccount->contact_phone : '' }}" name="DIENTHOAILIENLAC"disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="col-form-label">Email:</label>
                                    <div class="col-sm">
                                        <input type="email" class="form-control input-modal-account" value="{{ $detailAccount ? $detailAccount->email : '' }}" name="EMAIL" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="col-form-label">Giới tính:</label>
                                    <div class="col-sm">
                                        <input type="email" class="form-control input-modal-account" value="{{ $detailAccount ? $detailAccount->gender : '' }}" name="GENDER" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group form-checkbox">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input success" type="checkbox" id="success2-check" value="option1" {{ $detailAccount ? $detailAccount->account_holder : '' }} disabled>
                                        <label class="form-check-label" for="success2-check" style="font-weight: 600;color: #6c757d;">Thân nhân</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="col-form-label">Ngày sinh:</label>
                                    <div class="col-sm">
                                        <div class="input-group">
                                            <input type="text" value="{{ $detailAccount ? $detailAccount->birth_year : '' }}" class="form-control input-modal-account singledate" name="namsinh" disabled/>
                                            <span class="input-group-addon">
                                                <i class="icofont icofont-clock-time"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="col-form-label">Số CCCD:</label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control input-modal-account" name="SOCMND" value="{{ $detailAccount ? $detailAccount->identity_card_number : '' }}" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="col-form-label">Ngày cấp:</label>
                                    <div class="col-sm">
                                        <div class="input-group">
                                            <input type="text" class="form-control input-modal-account" name="NGAYCAPCMND" value="{{ $detailAccount ? $detailAccount->issue_date : '' }}" disabled/>
                                            <span class="input-group-addon">
                                                <i class="icofont icofont-clock-time"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="col-form-label">Nơi cấp:</label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control input-modal-account" name="NOICAP" value="{{ $detailAccount ? $detailAccount->issue_place : '' }}" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="col-form-label">Địa chỉ cư ngụ: </label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control input-modal-account" name="DIACHICUTRU" value="{{ $detailAccount ? $detailAccount->address : '' }}" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="col-form-label">Tỉnh thành phố:</label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control input-modal-account" name="THANHPHO" value="{{ $detailAccount ? $detailAccount->province_name : '' }}" disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-12 w-100 position-relative overflow-hidden mb-0">
                        <div class="card note-has-grid">
                            <div class="card-body p-4 single-note-item">
                                <span class="side-stick"></span>
                                <h5 class="card-title fw-semibold">Thông tin công ty</h5>
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Tên công ty:</label>
                                            <div class="col-sm">
                                                <input type="text" class="form-control input-modal-account" name="TENCONGTY" value="{{ $detailAccount ? $detailAccount->company_name : '' }}" disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 w-100 position-relative overflow-hidden mb-0">
                        <div class="card">
                            <div class="card-body p-4 single-note-item">
                                <span class="side-stick"></span>
                                <h5 class="card-title fw-semibold">Thông tin hợp đồng bảo hiểm</h5>
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Tên chủ tài khoản:</label>
                                                <div class="col-sm">
                                                    <input type="text" class="form-control input-modal-account" name="TENHO" value="{{ $detailAccount ? $detailAccount->full_name : '' }}" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Số thẻ</label>
                                                <div class="col-sm">
                                                    <input type="text" class="form-control input-modal-account" name="sothe" value="{{ $detailAccount ? $detailAccount->card_number : '' }}" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Tên hợp đồng:</label>
                                                <div class="col-sm">
                                                    <input type="text" class="form-control input-modal-account" name="TENHOPDONG" value="{{ $detailAccount ? $detailAccount->contract_name : '' }}" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Niên hạn:</label>
                                                <div class="col-sm">
                                                    <input type="text" class="form-control input-modal-account" name="tennienhan" value="{{ $detailAccount ? $detailAccount->period_name : '' }}" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Ghi chú tài khoản:</label>
                                                <div class="col-sm">
                                                    <input type="text" class="form-control input-modal-account" value="{{ $detailAccount ? $detailAccount->note : '' }}" name="GHICHU" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                            <label class="col-form-label">Phân loại KH:</label>
                                            <div class="col-sm">
                                                <input type="text" class="form-control input-modal-account" value="{{ $detailAccount ? $detailAccount->group_name : '' }}" name="TYPE" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Loại tài khoản (plan):</label>
                                                <div class="col-sm">
                                                    <input type="text" class="form-control input-modal-account" value="{{ $detailAccount ? $detailAccount->package_name : '' }}" name="LOAITAIKHOAN" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group bhpvi">
                                                <label class="col-form-label">Giới hạn đầu kỳ Bảo Hiểm:</label>
                                                <div class="col-sm">
                                                    <input type="text" class="form-control input-modal-account" name="GIOIHANGOI" value="{{ is_numeric($detailAccount?->package_price) ? number_format($detailAccount->package_price, 0, '.', ' ') : '' }}" disabled/>
                                                </div>
                                                <span class="vnd" style="font-size: 14px;">đồng</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group ">
                                                <label class="col-form-label">Thời gian hiệu lực từ:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control daterange" value="{{ $detailAccount ? ($detailAccount->effective_time . ' - ' . $detailAccount->end_time) : '' }}" disabled>
                                                    <span class="input-group-text">
                                                        <i class="ti ti-calendar fs-5"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
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
@endsection

<div class="card card-body">
    <h5>Chi bảo hiêm</h5>
    <form action="">
        <div class="row mb-3">
            <div class="col-11">
                <div class="row ">
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
                    <div class="col-sm-12 col-md-6 col-xl-3 ">
                        @include('common/input-keyword', [
                            'keyword' => isset($_GET['keyword']) ? $_GET['keyword'] : '',
                        ])
                    </div>
                </div>
            </div>
            <div class="col-1 d-flex flex-column-reverse">
                <button class="btn btn-primary w-100" type="submit">Tìm kiếm</button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-12 col-md-6 col-xl-3">
                <div class="form-group ">
                    <label class="col-form-label">Thời gian:</label>
                    <div class="input-group">
                        <input type="text" class="form-control daterange">
                        <span class="input-group-text">
                            <i class="ti ti-calendar fs-5"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-xl-3">
                <div class="form-group ">
                    <label class="col-form-label">Tên bệnh viện:</label>
                    <select class="form-select mr-sm-2 {{ isset($class) ? $class : '' }}"
                        id="{{ isset($id) ? $id : 'hospitalSelectGeneral' }}" name="{{ isset($name) ? $name : 'hospital' }}">
                        @foreach ($hospitalList as $hospital)
                            <option value="{{ $hospital->id }}" >
                                {{ $hospital->hospital_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-xl-3 btn-flexend">
                <div>
                    <button class="btn btn-primary" type="button">Duyệt chi</button>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-xl-3 btn-flexend">
                <div>
                    <button class="btn btn-primary" type="button">Xuất ra Excel</button>
                </div>
            </div>
        </div>
        <div class="bg-infor bg-info-insurance py-2 px-3 mb-3">
            Thông tin đơn/hợp đồng bảo hiểm
        </div>
        <div class="info-contract mb-3" style="display: none;">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-xl-3 mb-3">
                    <div class="info-contract-item">
                        <div class="title me-2">Tên công ty:</div>
                        <div class="content">
                            {{ isset($contractDetail->company_name) ? $contractDetail->company_name : '' }}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-xl-3 mb-3">
                    <div class="info-contract-item">
                        <div class="title me-2">Tên HĐ:</div>
                        <div class="content">
                            {{ isset($contractDetail->contract_name) ? $contractDetail->contract_name : '' }}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-xl-3 mb-3">
                    <div class="info-contract-item">
                        <div class="title me-2">Số HĐ:</div>
                        <div class="content">
                            {{ isset($contractDetail->contract_supplement_number) ? $contractDetail->contract_supplement_number : '' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-xl-3 mb-3">
                    <div class="info-contract-item">
                        <div class="title me-2">Ngày ký HĐ:</div>
                        <div class="content">
                            {{ isset($contractDetail->signature_date) ? date('d/m/Y', strtotime($contractDetail->signature_date)) : '' }}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-xl-3">
                    <div class="info-contract-item">
                        <div class="title me-2">Giá trị HĐ:</div>
                        <div class="content">
                            {{ isset($contractDetail->total_contract_value) ? number_format($contractDetail->total_contract_value) : '' }}
                            <span>đồng</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-xl-3 mb-3">
                    <div class="info-contract-item">
                        <div class="title me-2">Thời hạn từ:</div>
                        <div class="content">
                            {{ isset($contractDetail->effective_time) ? date('d/m/Y', strtotime($contractDetail->effective_time)) : '' }}
                            <span>đến:</span>
                            {{ isset($contractDetail->end_time) ? date('d/m/Y', strtotime($contractDetail->end_time)) : '' }}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-xl-3">
                    <div class="info-contract-item">
                        <div class="title me-2">Tên niên hạn:</div>
                        <div class="content">
                            {{ isset($contractDetail->period_name) ? $contractDetail->period_name : '' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

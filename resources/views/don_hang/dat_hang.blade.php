@extends('layouts.khach')

@section('tieu_de', 'Đặt hàng - VPP Corner')

@section('noi_dung')
<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-bag-check me-2 text-primary"></i>Xác nhận đặt hàng</h3>

    @if($errors->any())
        <div class="alert alert-danger py-2 small">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $loi)
                    <li>{{ $loi }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dat_hang.xu_ly') }}" method="POST">
        @csrf
        <div class="row g-4">
            <!-- Thông tin người nhận & thanh toán -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Thông tin giao hàng</h5>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Họ và tên người nhận <span class="text-danger">*</span></label>
                            <input type="text" name="ten_nguoi_nhan" class="form-control"
                                   value="{{ old('ten_nguoi_nhan', $nguoiDung->ho_ten ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" name="sdt_nguoi_nhan" class="form-control"
                                   value="{{ old('sdt_nguoi_nhan', $nguoiDung->so_dien_thoai ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <textarea name="dia_chi_giao" rows="2" class="form-control" required>{{ old('dia_chi_giao', $nguoiDung->dia_chi ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phương thức thanh toán <span class="text-danger">*</span></label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="phuong_thuc_thanh_toan"
                                       id="ptCod" value="COD" {{ old('phuong_thuc_thanh_toan', 'COD') == 'COD' ? 'checked' : '' }}>
                                <label class="form-check-label" for="ptCod">
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="phuong_thuc_thanh_toan"
                                       id="ptCk" value="chuyen_khoan" {{ old('phuong_thuc_thanh_toan') == 'chuyen_khoan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="ptCk">
                                    Chuyển khoản ngân hàng
                                </label>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold">Ghi chú đơn hàng</label>
                            <textarea name="ghi_chu" rows="2" class="form-control"
                                      placeholder="Ví dụ: Giao giờ hành chính...">{{ old('ghi_chu') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tóm tắt sản phẩm & tiền -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Sản phẩm đã chọn</h5>

                        <ul class="list-group list-group-flush mb-3">
                            @foreach($gioHang as $item)
                                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">{{ $item['ten_san_pham'] }}</div>
                                        <small class="text-muted">
                                            {{ number_format($item['gia_ban'], 0, ',', '.') }}đ x {{ $item['so_luong'] }} {{ $item['don_vi_tinh'] }}
                                        </small>
                                    </div>
                                    <span class="fw-semibold">
                                        {{ number_format($item['gia_ban'] * $item['so_luong'], 0, ',', '.') }}đ
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tạm tính:</span>
                            <span>{{ number_format($tongTienHang, 0, ',', '.') }}đ</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">
                                Giảm giá
                                @if($maApDung)
                                    <span class="badge bg-success-subtle text-success">{{ $maApDung['ma_code'] }}</span>
                                @endif
                                :
                            </span>
                            <span class="text-success fw-semibold">-{{ number_format($tienGiam, 0, ',', '.') }}đ</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Tổng thanh toán:</span>
                            <span class="fw-bold text-danger fs-5">{{ number_format($thanhTien, 0, ',', '.') }}đ</span>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Xác nhận đặt hàng</button>
                            <a href="{{ route('gio_hang.index') }}" class="btn btn-outline-secondary btn-sm">Quay lại giỏ hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

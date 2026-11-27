@extends('layouts.khach')

@section('tieu_de', 'Giỏ hàng - VPP Corner')

@section('noi_dung')
<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-cart3 me-2 text-primary"></i>Giỏ hàng của bạn</h3>

    @if($errors->has('ma_code'))
        <div class="alert alert-danger py-2 small">{{ $errors->first('ma_code') }}</div>
    @endif

    @if(empty($gioHang))
        <div class="card border-0 shadow-sm text-center p-5">
            <i class="bi bi-cart-x fs-1 text-secondary mb-3"></i>
            <h5 class="fw-bold">Giỏ hàng hiện đang trống</h5>
            <p class="text-muted">Hãy chọn thêm sản phẩm văn phòng phẩm để bắt đầu đặt hàng.</p>
            <div>
                <a href="{{ route('trang_chu') }}#khu-vuc-san-pham" class="btn btn-primary">
                    Tiếp tục mua sắm
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            <!-- Danh sách sản phẩm trong giỏ -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-end">Đơn giá</th>
                                        <th style="width: 170px;" class="text-center">Số lượng</th>
                                        <th class="text-end">Thành tiền</th>
                                        <th class="text-center">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gioHang as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    @if(!empty($item['hinh_anh']))
                                                        <img src="{{ asset('storage/' . $item['hinh_anh']) }}"
                                                             alt="{{ $item['ten_san_pham'] }}"
                                                             class="anh-nho-gio">
                                                    @else
                                                        <div class="anh-nho-gio bg-light d-flex align-items-center justify-content-center text-secondary">
                                                            <i class="bi bi-box-seam"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <a href="{{ route('san_pham.chi_tiet', $item['duong_dan']) }}"
                                                           class="fw-semibold text-dark text-decoration-none d-block">
                                                            {{ $item['ten_san_pham'] }}
                                                        </a>
                                                        <small class="text-muted">ĐVT: {{ $item['don_vi_tinh'] }} | Tồn: {{ $item['so_luong_ton'] }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end fw-semibold">
                                                {{ number_format($item['gia_ban'], 0, ',', '.') }}đ
                                            </td>
                                            <td>
                                                <form action="{{ route('gio_hang.cap_nhat') }}" method="POST" class="d-flex gap-1 justify-content-center">
                                                    @csrf
                                                    <input type="hidden" name="san_pham_id" value="{{ $item['id'] }}">
                                                    <input type="number" name="so_luong"
                                                           value="{{ $item['so_luong'] }}"
                                                           min="1" max="{{ $item['so_luong_ton'] }}"
                                                           class="form-control form-control-sm text-center o-so-luong-gio">
                                                    <button type="submit" class="btn btn-outline-primary btn-sm" title="Cập nhật">
                                                        <i class="bi bi-check2"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="text-end fw-bold text-danger">
                                                {{ number_format($item['gia_ban'] * $item['so_luong'], 0, ',', '.') }}đ
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('gio_hang.xoa', $item['id']) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Xóa">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <a href="{{ route('trang_chu') }}#khu-vuc-san-pham" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i>Mua thêm sản phẩm
                            </a>

                            <form action="{{ route('gio_hang.xoa_tat_ca') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    Xóa toàn bộ giỏ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột Mã giảm giá & Tổng kết -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-ticket-perforated me-1 text-danger"></i>Mã giảm giá</h6>

                        @if($maApDung)
                            <div class="d-flex justify-content-between align-items-center bg-success-subtle border border-success-subtle rounded p-2 mb-2">
                                <div>
                                    <strong class="text-success">{{ $maApDung['ma_code'] }}</strong>
                                    <div class="small text-muted">{{ $maApDung['ten_chuong_trinh'] }}</div>
                                </div>
                                <form action="{{ route('gio_hang.go_ma') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Gỡ</button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('gio_hang.ap_dung_ma') }}" method="POST" class="input-group">
                                @csrf
                                <input type="text" name="ma_code" class="form-control text-uppercase"
                                       placeholder="Nhập mã (VD: GIAM10)" value="{{ old('ma_code') }}">
                                <button type="submit" class="btn btn-danger">Áp dụng</button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Tóm tắt đơn hàng</h6>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tạm tính:</span>
                            <span class="fw-semibold">{{ number_format($tongTienHang, 0, ',', '.') }}đ</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Giảm giá:</span>
                            <span class="fw-semibold text-success">-{{ number_format($tienGiam, 0, ',', '.') }}đ</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold">Tổng thanh toán:</span>
                            <span class="fw-bold text-danger fs-5">{{ number_format($thanhTien, 0, ',', '.') }}đ</span>
                        </div>

                        <div class="d-grid">
                            <a href="#" class="btn btn-primary">Tiến hành đặt hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

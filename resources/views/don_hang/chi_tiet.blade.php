@extends('layouts.khach')

@section('tieu_de', 'Chi tiết đơn hàng ' . $donHang->ma_don_hang . ' - VPP Corner')

@section('noi_dung')
<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h3 class="fw-bold mb-1">Đơn hàng #{{ $donHang->ma_don_hang }}</h3>
            <small class="text-muted">Đặt lúc: {{ $donHang->created_at?->format('d/m/Y H:i') }}</small>
        </div>

        <div class="d-flex gap-2">
            @if($donHang->trang_thai === 'cho_xac_nhan')
                <form action="{{ route('don_hang.huy', $donHang->id) }}" method="POST"
                      onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-x-circle me-1"></i>Hủy đơn hàng
                    </button>
                </form>
            @endif
            <a href="{{ route('don_hang.lich_su') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Danh sách đơn
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Danh sách sản phẩm</h6>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($donHang->chiTietDonHang as $ct)
                                    <tr>
                                        <td class="fw-semibold">{{ $ct->sanPham->ten_san_pham ?? 'Sản phẩm #' . $ct->san_pham_id }}</td>
                                        <td class="text-end">{{ number_format($ct->don_gia, 0, ',', '.') }}đ</td>
                                        <td class="text-center">{{ $ct->so_luong }}</td>
                                        <td class="text-end fw-bold text-danger">{{ number_format($ct->thanh_tien, 0, ',', '.') }}đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Thông tin nhận hàng</h6>
                    <p class="mb-1 small"><strong>Người nhận:</strong> {{ $donHang->ten_nguoi_nhan }}</p>
                    <p class="mb-1 small"><strong>Điện thoại:</strong> {{ $donHang->sdt_nguoi_nhan }}</p>
                    <p class="mb-1 small"><strong>Địa chỉ:</strong> {{ $donHang->dia_chi_giao }}</p>
                    <p class="mb-1 small"><strong>Thanh toán:</strong> {{ strtoupper($donHang->phuong_thuc_thanh_toan) }}</p>
                    @if($donHang->ghi_chu)
                        <p class="mb-0 small text-muted"><strong>Ghi chú:</strong> {{ $donHang->ghi_chu }}</p>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Tổng kết thanh toán</h6>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Tạm tính:</span>
                        <span>{{ number_format($donHang->tam_tinh, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Giảm giá:</span>
                        <span class="text-success">-{{ number_format($donHang->so_tien_giam, 0, ',', '.') }}đ</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Tổng thanh toán:</span>
                        <span class="fw-bold text-danger fs-5">{{ number_format($donHang->tong_thanh_toan, 0, ',', '.') }}đ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('tieu_de', 'Chi tiết Đơn hàng - VPP Corner')

@section('noi_dung')
@php
    $nhanTrangThai = [
        'cho_xac_nhan' => ['Chờ xác nhận', 'bg-warning text-dark'],
        'dang_giao' => ['Đang giao', 'bg-info text-dark'],
        'hoan_tat' => ['Hoàn tất', 'bg-success'],
        'da_huy' => ['Đã hủy', 'bg-danger'],
    ];
    [$chuTrangThai, $mauBadge] = $nhanTrangThai[$donHang->trang_thai] ?? [$donHang->trang_thai, 'bg-secondary'];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-2">
        <h3 class="fw-bold mb-0">Đơn hàng {{ $donHang->ma_don_hang }}</h3>
        <span class="badge {{ $mauBadge }}">{{ $chuTrangThai }}</span>
    </div>
    <a href="{{ route('admin.don_hang.index') }}" class="btn btn-outline-secondary btn-sm">Quay lại danh sách</a>
</div>

@if(session('thong_bao'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('thong_bao') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Sản phẩm trong đơn</h5>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th class="text-end">Đơn giá</th>
                                <th class="text-center">SL</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donHang->chiTietDonHang as $ct)
                                <tr>
                                    <td>{{ $ct->sanPham->ten_san_pham ?? ('SP #' . $ct->san_pham_id) }}</td>
                                    <td class="text-end">{{ number_format($ct->don_gia, 0, ',', '.') }}đ</td>
                                    <td class="text-center">{{ $ct->so_luong }}</td>
                                    <td class="text-end fw-semibold">
                                        {{ number_format($ct->thanh_tien, 0, ',', '.') }}đ
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 text-end">
                    <div class="text-muted">Tạm tính: {{ number_format($donHang->tam_tinh, 0, ',', '.') }}đ</div>
                    <div class="text-success">
                        Giảm giá
                        @if($donHang->maGiamGia)
                            ({{ $donHang->maGiamGia->ma_code ?? ('#' . $donHang->ma_giam_gia_id) }})
                        @endif
                        : -{{ number_format($donHang->so_tien_giam, 0, ',', '.') }}đ
                    </div>
                    <div class="fw-bold fs-5 text-danger mt-1">
                        Tổng thanh toán: {{ number_format($donHang->tong_thanh_toan, 0, ',', '.') }}đ
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Thông tin nhận hàng</h5>
                <p class="mb-1"><strong>Người nhận:</strong> {{ $donHang->ten_nguoi_nhan }}</p>
                <p class="mb-1"><strong>SĐT:</strong> {{ $donHang->sdt_nguoi_nhan }}</p>
                <p class="mb-1"><strong>Địa chỉ:</strong> {{ $donHang->dia_chi_giao }}</p>
                <p class="mb-1"><strong>Thanh toán:</strong> {{ strtoupper($donHang->phuong_thuc_thanh_toan) }}</p>
                <p class="mb-0"><strong>Ghi chú:</strong> {{ $donHang->ghi_chu ?: '-' }}</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Cập nhật trạng thái</h5>
                <form action="{{ route('admin.don_hang.cap_nhat_trang_thai', $donHang->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="trang_thai" class="form-select">
                            <option value="cho_xac_nhan" {{ $donHang->trang_thai === 'cho_xac_nhan' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="dang_giao" {{ $donHang->trang_thai === 'dang_giao' ? 'selected' : '' }}>Đang giao</option>
                            <option value="hoan_tat" {{ $donHang->trang_thai === 'hoan_tat' ? 'selected' : '' }}>Hoàn tất</option>
                            <option value="da_huy" {{ $donHang->trang_thai === 'da_huy' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Lưu trạng thái</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

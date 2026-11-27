@extends('layouts.admin')

@section('tieu_de', 'Quản lý Đơn hàng - VPP Corner')

@section('noi_dung')
<h3 class="fw-bold mb-4">Quản lý Đơn hàng</h3>

@if(session('thong_bao'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('thong_bao') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.don_hang.index') }}" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="tu_khoa" class="form-control"
                       placeholder="Tìm mã đơn, tên người nhận, SĐT..."
                       value="{{ request('tu_khoa') }}">
            </div>
            <div class="col-md-4">
                <select name="trang_thai" class="form-select">
                    <option value="">-- Tất cả trạng thái --</option>
                    <option value="cho_xac_nhan" {{ request('trang_thai') === 'cho_xac_nhan' ? 'selected' : '' }}>Chờ xác nhận</option>
                    <option value="dang_giao" {{ request('trang_thai') === 'dang_giao' ? 'selected' : '' }}>Đang giao</option>
                    <option value="hoan_tat" {{ request('trang_thai') === 'hoan_tat' ? 'selected' : '' }}>Hoàn tất</option>
                    <option value="da_huy" {{ request('trang_thai') === 'da_huy' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-dark w-100">Lọc</button>
                <a href="{{ route('admin.don_hang.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Người nhận</th>
                        <th>Ngày đặt</th>
                        <th class="text-end">Tổng thanh toán</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dsDonHang as $dh)
                        <tr>
                            <td class="fw-semibold">{{ $dh->ma_don_hang }}</td>
                            <td>
                                <div class="fw-semibold">{{ $dh->ten_nguoi_nhan }}</div>
                                <small class="text-muted">{{ $dh->sdt_nguoi_nhan }}</small>
                            </td>
                            <td class="small">{{ optional($dh->created_at)->format('d/m/Y H:i') }}</td>
                            <td class="text-end fw-semibold text-danger">
                                {{ number_format($dh->tong_thanh_toan, 0, ',', '.') }}đ
                            </td>
                            <td>
                                @php
                                    $nhanTrangThai = [
                                        'cho_xac_nhan' => ['Chờ xác nhận', 'bg-warning text-dark'],
                                        'dang_giao' => ['Đang giao', 'bg-info text-dark'],
                                        'hoan_tat' => ['Hoàn tất', 'bg-success'],
                                        'da_huy' => ['Đã hủy', 'bg-danger'],
                                    ];
                                    [$chuTrangThai, $mauBadge] = $nhanTrangThai[$dh->trang_thai] ?? [$dh->trang_thai, 'bg-secondary'];
                                @endphp
                                <span class="badge {{ $mauBadge }}">{{ $chuTrangThai }}</span>

                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.don_hang.show', $dh->id) }}" class="btn btn-outline-primary btn-sm">
                                    Chi tiết
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Chưa có đơn hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $dsDonHang->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

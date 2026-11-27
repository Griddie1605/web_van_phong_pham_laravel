@extends('layouts.admin')

@section('tieu_de', 'Dashboard Quản trị - VPP Corner')

@section('noi_dung')
<h3 class="fw-bold mb-4">Tổng quan hệ thống</h3>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Doanh thu đơn hoàn tất</div>
                <div class="fs-4 fw-bold text-success mt-1">{{ number_format($tongDoanhThu, 0, ',', '.') }}đ</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Đơn hàng chờ xác nhận</div>
                <div class="fs-4 fw-bold text-warning mt-1">{{ $donChoXacNhan }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Sản phẩm đang bán</div>
                <div class="fs-4 fw-bold text-primary mt-1">{{ $sanPhamDangBan }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Sản phẩm sắp hết hàng (tồn &le; 10)</h5>
            <a href="{{ route('admin.kho.nhap_kho') }}" class="btn btn-primary btn-sm">Lập phiếu nhập kho</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th class="text-center">Tồn kho</th>
                        <th>Đơn vị</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($spSapHetHang as $sp)
                        <tr>
                            <td class="fw-semibold">#{{ $sp->id }}</td>
                            <td>{{ $sp->ten_san_pham }}</td>
                            <td>{{ $sp->danhMuc->ten_danh_muc ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-danger-subtle text-danger">{{ $sp->so_luong_ton }}</span>
                            </td>
                            <td>{{ $sp->don_vi_tinh }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">Không có sản phẩm nào sắp hết hàng.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

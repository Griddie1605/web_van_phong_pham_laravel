@extends('layouts.admin')

@section('tieu_de', 'Quản lý Sản phẩm - VPP Corner')

@section('noi_dung')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <h3 class="fw-bold mb-0">Quản lý Sản phẩm</h3>
    <a href="{{ route('admin.san_pham.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Thêm sản phẩm
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.san_pham.index') }}" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="tu_khoa" class="form-control" placeholder="Tìm theo tên sản phẩm..."
                       value="{{ request('tu_khoa') }}">
            </div>
            <div class="col-md-4">
                <select name="danh_muc_id" class="form-select">
                    <option value="">-- Tất cả danh mục --</option>
                    @foreach($dsDanhMuc as $dm)
                        <option value="{{ $dm->id }}" {{ request('danh_muc_id') == $dm->id ? 'selected' : '' }}>
                            {{ $dm->ten_danh_muc }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-dark w-100">Lọc</button>
                <a href="{{ route('admin.san_pham.index') }}" class="btn btn-outline-secondary">Reset</a>
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
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th class="text-end">Giá bán</th>
                        <th class="text-center">Tồn</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dsSanPham as $sp)
                        <tr>
                            <td>
                                @if($sp->hinh_anh)
                                    <img src="{{ asset('storage/' . $sp->hinh_anh) }}" alt="{{ $sp->ten_san_pham }}"
                                         width="48" height="48" class="rounded object-fit-cover">
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">No img</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $sp->ten_san_pham }}</div>
                                <small class="text-muted">{{ $sp->don_vi_tinh }}</small>
                            </td>
                            <td>{{ $sp->danhMuc->ten_danh_muc ?? '-' }}</td>
                            <td class="text-end fw-semibold text-danger">{{ number_format($sp->gia_ban, 0, ',', '.') }}đ</td>
                            <td class="text-center">{{ $sp->so_luong_ton }}</td>
                            <td>
                                <form action="{{ route('admin.san_pham.doi_trang_thai', $sp->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $sp->trang_thai === 'hien' ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $sp->trang_thai === 'hien' ? 'Đang bán' : 'Đang ẩn' }}
                                    </button>
                                </form>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.san_pham.edit', $sp->id) }}" class="btn btn-outline-primary btn-sm">Sửa</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Không tìm thấy sản phẩm nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $dsSanPham->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

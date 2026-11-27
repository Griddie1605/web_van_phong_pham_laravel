@extends('layouts.admin')

@section('tieu_de', 'Quản lý Danh mục - VPP Corner')

@section('noi_dung')
<h3 class="fw-bold mb-4">Quản lý Danh mục</h3>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Thêm danh mục mới</h5>
                <form action="{{ route('admin.danh_muc.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" name="ten_danh_muc" class="form-control" value="{{ old('ten_danh_muc') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả</label>
                        <textarea name="mo_ta" rows="2" class="form-control">{{ old('mo_ta') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Thêm danh mục</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Danh sách danh mục</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tên danh mục</th>
                                <th>Đường dẫn</th>
                                <th class="text-center">Số SP</th>
                                <th>Trạng thái</th>
                                <th class="text-end">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dsDanhMuc as $dm)
                                <tr>
                                    <td class="fw-semibold">{{ $dm->ten_danh_muc }}</td>
                                    <td class="small text-muted">{{ $dm->duong_dan }}</td>
                                    <td class="text-center">{{ $dm->san_pham_count }}</td>
                                    <td>
                                        <form action="{{ route('admin.danh_muc.doi_trang_thai', $dm->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ ($dm->trang_thai ?? 'hien') === 'hien' ? 'btn-success' : 'btn-secondary' }}">
                                                {{ ($dm->trang_thai ?? 'hien') === 'hien' ? 'Đang hiện' : 'Đang ẩn' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#suaDm{{ $dm->id }}">
                                            Sửa
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Chưa có danh mục nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($dsDanhMuc as $dm)
    <div class="modal fade" id="suaDm{{ $dm->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.danh_muc.update', $dm->id) }}" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h6 class="modal-title fw-bold">Sửa danh mục</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên danh mục</label>
                        <input type="text" name="ten_danh_muc" class="form-control"
                               value="{{ $dm->ten_danh_muc }}" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Mô tả</label>
                        <textarea name="mo_ta" rows="2" class="form-control">{{ $dm->mo_ta }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary btn-sm">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
@endforeach
@endsection

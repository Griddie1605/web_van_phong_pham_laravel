@extends('layouts.admin')

@section('tieu_de', ($sanPham ? 'Sửa sản phẩm' : 'Thêm sản phẩm') . ' - VPP Corner')

@section('noi_dung')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">{{ $sanPham ? 'Sửa sản phẩm' : 'Thêm sản phẩm mới' }}</h3>
    <a href="{{ route('admin.san_pham.index') }}" class="btn btn-outline-secondary btn-sm">Quay lại danh sách</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ $sanPham ? route('admin.san_pham.update', $sanPham->id) : route('admin.san_pham.store') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if($sanPham)
                @method('PUT')
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tên sản phẩm <span class="text-danger">*</span></label>
                    <input type="text" name="ten_san_pham" class="form-control"
                           value="{{ old('ten_san_pham', $sanPham->ten_san_pham ?? '') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Danh mục <span class="text-danger">*</span></label>
                    <select name="danh_muc_id" class="form-select" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($dsDanhMuc as $dm)
                            <option value="{{ $dm->id }}"
                                {{ old('danh_muc_id', $sanPham->danh_muc_id ?? '') == $dm->id ? 'selected' : '' }}>
                                {{ $dm->ten_danh_muc }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Đơn vị tính <span class="text-danger">*</span></label>
                    <input type="text" name="don_vi_tinh" class="form-control"
                           placeholder="cay, cuon, hop, vien..."
                           value="{{ old('don_vi_tinh', $sanPham->don_vi_tinh ?? 'cay') }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Giá bán <span class="text-danger">*</span></label>
                    <input type="number" step="100" min="0" name="gia_ban" class="form-control"
                           value="{{ old('gia_ban', $sanPham->gia_ban ?? 0) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Số lượng tồn <span class="text-danger">*</span></label>
                    <input type="number" min="0" name="so_luong_ton" class="form-control"
                           value="{{ old('so_luong_ton', $sanPham->so_luong_ton ?? 0) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Trạng thái <span class="text-danger">*</span></label>
                    <select name="trang_thai" class="form-select" required>
                        <option value="hien" {{ old('trang_thai', $sanPham->trang_thai ?? 'hien') === 'hien' ? 'selected' : '' }}>Hiển thị</option>
                        <option value="an" {{ old('trang_thai', $sanPham->trang_thai ?? '') === 'an' ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Hình ảnh sản phẩm</label>
                    <input type="file" name="hinh_anh" class="form-control" accept="image/*">
                    @if($sanPham && $sanPham->hinh_anh)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $sanPham->hinh_anh) }}" alt="{{ $sanPham->ten_san_pham }}"
                                 width="80" height="80" class="rounded object-fit-cover border">
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Mô tả</label>
                    <textarea name="mo_ta" rows="2" class="form-control">{{ old('mo_ta', $sanPham->mo_ta ?? '') }}</textarea>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">{{ $sanPham ? 'Cập nhật sản phẩm' : 'Lưu sản phẩm' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

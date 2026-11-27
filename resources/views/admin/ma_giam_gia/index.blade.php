@extends('layouts.admin')

@section('tieu_de', 'Quản lý Mã giảm giá - VPP Corner')

@section('noi_dung')
<h3 class="fw-bold mb-4">Quản lý Mã giảm giá</h3>

@if(session('thong_bao'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('thong_bao') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $loi)
                <li>{{ $loi }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Thêm mã giảm giá</h5>
                <form action="{{ route('admin.ma_giam_gia.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mã code <span class="text-danger">*</span></label>
                        <input type="text" name="ma_code" class="form-control text-uppercase"
                               placeholder="VD: VPP25, GIAM10" value="{{ old('ma_code') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên chương trình <span class="text-danger">*</span></label>
                        <input type="text" name="ten_chuong_trinh" class="form-control"
                               value="{{ old('ten_chuong_trinh') }}" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Loại giảm <span class="text-danger">*</span></label>
                            <select name="loai_giam" class="form-select" required>
                                <option value="so_tien" {{ old('loai_giam') === 'so_tien' ? 'selected' : '' }}>Số tiền (đ)</option>
                                <option value="phan_tram" {{ old('loai_giam') === 'phan_tram' ? 'selected' : '' }}>Phần trăm (%)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Giá trị giảm <span class="text-danger">*</span></label>
                            <input type="number" step="1" min="1" name="gia_tri_giam" class="form-control"
                                   value="{{ old('gia_tri_giam') }}" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Đơn tối thiểu (đ)</label>
                            <input type="number" step="100" min="0" name="don_hang_toi_thieu" class="form-control"
                                   value="{{ old('don_hang_toi_thieu', 0) }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Giảm tối đa (đ)</label>
                            <input type="number" step="100" min="0" name="giam_toi_da" class="form-control"
                                   value="{{ old('giam_toi_da') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Số lượng tối đa</label>
                        <input type="number" min="1" name="so_luong_toi_da" class="form-control"
                               placeholder="Để trống nếu không giới hạn" value="{{ old('so_luong_toi_da') }}">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Từ ngày</label>
                            <input type="datetime-local" name="ngay_bat_dau" class="form-control"
                                   value="{{ old('ngay_bat_dau') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Đến ngày</label>
                            <input type="datetime-local" name="ngay_ket_thuc" class="form-control"
                                   value="{{ old('ngay_ket_thuc') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Trạng thái <span class="text-danger">*</span></label>
                        <select name="trang_thai" class="form-select" required>
                            <option value="kich_hoat" {{ old('trang_thai', 'kich_hoat') === 'kich_hoat' ? 'selected' : '' }}>Kích hoạt</option>
                            <option value="tam_dung" {{ old('trang_thai') === 'tam_dung' ? 'selected' : '' }}>Tạm dừng</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Lưu mã giảm giá</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Danh sách mã giảm giá</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã</th>
                                <th>Chương trình</th>
                                <th>Mức giảm</th>
                                <th>Đơn tối thiểu</th>
                                <th>Trạng thái</th>
                                <th class="text-end">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dsMaGiamGia as $ma)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $ma->ma_code }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $ma->ten_chuong_trinh }}</div>
                                        <small class="text-muted">
                                            Đã dùng: {{ $ma->da_su_dung }}
                                            @if($ma->so_luong_toi_da)
                                                / {{ $ma->so_luong_toi_da }}
                                            @endif
                                        </small>
                                    </td>
                                    <td class="fw-semibold">
                                        @if($ma->loai_giam === 'phan_tram')
                                            {{ rtrim(rtrim(number_format($ma->gia_tri_giam, 2, '.', ''), '0'), '.') }}%
                                        @else
                                            {{ number_format($ma->gia_tri_giam, 0, ',', '.') }}đ
                                        @endif
                                    </td>
                                    <td>{{ number_format($ma->don_hang_toi_thieu, 0, ',', '.') }}đ</td>
                                    <td>
                                        <form action="{{ route('admin.ma_giam_gia.doi_trang_thai', $ma->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $ma->trang_thai === 'kich_hoat' ? 'btn-success' : 'btn-secondary' }}">
                                                {{ $ma->trang_thai === 'kich_hoat' ? 'Kích hoạt' : 'Tạm dừng' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#suaMa{{ $ma->id }}">
                                            Sửa
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">Chưa có mã giảm giá nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($dsMaGiamGia as $ma)
    <div class="modal fade" id="suaMa{{ $ma->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.ma_giam_gia.update', $ma->id) }}" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h6 class="modal-title fw-bold">Sửa mã giảm giá</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã code</label>
                        <input type="text" name="ma_code" class="form-control text-uppercase"
                               value="{{ $ma->ma_code }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên chương trình</label>
                        <input type="text" name="ten_chuong_trinh" class="form-control"
                               value="{{ $ma->ten_chuong_trinh }}" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">Loại giảm</label>
                            <select name="loai_giam" class="form-select" required>
                                <option value="so_tien" {{ $ma->loai_giam === 'so_tien' ? 'selected' : '' }}>Số tiền (đ)</option>
                                <option value="phan_tram" {{ $ma->loai_giam === 'phan_tram' ? 'selected' : '' }}>Phần trăm (%)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Giá trị giảm</label>
                            <input type="number" step="1" min="1" name="gia_tri_giam" class="form-control"
                                   value="{{ (float) $ma->gia_tri_giam }}" required>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">Đơn tối thiểu (đ)</label>
                            <input type="number" step="100" min="0" name="don_hang_toi_thieu" class="form-control"
                                   value="{{ (float) $ma->don_hang_toi_thieu }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Giảm tối đa (đ)</label>
                            <input type="number" step="100" min="0" name="giam_toi_da" class="form-control"
                                   value="{{ $ma->giam_toi_da !== null ? (float) $ma->giam_toi_da : '' }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số lượng tối đa</label>
                        <input type="number" min="1" name="so_luong_toi_da" class="form-control"
                               value="{{ $ma->so_luong_toi_da }}">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">Từ ngày</label>
                            <input type="datetime-local" name="ngay_bat_dau" class="form-control"
                                   value="{{ optional($ma->ngay_bat_dau)->format('Y-m-d\TH:i') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Đến ngày</label>
                            <input type="datetime-local" name="ngay_ket_thuc" class="form-control"
                                   value="{{ optional($ma->ngay_ket_thuc)->format('Y-m-d\TH:i') }}">
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Trạng thái</label>
                        <select name="trang_thai" class="form-select" required>
                            <option value="kich_hoat" {{ $ma->trang_thai === 'kich_hoat' ? 'selected' : '' }}>Kích hoạt</option>
                            <option value="tam_dung" {{ $ma->trang_thai === 'tam_dung' ? 'selected' : '' }}>Tạm dừng</option>
                        </select>
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

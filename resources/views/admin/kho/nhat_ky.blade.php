@extends('layouts.admin')

@section('tieu_de', 'Nhật ký kho & Điều chỉnh tồn - VPP Corner')

@section('noi_dung')
<h3 class="fw-bold mb-4">Nhật ký kho & Điều chỉnh tồn</h3>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Điều chỉnh tồn kho kiểm kê</h6>
        <form action="{{ route('admin.kho.dieu_chinh_ton') }}" method="POST" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Sản phẩm</label>
                <select name="san_pham_id" class="form-select form-select-sm" required>
                    <option value="">-- Chọn sản phẩm --</option>
                    @foreach($dsSanPham as $sp)
                        <option value="{{ $sp->id }}">{{ $sp->ten_san_pham }} (Hiện tại: {{ $sp->so_luong_ton }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Số lượng tồn thực tế</label>
                <input type="number" name="ton_thuc_te" class="form-control form-control-sm" min="0" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Lý do / Ghi chú</label>
                <input type="text" name="ghi_chu" class="form-control form-control-sm" placeholder="Kiểm kê cuối tháng...">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-warning btn-sm w-100 fw-semibold">Cập nhật tồn</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.kho.nhat_ky') }}" class="row g-2">
            <div class="col-md-4">
                <select name="san_pham_id" class="form-select form-select-sm">
                    <option value="">-- Tất cả sản phẩm --</option>
                    @foreach($dsSanPham as $sp)
                        <option value="{{ $sp->id }}" {{ request('san_pham_id') == $sp->id ? 'selected' : '' }}>
                            {{ $sp->ten_san_pham }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="loai_bien_dong" class="form-select form-select-sm">
                    <option value="">-- Tất cả loại biến động --</option>
                    <option value="nhap_kho" {{ request('loai_bien_dong') === 'nhap_kho' ? 'selected' : '' }}>Nhập kho</option>
                    <option value="xuat_ban" {{ request('loai_bien_dong') === 'xuat_ban' ? 'selected' : '' }}>Xuất bán</option>
                    <option value="hoan_tra" {{ request('loai_bien_dong') === 'hoan_tra' ? 'selected' : '' }}>Hoàn trả</option>
                    <option value="dieu_chinh" {{ request('loai_bien_dong') === 'dieu_chinh' ? 'selected' : '' }}>Điều chỉnh</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-dark btn-sm">Lọc nhật ký</button>
                <a href="{{ route('admin.kho.nhat_ky') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
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
                        <th>Thời gian</th>
                        <th>Sản phẩm</th>
                        <th>Loại biến động</th>
                        <th class="text-end">Thay đổi</th>
                        <th class="text-end">Tồn sau</th>
                        <th>Người thực hiện</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dsNhatKy as $nk)
                        <tr>
                            <td class="small text-muted">{{ $nk->created_at?->format('d/m/Y H:i') }}</td>
                            <td class="fw-semibold">{{ $nk->sanPham->ten_san_pham ?? ('SP #' . $nk->san_pham_id) }}</td>
                            <td>
                                <span class="badge bg-secondary-subtle text-dark">{{ $nk->loai_bien_dong }}</span>
                            </td>
                            <td class="text-end fw-bold {{ $nk->so_luong_thay_doi >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $nk->so_luong_thay_doi >= 0 ? '+' . $nk->so_luong_thay_doi : $nk->so_luong_thay_doi }}
                            </td>
                            <td class="text-end fw-semibold">{{ $nk->ton_sau_bien_dong }}</td>
                            <td class="small">{{ $nk->nguoiThucHien->ho_ten ?? '-' }}</td>
                            <td class="small text-muted">{{ $nk->ghi_chu }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Chưa có biến động kho nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $dsNhatKy->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

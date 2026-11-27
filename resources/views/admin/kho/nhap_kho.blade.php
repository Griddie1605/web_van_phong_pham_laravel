@extends('layouts.admin')

@section('tieu_de', 'Nhập kho - VPP Corner')

@section('noi_dung')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Lập phiếu nhập kho</h3>
    <a href="{{ route('admin.kho.nhat_ky') }}" class="btn btn-outline-dark btn-sm">Xem nhật ký kho</a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form action="{{ route('admin.kho.xu_ly_nhap') }}" method="POST" id="formNhapKho">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nhà cung cấp</label>
                    <input type="text" name="nha_cung_cap" class="form-control" value="{{ old('nha_cung_cap') }}"
                           placeholder="Ví dụ: Thiên Long, Hồng Hà...">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Ghi chú phiếu nhập</label>
                    <input type="text" name="ghi_chu" class="form-control" value="{{ old('ghi_chu') }}">
                </div>
            </div>

            <div class="table-responsive mb-3">
                <table class="table table-bordered align-middle" id="bangDongNhap">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 45%;">Sản phẩm</th>
                            <th style="width: 20%;">Số lượng nhập</th>
                            <th style="width: 25%;">Đơn giá nhập</th>
                            <th style="width: 10%;" class="text-center">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="chi_tiet[0][san_pham_id]" class="form-select" required>
                                    <option value="">-- Chọn sản phẩm --</option>
                                    @foreach($dsSanPham as $sp)
                                        <option value="{{ $sp->id }}">
                                            {{ $sp->ten_san_pham }} (Tồn: {{ $sp->so_luong_ton }} {{ $sp->don_vi_tinh }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="chi_tiet[0][so_luong]" class="form-control" min="1" value="1" required>
                            </td>
                            <td>
                                <input type="number" name="chi_tiet[0][don_gia_nhap]" class="form-control" min="0" step="100" value="0" required>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-xoa-dong">&times;</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-outline-primary btn-sm" id="btnThemDong">+ Thêm dòng sản phẩm</button>
                <button type="submit" class="btn btn-primary">Lưu phiếu nhập kho</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Phiếu nhập gần đây</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mã phiếu</th>
                        <th>Nhà cung cấp</th>
                        <th class="text-end">Tổng tiền</th>
                        <th>Ngày lập</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dsPhieuNhap as $pn)
                        <tr>
                            <td class="fw-semibold">{{ $pn->ma_phieu_nhap }}</td>
                            <td>{{ $pn->nha_cung_cap ?: '-' }}</td>
                            <td class="text-end fw-semibold text-success">{{ number_format($pn->tong_tien_nhap, 0, ',', '.') }}đ</td>
                            <td class="small text-muted">{{ $pn->created_at?->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Chưa có phiếu nhập nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    let index = 1;
    const tbody = document.querySelector('#bangDongNhap tbody');
    const btnThem = document.getElementById('btnThemDong');
    const optionsHtml = `@foreach($dsSanPham as $sp)<option value="{{ $sp->id }}">{{ e($sp->ten_san_pham) }} (Tồn: {{ $sp->so_luong_ton }} {{ e($sp->don_vi_tinh) }})</option>@endforeach`;

    btnThem.addEventListener('click', function () {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <select name="chi_tiet[${index}][san_pham_id]" class="form-select" required>
                    <option value="">-- Chọn sản phẩm --</option>
                    ${optionsHtml}
                </select>
            </td>
            <td><input type="number" name="chi_tiet[${index}][so_luong]" class="form-control" min="1" value="1" required></td>
            <td><input type="number" name="chi_tiet[${index}][don_gia_nhap]" class="form-control" min="0" step="100" value="0" required></td>
            <td class="text-center"><button type="button" class="btn btn-outline-danger btn-sm btn-xoa-dong">&times;</button></td>
        `;
        tbody.appendChild(tr);
        index++;
    });

    tbody.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-xoa-dong') && tbody.rows.length > 1) {
            e.target.closest('tr').remove();
        }
    });
})();
</script>
@endpush
@endsection

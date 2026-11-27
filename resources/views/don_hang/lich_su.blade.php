@extends('layouts.khach')

@section('tieu_de', 'Đơn hàng của tôi - VPP Corner')

@section('noi_dung')
<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-receipt me-2 text-primary"></i>Đơn hàng của tôi</h3>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($dsDonHang->isEmpty())
                <div class="text-center py-4">
                    <p class="text-muted mb-3">Bạn chưa có đơn hàng nào.</p>
                    <a href="{{ route('trang_chu') }}#khu-vuc-san-pham" class="btn btn-primary btn-sm">Mua sắm ngay</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Thanh toán</th>
                                <th class="text-end">Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th class="text-end">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dsDonHang as $dh)
                                <tr>
                                    <td class="fw-semibold">{{ $dh->ma_don_hang }}</td>
                                    <td class="small text-muted">{{ $dh->created_at?->format('d/m/Y H:i') }}</td>
                                    <td class="small">{{ strtoupper($dh->phuong_thuc_thanh_toan) }}</td>
                                    <td class="text-end fw-bold text-danger">{{ number_format($dh->tong_thanh_toan, 0, ',', '.') }}đ</td>
                                    <td>
                                        @switch($dh->trang_thai)
                                            @case('cho_xac_nhan')
                                                <span class="badge bg-warning-subtle text-warning-emphasis">Chờ xác nhận</span>
                                                @break
                                            @case('dang_giao')
                                                <span class="badge bg-info-subtle text-info-emphasis">Đang giao</span>
                                                @break
                                            @case('hoan_tat')
                                                <span class="badge bg-success-subtle text-success">Hoàn tất</span>
                                                @break
                                            @case('da_huy')
                                                <span class="badge bg-danger-subtle text-danger">Đã hủy</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $dh->trang_thai }}</span>
                                        @endswitch
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('don_hang.chi_tiet', $dh->id) }}" class="btn btn-outline-primary btn-sm">
                                            Chi tiết
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-center">
                    {{ $dsDonHang->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

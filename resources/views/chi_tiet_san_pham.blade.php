@extends('layouts.khach')

@section('tieu_de', $sanPham->ten_san_pham . ' - VPP Corner')

@section('noi_dung')
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('trang_chu') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('trang_chu', ['danh_muc' => $sanPham->danhMuc->duong_dan ?? '']) }}#khu-vuc-san-pham">{{ $sanPham->danhMuc->ten_danh_muc ?? 'Sản phẩm' }}</a></li>
            <li class="breadcrumb-item active">{{ $sanPham->ten_san_pham }}</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-4 align-items-center">
                <div class="col-md-5">
                    @if($sanPham->hinh_anh)
                        <img src="{{ asset('storage/' . $sanPham->hinh_anh) }}" class="img-fluid rounded border w-100" alt="{{ $sanPham->ten_san_pham }}">
                    @else
                        <div class="bg-light rounded border d-flex flex-column justify-content-center align-items-center text-secondary" style="height: 320px;">
                            <i class="bi bi-box-seam display-3"></i>
                            <span class="mt-2">Chưa có hình ảnh sản phẩm</span>
                        </div>
                    @endif
                </div>

                <div class="col-md-7">
                    <span class="badge bg-primary mb-2">{{ $sanPham->danhMuc->ten_danh_muc ?? '' }}</span>
                    <h3 class="fw-bold">{{ $sanPham->ten_san_pham }}</h3>
                    <p class="text-danger fw-bold fs-4 mb-2">
                        {{ number_format($sanPham->gia_ban, 0, ',', '.') }}đ
                        <span class="text-muted fs-6 fw-normal">/ {{ $sanPham->don_vi_tinh }}</span>
                    </p>

                    <p class="mb-3">
                        Tình trạng:
                        @if($sanPham->so_luong_ton > 0)
                            <span class="badge bg-success">Còn hàng ({{ $sanPham->so_luong_ton }} {{ $sanPham->don_vi_tinh }})</span>
                        @else
                            <span class="badge bg-danger">Hết hàng</span>
                        @endif
                    </p>

                    <p class="text-secondary">{{ $sanPham->mo_ta ?: 'Đang cập nhật mô tả chi tiết cho sản phẩm này.' }}</p>

                    @if($sanPham->so_luong_ton > 0)
                        <div class="d-flex align-items-center gap-2 mt-4">
                            <input type="number" id="so-luong-mua" class="form-control" style="width: 100px;"
                                   value="1" min="1" max="{{ $sanPham->so_luong_ton }}">
                            <button type="button" class="btn btn-primary px-4 btn-them-gio" data-id="{{ $sanPham->id }}">
                                <i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ hàng
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($sanPhamLienQuan->count() > 0)
        <h5 class="fw-bold mb-3">Sản phẩm cùng danh mục</h5>
        <div class="row g-3">
            @foreach($sanPhamLienQuan as $sp)
                <div class="col-6 col-md-3">
                    <div class="card h-100 border-0 shadow-sm card-san-pham">
                        <a href="{{ route('san_pham.chi_tiet', $sp->duong_dan) }}" class="text-decoration-none">
                            <div class="bg-light d-flex justify-content-center align-items-center text-secondary anh-san-pham">
                                @if($sp->hinh_anh)
                                    <img src="{{ asset('storage/' . $sp->hinh_anh) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $sp->ten_san_pham }}">
                                @else
                                    <i class="bi bi-box-seam fs-1"></i>
                                @endif
                            </div>
                        </a>
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="{{ route('san_pham.chi_tiet', $sp->duong_dan) }}" class="text-dark text-decoration-none">{{ $sp->ten_san_pham }}</a>
                            </h6>
                            <span class="text-danger fw-bold">{{ number_format($sp->gia_ban, 0, ',', '.') }}đ</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

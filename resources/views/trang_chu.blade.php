@extends('layouts.khach')

@section('tieu_de', 'Trang chủ - VPP Corner')

@section('noi_dung')
<div class="container mt-3">
    <!-- 1. Banner trượt chỉ hình ảnh (Carousel) -->
    <div id="bannerKhuyenMai" class="carousel slide rounded-3 overflow-hidden shadow-sm" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#bannerKhuyenMai" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#bannerKhuyenMai" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#bannerKhuyenMai" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/banner1.jpg') }}"
                     onerror="this.src='https://placehold.co/1200x380/e9ecef/495057?text=Banner+1+(1200x380)'"
                     class="d-block w-100 anh-banner" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/banner2.jpg') }}"
                     onerror="this.src='https://placehold.co/1200x380/dee2e6/495057?text=Banner+2+(1200x380)'"
                     class="d-block w-100 anh-banner" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/banner3.jpg') }}"
                     onerror="this.src='https://placehold.co/1200x380/ced4da/495057?text=Banner+3+(1200x380)'"
                     class="d-block w-100 anh-banner" alt="Banner 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerKhuyenMai" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerKhuyenMai" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <br>

    <!-- 2. Dải Mã giảm giá nổi bật -->
    @if($dsMaGiamGia->isNotEmpty())
    <section id="khu-vuc-ma-giam-gia" class="mb-4">
        <h5 class="fw-bold mb-3">Mã giảm giá dành cho bạn</h5>
        <div class="row g-3">
            @foreach($dsMaGiamGia as $ma)
                <div class="col-md-4">
                    <div class="card border-0 border-start border-4 border-danger shadow-sm h-100">
                        <div class="card-body d-flex justify-content-between align-items-center gap-2">
                            <div>
                                <span class="badge bg-danger-subtle text-danger fw-bold mb-1">{{ $ma->ma_code }}</span>
                                <div class="fw-bold">{{ $ma->ten_chuong_trinh }}</div>
                                <small class="text-muted">
                                    @if($ma->loai_giam === 'phan_tram')
                                        Giảm {{ rtrim(rtrim(number_format($ma->gia_tri_giam, 2, '.', ''), '0'), '.') }}%
                                        @if($ma->giam_toi_da)
                                            (tối đa {{ number_format($ma->giam_toi_da, 0, ',', '.') }}đ)
                                        @endif
                                    @else
                                        Giảm {{ number_format($ma->gia_tri_giam, 0, ',', '.') }}đ
                                    @endif
                                    · Đơn tối thiểu: {{ number_format($ma->don_hang_toi_thieu, 0, ',', '.') }}đ
                                </small>
                            </div>
                            <button type="button" class="btn btn-outline-danger btn-sm text-nowrap"
                                    onclick="navigator.clipboard?.writeText('{{ $ma->ma_code }}')">
                                Sao chép
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif


    <!-- 3. Section Sản phẩm + Thanh tìm kiếm & Bộ lọc -->
    <section id="khu-vuc-san-pham" class="mt-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <h3 class="fw-bold mb-0">Sản phẩm văn phòng phẩm</h3>
            <span class="text-muted small">Tìm thấy {{ $dsSanPham->total() }} sản phẩm</span>
        </div>

        <!-- Khung Tìm kiếm & Filter chung -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('trang_chu') }}#khu-vuc-san-pham" method="GET" class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold mb-1">Tìm kiếm sản phẩm</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" name="tu_khoa" class="form-control"
                                   placeholder="Nhập tên bút, tập, gôm..." value="{{ request('tu_khoa') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-semibold mb-1">Danh mục</label>
                        <select name="danh_muc" class="form-select">
                            <option value="">Tất cả danh mục</option>
                            @foreach($dsDanhMuc as $dm)
                                <option value="{{ $dm->duong_dan }}" {{ request('danh_muc') == $dm->duong_dan ? 'selected' : '' }}>
                                    {{ $dm->ten_danh_muc }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-semibold mb-1">Giá từ (VNĐ)</label>
                        <input type="number" name="gia_tu" class="form-control" min="0" step="1000"
                               placeholder="0" value="{{ request('gia_tu') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-semibold mb-1">Đến giá (VNĐ)</label>
                        <input type="number" name="gia_den" class="form-control" min="0" step="1000"
                               placeholder="500000" value="{{ request('gia_den') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-semibold mb-1">Sắp xếp</label>
                        <select name="sap_xep" class="form-select">
                            <option value="moi_nhat" {{ request('sap_xep') == 'moi_nhat' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="gia_tang" {{ request('sap_xep') == 'gia_tang' ? 'selected' : '' }}>Giá tăng dần</option>
                            <option value="gia_giam" {{ request('sap_xep') == 'gia_giam' ? 'selected' : '' }}>Giá giảm dần</option>
                        </select>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                        @if(request()->hasAny(['tu_khoa', 'danh_muc', 'gia_tu', 'gia_den', 'sap_xep']))
                            <a href="{{ route('trang_chu') }}#khu-vuc-san-pham" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Đặt lại bộ lọc
                            </a>
                        @endif
                        <button type="submit" class="btn btn-primary btn-sm px-3">
                            <i class="bi bi-funnel me-1"></i>Tìm & Lọc
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lưới hiển thị sản phẩm -->
        <div class="row g-3">
            @forelse($dsSanPham as $sp)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm card-san-pham">
                        <a href="{{ route('san_pham.chi_tiet', $sp->duong_dan) }}" class="text-decoration-none">
                            @if($sp->hinh_anh)
                                <img src="{{ asset('storage/' . $sp->hinh_anh) }}" class="card-img-top anh-san-pham" alt="{{ $sp->ten_san_pham }}">
                            @else
                                <div class="bg-light d-flex flex-column justify-content-center align-items-center text-secondary anh-san-pham">
                                    <i class="bi bi-box-seam fs-1"></i>
                                    <span class="small mt-1">{{ $sp->danhMuc->ten_danh_muc ?? 'Văn phòng phẩm' }}</span>
                                </div>
                            @endif
                        </a>

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="badge bg-light text-dark border">{{ $sp->danhMuc->ten_danh_muc ?? '' }}</span>
                                <small class="text-muted">ĐVT: {{ $sp->don_vi_tinh }}</small>
                            </div>

                            <h6 class="card-title mb-2">
                                <a href="{{ route('san_pham.chi_tiet', $sp->duong_dan) }}" class="text-dark text-decoration-none">
                                    {{ $sp->ten_san_pham }}
                                </a>
                            </h6>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-danger fs-6">{{ number_format($sp->gia_ban, 0, ',', '.') }}đ</span>
                                    @if($sp->so_luong_ton > 0)
                                        <small class="text-success">Còn {{ $sp->so_luong_ton }}</small>
                                    @else
                                        <small class="text-danger fw-semibold">Hết hàng</small>
                                    @endif
                                </div>

                                <div class="d-grid gap-1">
                                    <button type="button"
                                            class="btn btn-primary btn-sm btn-them-gio"
                                            data-id="{{ $sp->id }}"
                                            {{ $sp->so_luong_ton <= 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        Không tìm thấy sản phẩm nào phù hợp với từ khóa hoặc bộ lọc của bạn.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Phân trang -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $dsSanPham->links('pagination::bootstrap-5') }}
        </div>
    </section>

        <!-- 4. Dải Cam kết dịch vụ (to hơn, có viền/màu nhấn) -->
    <section class="mt-5">
        <div class="row g-4">
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 text-center p-4 cam-ket-card cam-ket-1">
                    <div class="cam-ket-icon mx-auto mb-3 bg-primary-subtle text-primary">
                        <i class="bi bi-patch-check-fill fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Hàng chính hãng</h5>
                    <p class="text-muted small mb-0">Bút, tập vở, dụng cụ văn phòng rõ nguồn gốc, chất lượng ổn định.</p>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 text-center p-4 cam-ket-card cam-ket-2">
                    <div class="cam-ket-icon mx-auto mb-3 bg-success-subtle text-success">
                        <i class="bi bi-box-seam-fill fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Đóng gói kỹ lưỡng</h5>
                    <p class="text-muted small mb-0">Bọc chống sốc, nẹp cứng chống cong mép giấy và gãy ngòi.</p>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 text-center p-4 cam-ket-card cam-ket-3">
                    <div class="cam-ket-icon mx-auto mb-3 bg-warning-subtle text-warning-emphasis">
                        <i class="bi bi-truck fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Giao hàng nhanh</h5>
                    <p class="text-muted small mb-0">Xác nhận và giao đơn nhanh chóng, hỗ trợ kiểm tra khi nhận.</p>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 text-center p-4 cam-ket-card cam-ket-4">
                    <div class="cam-ket-icon mx-auto mb-3 bg-danger-subtle text-danger">
                        <i class="bi bi-arrow-repeat fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Đổi trả dễ dàng</h5>
                    <p class="text-muted small mb-0">Hỗ trợ đổi mới nhanh chóng nếu sản phẩm lỗi từ nhà sản xuất.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Địa chỉ cửa hàng, Giờ mở/đóng cửa & Google Map -->
    <section id="dia-chi-cua-hang" class="mt-5">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="row g-0 align-items-stretch">
                <div class="col-lg-5 p-4 p-md-5 bg-white d-flex flex-column justify-content-center">
                    <span class="badge bg-primary-subtle text-primary align-self-start mb-2">Cửa hàng trực tiếp</span>
                    <h3 class="fw-bold mb-3">Địa chỉ & Giờ hoạt động</h3>

                    <div class="mb-3">
                        <div class="fw-semibold text-dark mb-1">
                            <i class="bi bi-geo-alt-fill text-danger me-2"></i>Địa chỉ cụ thể
                        </div>
                        <p class="text-muted mb-0 ps-4">
                            18 Ung Văn Khiêm, Phường Mỹ Xuyên, TP. Long Xuyên, An Giang
                        </p>
                    </div>

                    <div class="mb-3">
                        <div class="fw-semibold text-dark mb-1">
                            <i class="bi bi-clock-fill text-primary me-2"></i>Giờ mở - đóng cửa
                        </div>
                        <ul class="list-unstyled text-muted small mb-0 ps-4">
                            <li class="mb-1">Thứ 2 – Thứ 7: <strong>07:30 – 20:30</strong></li>
                            <li>Chủ nhật: <strong>08:00 – 19:00</strong></li>
                        </ul>
                    </div>

                    <div>
                        <div class="fw-semibold text-dark mb-1">
                            <i class="bi bi-telephone-fill text-success me-2"></i>Hotline hỗ trợ
                        </div>
                        <p class="text-muted mb-0 ps-4">0901 234 567</p>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="khung-ban-do h-100">
                        <iframe
                            src="https://www.google.com/maps?q=Long+Xuyen,+An+Giang,+Vietnam&output=embed"
                            class="w-100 h-100 border-0"
                            style="min-height: 320px;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

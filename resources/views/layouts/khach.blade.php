<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('tieu_de', 'Cửa hàng Văn Phòng Phẩm')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/khach_hang.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('trang_chu') }}">
                <i class="bi bi-pencil-square me-1"></i>VPP Corner
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuChinh">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuChinh">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('trang_chu') ? 'active fw-semibold' : '' }}" href="{{ route('trang_chu') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('trang_chu') }}#khu-vuc-san-pham">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gioi_thieu') ? 'active fw-semibold' : '' }}" href="{{ route('gioi_thieu') }}">Giới thiệu</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('gio_hang.index') }}" class="btn btn-outline-primary position-relative">
                    <i class="bi bi-cart3"></i> Giỏ hàng
                    <span id="so-luong-gio-hang" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ array_sum(array_column(session('gio_hang', []), 'so_luong')) }}
                    </span>
                </a>

                    @auth
                        <div class="dropdown">
                            <button class="btn btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->ho_ten }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('tai_khoan.ho_so') }}">Thông tin cá nhân</a></li>
                                <li><a class="dropdown-item" href="{{ route('don_hang.lich_su') }}">Đơn hàng của tôi</a></li>
                                @if(Auth::user()->vai_tro === 'admin')
                                    <li><a class="dropdown-item text-primary fw-semibold" href="{{ route('admin.dashboard') }}">Trang quản trị</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('dang_xuat') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('dang_nhap') }}" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Nội dung chính -->
    <main class="flex-grow-1">
        @if(session('thong_bao'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                    {{ session('thong_bao') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        @yield('noi_dung')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row gy-4 align-items-start">
                <div class="col-md-5">
                    <h5 class="fw-bold"><i class="bi bi-pencil-square me-1"></i>VPP Corner</h5>
                    <p class="text-secondary mb-2">Chuyên cung cấp bút viết, tập vở, sổ tay và dụng cụ văn phòng chất lượng cho học sinh, sinh viên và doanh nghiệp.</p>
                    <p class="text-secondary small mb-0">
                        <i class="bi bi-geo-alt me-1"></i>Long Xuyên, An Giang &nbsp;|&nbsp;
                        <i class="bi bi-telephone me-1"></i>0901 234 567
                    </p>
                </div>

                <div class="col-md-3">
                    <h6 class="fw-bold text-uppercase mb-3">Khám phá</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="{{ route('trang_chu') }}#khu-vuc-ma-giam-gia" class="text-secondary text-decoration-none link-footer">
                                Mã giảm giá
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('gioi_thieu') }}" class="text-secondary text-decoration-none link-footer">
                                Giới thiệu
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 text-md-end">
                    <div class="d-flex flex-column gap-1">
                        <a href="#" target="_blank" class="text-light text-decoration-none fw-bold fs-3 link-mang-xa-hoi">Instagram</a>
                        <a href="#" target="_blank" class="text-light text-decoration-none fw-bold fs-3 link-mang-xa-hoi">Facebook</a>
                        <a href="#" target="_blank" class="text-light text-decoration-none fw-bold fs-3 link-mang-xa-hoi">TikTok</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/khach_hang.js') }}"></script>
    @stack('js')
</body>
</html>

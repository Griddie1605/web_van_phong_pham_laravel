<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('tieu_de', 'Quản trị - VPP Corner')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2 me-1"></i>VPP Corner Admin
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.don_hang.*') ? 'active fw-semibold' : '' }}"
                    href="{{ route('admin.don_hang.index') }}">Đơn hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.danh_muc.*') ? 'active' : '' }}" href="{{ route('admin.danh_muc.index') }}">Danh mục</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.san_pham.*') ? 'active' : '' }}" href="{{ route('admin.san_pham.index') }}">Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.kho.nhap_kho') ? 'active' : '' }}" href="{{ route('admin.kho.nhap_kho') }}">Nhập kho</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.kho.nhat_ky') ? 'active' : '' }}" href="{{ route('admin.kho.nhat_ky') }}">Nhật ký kho</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.ma_giam_gia.*') ? 'active fw-semibold' : '' }}"
                    href="{{ route('admin.ma_giam_gia.index') }}">Mã giảm giá</a>
                </li>

            </ul>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('trang_chu') }}" class="btn btn-outline-light btn-sm">Xem cửa hàng</a>
                <form action="{{ route('dang_xuat') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Đăng xuất</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<main class="container-fluid py-4 px-lg-4">
    @if(session('thong_bao'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('thong_bao') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger py-2 small">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $loi)
                    <li>{{ $loi }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('noi_dung')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>

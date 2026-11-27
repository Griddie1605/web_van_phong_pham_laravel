@extends('layouts.khach')

@section('tieu_de', 'Đăng ký - VPP Corner')

@section('noi_dung')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-center mb-4">Đăng ký tài khoản mới</h4>

                    @if($errors->any())
                        <div class="alert alert-danger py-2 small">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $loi)
                                    <li>{{ $loi }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('dang_ky.xu_ly') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="ho_ten" class="form-control" value="{{ old('ho_ten') }}" required>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Số điện thoại</label>
                                <input type="text" name="so_dien_thoai" class="form-control" value="{{ old('so_dien_thoai') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Địa chỉ giao hàng mặc định</label>
                            <input type="text" name="dia_chi" class="form-control" value="{{ old('dia_chi') }}">
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="mat_khau" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="mat_khau_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
                        </div>
                    </form>

                    <div class="text-center mt-3 small">
                        Đã có tài khoản? <a href="{{ route('dang_nhap') }}">Đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.khach')

@section('tieu_de', 'Thông tin cá nhân - VPP Corner')

@section('noi_dung')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Thông tin tài khoản</h4>

                    @if($errors->any())
                        <div class="alert alert-danger py-2 small">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('tai_khoan.cap_nhat') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email đăng nhập</label>
                            <input type="email" class="form-control" value="{{ $nguoiDung->email }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="ho_ten" class="form-control" value="{{ old('ho_ten', $nguoiDung->ho_ten) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Số điện thoại</label>
                            <input type="text" name="so_dien_thoai" class="form-control" value="{{ old('so_dien_thoai', $nguoiDung->so_dien_thoai) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Địa chỉ giao hàng mặc định</label>
                            <textarea name="dia_chi" rows="2" class="form-control">{{ old('dia_chi', $nguoiDung->dia_chi) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

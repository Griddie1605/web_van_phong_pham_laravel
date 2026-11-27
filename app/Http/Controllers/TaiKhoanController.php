<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TaiKhoanController extends Controller
{
    public function formDangNhap()
    {
        if (Auth::check()) {
            return redirect()->route('trang_chu');
        }

        return view('tai_khoan.dang_nhap');
    }

    public function xuLyDangNhap(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'mat_khau' => 'required|min:6',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'mat_khau.required' => 'Vui lòng nhập mật khẩu.',
            'mat_khau.min' => 'Mật khẩu tối thiểu 6 ký tự.',
        ]);

        $nguoiDung = NguoiDung::where('email', $request->email)->first();

        if (!$nguoiDung || !Hash::check($request->mat_khau, $nguoiDung->mat_khau)) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Email hoặc mật khẩu không chính xác.']);
        }

        if ($nguoiDung->trang_thai === 'bi_khoa') {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Tài khoản của bạn đã bị khóa.']);
        }

        Auth::login($nguoiDung, $request->boolean('ghi_nho'));
        $request->session()->regenerate();

        return redirect()->intended(route('trang_chu'))
            ->with('thong_bao', 'Đăng nhập thành công!');
    }

    public function formDangKy()
    {
        if (Auth::check()) {
            return redirect()->route('trang_chu');
        }

        return view('tai_khoan.dang_ky');
    }

    public function xuLyDangKy(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:nguoi_dung,email',
            'so_dien_thoai' => 'nullable|string|max:20',
            'dia_chi' => 'nullable|string|max:500',
            'mat_khau' => 'required|min:6|confirmed',
        ], [
            'ho_ten.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.unique' => 'Email này đã tồn tại trong hệ thống.',
            'mat_khau.required' => 'Vui lòng nhập mật khẩu.',
            'mat_khau.min' => 'Mật khẩu tối thiểu 6 ký tự.',
            'mat_khau.confirmed' => 'Mật khẩu nhập lại không khớp.',
        ]);

        $nguoiDung = NguoiDung::create([
            'ho_ten' => $request->ho_ten,
            'email' => $request->email,
            'so_dien_thoai' => $request->so_dien_thoai,
            'dia_chi' => $request->dia_chi,
            'mat_khau' => Hash::make($request->mat_khau),
            'vai_tro' => 'khach_hang',
            'trang_thai' => 'hoat_dong',
        ]);

        Auth::login($nguoiDung);
        $request->session()->regenerate();

        return redirect()->route('trang_chu')
            ->with('thong_bao', 'Đăng ký tài khoản thành công!');
    }

    public function dangXuat(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('trang_chu')
            ->with('thong_bao', 'Đã đăng xuất khỏi hệ thống.');
    }

    public function hoSo()
    {
        $nguoiDung = Auth::user();

        return view('tai_khoan.ho_so', compact('nguoiDung'));
    }

    public function capNhatHoSo(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:100',
            'so_dien_thoai' => 'nullable|string|max:20',
            'dia_chi' => 'nullable|string|max:500',
        ], [
            'ho_ten.required' => 'Vui lòng nhập họ và tên.',
        ]);

        /** @var \App\Models\NguoiDung $nguoiDung */
        $nguoiDung = Auth::user();
        $nguoiDung->update([
            'ho_ten' => $request->ho_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'dia_chi' => $request->dia_chi,
        ]);

        return back()->with('thong_bao', 'Đã cập nhật thông tin cá nhân.');
    }
}

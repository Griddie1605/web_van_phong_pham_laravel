<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KiemTraAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('dang_nhap')
                ->withErrors(['email' => 'Vui lòng đăng nhập tài khoản quản trị.']);
        }

        $nguoiDung = Auth::user();

        if ($nguoiDung->trang_thai === 'bi_khoa') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('dang_nhap')
                ->withErrors(['email' => 'Tài khoản đã bị khóa.']);
        }

        if ($nguoiDung->vai_tro !== 'admin') {
            return redirect()->route('trang_chu')
                ->with('thong_bao', 'Bạn không có quyền truy cập khu vực quản trị.');
        }

        return $next($request);
    }
}

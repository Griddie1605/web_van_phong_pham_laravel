@extends('layouts.khach')

@section('tieu_de', 'Giới thiệu - VPP Corner')

@section('noi_dung')
<div class="container py-4 py-md-5">
    <!-- 1. Phần mở đầu giới thiệu -->
    <div class="card border-0 shadow-sm mb-4 overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="badge bg-primary-subtle text-primary fw-semibold mb-2">
                        <i class="bi bi-pencil-square me-1"></i>Giới thiệu VPP Corner
                    </span>
                    <h1 class="fw-bold text-dark mb-3">Không gian văn phòng phẩm gọn gàng, rõ ràng và dễ chọn</h1>
                    <p class="lead text-secondary mb-3">
                        VPP Corner chuyên cung cấp văn phòng phẩm, dụng cụ học tập, sổ tay và phụ kiện bàn làm việc phục vụ học sinh, sinh viên, giảng viên và nhân viên văn phòng.
                    </p>
                    <p class="text-muted mb-4">
                        Mỗi sản phẩm đều hiển thị rõ đơn vị tính (cây, cuốn, hộp, xấp), số lượng tồn kho thực tế và giá bán minh bạch để bạn chủ động chọn mua cho cá nhân hoặc đặt số lượng cho nhóm học tập, phòng ban.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('trang_chu') }}#khu-vuc-san-pham" class="btn btn-primary px-4">
                            <i class="bi bi-bag-check me-1"></i>Xem sản phẩm ngay
                        </a>
                        <a href="{{ route('trang_chu') }}#khu-vuc-ma-giam-gia" class="btn btn-outline-danger px-4">
                            <i class="bi bi-ticket-perforated me-1"></i>Mã giảm giá hiện có
                        </a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-light rounded-3 p-4 border h-100">
                        <h6 class="fw-bold text-uppercase text-secondary small mb-3">Điểm nổi bật tại cửa hàng</h6>
                        <ul class="list-unstyled mb-0 vstack gap-3">
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-circle-fill text-success mt-1"></i>
                                <div>
                                    <div class="fw-semibold">Tồn kho cập nhật liên tục</div>
                                    <small class="text-muted">Biết rõ số lượng còn lại trước khi thêm vào giỏ.</small>
                                </div>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-circle-fill text-success mt-1"></i>
                                <div>
                                    <div class="fw-semibold">Áp mã giảm giá linh hoạt</div>
                                    <small class="text-muted">Hỗ trợ mã giảm theo số tiền hoặc phần trăm ngay tại giỏ hàng.</small>
                                </div>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-circle-fill text-success mt-1"></i>
                                <div>
                                    <div class="fw-semibold">Theo dõi đơn hàng dễ dàng</div>
                                    <small class="text-muted">Xem lịch sử và trạng thái từng đơn hàng trong tài khoản.</small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Các con số tổng quan -->
    <div class="row g-3 mb-5">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm text-center h-100 p-3">
                <div class="fs-3 fw-bold text-primary">6+</div>
                <div class="fw-semibold">Nhóm mặt hàng chính</div>
                <small class="text-muted">Bút viết, tập vở, sổ tay, bìa hồ sơ...</small>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm text-center h-100 p-3">
                <div class="fs-3 fw-bold text-success">100%</div>
                <div class="fw-semibold">Giá niêm yết rõ ràng</div>
                <small class="text-muted">Hiển thị đầy đủ theo từng đơn vị tính</small>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm text-center h-100 p-3">
                <div class="fs-3 fw-bold text-warning">24/7</div>
                <div class="fw-semibold">Đặt hàng trực tuyến</div>
                <small class="text-muted">Chủ động lên đơn và kiểm tra lịch sử</small>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm text-center h-100 p-3">
                <div class="fs-3 fw-bold text-danger">Nhanh</div>
                <div class="fw-semibold">Xử lý & đóng gói</div>
                <small class="text-muted">Bọc chống sốc, giữ form tập vở đẹp</small>
            </div>
        </div>
    </div>

    <!-- 3. Đối tượng phục vụ & Danh mục -->
    <div class="mb-5">
        <div class="mb-3">
            <h3 class="fw-bold mb-1">Phù hợp cho từng nhu cầu</h3>
            <p class="text-muted mb-0">Dù bạn chuẩn bị đồ dùng cho năm học mới hay bổ sung vật tư cho văn phòng, VPP Corner đều có lựa chọn phù hợp.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 bg-primary-subtle text-primary p-3 mb-3">
                            <i class="bi bi-mortarboard-fill fs-4"></i>
                        </div>
                        <h5 class="fw-bold">Học sinh & Sinh viên</h5>
                        <p class="text-muted mb-0">
                            Tập vở, bút bi, bút gel, bút highlight, thước kẻ, gôm tẩy, máy tính cầm tay và sổ ghi chép phục vụ học tập, làm bài tập lớn và đồ án.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 bg-success-subtle text-success p-3 mb-3">
                            <i class="bi bi-building fs-4"></i>
                        </div>
                        <h5 class="fw-bold">Văn phòng & Cơ quan</h5>
                        <p class="text-muted mb-0">
                            Giấy in, bìa lá, bìa trình ký, kẹp bướm, bấm kim, băng keo, bút ký và đồ dùng lưu trữ giúp bàn làm việc và hồ sơ luôn ngăn nắp.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 bg-warning-subtle text-warning-emphasis p-3 mb-3">
                            <i class="bi bi-journal-bookmark-fill fs-4"></i>
                        </div>
                        <h5 class="fw-bold">Người yêu sổ tay & Decor</h5>
                        <p class="text-muted mb-0">
                            Sổ lò xo, sổ bullet journal, bút màu, sticker và phụ kiện trang trí góc học tập, góc làm việc gọn gàng, truyền cảm hứng mỗi ngày.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Cam kết dịch vụ -->
    <div class="mb-5">
        <div class="mb-3">
            <h3 class="fw-bold mb-1">Cam kết của VPP Corner</h3>
            <p class="text-muted mb-0">Giữ trải nghiệm mua sắm đơn giản, đáng tin cậy từ lúc chọn món đến khi nhận hàng.</p>
        </div>

        <div class="row g-3">
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 p-3">
                    <div class="fw-bold text-primary mb-1"><i class="bi bi-patch-check me-1"></i>Nguồn gốc rõ ràng</div>
                    <p class="text-muted small mb-0">Ưu tiên sản phẩm chính hãng, chất lượng ổn định, mô tả đúng thông tin và quy cách.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 p-3">
                    <div class="fw-bold text-success mb-1"><i class="bi bi-box-seam me-1"></i>Đóng gói cẩn thận</div>
                    <p class="text-muted small mb-0">Chống móp góc tập vở, hạn chế va đập làm gãy ngòi bút hay rách bao bì trong quá trình vận chuyển.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 p-3">
                    <div class="fw-bold text-warning mb-1"><i class="bi bi-receipt me-1"></i>Đơn hàng minh bạch</div>
                    <p class="text-muted small mb-0">Thể hiện rõ tạm tính, số tiền giảm giá và tổng thanh toán trước khi xác nhận đặt hàng.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 p-3">
                    <div class="fw-bold text-danger mb-1"><i class="bi bi-headset me-1"></i>Hỗ trợ tận tình</div>
                    <p class="text-muted small mb-0">Sẵn sàng hỗ trợ giải đáp khi có sai sót, thiếu món hoặc cần tư vấn chọn mặt hàng phù hợp.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. Quy trình mua sắm 4 bước -->
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-4 p-md-5">
            <h3 class="fw-bold mb-4">Quy trình mua sắm đơn giản</h3>
            <div class="row g-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill bg-primary fs-6">1</span>
                        <h6 class="fw-bold mb-0">Tìm & chọn sản phẩm</h6>
                    </div>
                    <p class="text-muted small mb-0">Lọc theo danh mục, khoảng giá hoặc từ khóa và xem chi tiết từng sản phẩm.</p>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill bg-primary fs-6">2</span>
                        <h6 class="fw-bold mb-0">Thêm giỏ & áp mã</h6>
                    </div>
                    <p class="text-muted small mb-0">Điều chỉnh số lượng, sao chép và áp dụng mã giảm giá phù hợp với giá trị đơn hàng.</p>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill bg-primary fs-6">3</span>
                        <h6 class="fw-bold mb-0">Xác nhận đặt hàng</h6>
                    </div>
                    <p class="text-muted small mb-0">Điền thông tin người nhận, địa chỉ giao hàng và gửi đơn nhanh chóng.</p>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill bg-primary fs-6">4</span>
                        <h6 class="fw-bold mb-0">Theo dõi & nhận hàng</h6>
                    </div>
                    <p class="text-muted small mb-0">Theo dõi tiến trình đơn hàng và kiểm tra sản phẩm khi nhận.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. Thông tin liên hệ & cửa hàng -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <h4 class="fw-bold mb-2">Thông tin liên hệ & cửa hàng</h4>
                    <p class="text-muted mb-3">
                        Cần hỗ trợ đặt hàng hoặc kiểm tra thông tin sản phẩm, bạn có thể liên hệ trực tiếp với VPP Corner:
                    </p>
                    <ul class="list-unstyled mb-0 vstack gap-2 text-secondary">
                        <li><i class="bi bi-geo-alt-fill text-danger me-2"></i><strong>Địa chỉ:</strong> 18 Ung Văn Khiêm, Phường Mỹ Xuyên, TP. Long Xuyên, An Giang</li>
                        <li><i class="bi bi-clock-fill text-primary me-2"></i><strong>Giờ hoạt động:</strong> Thứ 2 – Thứ 7 (07:30 – 20:30) · Chủ nhật (08:00 – 19:00)</li>
                        <li><i class="bi bi-telephone-fill text-success me-2"></i><strong>Hotline:</strong> 0901 234 567</li>
                    </ul>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <a href="{{ route('trang_chu') }}#dia-chi-cua-hang" class="btn btn-outline-dark me-2 mb-2 mb-sm-0">
                        <i class="bi bi-map me-1"></i>Xem bản đồ
                    </a>
                    <a href="{{ route('gio_hang.index') }}" class="btn btn-primary">
                        <i class="bi bi-cart3 me-1"></i>Đi tới giỏ hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

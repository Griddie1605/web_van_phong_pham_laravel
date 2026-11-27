document.addEventListener("DOMContentLoaded", function () {
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute("content") : "";

    const nutThemGioList = document.querySelectorAll(".btn-them-gio");
    nutThemGioList.forEach(function (nut) {
        nut.addEventListener("click", function () {
            const sanPhamId = this.getAttribute("data-id");
            const oSoLuong = document.getElementById("so-luong-mua");
            const soLuong = oSoLuong ? parseInt(oSoLuong.value, 10) || 1 : 1;

            if (!sanPhamId) {
                return;
            }

            fetch("/gio-hang/them", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json",
                },
                body: JSON.stringify({
                    san_pham_id: sanPhamId,
                    so_luong: soLuong,
                }),
            })
                .then(function (res) {
                    return res.json().then(function (data) {
                        return { status: res.status, data: data };
                    });
                })
                .then(function (kq) {
                    if (kq.data && kq.data.thanh_cong) {
                        const badge = document.getElementById("so-luong-gio-hang");
                        if (badge) {
                            badge.textContent = kq.data.so_luong_gio_hang;
                        }
                        hienThongBaoNhanh(kq.data.thong_bao, "success");
                    } else {
                        hienThongBaoNhanh((kq.data && kq.data.thong_bao) || "Không thể thêm sản phẩm.", "danger");
                    }
                })
                .catch(function () {
                    hienThongBaoNhanh("Có lỗi kết nối khi thêm vào giỏ hàng.", "danger");
                });
        });
    });

    const nutSaoChepList = document.querySelectorAll(".btn-sao-chep-ma");
    nutSaoChepList.forEach(function (nut) {
        nut.addEventListener("click", function () {
            const maCode = this.getAttribute("data-ma");
            if (!maCode) {
                return;
            }

            navigator.clipboard.writeText(maCode).then(function () {
                const chuCu = nut.textContent;
                nut.textContent = "Đã chép";
                nut.classList.replace("btn-outline-danger", "btn-success");

                setTimeout(function () {
                    nut.textContent = chuCu;
                    nut.classList.replace("btn-success", "btn-outline-danger");
                }, 1500);
            });
        });
    });

    function hienThongBaoNhanh(noiDung, loai) {
        const hopThongBao = document.createElement("div");
        hopThongBao.className = "alert alert-" + (loai || "success") + " alert-dismissible fade show position-fixed bottom-0 end-0 m-3 shadow";
        hopThongBao.style.zIndex = "1080";
        hopThongBao.innerHTML =
            noiDung +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';

        document.body.appendChild(hopThongBao);
        setTimeout(function () {
            hopThongBao.remove();
        }, 2500);
    }
});

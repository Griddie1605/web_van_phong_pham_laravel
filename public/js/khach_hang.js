document.addEventListener("DOMContentLoaded", function () {
    const nutThemGioList = document.querySelectorAll(".btn-them-gio");

    nutThemGioList.forEach(function (nut) {
        nut.addEventListener("click", function () {
            const sanPhamId = this.getAttribute("data-id");
            const oSoLuong = document.getElementById("so-luong-mua");
            const soLuong = oSoLuong ? parseInt(oSoLuong.value, 10) || 1 : 1;

            if (!sanPhamId) {
                return;
            }

            alert("Đã chọn thêm sản phẩm #" + sanPhamId + " (số lượng: " + soLuong + ") vào giỏ.");
        });
    });

    const nutSaoChepList = document.querySelectorAll(".btn-sao-chep-ma");

    nutSaoChepList.forEach(function (nut) {
        nut.addEventListener("click", function () {
            const maCode = this.getAttribute("data-ma");
            if (!maCode) {
                return;
            }

            navigator.clipboard.writeText(maCode).then(() => {
                const chuCu = this.textContent;
                this.textContent = "Đã chép";
                this.classList.replace("btn-outline-danger", "btn-success");

                setTimeout(() => {
                    this.textContent = chuCu;
                    this.classList.replace("btn-success", "btn-outline-danger");
                }, 1500);
            });
        });
    });
});

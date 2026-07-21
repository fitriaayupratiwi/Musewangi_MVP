$(function () {
    $(document).on("click", "#delete", function (e) {
        e.preventDefault();
        var link = $(this).attr("href");

        Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Ingin menghapus menu?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire("Berhasil!", "Menu telah dihapus.", "success");
            }
        });
    });
});

$(function () {
    $(document).on("click", "#deleteKategori", function (e) {
        e.preventDefault();
        var link = $(this).attr("href");

        Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Ingin Menghapus Kategori?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire("Berhasil!", "Kategori telah dihapus.", "success");
            }
        });
    });
});

$(function () {
    $(document).on("click", ".btn-stok", function (e) {
        e.preventDefault();
        let form = $(this).closest("form");

        Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Ingin Mengubah Stok?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Ubah!",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
                Swal.fire("Berhasil!", "Stok telah diubah.", "success");
            }
        });
    });
});

$(function () {
    $(document).on("click", ".btn-rekomendasi", function (e) {
        e.preventDefault();
        let form = $(this).closest("form");

        Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Ingin Mengubah Rekomendasi?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Ubah!",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
                Swal.fire("Berhasil!", "Rekomendasi telah diubah.", "success");
            }
        });
    });
});

$(document).on("click", "#pesanLagiBtn", function (e) {
    e.preventDefault();

    Swal.fire({
        text: "Kamu yakin ingin memulai pesanan baru?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Pesanan Baru",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = $(this).attr("href");
        }
    });
});


$(function () {
    $(document).on("click", ".btn-status", function (e) {
        e.preventDefault();
        let form = $(this).closest("form");

        Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Ingin Mengubah Status?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Ubah!",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
                Swal.fire("Berhasil!", "Status telah diubah.", "success");
            }
        });
    });

});


<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
Admin MUSEWANGI | QR Code Koleksi
</title>

<!-- Favicon HD Multi-Resolution -->
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=5">
<link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}?v=5">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=5">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=5">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=5">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=5">


<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@vite([
    'resources/css/app.css',
    'resources/js/app.js'
])

<link
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
    rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<style>
    [x-cloak] { display: none !important; }
</style>

<script>
function qrcodeApp() {
    return {
        sidebarToggle: false,
        qrModal: false,
        qrImage: '',
        qrName: '',
        qrUrl: '',
        labelUrl: '',

        buatQR() {
            const container = document.getElementById('qrCodeContainer');
            if (!container) return;
            container.innerHTML = '';

            try {
                if (typeof QRCode !== 'undefined') {
                    new QRCode(container, {
                        text: this.qrUrl,
                        width: 208,
                        height: 208,
                        colorDark: '#162544',
                        colorLight: '#ffffff',
                        correctLevel: QRCode.CorrectLevel.H
                    });
                    return;
                }
            } catch (e) {
                console.error(e);
            }

            container.innerHTML = '<img src="https://api.qrserver.com/v1/create-qr-code/?size=208x208&data=' + encodeURIComponent(this.qrUrl) + '" class="w-52 h-52 object-contain" alt="QR Code">';
        },

        downloadQR() {
            const container = document.getElementById('qrCodeContainer');
            const canvas = container ? container.querySelector('canvas') : null;
            const img = container ? container.querySelector('img') : null;

            if (canvas) {
                const link = document.createElement('a');
                link.href = canvas.toDataURL('image/png');
                link.download = 'QR-' + (this.qrName || 'koleksi') + '.png';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else if (img && img.src) {
                const link = document.createElement('a');
                link.href = img.src;
                link.download = 'QR-' + (this.qrName || 'koleksi') + '.png';
                link.target = '_blank';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                alert('QR Code belum tersedia.');
            }
        },

        printQR() {
            const container = document.getElementById('qrCodeContainer');
            const img = container ? (container.querySelector('img') || container.querySelector('canvas')) : null;
            if (!img) return;

            const src = img.src || (img.toDataURL ? img.toDataURL() : '');
            const win = window.open('', '_blank', 'width=450,height=550');
            if (!win) return;

            win.document.write(
                '<!DOCTYPE html>' +
                '<html>' +
                '<head>' +
                '<title>Cetak QR - ' + this.qrName + '</title>' +
                '<style>' +
                'body { font-family: sans-serif; text-align: center; padding: 24px; margin: 0; }' +
                '.qr-box { border: 2px solid #C9981C; border-radius: 16px; padding: 20px; display: inline-block; max-width: 320px; }' +
                'img { width: 200px; height: 200px; object-fit: contain; }' +
                'h2 { font-size: 16px; color: #162544; margin: 12px 0 4px; }' +
                '.footer { font-size: 10px; color: #999; margin-top: 12px; }' +
                '</style>' +
                '</head>' +
                '<body>' +
                '<div class="qr-box">' +
                '<img src="' + src + '">' +
                '<h2>' + this.qrName + '</h2>' +
                '<div class="footer">MUSEWANGI &middot; Museum Blambangan Banyuwangi</div>' +
                '</div>' +
                '<script>window.onload = function() { window.print(); }<' + '/script>' +
                '</body>' +
                '</html>'
            );
            win.document.close();
        }
    };
}
</script>
</head>

<body x-data="qrcodeApp()" class="bg-[#F8F5ED]">



{{-- SIDEBAR --}}

@include('admin.body.sidebar')



{{-- OVERLAY MOBILE --}}

<div

x-show="sidebarToggle"

@click="sidebarToggle=false"

class="
fixed
inset-0
bg-black/50
z-40
lg:hidden
"

></div>




{{-- HEADER --}}

@include('admin.body.header')

<main class="pt-24 lg:ml-64 p-5">


<div class="max-w-7xl mx-auto">

<div class="mb-6 flex items-end justify-between gap-4 flex-wrap">

    {{-- TITLE --}}
    <div>
        <h1 class="text-3xl font-bold text-[#162544]">
            QR Code Koleksi
        </h1>

        <p class="text-gray-500 mt-2">
            Lihat atau unduh QR Code setiap koleksi museum.
        </p>
    </div>


    {{-- SEARCH --}}
    <form
        method="GET"
        action="{{ route('admin.qrcode.index') }}"
        class="relative w-full sm:w-80">

        <i class="fa-solid fa-magnifying-glass
                  absolute left-4 top-1/2
                  -translate-y-1/2
                  text-gray-400">
        </i>

        <input
            type="text"
            name="cari"
            value="{{ request('cari') }}"
            placeholder="Cari koleksi..."
            autocomplete="off"
            class="w-full rounded-xl
                   border border-[#E8DCC0]
                   bg-white
                   py-3 pl-11 pr-11
                   text-sm
                   focus:outline-none
                   focus:ring-2
                   focus:ring-[#C9981C]">

        @if(request('cari'))
            <a
                href="{{ route('admin.qrcode.index') }}"
                class="absolute right-3 top-1/2
                       -translate-y-1/2
                       text-gray-400
                       hover:text-red-500">

                <i class="fa-solid fa-xmark"></i>

            </a>
        @endif

    </form>

</div>

{{-- CARD TABLE --}}

<div

class="
bg-white
rounded-2xl
shadow-lg
border
border-[#E8DCC0]
overflow-hidden
"

>



<div class="overflow-x-auto">



<table class="w-full text-sm">





<thead class="bg-[#E9DEC7] text-[#162544]">
    <tr>
        <th class="px-6 py-4 text-center w-24">Foto</th>
        <th class="px-6 py-4 text-left">Nama Koleksi</th>
        <th class="px-6 py-4 text-left">No. Registrasi</th>
        <th class="px-6 py-4 text-center">QR Code</th>
        <th class="px-6 py-4 text-center">Aksi</th>
    </tr>
</thead>

<tbody>
@forelse($koleksis as $koleksi)
    <tr class="border-b border-gray-100 hover:bg-[#faf7ef] transition">
        {{-- FOTO --}}
        <td class="px-6 py-4 text-center">
            @if($koleksi->fotoUrl())
                <img
                    src="{{ $koleksi->fotoUrl() }}"
                    alt="{{ $koleksi->nama_koleksi }}"
                    class="w-14 h-14 rounded-xl object-cover mx-auto bg-[#E8DCC0] border border-[#E8DCC0] shadow-sm"
                    onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-14 h-14 rounded-xl bg-[#E8DCC0] flex items-center justify-center text-gray-400 mx-auto border border-[#E8DCC0]\'><i class=\'fa fa-image text-lg text-[#C9981C]/70\'></i></div>';">
            @else
                <div class="w-14 h-14 rounded-xl bg-[#E8DCC0] flex items-center justify-center text-gray-400 mx-auto border border-[#E8DCC0]">
                    <i class="fa fa-image text-lg text-[#C9981C]/70"></i>
                </div>
            @endif
        </td>

        {{-- NAMA --}}
        <td class="px-6 py-4 font-semibold text-[#162544]">
            {{ $koleksi->nama_koleksi }}
        </td>

        {{-- NO REGISTRASI --}}
        <td class="px-6 py-4 font-mono text-gray-600 text-xs">
            {{ $koleksi->no_registrasi }}
        </td>

        {{-- QR CODE PREVIEW LANGSUNG TAMPIL --}}
        <td class="px-6 py-3 text-center">
            <div
                @click="
                    qrName = @js($koleksi->nama_koleksi);
                    qrReg = @js($koleksi->no_registrasi);
                    qrUrl = @js($koleksi->publicUrl());
                    qrModal = true;
                    $nextTick(() => { buatQR(); });
                "
                class="inline-flex items-center justify-center p-1.5 bg-white hover:bg-[#FFF8EA] rounded-xl border border-[#E8DCC0] hover:border-[#C9981C] shadow-sm hover:shadow transition transform hover:scale-105 cursor-pointer group"
                title="Klik untuk perbesar & cetak QR Code">
                <img
                    src="{{ $koleksi->qrCodeDataUri(56) }}"
                    alt="QR Code {{ $koleksi->nama_koleksi }}"
                    class="w-12 h-12 object-contain pointer-events-none select-none">
            </div>
        </td>

        {{-- AKSI --}}
        <td class="px-6 py-4">
            <div class="flex justify-center items-center gap-1.5">
                {{-- BUKA LINK PUBLIK (TEST SCAN) --}}
                <a
                    href="{{ $koleksi->publicUrl() }}"
                    target="_blank"
                    class="w-8 h-8 rounded-lg bg-[#EBF5FB] hover:bg-[#D4E6F1] text-[#2980B9] flex items-center justify-center transition"
                    title="Buka Halaman Publik (Hasil Scan HP)">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                </a>

                {{-- CETAK LABEL ETALASE MUSEUM --}}
                <a
                    href="{{ route('admin.qrcode.cetakLabel', $koleksi->id) }}"
                    target="_blank"
                    class="w-8 h-8 rounded-lg bg-[#FFF8EA] hover:bg-[#C9981C] text-[#C9981C] hover:text-white border border-[#C9981C]/40 flex items-center justify-center transition shadow-xs"
                    title="Cetak Label Etalase Museum (Placard Pameran)">
                    <i class="fa-solid fa-id-card text-xs"></i>
                </a>

                {{-- LIHAT QR --}}
                <button
                    type="button"
                    @click="
                        qrName = @js($koleksi->nama_koleksi);
                        qrReg = @js($koleksi->no_registrasi);
                        qrUrl = @js($koleksi->publicUrl());
                        labelUrl = @js(route('admin.qrcode.cetakLabel', $koleksi->id));
                        qrModal = true;
                        $nextTick(() => { buatQR(); });
                    "
                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-[#162544] flex items-center justify-center transition"
                    title="Perbesar & Cetak Label">
                    <i class="fa-solid fa-eye text-xs"></i>
                </button>

                {{-- HAPUS QR --}}
                <button
                    type="button"
                    class="btn-hapus-qr w-8 h-8 rounded-lg bg-gray-100 hover:bg-red-100 text-red-500 flex items-center justify-center transition"
                    data-nama="{{ $koleksi->nama_koleksi }}"
                    title="Hapus QR Code">
                    <i class="fa-solid fa-trash text-xs"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center py-12 text-gray-400">
            <i class="fa-solid fa-qrcode text-4xl mb-2 text-gray-300 block"></i>
            Belum ada QR Code koleksi museum.
        </td>
    </tr>
@endforelse
</tbody>
</table>

</div>
</div>

{{-- MODAL QR CODE --}}


<div
    x-show="qrModal"
    x-cloak
    style="display: none;"
    x-transition
    class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center">

    <div
        @click.outside="qrModal = false"

class="
bg-[#F8F5ED]
w-[420px]
rounded-2xl
shadow-2xl
p-8
relative
border
border-[#E8DCC0]
text-center
"

>


{{-- CLOSE --}}


<button


@click="qrModal=false"


class="
absolute
right-5
top-3
text-3xl
text-gray-700
"

>

×

</button>


<h2 class="text-xl font-bold text-[#162544] mb-1">QR Code</h2>
<p class="text-xs text-gray-500 font-medium mb-5" x-text="qrName"></p>

<div
    id="qrCodeContainer"
    class="
        w-52
        h-52
        mx-auto
        bg-white
        rounded-lg
        flex
        items-center
        justify-center
        mb-6
></div>

<div class="mb-4">
    <a
        :href="labelUrl"
        target="_blank"
        class="w-full py-2.5 px-4 rounded-xl bg-[#A0731E] hover:bg-[#875F14] text-white font-bold text-xs shadow-md flex items-center justify-center gap-2 transition transform active:scale-95"
    >
        <i class="fa-solid fa-id-card text-sm text-[#FFD86B]"></i>
        <span>Cetak Label Etalase Museum (Placard Pameran)</span>
    </a>
</div>

<div class="flex gap-2.5 justify-center">
    <button
        type="button"
        @click="printQR()"
        class="
            border border-[#C9981C]
            text-[#C9981C]
            hover:bg-[#C9981C]/10
            px-6
            py-2
            rounded-lg
            text-sm
            font-bold
            flex items-center gap-1.5
            transition
        "
    >
        <i class="fa-solid fa-print"></i> Cetak
    </button>

    <button
        type="button"
        @click="downloadQR()"
        class="
            bg-[#162544]
            hover:bg-[#0E1830]
            text-white
            px-6
            py-2
            rounded-lg
            text-sm
            font-bold
            flex items-center gap-1.5
            shadow
            transition
        "
    >
        <i class="fa-solid fa-download"></i> Download
    </button>
</div>

    <div class="mt-4 pt-4 border-t border-[#E8DCC0]/60">
        <a
            :href="qrUrl"
            target="_blank"
            class="inline-flex items-center gap-1.5 text-xs text-[#2980B9] hover:text-[#1F618D] font-medium hover:underline">
            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Buka Halaman Pengunjung (Hasil Scan)
        </a>
    </div>


</div>


</div>

</body>


</html>
{{-- SWEETALERT HAPUS QR --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.btn-hapus-qr').forEach(function (button) {

        button.addEventListener('click', function () {

            const form = this.closest('.form-hapus-qr');
            const nama = this.dataset.nama;

            Swal.fire({
                title: 'Hapus QR Code?',
                text: 'QR Code "' + nama + '" akan dihapus dari sistem.',
                icon: 'warning',

                showCancelButton: true,

                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#6B7280',

                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',

                reverseButtons: true,

                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-lg',
                    cancelButton: 'rounded-lg'
                }

            }).then(function (result) {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

        });

    });

});
</script>


{{-- TOAST BERHASIL --}}
@if(session('success'))

<script>
document.addEventListener('DOMContentLoaded', function () {

    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 3000,
        extendedTimeOut: 1000,
        showDuration: 300,
        hideDuration: 300,
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut'
    };

    toastr.success(@json(session('success')));

});
</script>

@endif

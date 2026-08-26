<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
Admin MUSEWANGI | QR Code Koleksi
</title>


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
</head>

<body

x-data="
{
    sidebarToggle: false,

    qrModal: false,

    qrImage: '',
    qrName: '',
    qrUrl: '',

    buatQR() {

        const container = document.getElementById('qrCodeContainer');

        container.innerHTML = '';

        new QRCode(container, {
            text: this.qrUrl,
            width: 208,
            height: 208,
            colorDark: '#162544',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });

    },

    downloadQR() {

        const container = document.getElementById('qrCodeContainer');

        const canvas = container.querySelector('canvas');

        if (!canvas) {
            alert('QR Code belum tersedia.');
            return;
        }

        const link = document.createElement('a');

        link.href = canvas.toDataURL('image/png');

        link.download = 'QR-' + this.qrName + '.png';

        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);
    }
}
"

class="bg-[#F8F5ED]"

>



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





<thead

class="
bg-[#E9DEC7]
text-[#162544]
"

>


<tr>


<th class="px-8 py-4 text-left">

Nama

</th>


<th class="px-8 py-4 text-left">

No. Registrasi

</th>


<th class="px-8 py-4 text-center">

QR Code

</th>


<th class="px-8 py-4 text-center">

Aksi

</th>


</tr>


</thead>









<tbody>


@forelse($koleksis as $koleksi)



<tr

class="
border-b
hover:bg-[#faf7ef]
transition
"

>





{{-- NAMA --}}


<td

class="
px-8
py-5
font-semibold
text-[#162544]
"

>


{{$koleksi->nama_koleksi}}


</td>



{{-- NO REGISTRASI --}}


<td

class="
px-8
py-5
text-gray-600
"

>


{{$koleksi->no_registrasi}}


</td>



{{-- QR CODE PREVIEW --}}


<td

class="
px-8
py-5
text-center
"

>



@if($koleksi->qr_code)



<img


src="{{asset($koleksi->qr_code)}}"


class="
w-10
h-10
mx-auto
object-contain
pointer-events-none
select-none
"

>



@else


<div

class="
w-10
h-10
mx-auto
bg-gray-100
rounded
flex
items-center
justify-center
"

>


<i

class="
fa-solid
fa-qrcode
text-gray-400
"

></i>


</div>


@endif


</td>

{{-- AKSI --}}

<td class="px-8 py-5">
<div class="flex justify-center gap-2">

    {{-- LIHAT QR --}}
    <button
        type="button"
        @click="
            qrName = @js($koleksi->nama_koleksi);
            qrUrl = @js(route('collection.show', $koleksi->id));
            qrModal = true;

            $nextTick(() => {
                buatQR();
            });
        "
        class="w-8 h-8 rounded-md
               bg-gray-100
               hover:bg-gray-200
               flex items-center
               justify-center
               transition"
        title="Lihat QR Code">

        <i class="fa-solid fa-eye text-[#162544] text-xs"></i>

    </button>

    {{-- HAPUS QR --}}
    <button
        type="button"
        class="btn-hapus-qr
               w-8 h-8
               rounded-md
               bg-gray-100
               hover:bg-red-100
               flex items-center
               justify-center
               transition"
        data-nama="{{ $koleksi->nama_koleksi }}"
        title="Hapus QR Code">

        <i class="fa-solid fa-trash text-red-500 text-xs"></i>

    </button>

</div>

</form>
@empty

<tr>
    <td colspan="4" class="text-center py-8 text-gray-500">
        Tidak ada data koleksi
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


x-transition


class="
fixed
inset-0
z-50
bg-black/50
backdrop-blur-sm
flex
items-center
justify-center
"

>



<div


@click.away="qrModal=false"


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


<h2

class="
text-xl
font-bold
text-[#162544]
mb-6
"

>


QR Code


</h2>

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
    "
></div>

<button
    type="button"
    @click="downloadQR()"
    class="
        bg-[#162544]
        hover:bg-[#0E1830]
        text-white
        px-10
        py-2
        rounded-lg
        text-sm
    "
>
    Download
</button>


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

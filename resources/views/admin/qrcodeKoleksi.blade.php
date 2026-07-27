<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <title>Admin Musewangi | QR Code Koleksi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    x-data="qrPage()"
    x-init="init()"
    :class="{ 'dark bg-gray-900': darkMode === true }"
    class="relative min-w-screen bg-[#F5EFE3] font-sans antialiased"
>
    @include('admin.body.sidebar')

    <div
        x-show="sidebarToggle"
        @click="sidebarToggle = false"
        class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        x-transition.opacity
    ></div>

    @include('admin.body.header')

    <main class="pt-16 transition-all duration-300 p-4 lg:ml-64 z-10">
        <div class="mx-auto max-w-6xl">
            <div class="mb-5 flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-[28px] font-bold leading-tight text-[#1D2745]">QR Code Koleksi</h1>
                    <p class="mt-1 max-w-2xl text-sm text-[#5A554B]">
                        Lihat atau unduh QR Code untuk setiap koleksi agar informasi mudah diakses.
                    </p>
                </div>

                <a
                    href="{{ route('admin.kategori.menu') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#B78921] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:brightness-110"
                >
                    <span class="text-base leading-none">+</span>
                    Tambah Kategori
                </a>
            </div>

            <div class="overflow-hidden rounded-2xl border border-[#D9C28F] bg-[#F1E4C7] shadow-[0_10px_28px_rgba(0,0,0,0.18)]">
                <div class="grid grid-cols-12 border-b border-[#D9C28F] px-6 py-4 text-center text-sm font-semibold text-[#3A3A3A]">
                    <div class="col-span-4">Nama</div>
                    <div class="col-span-2">No. Registrasi</div>
                    <div class="col-span-3">QR Code</div>
                    <div class="col-span-3">Aksi</div>
                </div>

                <div class="rounded-b-2xl bg-white">
                    @forelse ($kategori as $item)
                        @php
                            $qrText = url('/menu?kategori=' . $item->id);
                        @endphp
                        <div class="grid grid-cols-12 items-center border-b border-gray-100 px-6 py-4 last:border-b-0">
                            <div class="col-span-4 text-sm text-[#575757]">
                                {{ $item->nama }}
                            </div>

                            <div class="col-span-2 text-sm text-[#575757]">
                                {{ $item->id }}
                            </div>

                            <div class="col-span-3 flex items-center justify-center">
                                <div id="qr-row-{{ $item->id }}" class="qr-box h-[64px] w-[64px]"></div>
                            </div>

                            <div class="col-span-3 flex justify-center gap-2">
                                <button
                                    type="button"
                                    @click="openQrModal({ name: @js($item->nama), text: @js($qrText), id: {{ $item->id }} })"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-[#E3E3E3] text-[#2F2F2F] transition hover:bg-[#D4D4D4]"
                                    title="Lihat"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 4.5c-3.03 0-5.64 1.83-7 4.5 1.36 2.67 3.97 4.5 7 4.5s5.64-1.83 7-4.5c-1.36-2.67-3.97-4.5-7-4.5Zm0 7a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z" />
                                    </svg>
                                </button>

                                <button
                                    type="button"
                                    @click="downloadQr('qr-row-{{ $item->id }}', @js($item->nama))"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-md bg-[#E3E3E3] text-[#2F2F2F] transition hover:bg-[#D4D4D4]"
                                    title="Download"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 3a1 1 0 0 1 1 1v5.59l1.3-1.3 1.4 1.42L10 13.41 6.3 9.7l1.4-1.42L9 9.59V4a1 1 0 0 1 1-1Zm-6 12h12v2H4v-2Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center text-sm text-gray-500">
                            Belum ada kategori.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <!-- QR MODAL -->
    <div x-cloak x-show="qrOpen" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 p-4" x-transition.opacity>
        <div class="relative w-full max-w-lg rounded-[22px] bg-[#F7EFE0] px-8 py-7 shadow-2xl">
            <button type="button" @click="qrOpen = false" class="absolute right-5 top-4 text-2xl leading-none text-black/80">&times;</button>

            <h2 class="text-lg font-bold text-[#17223F]">QR Code</h2>

            <div class="mt-6 flex flex-col items-center">
                <div id="qr-modal-box" class="rounded-md bg-white p-4 shadow-sm"></div>
            </div>

            <div class="mt-6 flex justify-center">
                <button type="button" @click="downloadCurrentQr()" class="rounded-md bg-[#17223F] px-5 py-2 text-xs font-semibold text-white">
                    Download
                </button>
            </div>
        </div>
    </div>

    <script>
        function qrPage() {
            return {
                darkMode: false,
                sidebarToggle: false,
                qrOpen: false,
                qrName: '',
                qrText: '',
                init() {
                    this.darkMode = JSON.parse(localStorage.getItem('darkMode') || 'false');
                    this.$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)));

                    this.renderRowQrs();
                },
                renderRowQrs() {
                    @foreach ($kategori as $item)
                        const row{{ $item->id }} = document.getElementById('qr-row-{{ $item->id }}');
                        if (row{{ $item->id }}) {
                            row{{ $item->id }}.innerHTML = '';
                            new QRCode(row{{ $item->id }}, {
                                text: @js(url('/menu?kategori=' . $item->id)),
                                width: 64,
                                height: 64,
                                colorDark: '#111111',
                                colorLight: '#ffffff',
                                correctLevel: QRCode.CorrectLevel.H,
                            });
                        }
                    @endforeach
                },
                openQrModal(payload) {
                    this.qrName = payload.name;
                    this.qrText = payload.text;
                    this.qrOpen = true;

                    this.$nextTick(() => {
                        const box = document.getElementById('qr-modal-box');
                        if (!box) return;
                        box.innerHTML = '';
                        new QRCode(box, {
                            text: payload.text,
                            width: 220,
                            height: 220,
                            colorDark: '#111111',
                            colorLight: '#ffffff',
                            correctLevel: QRCode.CorrectLevel.H,
                        });
                    });
                },
                downloadCurrentQr() {
                    const box = document.getElementById('qr-modal-box');
                    if (!box) return;

                    const canvas = box.querySelector('canvas');
                    const img = box.querySelector('img');
                    let dataUrl = '';

                    if (canvas) {
                        dataUrl = canvas.toDataURL('image/png');
                    } else if (img) {
                        dataUrl = img.src;
                    }

                    if (!dataUrl) return;

                    const link = document.createElement('a');
                    link.href = dataUrl;
                    const safeName = (this.qrName || 'koleksi').toString().replace(/[^a-z0-9-_]+/gi, '-').toLowerCase();
                    link.download = `qr-${safeName}.png`;
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                },
                downloadQr(rowId, name) {
                    const box = document.getElementById(rowId);
                    if (!box) return;

                    const canvas = box.querySelector('canvas');
                    const img = box.querySelector('img');
                    let dataUrl = '';

                    if (canvas) {
                        dataUrl = canvas.toDataURL('image/png');
                    } else if (img) {
                        dataUrl = img.src;
                    }

                    if (!dataUrl) return;

                    const link = document.createElement('a');
                    link.href = dataUrl;
                    const safeName = (name || 'koleksi').toString().replace(/[^a-z0-9-_]+/gi, '-').toLowerCase();
                    link.download = `qr-${safeName}.png`;
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                },
            }
        }
    </script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;
                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;
                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;
                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>
</body>

</html>

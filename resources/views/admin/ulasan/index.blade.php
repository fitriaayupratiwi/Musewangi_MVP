<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin MUSEWANGI | Moderasi Ulasan Pengunjung</title>

    <!-- Favicon HD Multi-Resolution -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=5">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=5">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=5">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=5">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Toastr & SweetAlert -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F8F5ED;
        }
    </style>
</head>

<body x-data="{ sidebarToggle: false, darkMode: false }" class="relative min-h-screen bg-[#F8F5ED]">

    {{-- SIDEBAR --}}
    @include('admin.body.sidebar')

    {{-- OVERLAY MOBILE --}}
    <div x-show="sidebarToggle" @click="sidebarToggle = false"
        class="fixed inset-0 z-40 bg-black/50 backdrop-blur-xs lg:hidden" style="display: none;"></div>

    {{-- HEADER --}}
    @include('admin.body.header')

    {{-- MAIN CONTENT --}}
    <main class="pt-28 pb-16 px-4 sm:px-6 lg:px-8 lg:ml-64 z-10 min-h-screen transition-all duration-300">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- PAGE TITLE BAR -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-[#E8DCC0] shadow-xs">
                <div>
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#162544] to-[#21365E] text-[#FFD86B] flex items-center justify-center shadow-xs">
                            <i class="fa-solid fa-comments text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-extrabold text-[#162544] tracking-tight">
                                Moderasi Ulasan Pengunjung
                            </h1>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Pantau, setujui, sembunyikan, atau hapus feedback dari pengunjung museum.
                            </p>
                        </div>
                    </div>
                </div>

                @if($stats['pending'] > 0)
                    <form action="{{ route('admin.ulasan.bulkApprove') }}" method="POST" onsubmit="return confirmBulkApprove(event)">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition active:scale-95">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Setujui Semua Pending ({{ $stats['pending'] }})</span>
                        </button>
                    </form>
                @endif
            </div>

            <!-- STATS CARDS ROW -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
                <!-- 1. Total Ulasan -->
                <div class="bg-white p-4 rounded-2xl border border-[#E8DCC0] shadow-xs">
                    <div class="flex items-center justify-between text-gray-500 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider">Total</span>
                        <div class="w-8 h-8 rounded-lg bg-[#162544]/10 text-[#162544] flex items-center justify-center text-xs">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-[#162544]">{{ $stats['total'] }}</div>
                    <div class="text-[11px] text-gray-400 mt-0.5">Seluruh ulasan masuk</div>
                </div>

                <!-- 2. Menunggu Moderasi (Pending) -->
                <div class="bg-white p-4 rounded-2xl border {{ $stats['pending'] > 0 ? 'border-amber-400 bg-amber-50/30' : 'border-[#E8DCC0]' }} shadow-xs">
                    <div class="flex items-center justify-between text-amber-600 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider">Pending</span>
                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-xs {{ $stats['pending'] > 0 ? 'animate-bounce' : '' }}">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-amber-700">{{ $stats['pending'] }}</div>
                    <div class="text-[11px] text-amber-600/80 mt-0.5">Perlu ditinjau petugas</div>
                </div>

                <!-- 3. Disetujui (Approved) -->
                <div class="bg-white p-4 rounded-2xl border border-[#E8DCC0] shadow-xs">
                    <div class="flex items-center justify-between text-emerald-600 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider">Disetujui</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-emerald-700">{{ $stats['approved'] }}</div>
                    <div class="text-[11px] text-emerald-600/80 mt-0.5">Tampil di publik</div>
                </div>

                <!-- 4. Ditolak / Tersembunyi (Rejected) -->
                <div class="bg-white p-4 rounded-2xl border border-[#E8DCC0] shadow-xs">
                    <div class="flex items-center justify-between text-rose-600 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider">Ditolak</span>
                        <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-eye-slash"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-extrabold text-rose-700">{{ $stats['rejected'] }}</div>
                    <div class="text-[11px] text-rose-600/80 mt-0.5">Disembunyikan</div>
                </div>

                <!-- 5. Rata-rata Skor Bintang -->
                <div class="col-span-2 sm:col-span-1 bg-gradient-to-br from-[#162544] to-[#21365E] p-4 rounded-2xl text-white shadow-sm">
                    <div class="flex items-center justify-between text-[#FFD86B] mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider">Rating Rata-rata</span>
                        <i class="fa-solid fa-star text-sm"></i>
                    </div>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-2xl font-extrabold text-white">{{ $stats['avg_rating'] }}</span>
                        <span class="text-xs text-[#FFD86B]/80 font-medium">/ 5.0</span>
                    </div>
                    <div class="flex items-center gap-1 text-[#FFD86B] text-[10px] mt-1">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star {{ $i <= round($stats['avg_rating']) ? 'text-[#FFD86B]' : 'text-white/20' }}"></i>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- FILTER TABS & SEARCH -->
            <div class="bg-white p-4 rounded-2xl border border-[#E8DCC0] shadow-xs space-y-4">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <!-- Status Filter Tabs -->
                    <div class="flex flex-wrap items-center gap-1.5 bg-[#F8F5ED] p-1.5 rounded-xl border border-[#E8DCC0]/60">
                        <a href="{{ route('admin.ulasan.index', array_merge(request()->query(), ['status' => 'all'])) }}"
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ $status === 'all' ? 'bg-[#162544] text-white shadow-xs' : 'text-gray-600 hover:text-[#162544]' }}">
                            Semua ({{ $stats['total'] }})
                        </a>
                        <a href="{{ route('admin.ulasan.index', array_merge(request()->query(), ['status' => 'pending'])) }}"
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 {{ $status === 'pending' ? 'bg-amber-500 text-white shadow-xs' : 'text-amber-700 hover:text-amber-800' }}">
                            <span>Perlu Ditinjau</span>
                            @if($stats['pending'] > 0)
                                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'pending' ? 'bg-white text-amber-600' : 'bg-amber-200 text-amber-800' }} font-black">
                                    {{ $stats['pending'] }}
                                </span>
                            @endif
                        </a>
                        <a href="{{ route('admin.ulasan.index', array_merge(request()->query(), ['status' => 'approved'])) }}"
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ $status === 'approved' ? 'bg-emerald-600 text-white shadow-xs' : 'text-emerald-700 hover:text-emerald-800' }}">
                            Disetujui ({{ $stats['approved'] }})
                        </a>
                        <a href="{{ route('admin.ulasan.index', array_merge(request()->query(), ['status' => 'rejected'])) }}"
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ $status === 'rejected' ? 'bg-rose-600 text-white shadow-xs' : 'text-rose-700 hover:text-rose-800' }}">
                            Ditolak ({{ $stats['rejected'] }})
                        </a>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.ulasan.index') }}" class="flex items-center gap-2">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <div class="relative w-full sm:w-64">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="text" name="search" value="{{ $search }}"
                                placeholder="Cari pengunjung / ulasan..."
                                class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-[#E8DCC0] focus:border-[#C9981C] focus:ring-1 focus:ring-[#C9981C] outline-none">
                        </div>
                        @if($search)
                            <a href="{{ route('admin.ulasan.index', ['status' => $status]) }}"
                                class="px-2.5 py-2 text-xs rounded-xl border border-gray-300 text-gray-500 hover:bg-gray-100" title="Reset pencarian">
                                <i class="fa-solid fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- TABLE REVIEW LIST -->
            <div class="bg-white rounded-2xl border border-[#E8DCC0] shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-[#F8F5ED] text-[#162544] font-bold uppercase tracking-wider border-b border-[#E8DCC0]">
                            <tr>
                                <th class="px-4 py-3.5 w-12 text-center">#</th>
                                <th class="px-4 py-3.5 min-w-[180px]">Koleksi Artefak</th>
                                <th class="px-4 py-3.5 min-w-[160px]">Pengunjung</th>
                                <th class="px-4 py-3.5 min-w-[120px]">Rating</th>
                                <th class="px-4 py-3.5 min-w-[280px]">Ulasan / Komentar</th>
                                <th class="px-4 py-3.5 min-w-[130px] text-center">Status</th>
                                <th class="px-4 py-3.5 min-w-[140px] text-center">Aksi Moderasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E8DCC0]/60">
                            @forelse($reviews as $idx => $review)
                                @php
                                    $badge = $review->statusBadge();
                                @endphp
                                <tr class="hover:bg-[#FDFAF4] transition {{ $review->isPending() ? 'bg-amber-50/30' : '' }}">
                                    <!-- No -->
                                    <td class="px-4 py-3.5 text-center font-mono text-gray-400">
                                        {{ $reviews->firstItem() + $idx }}
                                    </td>

                                    <!-- Koleksi -->
                                    <td class="px-4 py-3.5">
                                        @if($review->collection)
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100 border border-[#E8DCC0] shrink-0">
                                                    @if($review->collection->fotoUrl())
                                                        <img src="{{ $review->collection->fotoUrl() }}" alt="{{ $review->collection->nama_koleksi }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                            <i class="fa-solid fa-image text-xs"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="min-w-0">
                                                    <a href="{{ $review->collection->publicUrl() }}" target="_blank"
                                                        class="font-bold text-[#162544] hover:text-[#C9981C] transition line-clamp-1 flex items-center gap-1">
                                                        <span>{{ $review->collection->nama_koleksi }}</span>
                                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px] text-gray-400"></i>
                                                    </a>
                                                    <span class="text-[10px] text-gray-500 font-mono">{{ $review->collection->no_registrasi }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Koleksi Dihapus</span>
                                        @endif
                                    </td>

                                    <!-- Pengunjung -->
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-[#C9981C] to-[#E6B138] text-white font-black text-[11px] flex items-center justify-center shrink-0 shadow-xs">
                                                {{ strtoupper(substr($review->nama_pengunjung, 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <div class="font-bold text-[#162544] truncate">{{ $review->nama_pengunjung }}</div>
                                                <div class="text-[10px] text-gray-400" title="{{ $review->created_at->format('d M Y H:i:s') }}">
                                                    {{ $review->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Rating -->
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star text-xs {{ $i <= $review->rating ? 'text-[#FFB800]' : 'text-gray-200' }}"></i>
                                            @endfor
                                            <span class="ml-1 font-bold text-[#162544] text-[11px]">({{ $review->rating }}/5)</span>
                                        </div>
                                    </td>

                                    <!-- Komentar -->
                                    <td class="px-4 py-3.5">
                                        <p class="text-gray-700 leading-relaxed bg-[#F8F5ED]/70 p-2.5 rounded-xl border border-[#E8DCC0]/40 text-xs">
                                            "{{ $review->komentar }}"
                                        </p>
                                    </td>

                                    <!-- Status Badge -->
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold {{ $badge['class'] }}">
                                            <i class="{{ $badge['icon'] }}"></i>
                                            <span>{{ $badge['label'] }}</span>
                                        </span>
                                    </td>

                                    <!-- Aksi Moderasi -->
                                    <td class="px-4 py-3.5 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            {{-- TOMBOL SETUJUI (Jika belum approved) --}}
                                            @if(!$review->isApproved())
                                                <form action="{{ route('admin.ulasan.approve', $review->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white border border-emerald-300 flex items-center justify-center transition shadow-xs"
                                                        title="Setujui (Tampilkan di Publik)">
                                                        <i class="fa-solid fa-check text-xs"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- TOMBOL TOLAK (Jika belum rejected) --}}
                                            @if(!$review->isRejected())
                                                <form action="{{ route('admin.ulasan.reject', $review->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white border border-amber-300 flex items-center justify-center transition shadow-xs"
                                                        title="Tolak (Sembunyikan dari Publik)">
                                                        <i class="fa-solid fa-ban text-xs"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- TOMBOL HAPUS PERMANEN --}}
                                            <button type="button"
                                                onclick="konfirmasiHapusUlasan('{{ $review->id }}', '{{ addslashes($review->nama_pengunjung) }}')"
                                                class="w-8 h-8 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-600 hover:text-white border border-rose-300 flex items-center justify-center transition shadow-xs"
                                                title="Hapus Permanen">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>

                                            <form id="form-delete-{{ $review->id }}"
                                                action="{{ route('admin.ulasan.destroy', $review->id) }}"
                                                method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center text-gray-300 text-2xl">
                                                <i class="fa-solid fa-comment-slash"></i>
                                            </div>
                                            <div class="font-bold text-gray-600 text-sm">Tidak ada ulasan ditemukan</div>
                                            <p class="text-xs text-gray-400 max-w-sm">
                                                @if($status === 'pending')
                                                    Semua ulasan pengunjung sudah selesai dimoderasi.
                                                @elseif($search)
                                                    Tidak ada ulasan yang cocok dengan kata kunci "{{ $search }}".
                                                @else
                                                    Belum ada ulasan dari pengunjung yang masuk ke dalam sistem.
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                @if($reviews->hasPages())
                    <div class="p-4 border-t border-[#E8DCC0] bg-[#F8F5ED]/40 flex justify-between items-center">
                        <div class="text-xs text-gray-500">
                            Menampilkan <span class="font-bold text-[#162544]">{{ $reviews->firstItem() }}</span> sampai <span class="font-bold text-[#162544]">{{ $reviews->lastItem() }}</span> dari <span class="font-bold text-[#162544]">{{ $reviews->total() }}</span> ulasan
                        </div>
                        <div>
                            {{ $reviews->links() }}
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </main>

    <!-- SWEETALERT & TOASTR SCRIPTS -->
    <script>
        function konfirmasiHapusUlasan(id, nama) {
            Swal.fire({
                title: 'Hapus Ulasan?',
                text: `Ulasan dari "${nama}" akan dihapus secara permanen dari basis data.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#E11D48',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl border border-gray-200'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + id).submit();
                }
            });
        }

        function confirmBulkApprove(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Setujui Semua Pending?',
                text: 'Semua ulasan yang saat ini menunggu moderasi akan disetujui dan langsung tampil di halaman publik museum.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Setujui Semua!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl border border-gray-200'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
            return false;
        }

        // Flash Toastr Notification
        @if(session('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "4000"
            };
            var alertType = "{{ session('alert-type', 'info') }}";
            switch(alertType) {
                case 'success':
                    toastr.success("{{ session('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ session('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ session('message') }}");
                    break;
                default:
                    toastr.info("{{ session('message') }}");
                    break;
            }
        @endif
    </script>

</body>

</html>

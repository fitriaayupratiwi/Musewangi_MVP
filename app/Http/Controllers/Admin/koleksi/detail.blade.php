<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin MUSEWANGI | Detail Koleksi</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body x-data="{ sidebarToggle: false }" class="bg-[#F8F5ED]">


    @include('admin.body.sidebar')


    <div x-show="sidebarToggle" @click="sidebarToggle=false" class="fixed inset-0 bg-black/50 z-40 lg:hidden">
    </div>


    @include('admin.body.header')



    <main class="pt-20 lg:ml-64 p-8">


        <div class="max-w-7xl mx-auto">


            {{-- JUDUL --}}

            <h1 class="
text-3xl
font-bold
text-[#162544]
">

                Detail Koleksi

            </h1>


            <div class="text-sm text-gray-500 mt-2 mb-8">

                Dashboard
                >
                Koleksi
                >
                Detail Koleksi

            </div>




            <div class="
bg-white
rounded-2xl
shadow-lg
p-8
border
border-[#E8DCC0]
">


                <div class="grid grid-cols-2 gap-10">



                    {{-- FOTO --}}
                    @if ($collection->foto)
                        <img src="{{ asset('storage/' . $collection->foto) }}"
                            class="
max-w-md
max-h-80
w-auto
h-auto
rounded-xl
object-contain
shadow
">
                    @else
                        <div class="
w-64
h-64
rounded-xl
bg-gray-200
flex
items-center
justify-center
text-gray-400
">

                            <i class="fa fa-image text-3xl"></i>

                        </div>
                    @endif

                    {{-- DATA KOLEKSI --}}

                    <div class="space-y-3 text-sm">


                        <div class="grid grid-cols-2">

                            <span>
                                Nama Koleksi
                            </span>

                            <b class="text-[#162544]">
                                {{ $collection->nama_koleksi }}
                            </b>

                        </div>



                        <div class="grid grid-cols-2">

                            <span>
                                No. Registrasi Baru
                            </span>

                            <b>
                                {{ $collection->no_registrasi }}
                            </b>

                        </div>




                        <div class="grid grid-cols-2">

                            <span>
                                No. Registrasi Lama
                            </span>

                            <b>
                                {{ $collection->no_registrasi_lama ?? '-' }}
                            </b>

                        </div>




                        <div class="grid grid-cols-2">

                            <span>
                                Kategori
                            </span>

                            <b>
                                {{ $collection->kategori ?? '-' }}
                            </b>

                        </div>




                        <div class="grid grid-cols-2">

                            <span>
                                Jenis Benda
                            </span>

                            <b>
                                {{ $collection->jenis_benda ?? '-' }}
                            </b>

                        </div>




                        <div class="grid grid-cols-2">

                            <span>
                                Tahun Pembuatan
                            </span>

                            <b>
                                {{ $collection->tahun_pembuatan ?? '-' }}
                            </b>

                        </div>




                        <div class="grid grid-cols-2">

                            <span>
                                Asal
                            </span>

                            <b>
                                {{ $collection->asal }}
                            </b>

                        </div>




                        <div class="grid grid-cols-2">

                            <span>
                                Kondisi
                            </span>

                            <b>

                                @if ($collection->kondisi == 'Baik')
                                    <span class="
bg-green-100
text-green-700
px-3
py-1
rounded-full
">

                                        Baik

                                    </span>
                                @elseif($collection->kondisi == 'Rusak Ringan')
                                    <span class="
bg-yellow-100
text-yellow-700
px-3
py-1
rounded-full
">

                                        Rusak Ringan

                                    </span>
                                @else
                                    <span class="
bg-red-100
text-red-700
px-3
py-1
rounded-full
">

                                        Rusak Berat

                                    </span>
                                @endif


                            </b>

                        </div>



                    </div>


                </div>





                {{-- DESKRIPSI --}}


                <div class="mt-8">


                    <h3 class="
font-bold
text-[#162544]
mb-3
">

                        Deskripsi

                    </h3>


                    <div class="
border
border-[#C9981C]
rounded-lg
p-4
text-sm
">

                        {{ $collection->deskripsi ?? 'Tidak ada deskripsi' }}


                    </div>


                </div>






                {{-- SUARA --}}


                <div class="mt-8">


                    <h3 class="
font-bold
text-[#162544]
mb-3
">

                        Rekaman Suara Deskripsi

                    </h3>



                    @if ($collection->voice_over)
                        <div class="
bg-[#F8F5ED]
rounded-xl
p-4
border
border-[#E8DCC0]
">


                            <audio controls class="w-full">


                                <source src="{{ asset('storage/' . $collection->voice_over) }}" type="audio/mpeg">


                                Browser tidak mendukung audio.


                            </audio>



                        </div>
                    @else
                        <div class="
bg-gray-100
rounded-lg
p-4
text-gray-500
text-sm
">

                            Belum ada rekaman suara


                        </div>
                    @endif



                </div>





                <div class="mt-8 flex justify-end">


                    <a href="{{ route('admin.koleksi.index') }}"
                        class="
bg-[#162544]
text-white
px-5
py-3
rounded-lg
">

                        Kembali

                    </a>


                </div>



            </div>


        </div>


    </main>


</body>

</html>

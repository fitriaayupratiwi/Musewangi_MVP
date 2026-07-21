<nav class="border-blue-200 bg-white dark:bg-gray-800 dark:border-blue-700">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            {{-- Tombol back --}}
                <a href="{{ route('customer.menu') }}" 
                class="relative inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full shadow hover:bg-blue-200 transition duration-300"
                title="Menu">
                    <!-- Icon -->
                    <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M13.729 5.575c1.304-1.074 3.27-.146 3.27 1.544v9.762c0 1.69-1.966 2.618-3.27 1.544l-5.927-4.881a2 2 0 0 1 0-3.088l5.927-4.88Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>

            {{-- Keranjang ICON --}}
                <a href="{{ route('customer.keranjang.view') }}" 
                    class="relative inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full shadow hover:bg-blue-200 transition duration-300">
                        <!-- Icon -->
                        <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
        </div>
    </nav>
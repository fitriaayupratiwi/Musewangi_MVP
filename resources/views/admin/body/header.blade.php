<header
    class="fixed
           top-0
           right-0
           z-30
           w-full
           border-b
           border-[#E8DCC0]
           bg-[#F8F5ED]"
>
    <div
        class="flex
               h-20
               items-center
               justify-between
               px-5
               lg:ml-64
               lg:px-8"
    >

        <!-- ================= LEFT HEADER ================= -->
        <div class="flex items-center">

            <!-- BURGER BUTTON (MOBILE & TABLET) -->
            <button
                @click="sidebarToggle = !sidebarToggle"
                class="lg:hidden
                       flex
                       h-10
                       w-10
                       items-center
                       justify-center
                       rounded-lg
                       text-[#162544]
                       hover:bg-[#E9DEC7]
                       hover:text-[#C9981C]
                       transition"
                aria-label="Toggle Sidebar"
            >
                <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>
            </button>

        </div>

        <!-- ================= RIGHT HEADER ================= -->
        <div class="flex items-center">

            <!-- ================= USER ================= -->
            <div
                class="relative"
                x-data="{ dropdownOpen: false }"
                @click.outside="dropdownOpen = false"
            >

                <!-- USER BUTTON -->
                <button
                    type="button"
                    class="flex
                           items-center
                           gap-2
                           text-[#162544]"
                    @click="dropdownOpen = !dropdownOpen"
                >

                    <!-- AVATAR -->
                    <span
                        class="h-10
                               w-10
                               flex
                               items-center
                               justify-center
                               rounded-full
                               bg-[#162544]
                               flex-shrink-0"
                    >
                        <svg
                            class="h-7 w-7 text-white"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <circle
                                cx="12"
                                cy="8"
                                r="3.5"
                                fill="currentColor"
                            />

                            <path
                                d="M5 19C5.8 15.8 8.3 14 12 14C15.7 14 18.2 15.8 19 19"
                                fill="currentColor"
                            />
                        </svg>
                    </span>

                    <!-- USER NAME -->
                    <span
                        class="hidden
                               sm:flex
                               flex-col
                               items-start
                               leading-tight
                               mr-1"
                    >
                        <span
                            class="text-[12px]
                                   font-bold
                                   text-[#162544]"
                        >
                            {{ Auth::user()->name }}
                        </span>

                        <span
                            class="mt-1
                                   text-[11px]
                                   font-medium
                                   text-[#C9981C]"
                        >
                            Administrator
                        </span>
                    </span>

                    <!-- ARROW -->
                    <svg
                        :class="dropdownOpen && 'rotate-180'"
                        class="h-5
                               w-5
                               text-[#162544]
                               transition-transform
                               flex-shrink-0"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 9l6 6 6-6"
                        />
                    </svg>

                </button>

                <!-- ================= DROPDOWN ================= -->
                <div
                    x-show="dropdownOpen"
                    x-transition
                    class="absolute
                           right-0
                           z-50
                           mt-4
                           w-[260px]
                           rounded-2xl
                           border
                           border-[#E8DCC0]
                           bg-white
                           p-3
                           shadow-lg"
                >

                    <!-- USER INFO -->
                    <span
                        class="block
                               font-medium
                               text-[#162544]"
                    >
                        {{ Auth::user()->name }}
                    </span>

                    <span
                        class="text-sm
                               text-gray-500"
                    >
                        {{ Auth::user()->email }}
                    </span>

                    <!-- KELOLA AKUN -->
                    <a
                        href="{{ route('admin.kelolaadmin') }}"
                        class="group
                               mt-3
                               flex
                               w-full
                               items-center
                               gap-3
                               rounded-lg
                               px-3
                               py-2
                               font-medium
                               text-[#162544]
                               hover:bg-[#F8F5ED]
                               hover:text-[#C9981C]"
                    >
                        <svg
                            class="text-[#162544]
                                   group-hover:text-[#C9981C]"
                            width="21"
                            height="21"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <circle
                                cx="12"
                                cy="8"
                                r="3"
                            />

                            <path
                                d="M5 20c.8-3.2 3.1-5 7-5s6.2 1.8 7 5"
                            />
                        </svg>

                        Kelola Akun
                    </a>

                    <!-- SIGN OUT -->
                    <button
                        id="signoutBtn"
                        type="button"
                        class="group
                               mt-1
                               flex
                               w-full
                               items-center
                               gap-3
                               rounded-lg
                               px-3
                               py-2
                               font-medium
                               text-[#162544]
                               hover:bg-[#F8F5ED]
                               hover:text-[#C9981C]"
                    >
                        <svg
                            class="text-[#162544]
                                   group-hover:text-[#C9981C]"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M15.1007 19.247C14.6865 19.247 14.3507 18.9112 14.3507 18.497L14.3507 14.245H12.8507V18.497C12.8507 19.7396 13.8581 20.747 15.1007 20.747H18.5007C19.7434 20.747 20.7507 19.7396 20.7507 18.497L20.7507 5.49609C20.7507 4.25345 19.7433 3.24609 18.5007 3.24609H15.1007C13.8581 3.24609 12.8507 4.25345 12.8507 5.49609V9.74501L14.3507 9.74501V5.49609C14.3507 5.08188 14.6865 4.74609 15.1007 4.74609L18.5007 4.74609C18.9149 4.74609 19.2507 5.08188 19.2507 5.49609L19.2507 18.497C19.2507 18.9112 18.9149 19.247 18.5007 19.247H15.1007ZM3.25073 11.9984C3.25073 12.2144 3.34204 12.4091 3.48817 12.546L8.09483 17.1556C8.38763 17.4485 8.86251 17.4487 9.15549 17.1559C9.44848 16.8631 9.44863 16.3882 9.15583 16.0952L5.81116 12.7484L16.0007 12.7484C16.4149 12.7484 16.7507 12.4127 16.7507 11.9984C16.7507 11.5842 16.4149 11.2484 16.0007 11.2484L5.81528 11.2484L9.15585 7.90554C9.44864 7.61255 9.44847 7.13767 9.15547 6.84488C8.86248 6.55209 8.3876 6.55226 8.09481 6.84525C3.52309 11.4202 3.25073 11.7657 3.25073 11.9984Z"
                                fill="currentColor"
                            />
                        </svg>

                        Sign out
                    </button>

                </div>

            </div>

        </div>

    </div>
</header>
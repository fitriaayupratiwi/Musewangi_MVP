{{-- <button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center w-full px-4 py-3 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button> --}}

<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => '
            inline-flex
            items-center
            justify-center
            px-4
            py-3
            bg-[#0F1F3A]
            border
            border-transparent
            rounded-lg
            font-semibold
            text-sm
            text-white
            tracking-wide
            transition
            duration-300
            hover:bg-[#1B355F]
            active:bg-[#2B4C7E]
            focus:outline-none
            focus:ring-2
            focus:ring-[#3E5F8A]
            focus:ring-offset-2
            w-full
        ',
    ]) }}>
    {{ $slot }}
</button>

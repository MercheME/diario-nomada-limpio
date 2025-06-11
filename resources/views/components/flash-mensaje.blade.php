@if (session('success') || session('error'))
    @php
        $isSuccess = session('success') !== null;
        $message = $isSuccess ? session('success') : session('error');

        // Clases de Tailwind paratipo de mensaje
        $typeClasses = [
            'success' => [
                'bg' => 'bg-green-50',
                'border' => 'border-green-400',
                'icon_color' => 'text-green-500',
                'text_color' => 'text-green-800',
                'focus_ring' => 'focus:ring-offset-green-50 focus:ring-green-600',
            ],
            'error' => [
                'bg' => 'bg-red-50',
                'border' => 'border-red-400',
                'icon_color' => 'text-red-500',
                'text_color' => 'text-red-800',
                'focus_ring' => 'focus:ring-offset-red-50 focus:ring-red-600',
            ],
        ];

        $classes = $isSuccess ? $typeClasses['success'] : $typeClasses['error'];
    @endphp

    <div id="flash-message"
         class="fixed bottom-5 right-5 z-50 max-w-xs w-full p-4 rounded-lg shadow-2xl border-l-4
                {{ $classes['bg'] }} {{ $classes['border'] }}
                transition-all duration-500 ease-in-out transform opacity-0 translate-y-4"
         role="alert">

        <div class="flex items-start">
            <div class="flex-shrink-0">
                @if($isSuccess)
                    <svg class="h-6 w-6 {{ $classes['icon_color'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @else
                    <svg class="h-6 w-6 {{ $classes['icon_color'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                @endif
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium {{ $classes['text_color'] }}">
                    {{ $message }}
                </p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button type="button"
                        onclick="document.getElementById('flash-message').remove()"
                        class="inline-flex rounded-md p-1.5 {{ $classes['text_color'] }} opacity-70 hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $classes['focus_ring'] }}">
                    <span class="sr-only">Cerrar</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif

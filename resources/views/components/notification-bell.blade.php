@php
    $notifications = auth()->user()->notifications()->take(8)->get();
    $unreadCount = auth()->user()->unreadNotifications()->count();
@endphp

<div x-data="{ open: false }" class="relative">
    {{-- Bell trigger --}}
    <button @click="open = !open" class="relative inline-flex items-center justify-center h-10 w-10 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none transition dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if($unreadCount > 0)
            <span class="absolute top-1.5 right-1.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    {{-- Dropdown --}}
    <div x-show="open"
         @click.outside="open = false"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 sm:w-96 max-w-[calc(100vw-2rem)] origin-top-right rounded-2xl bg-white shadow-xl border border-gray-100 z-50 overflow-hidden dark:bg-gray-800 dark:border-gray-700"
         style="display: none;">

        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700">
            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">Notifications
                @if($unreadCount > 0)<span class="ml-1 text-xs font-medium text-gray-400 dark:text-gray-500">({{ $unreadCount }} unread)</span>@endif
            </h3>
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.readAll') }}" class="m-0">
                    @csrf
                    <button class="text-xs font-semibold text-blue-600 hover:underline">Mark all read</button>
                </form>
            @endif
        </div>

        {{-- List --}}
        <div class="max-h-96 overflow-y-auto divide-y divide-gray-50 dark:divide-gray-700">
            @forelse($notifications as $note)
                @php
                    $isUnread = is_null($note->read_at);
                    $icon = $note->data['icon'] ?? 'bell';
                    $iconMap = [
                        'user-plus'  => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'path' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'],
                        'calendar'   => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'path' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        'user-edit'  => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'path' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                        'user-check' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'path' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        'bell'       => ['bg' => 'bg-gray-100', 'text' => 'text-gray-500', 'path' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5'],
                    ];
                    $ic = $iconMap[$icon] ?? $iconMap['bell'];
                @endphp
                <div class="flex items-start gap-3 px-4 py-3 {{ $isUnread ? 'bg-blue-50/40 dark:bg-blue-950/30' : '' }} hover:bg-gray-50 dark:hover:bg-gray-700/50 transition group">
                    <div class="h-9 w-9 rounded-xl {{ $ic['bg'] }} {{ $ic['text'] }} flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $ic['path'] }}"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <form method="POST" action="{{ route('notifications.read', $note->id) }}" class="m-0">
                            @csrf
                            <button type="submit" class="text-left w-full">
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                    {{ $note->data['title'] ?? 'Notification' }}
                                    @if($isUnread)<span class="h-2 w-2 rounded-full bg-blue-500 shrink-0"></span>@endif
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 leading-snug">{{ $note->data['message'] ?? '' }}</div>
                                <div class="text-[11px] text-gray-400 dark:text-gray-500 mt-1">{{ $note->created_at->diffForHumans() }}</div>
                            </button>
                        </form>
                    </div>
                    <form method="POST" action="{{ route('notifications.destroy', $note->id) }}" class="m-0 shrink-0">
                        @csrf
                        @method('DELETE')
                        <button class="text-gray-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition p-1" title="Delete">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                </div>
            @empty
                    <div class="px-4 py-10 text-center">
                    <svg class="h-10 w-10 mx-auto text-gray-200 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">No notifications yet</p>
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        @if($notifications->isNotEmpty())
            <div class="px-4 py-2.5 border-t border-gray-100 bg-gray-50/50 text-center dark:border-gray-700 dark:bg-gray-800/50">
                <a href="{{ route('notifications.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">View all notifications</a>
            </div>
        @endif
    </div>
</div>

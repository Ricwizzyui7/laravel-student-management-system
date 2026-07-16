<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Notifications</h1>
                <p class="text-sm text-gray-500 mt-1">{{ auth()->user()->unreadNotifications()->count() }} unread</p>
            </div>
            <div class="flex items-center gap-2">
                @if(auth()->user()->unreadNotifications()->count() > 0)
                    <form method="POST" action="{{ route('notifications.readAll') }}" class="m-0">
                        @csrf
                        <button class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-xl px-4 py-2 transition">Mark all read</button>
                    </form>
                @endif
                @if($notifications->total() > 0)
                    <form method="POST" action="{{ route('notifications.clear') }}" class="m-0" onsubmit="return confirm('Delete all notifications?')">
                        @csrf
                        <button class="bg-white border border-gray-200 hover:bg-red-50 hover:text-red-600 text-gray-700 text-sm font-semibold rounded-xl px-4 py-2 transition">Clear all</button>
                    </form>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="divide-y divide-gray-50">
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
                    <div class="flex items-start gap-4 px-6 py-4 {{ $isUnread ? 'bg-blue-50/40' : '' }} hover:bg-gray-50 transition group">
                        <div class="h-10 w-10 rounded-xl {{ $ic['bg'] }} {{ $ic['text'] }} flex items-center justify-center shrink-0">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $ic['path'] }}"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                {{ $note->data['title'] ?? 'Notification' }}
                                @if($isUnread)<span class="h-2 w-2 rounded-full bg-blue-500 shrink-0"></span>@endif
                            </div>
                            <div class="text-sm text-gray-500 mt-0.5">{{ $note->data['message'] ?? '' }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ $note->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="flex items-center gap-1 shrink-0">
                            @if(!empty($note->data['url']))
                                <form method="POST" action="{{ route('notifications.read', $note->id) }}" class="m-0">
                                    @csrf
                                    <button class="text-xs font-semibold text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition">View</button>
                                </form>
                            @elseif($isUnread)
                                <form method="POST" action="{{ route('notifications.read', $note->id) }}" class="m-0">
                                    @csrf
                                    <button class="text-xs font-semibold text-gray-500 hover:bg-gray-100 px-3 py-1.5 rounded-lg transition">Mark read</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('notifications.destroy', $note->id) }}" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button class="text-gray-300 hover:text-red-500 p-1.5 rounded-lg transition" title="Delete">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-16 text-center">
                        <svg class="h-12 w-12 mx-auto text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <h3 class="text-sm font-semibold text-gray-900 mt-3">No notifications</h3>
                        <p class="text-xs text-gray-500 mt-1">You're all caught up.</p>
                    </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

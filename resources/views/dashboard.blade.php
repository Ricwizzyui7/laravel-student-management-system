<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-sm p-6 sm:p-8 mb-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Welcome Back, {{ Auth::user()->name }}!</h2>
                <p class="text-blue-100 text-sm sm:text-base mt-1.5 max-w-xl">
                    Here is an overview of what is happening across your student ecosystem today. Manage records, monitor enrollments, and check security access rules.
                </p>
            </div>
            <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
            <div class="absolute right-20 -bottom-20 h-48 w-48 rounded-full bg-indigo-500/20 blur-2xl pointer-events-none"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
            
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Total Registered</span>
                    <span class="block text-3xl font-bold text-gray-900 mt-1 tracking-tight">Active</span>
                    <span class="block text-xs text-blue-600 font-medium mt-1.5 flex items-center gap-1">
                        View Complete Directory →
                    </span>
                </div>
                <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Your Access Level</span>
                    <span class="block text-2xl font-bold text-gray-900 mt-2 tracking-tight uppercase">
                        {{ Auth::user()->role ?? 'Staff' }}
                    </span>
                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md mt-2">
                        ● Safe Connection Secure
                    </span>
                </div>
                <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between sm:col-span-2 lg:col-span-1">
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Host Platform Deployment</span>
                    <span class="block text-3xl font-bold text-gray-900 mt-1 tracking-tight">Cloud Live</span>
                    <span class="block text-xs text-gray-400 font-medium mt-1.5">
                        Dockerized Container Services
                    </span>
                </div>
                <div class="h-12 w-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-1">
                <h3 class="text-base font-bold text-gray-900 mb-4">Quick Navigation Links</h3>
                <div class="space-y-3">
                    
                    <a href="/students" class="group flex items-center justify-between p-3.5 rounded-xl bg-gray-50 hover:bg-blue-50 border border-gray-100 hover:border-blue-100 transition-all">
                        <div class="flex items-center gap-3">
                            <div class="text-gray-400 group-hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-900 transition-colors">View All Students</span>
                        </div>
                        <span class="text-gray-400 group-hover:text-blue-500 text-xs font-semibold transition-transform group-hover:translate-x-0.5">→</span>
                    </a>

                    @if(Auth::user()?->role == 'admin')
                        <a href="/students/create" class="group flex items-center justify-between p-3.5 rounded-xl bg-gray-50 hover:bg-blue-50 border border-gray-100 hover:border-blue-100 transition-all">
                            <div class="flex items-center gap-3">
                                <div class="text-gray-400 group-hover:text-blue-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-blue-900 transition-colors">Add New Record</span>
                            </div>
                            <span class="text-gray-400 group-hover:text-blue-500 text-xs font-semibold transition-transform group-hover:translate-x-0.5">→</span>
                        </a>
                    @endif

                    <a href="/profile" class="group flex items-center justify-between p-3.5 rounded-xl bg-gray-50 hover:bg-blue-50 border border-gray-100 hover:border-blue-100 transition-all">
                        <div class="flex items-center gap-3">
                            <div class="text-gray-400 group-hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-900 transition-colors">Account Settings</span>
                        </div>
                        <span class="text-gray-400 group-hover:text-blue-500 text-xs font-semibold transition-transform group-hover:translate-x-0.5">→</span>
                    </a>

                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-2">
                <h3 class="text-base font-bold text-gray-900 mb-3">System Operating Guidelines</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    This administrative suite handles role-based access management. Users assigned the <strong class="text-gray-700">Staff</strong> role are permitted full system visibility to access and view student records, while creation structural modification pipelines remain exclusively restricted to verified <strong class="text-gray-700">System Administrators</strong>.
                </p>
                <div class="mt-4 p-4 rounded-xl bg-blue-50/50 border border-blue-100/40 flex gap-3 items-start">
                    <div class="text-blue-600 mt-0.5 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="text-xs text-blue-800 leading-relaxed">
                        <strong>Deployment Notice:</strong> Media and file streams are synchronized with public local link assets. Ensure Docker storage configurations match your permanent environmental node permissions during live operational cycles.
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">System Settings</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Configure system-wide settings and institution information.</p>
        </div>

        <div x-data="{ activeTab: 'system' }" class="space-y-6">
            {{-- Tab Navigation --}}
            <div class="border-b border-gray-200 dark:border-gray-700 flex gap-8 overflow-x-auto">
                <button @click="activeTab = 'system'" :class="{'border-b-2 border-blue-600 text-blue-600' : activeTab === 'system', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' : activeTab !== 'system'}" class="pb-4 font-medium transition">
                    System
                </button>
                <button @click="activeTab = 'institution'" :class="{'border-b-2 border-blue-600 text-blue-600' : activeTab === 'institution', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' : activeTab !== 'institution'}" class="pb-4 font-medium transition">
                    Institution
                </button>
                <button @click="activeTab = 'contact'" :class="{'border-b-2 border-blue-600 text-blue-600' : activeTab === 'contact', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' : activeTab !== 'contact'}" class="pb-4 font-medium transition">
                    Contact
                </button>
                <button @click="activeTab = 'academic'" :class="{'border-b-2 border-blue-600 text-blue-600' : activeTab === 'academic', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' : activeTab !== 'academic'}" class="pb-4 font-medium transition">
                    Academic
                </button>
            </div>

            {{-- System Tab --}}
            <div x-show="activeTab === 'system'" x-transition class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                @include('settings.admin.partials.system')
            </div>

            {{-- Institution Tab --}}
            <div x-show="activeTab === 'institution'" x-transition class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                @include('settings.admin.partials.institution')
            </div>

            {{-- Contact Tab --}}
            <div x-show="activeTab === 'contact'" x-transition class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                @include('settings.admin.partials.contact')
            </div>

            {{-- Academic Tab --}}
            <div x-show="activeTab === 'academic'" x-transition class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                @include('settings.admin.partials.academic')
            </div>
        </div>
    </div>
</x-app-layout>

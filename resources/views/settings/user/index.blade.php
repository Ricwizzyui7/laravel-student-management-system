<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">Settings</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Manage your account preferences and notification settings.</p>
        </div>

        <div x-data="{ activeTab: 'profile' }" class="space-y-6">
            {{-- Tab Navigation --}}
            <div class="border-b border-gray-200 dark:border-gray-700 flex gap-8 overflow-x-auto">
                <button @click="activeTab = 'profile'" :class="{'border-b-2 border-blue-600 text-blue-600' : activeTab === 'profile', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' : activeTab !== 'profile'}" class="pb-4 font-medium transition">
                    Profile
                </button>
                <button @click="activeTab = 'password'" :class="{'border-b-2 border-blue-600 text-blue-600' : activeTab === 'password', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' : activeTab !== 'password'}" class="pb-4 font-medium transition">
                    Password
                </button>
                <button @click="activeTab = 'preferences'" :class="{'border-b-2 border-blue-600 text-blue-600' : activeTab === 'preferences', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' : activeTab !== 'preferences'}" class="pb-4 font-medium transition">
                    Preferences
                </button>
                <button @click="activeTab = 'notifications'" :class="{'border-b-2 border-blue-600 text-blue-600' : activeTab === 'notifications', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' : activeTab !== 'notifications'}" class="pb-4 font-medium transition">
                    Notifications
                </button>
            </div>

            {{-- Profile Tab --}}
            <div x-show="activeTab === 'profile'" x-transition class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                @include('settings.user.partials.profile')
            </div>

            {{-- Password Tab --}}
            <div x-show="activeTab === 'password'" x-transition class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                @include('settings.user.partials.password')
            </div>

            {{-- Preferences Tab --}}
            <div x-show="activeTab === 'preferences'" x-transition class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                @include('settings.user.partials.preferences')
            </div>

            {{-- Notifications Tab --}}
            <div x-show="activeTab === 'notifications'" x-transition class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                @include('settings.user.partials.notifications')
            </div>
        </div>
    </div>
</x-app-layout>

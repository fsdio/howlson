<script setup>
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    isUser: {
        type: Boolean,
        default: false
    },
    user: {
        type: Object,
        default: () => ({})
    }
});
</script>

<template>
    <Head title="Is User" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                User Status Check
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-center">
                            <div class="mb-6">
                                <div 
                                    class="mx-auto w-24 h-24 rounded-full flex items-center justify-center mb-4"
                                    :class="{
                                        'bg-blue-100': isUser,
                                        'bg-gray-100': !isUser
                                    }"
                                >
                                    <svg 
                                        v-if="isUser"
                                        class="w-12 h-12 text-blue-600" 
                                        fill="none" 
                                        stroke="currentColor" 
                                        viewBox="0 0 24 24"
                                    >
                                        <path 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            stroke-width="2" 
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        ></path>
                                    </svg>
                                    <svg 
                                        v-else
                                        class="w-12 h-12 text-gray-600" 
                                        fill="none" 
                                        stroke="currentColor" 
                                        viewBox="0 0 24 24"
                                    >
                                        <path 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            stroke-width="2" 
                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"
                                        ></path>
                                    </svg>
                                </div>
                                
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                                    {{ isUser ? 'Anda adalah User!' : 'Anda bukan User biasa' }}
                                </h3>
                                
                                <p class="text-gray-600">
                                    Status role untuk user: <strong>{{ user.name }}</strong>
                                </p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900 mb-2">Informasi User</h4>
                                <div class="space-y-2 text-sm">
                                    <p><span class="font-medium">Nama:</span> {{ user.name }}</p>
                                    <p><span class="font-medium">Email:</span> {{ user.email }}</p>
                                    <p><span class="font-medium">Status User:</span> 
                                        <span 
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                            :class="{
                                                'bg-blue-100 text-blue-800': isUser,
                                                'bg-gray-100 text-gray-800': !isUser
                                            }"
                                        >
                                            {{ isUser ? 'Ya' : 'Tidak' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <div class="flex justify-center space-x-4">
                                    <a 
                                        :href="route('permissions.index')"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    >
                                        Lihat Permissions
                                    </a>
                                    <a 
                                        :href="route('is-admin')"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    >
                                        Cek Status Admin
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
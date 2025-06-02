<script setup>
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    isAdmin: {
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
    <Head title="Is Admin" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Admin Status Check
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
                                        'bg-green-100': isAdmin,
                                        'bg-red-100': !isAdmin
                                    }"
                                >
                                    <svg 
                                        v-if="isAdmin"
                                        class="w-12 h-12 text-green-600" 
                                        fill="none" 
                                        stroke="currentColor" 
                                        viewBox="0 0 24 24"
                                    >
                                        <path 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            stroke-width="2" 
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        ></path>
                                    </svg>
                                    <svg 
                                        v-else
                                        class="w-12 h-12 text-red-600" 
                                        fill="none" 
                                        stroke="currentColor" 
                                        viewBox="0 0 24 24"
                                    >
                                        <path 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            stroke-width="2" 
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        ></path>
                                    </svg>
                                </div>
                                
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                                    {{ isAdmin ? 'Anda adalah Admin!' : 'Anda bukan Admin' }}
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
                                    <p><span class="font-medium">Status Admin:</span> 
                                        <span 
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                            :class="{
                                                'bg-green-100 text-green-800': isAdmin,
                                                'bg-red-100 text-red-800': !isAdmin
                                            }"
                                        >
                                            {{ isAdmin ? 'Ya' : 'Tidak' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <div class="flex justify-center space-x-4">
                                    <a 
                                        :href="route('roles.index')"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    >
                                        Lihat Roles
                                    </a>
                                    <a 
                                        :href="route('is-user')"
                                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    >
                                        Cek Status User
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
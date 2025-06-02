<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/components/ApplicationLogo.vue';
import Footer from '@/components/Footer.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />
    <div class="min-h-screen bg-gray-100">
        <!-- Header dengan logo dan tombol auth -->
        <div class="flex min-h-screen flex-col items-center justify-center px-6">
            <!-- Logo dan Brand -->
            <div class="mb-12 flex flex-col items-center justify-center">
                <div class="mb-6 flex h-32 w-32 items-center justify-center rounded-full bg-white shadow-lg border border-gray-200">
                    <ApplicationLogo class="h-20 w-20 fill-current text-gray-800" />
                </div>
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Howlson</h1>
                    <p class="text-lg text-gray-600">Platform Manajemen Peran & Izin</p>
                </div>
            </div>

            <!-- Tombol Login dan Register -->
            <div v-if="canLogin" class="mb-16 flex space-x-6">
                <template v-if="!$page.props.auth.user">
                    <Link
                        :href="route('login')"
                        class="rounded-lg bg-gray-800 px-8 py-3 text-white font-medium transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 shadow-md"
                    >
                        Masuk
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-lg border border-gray-300 bg-white px-8 py-3 text-gray-700 font-medium transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 shadow-md"
                    >
                        Daftar
                    </Link>
                </template>
                <template v-else>
                    <Link
                        :href="route('dashboard')"
                        class="rounded-lg bg-gray-800 px-8 py-3 text-white font-medium transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 shadow-md"
                    >
                        Dashboard
                    </Link>
                </template>
            </div>

            <!-- Feature Cards -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3 max-w-6xl">
                <!-- Card 1: Role Management -->
                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Manajemen Peran</h3>
                    <p class="text-gray-600 text-sm">Kelola peran pengguna dengan mudah dan fleksibel sesuai kebutuhan organisasi Anda.</p>
                </div>

                <!-- Card 2: Permission Control -->
                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Kontrol Izin</h3>
                    <p class="text-gray-600 text-sm">Atur izin akses dengan detail untuk menjaga keamanan dan integritas sistem.</p>
                </div>

                <!-- Card 3: User Management -->
                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Manajemen Pengguna</h3>
                    <p class="text-gray-600 text-sm">Kelola data pengguna dan assign peran dengan interface yang intuitif dan mudah digunakan.</p>
                </div>
            </div>

        </div>
        
        <!-- Footer -->
        <Footer />
    </div>
</template>

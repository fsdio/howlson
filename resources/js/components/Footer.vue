<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/components/ApplicationLogo.vue';
</script>

<template>
    <footer class="bg-gray-800 text-white">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <!-- Logo dan Deskripsi -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <ApplicationLogo class="h-8 w-auto fill-current text-white" />
                        <span class="ml-2 text-xl font-bold">howlson</span>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Platform manajemen peran dan izin yang powerful untuk aplikasi modern. 
                        Kelola akses pengguna dengan mudah dan aman.
                    </p>
                    <div class="mt-4 flex space-x-4">
                        <!-- Social Media Links -->
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Navigasi Cepat -->
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">
                        Navigasi
                    </h3>
                    <ul class="space-y-2">
                        <li>
                            <Link :href="route('dashboard')" class="text-gray-300 hover:text-white transition-colors text-sm">
                                Dashboard
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('roles.index')" class="text-gray-300 hover:text-white transition-colors text-sm">
                                Roles
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('permissions.index')" class="text-gray-300 hover:text-white transition-colors text-sm">
                                Permissions
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('profile.edit')" class="text-gray-300 hover:text-white transition-colors text-sm">
                                Profile
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">
                        Kontak
                    </h3>
                    <ul class="space-y-2">
                        <li class="text-gray-300 text-sm">
                            <span class="block">Email:</span>
                            <a href="mailto:info@howlson.com" class="hover:text-white transition-colors">
                    info@howlson.com
                            </a>
                        </li>
                        <li class="text-gray-300 text-sm">
                            <span class="block">Telepon:</span>
                            <a href="tel:+6281234567890" class="hover:text-white transition-colors">
                                +62 812-3456-7890
                            </a>
                        </li>
                        <li class="text-gray-300 text-sm">
                            <span class="block">Alamat:</span>
                            <span>Jakarta, Indonesia</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-8 border-t border-gray-700 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">
                        © {{ new Date().getFullYear() }} howlson. Semua hak dilindungi.
                    </p>
                    <div class="mt-4 md:mt-0 flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                            Kebijakan Privasi
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                            Syarat & Ketentuan
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                            Bantuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>
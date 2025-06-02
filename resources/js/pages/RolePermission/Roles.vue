<script setup>
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    roles: {
        type: Array,
        default: () => []
    }
});
</script>

<template>
    <Head title="Roles" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Roles Management
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Daftar Roles
                        </h3>
                        
                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <div 
                                v-for="role in roles" 
                                :key="role.id"
                                class="bg-gray-50 p-4 rounded-lg border"
                            >
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 capitalize">
                                            {{ role.name }}
                                        </h4>
                                        <p class="text-sm text-gray-600">
                                            Guard: {{ role.guard_name }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            ID: {{ role.id }}
                                        </p>
                                    </div>
                                    <div class="flex items-center">
                                        <span 
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                            :class="{
                                                'bg-red-100 text-red-800': role.name === 'admin',
                                                'bg-blue-100 text-blue-800': role.name === 'user'
                                            }"
                                        >
                                            {{ role.name }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div v-if="roles.length === 0" class="text-center py-8">
                            <p class="text-gray-500">Tidak ada roles yang ditemukan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
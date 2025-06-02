<script setup>
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    permissions: {
        type: Array,
        default: () => []
    }
});

// Group permissions by category
const groupedPermissions = computed(() => {
    const groups = {};
    props.permissions.forEach(permission => {
        const category = permission.name.split(' ')[0]; // Get first word as category
        if (!groups[category]) {
            groups[category] = [];
        }
        groups[category].push(permission);
    });
    return groups;
});
</script>

<template>
    <Head title="Permissions" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Permissions Management
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Daftar Permissions
                        </h3>
                        
                        <div class="space-y-6">
                            <div 
                                v-for="(perms, category) in groupedPermissions" 
                                :key="category"
                                class="bg-gray-50 p-4 rounded-lg border"
                            >
                                <h4 class="font-semibold text-gray-900 capitalize mb-3">
                                    {{ category }} Permissions
                                </h4>
                                
                                <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-4">
                                    <div 
                                        v-for="permission in perms" 
                                        :key="permission.id"
                                        class="bg-white p-3 rounded border"
                                    >
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-medium text-gray-900 text-sm">
                                                    {{ permission.name }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ permission.guard_name }}
                                                </p>
                                            </div>
                                            <span 
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                                :class="{
                                                    'bg-green-100 text-green-800': permission.name.includes('index'),
                                                    'bg-blue-100 text-blue-800': permission.name.includes('create'),
                                                    'bg-yellow-100 text-yellow-800': permission.name.includes('edit'),
                                                    'bg-red-100 text-red-800': permission.name.includes('delete')
                                                }"
                                            >
                                                {{ permission.name.split(' ')[1] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div v-if="permissions.length === 0" class="text-center py-8">
                            <p class="text-gray-500">Tidak ada permissions yang ditemukan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Plus, Edit, Trash2, Shield, Users } from 'lucide-vue-next';

defineProps({
    permissions: Array,
    roles: Array,
});

const deletePermission = (id) => {
    if (confirm('Are you sure you want to delete this permission?')) {
        router.delete(route('admin.permissions.destroy', id));
    }
};
</script>

<template>
    <Head title="Permission Management" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Permission Management
                </h2>
                <Link
                    :href="route('admin.permissions.create')"
                    class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                >
                    <Plus class="mr-2 h-4 w-4" />
                    Add New Permission
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Stats Cards -->
                        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="rounded-lg bg-green-50 p-4">
                                <div class="flex items-center">
                                    <Shield class="h-8 w-8 text-green-600" />
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-600">Total Permissions</p>
                                        <p class="text-2xl font-semibold text-green-900">{{ permissions ? permissions.length : 0 }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="rounded-lg bg-blue-50 p-4">
                                <div class="flex items-center">
                                    <Users class="h-8 w-8 text-blue-600" />
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-blue-600">Total Roles</p>
                                        <p class="text-2xl font-semibold text-blue-900">{{ roles ? roles.length : 0 }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Permissions Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Permission Name
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Guard Name
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Roles
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Created At
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="permission in permissions" :key="permission.id" class="hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ permission.name }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm text-gray-500">{{ permission.guard_name }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                <span
                                                    v-for="role in permission.roles"
                                                    :key="role.id"
                                                    class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800"
                                                >
                                                    {{ role.name }}
                                                </span>
                                                <span v-if="permission.roles.length === 0" class="text-sm text-gray-400">
                                                    No roles assigned
                                                </span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            {{ new Date(permission.created_at).toLocaleDateString() }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <Link
                                                    :href="route('admin.permissions.edit', permission.id)"
                                                    class="inline-flex items-center rounded-md bg-yellow-600 px-3 py-2 text-xs font-medium text-white hover:bg-yellow-700"
                                                >
                                                    <Edit class="h-3 w-3" />
                                                </Link>
                                                <button
                                                    @click="deletePermission(permission.id)"
                                                    class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-xs font-medium text-white hover:bg-red-700"
                                                >
                                                    <Trash2 class="h-3 w-3" />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-if="permissions.length === 0" class="py-12 text-center">
                                <Shield class="mx-auto h-12 w-12 text-gray-400" />
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No permissions</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new permission.</p>
                                <div class="mt-6">
                                    <Link
                                        :href="route('admin.permissions.create')"
                                        class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700"
                                    >
                                        <Plus class="mr-2 h-4 w-4" />
                                        Add New Permission
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
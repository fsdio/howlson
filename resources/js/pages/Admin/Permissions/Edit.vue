<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { ArrowLeft, Save, X } from 'lucide-vue-next';

const props = defineProps({
    permission: Object,
});

const form = useForm({
    name: props.permission.name,
    guard_name: props.permission.guard_name,
});

const submit = () => {
    form.put(route('admin.permissions.update', props.permission.id));
};
</script>

<template>
    <Head title="Edit Permission" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <Link
                        :href="route('admin.permissions.index')"
                        class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-medium text-white hover:bg-gray-700"
                    >
                        <ArrowLeft class="mr-2 h-4 w-4" />
                        Back to Permissions
                    </Link>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Edit Permission: {{ permission.name }}
                    </h2>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Permission Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Permission Name *
                                </label>
                                <input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    :class="{
                                        'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500': form.errors.name
                                    }"
                                    placeholder="Enter permission name (e.g., create-posts, edit-users)"
                                    required
                                />
                                <div v-if="form.errors.name" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.name }}
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Use lowercase letters, numbers, and hyphens. Examples: create-posts, edit-users, delete-comments
                                </p>
                            </div>

                            <!-- Guard Name -->
                            <div>
                                <label for="guard_name" class="block text-sm font-medium text-gray-700">
                                    Guard Name *
                                </label>
                                <select
                                    id="guard_name"
                                    v-model="form.guard_name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    :class="{
                                        'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500': form.errors.guard_name
                                    }"
                                    required
                                >
                                    <option value="web">Web</option>
                                    <option value="api">API</option>
                                </select>
                                <div v-if="form.errors.guard_name" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.guard_name }}
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Select the guard that this permission applies to. 'Web' for web routes, 'API' for API routes.
                                </p>
                            </div>

                            <!-- Permission Info -->
                            <div class="rounded-md bg-gray-50 p-4">
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Permission Information</h4>
                                <div class="space-y-2 text-sm text-gray-600">
                                    <div class="flex justify-between">
                                        <span>Created:</span>
                                        <span>{{ new Date(permission.created_at).toLocaleDateString() }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Last Updated:</span>
                                        <span>{{ new Date(permission.updated_at).toLocaleDateString() }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Assigned to Roles:</span>
                                        <span>{{ permission.roles?.length || 0 }} role(s)</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Assigned Roles -->
                            <div v-if="permission.roles && permission.roles.length > 0">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Currently Assigned to Roles
                                </label>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        v-for="role in permission.roles"
                                        :key="role.id"
                                        class="inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-800"
                                    >
                                        {{ role.name }}
                                    </span>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    This permission is currently assigned to the above roles. Changes to this permission will affect all assigned roles.
                                </p>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end space-x-3 border-t border-gray-200 pt-6">
                                <Link
                                    :href="route('admin.permissions.index')"
                                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    <X class="mr-2 h-4 w-4" />
                                    Cancel
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <Save class="mr-2 h-4 w-4" />
                                    {{ form.processing ? 'Updating...' : 'Update Permission' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Warning Section -->
                <div class="mt-6 overflow-hidden bg-yellow-50 shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-yellow-900 mb-4">⚠️ Important Notice</h3>
                        <div class="space-y-2 text-sm text-yellow-800">
                            <p>
                                <strong>Changing this permission will affect all roles and users that have this permission assigned.</strong>
                            </p>
                            <p>
                                Make sure to test the changes in a development environment before applying them to production.
                            </p>
                            <p>
                                If you change the permission name, you may need to update your application code that references this permission.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { ArrowLeft, Save, X } from 'lucide-vue-next';

const form = useForm({
    name: '',
    guard_name: 'web',
});

const submit = () => {
    form.post(route('admin.permissions.store'));
};
</script>

<template>
    <Head title="Create Permission" />

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
                        Create New Permission
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
                                    class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <Save class="mr-2 h-4 w-4" />
                                    {{ form.processing ? 'Creating...' : 'Create Permission' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="mt-6 overflow-hidden bg-blue-50 shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-blue-900 mb-4">Permission Naming Guidelines</h3>
                        <div class="space-y-3 text-sm text-blue-800">
                            <div class="flex items-start">
                                <span class="font-medium mr-2">•</span>
                                <div>
                                    <strong>Use descriptive names:</strong> create-posts, edit-users, delete-comments
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="font-medium mr-2">•</span>
                                <div>
                                    <strong>Follow action-resource pattern:</strong> action-resource (e.g., view-dashboard, manage-settings)
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="font-medium mr-2">•</span>
                                <div>
                                    <strong>Use lowercase and hyphens:</strong> Avoid spaces and special characters
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="font-medium mr-2">•</span>
                                <div>
                                    <strong>Be specific:</strong> Instead of 'admin', use 'manage-users' or 'view-reports'
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
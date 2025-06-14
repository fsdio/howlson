<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { ArrowLeft, Save } from 'lucide-vue-next';

const props = defineProps({
    role: Object,
    permissions: Array,
});

const form = useForm({
    name: props.role.name,
    guard_name: props.role.guard_name,
    permissions: props.role.permissions ? props.role.permissions.map(p => p.id) : [],
});

const submit = () => {
    form.put(route('admin.roles.update', props.role.id));
};

const togglePermission = (permissionId) => {
    const index = form.permissions.indexOf(permissionId);
    if (index > -1) {
        form.permissions.splice(index, 1);
    } else {
        form.permissions.push(permissionId);
    }
};
</script>

<template>
    <Head title="Edit Role" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <Link
                        :href="route('admin.roles.index')"
                        class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-medium text-white hover:bg-gray-700"
                    >
                        <ArrowLeft class="mr-2 h-4 w-4" />
                        Back to Roles
                    </Link>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Edit Role: {{ role.name }}
                    </h2>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6">
                        <div class="space-y-6">
                            <!-- Role Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Role Name
                                </label>
                                <input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{ 'border-red-500': form.errors.name }"
                                    required
                                />
                                <div v-if="form.errors.name" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.name }}
                                </div>
                            </div>

                            <!-- Guard Name -->
                            <div>
                                <label for="guard_name" class="block text-sm font-medium text-gray-700">
                                    Guard Name
                                </label>
                                <select
                                    id="guard_name"
                                    v-model="form.guard_name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{ 'border-red-500': form.errors.guard_name }"
                                >
                                    <option value="web">Web</option>
                                    <option value="api">API</option>
                                </select>
                                <div v-if="form.errors.guard_name" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.guard_name }}
                                </div>
                            </div>

                            <!-- Permissions -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Permissions
                                </label>
                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                    <div
                                        v-for="permission in permissions"
                                        :key="permission.id"
                                        class="relative flex items-start"
                                    >
                                        <div class="flex h-5 items-center">
                                            <input
                                                :id="`permission-${permission.id}`"
                                                type="checkbox"
                                                :checked="form.permissions.includes(permission.id)"
                                                @change="togglePermission(permission.id)"
                                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                            />
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label
                                                :for="`permission-${permission.id}`"
                                                class="font-medium text-gray-700 cursor-pointer"
                                            >
                                                {{ permission.name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="form.errors.permissions" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.permissions }}
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end space-x-3">
                                <Link
                                    :href="route('admin.roles.index')"
                                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                                >
                                    Cancel
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
                                >
                                    <Save class="mr-2 h-4 w-4" />
                                    {{ form.processing ? 'Updating...' : 'Update Role' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
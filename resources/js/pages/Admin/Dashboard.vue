<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Users, Shield, FileText, Package, FolderTree, TrendingUp, Eye, Edit } from 'lucide-vue-next';

defineProps({
    stats: Object,
    recent_blogs: Array,
    recent_products: Array,
    recent_users: Array,
});
</script>

<template>
    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Admin Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Stats Cards -->
                <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Users Stats -->
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <Users class="h-8 w-8 text-blue-600" />
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Total Users</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ stats.users }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Roles Stats -->
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <Shield class="h-8 w-8 text-green-600" />
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Roles & Permissions</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ stats.roles }} / {{ stats.permissions }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Blogs Stats -->
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <FileText class="h-8 w-8 text-purple-600" />
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Total Blogs</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ stats.blogs }}</p>
                                    <p class="text-xs text-gray-500">{{ stats.published_blogs }} published, {{ stats.draft_blogs }} drafts</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Stats -->
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <Package class="h-8 w-8 text-orange-600" />
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Total Products</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ stats.products }}</p>
                                    <p class="text-xs text-gray-500">{{ stats.active_products }} active</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Stats -->
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <FolderTree class="h-8 w-8 text-indigo-600" />
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Categories</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ stats.categories }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="overflow-hidden rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 shadow">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <TrendingUp class="h-8 w-8 text-white" />
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-blue-100">System Status</p>
                                    <p class="text-2xl font-semibold text-white">All Good</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Recent Blogs -->
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="border-b border-gray-200 bg-gray-50 px-6 py-3">
                            <h3 class="text-lg font-medium text-gray-900">Recent Blogs</h3>
                        </div>
                        <div class="divide-y divide-gray-200">
                            <div v-for="blog in recent_blogs" :key="blog.id" class="px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ blog.title }}</p>
                                        <p class="text-sm text-gray-500">by {{ blog.author?.name || 'Unknown' }}</p>
                                        <p class="text-xs text-gray-400">{{ new Date(blog.created_at).toLocaleDateString() }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <span :class="{
                                            'bg-green-100 text-green-800': blog.status === 'published',
                                            'bg-yellow-100 text-yellow-800': blog.status === 'draft'
                                        }" class="inline-flex rounded-full px-2 py-1 text-xs font-semibold">
                                            {{ blog.status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div v-if="recent_blogs.length === 0" class="px-6 py-4 text-center text-gray-500">
                                No blogs found
                            </div>
                        </div>
                    </div>

                    <!-- Recent Products -->
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="border-b border-gray-200 bg-gray-50 px-6 py-3">
                            <h3 class="text-lg font-medium text-gray-900">Recent Products</h3>
                        </div>
                        <div class="divide-y divide-gray-200">
                            <div v-for="product in recent_products" :key="product.id" class="px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ product.name }}</p>
                                        <p class="text-sm text-gray-500">{{ product.category?.name || 'No Category' }}</p>
                                        <p class="text-xs text-gray-400">{{ new Date(product.created_at).toLocaleDateString() }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <span :class="{
                                            'bg-green-100 text-green-800': product.status === 'active',
                                            'bg-red-100 text-red-800': product.status === 'inactive'
                                        }" class="inline-flex rounded-full px-2 py-1 text-xs font-semibold">
                                            {{ product.status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div v-if="recent_products.length === 0" class="px-6 py-4 text-center text-gray-500">
                                No products found
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Users -->
                <div class="mt-6 overflow-hidden rounded-lg bg-white shadow">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-3">
                        <h3 class="text-lg font-medium text-gray-900">Recent Users</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div v-for="user in recent_users" :key="user.id" class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">{{ user.name.charAt(0).toUpperCase() }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">{{ user.name }}</p>
                                        <p class="text-sm text-gray-500">{{ user.email }}</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <span v-for="role in user.roles" :key="role.id" class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800">
                                        {{ role.name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div v-if="recent_users.length === 0" class="px-6 py-4 text-center text-gray-500">
                            No users found
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Plus, Edit, Trash2, Eye, FileText, Users, TrendingUp } from 'lucide-vue-next';

defineProps({
    blogs: Object,
    filters: Object,
});

const deleteBlog = (id) => {
    if (confirm('Are you sure you want to delete this blog?')) {
        router.delete(route('admin.blogs.destroy', id));
    }
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>

<template>
    <Head title="Blog Management" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Blog Management
                </h2>
                <Link
                    :href="route('admin.blogs.create')"
                    class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700"
                >
                    <Plus class="mr-2 h-4 w-4" />
                    Add New Blog
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Stats Cards -->
                <div class="mb-6 grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div class="rounded-lg bg-blue-50 p-4">
                        <div class="flex items-center">
                            <FileText class="h-8 w-8 text-blue-600" />
                            <div class="ml-3">
                                <p class="text-sm font-medium text-blue-600">Total Blogs</p>
                                <p class="text-2xl font-semibold text-blue-900">{{ blogs && blogs.total ? blogs.total : 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-lg bg-green-50 p-4">
                        <div class="flex items-center">
                            <TrendingUp class="h-8 w-8 text-green-600" />
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-600">Published</p>
                                <p class="text-2xl font-semibold text-green-900">{{ blogs && blogs.data ? blogs.data.filter(b => b.status === 'published').length : 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-lg bg-yellow-50 p-4">
                        <div class="flex items-center">
                            <Edit class="h-8 w-8 text-yellow-600" />
                            <div class="ml-3">
                                <p class="text-sm font-medium text-yellow-600">Drafts</p>
                                <p class="text-2xl font-semibold text-yellow-900">{{ blogs && blogs.data ? blogs.data.filter(b => b.status === 'draft').length : 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blogs Table -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-3">
                        <h3 class="text-lg font-medium text-gray-900">All Blogs</h3>
                    </div>
                    
                    <div v-if="blogs && blogs.data && blogs.data.length > 0" class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Title
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Author
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Published Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Created
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="blog in blogs.data" :key="blog.id" class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <img v-if="blog.featured_image" :src="`/storage/${blog.featured_image}`" :alt="blog.title" class="h-10 w-10 rounded-lg object-cover" />
                                                <div v-else class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <FileText class="h-5 w-5 text-gray-400" />
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ blog.title }}</div>
                                                <div class="text-sm text-gray-500">{{ blog.excerpt || 'No excerpt' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                        {{ blog.author?.name || 'Unknown' }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span :class="{
                                            'bg-green-100 text-green-800': blog.status === 'published',
                                            'bg-yellow-100 text-yellow-800': blog.status === 'draft'
                                        }" class="inline-flex rounded-full px-2 py-1 text-xs font-semibold">
                                            {{ blog.status }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        {{ blog.published_at ? formatDate(blog.published_at) : '-' }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        {{ formatDate(blog.created_at) }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <Link
                                                :href="route('admin.blogs.show', blog.id)"
                                                class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-xs font-medium text-white hover:bg-blue-700"
                                            >
                                                <Eye class="h-3 w-3" />
                                            </Link>
                                            <Link
                                                :href="route('admin.blogs.edit', blog.id)"
                                                class="inline-flex items-center rounded-md bg-yellow-600 px-3 py-2 text-xs font-medium text-white hover:bg-yellow-700"
                                            >
                                                <Edit class="h-3 w-3" />
                                            </Link>
                                            <button
                                                @click="deleteBlog(blog.id)"
                                                class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-xs font-medium text-white hover:bg-red-700"
                                            >
                                                <Trash2 class="h-3 w-3" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Empty State -->
                    <div v-else class="px-6 py-12 text-center">
                        <FileText class="mx-auto h-12 w-12 text-gray-400" />
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No blogs</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new blog post.</p>
                        <div class="mt-6">
                            <Link
                                :href="route('admin.blogs.create')"
                                class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700"
                            >
                                <Plus class="mr-2 h-4 w-4" />
                                Add New Blog
                            </Link>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div v-if="blogs && blogs.links" class="border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                        <div class="flex flex-1 justify-between sm:hidden">
                            <Link
                                v-if="blogs.prev_page_url"
                                :href="blogs.prev_page_url"
                                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                            >
                                Previous
                            </Link>
                            <Link
                                v-if="blogs.next_page_url"
                                :href="blogs.next_page_url"
                                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                            >
                                Next
                            </Link>
                        </div>
                        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ blogs.from || 0 }}</span>
                                    to
                                    <span class="font-medium">{{ blogs.to || 0 }}</span>
                                    of
                                    <span class="font-medium">{{ blogs.total || 0 }}</span>
                                    results
                                </p>
                            </div>
                            <div>
                                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                    <Link
                                        v-if="blogs.prev_page_url"
                                        :href="blogs.prev_page_url"
                                        class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50"
                                    >
                                        Previous
                                    </Link>
                                    <Link
                                        v-if="blogs.next_page_url"
                                        :href="blogs.next_page_url"
                                        class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50"
                                    >
                                        Next
                                    </Link>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
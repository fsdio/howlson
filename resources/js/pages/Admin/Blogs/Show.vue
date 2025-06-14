<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { ArrowLeft, Edit, Trash2, Calendar, User, Eye, Tag } from 'lucide-vue-next';

defineProps({
    blog: Object,
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const deleteBlog = () => {
    if (confirm('Are you sure you want to delete this blog?')) {
        router.delete(route('admin.blogs.destroy', blog.id));
    }
};
</script>

<template>
    <Head :title="blog.title" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <Link
                        :href="route('admin.blogs.index')"
                        class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-medium text-white hover:bg-gray-700"
                    >
                        <ArrowLeft class="mr-2 h-4 w-4" />
                        Back to Blogs
                    </Link>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Blog Details
                    </h2>
                </div>
                <div class="flex space-x-2">
                    <Link
                        :href="route('admin.blogs.edit', blog.id)"
                        class="inline-flex items-center rounded-md bg-yellow-600 px-3 py-2 text-sm font-medium text-white hover:bg-yellow-700"
                    >
                        <Edit class="mr-2 h-4 w-4" />
                        Edit
                    </Link>
                    <button
                        @click="deleteBlog"
                        class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700"
                    >
                        <Trash2 class="mr-2 h-4 w-4" />
                        Delete
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <!-- Blog Header -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <!-- Featured Image -->
                        <div v-if="blog.featured_image" class="mb-6">
                            <img 
                                :src="`/storage/${blog.featured_image}`" 
                                :alt="blog.title" 
                                class="w-full h-64 object-cover rounded-lg"
                            />
                        </div>

                        <!-- Title -->
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ blog.title }}</h1>

                        <!-- Meta Information -->
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-6">
                            <div class="flex items-center">
                                <User class="h-4 w-4 mr-1" />
                                <span>{{ blog.author?.name || 'Unknown Author' }}</span>
                            </div>
                            <div class="flex items-center">
                                <Calendar class="h-4 w-4 mr-1" />
                                <span>{{ formatDate(blog.created_at) }}</span>
                            </div>
                            <div v-if="blog.published_at" class="flex items-center">
                                <Eye class="h-4 w-4 mr-1" />
                                <span>Published: {{ formatDate(blog.published_at) }}</span>
                            </div>
                            <div class="flex items-center">
                                <Tag class="h-4 w-4 mr-1" />
                                <span :class="{
                                    'bg-green-100 text-green-800': blog.status === 'published',
                                    'bg-yellow-100 text-yellow-800': blog.status === 'draft'
                                }" class="inline-flex rounded-full px-2 py-1 text-xs font-semibold">
                                    {{ blog.status }}
                                </span>
                            </div>
                        </div>

                        <!-- Excerpt -->
                        <div v-if="blog.excerpt" class="mb-6">
                            <div class="bg-gray-50 border-l-4 border-indigo-500 p-4 rounded">
                                <p class="text-gray-700 italic">{{ blog.excerpt }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blog Content -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Content</h2>
                        <div class="prose max-w-none">
                            <div class="whitespace-pre-wrap text-gray-700 leading-relaxed">
                                {{ blog.content }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Information -->
                <div v-if="blog.meta_title || blog.meta_description" class="overflow-hidden bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">SEO Information</h2>
                        
                        <div v-if="blog.meta_title" class="mb-4">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Meta Title</h3>
                            <p class="text-gray-600 bg-gray-50 p-3 rounded">{{ blog.meta_title }}</p>
                        </div>
                        
                        <div v-if="blog.meta_description">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Meta Description</h3>
                            <p class="text-gray-600 bg-gray-50 p-3 rounded">{{ blog.meta_description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Technical Details -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Technical Details</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Blog ID</h3>
                                <p class="text-gray-600 bg-gray-50 p-3 rounded font-mono text-sm">{{ blog.id }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Slug</h3>
                                <p class="text-gray-600 bg-gray-50 p-3 rounded font-mono text-sm">{{ blog.slug }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Created At</h3>
                                <p class="text-gray-600 bg-gray-50 p-3 rounded">{{ formatDate(blog.created_at) }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Last Updated</h3>
                                <p class="text-gray-600 bg-gray-50 p-3 rounded">{{ formatDate(blog.updated_at) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.prose {
    @apply text-gray-700;
}

.prose h1 {
    @apply text-2xl font-bold mb-4;
}

.prose h2 {
    @apply text-xl font-semibold mb-3;
}

.prose h3 {
    @apply text-lg font-medium mb-2;
}

.prose p {
    @apply mb-4;
}

.prose ul, .prose ol {
    @apply mb-4 pl-6;
}

.prose li {
    @apply mb-1;
}

.prose blockquote {
    @apply border-l-4 border-gray-300 pl-4 italic mb-4;
}

.prose code {
    @apply bg-gray-100 px-1 py-0.5 rounded text-sm font-mono;
}

.prose pre {
    @apply bg-gray-100 p-4 rounded overflow-x-auto mb-4;
}

.prose a {
    @apply text-indigo-600 hover:text-indigo-800 underline;
}
</style>
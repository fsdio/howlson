<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { ArrowLeft, Save, Upload, X } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    blog: Object,
    authors: Array,
});

const form = useForm({
    title: props.blog.title,
    content: props.blog.content,
    excerpt: props.blog.excerpt || '',
    featured_image: null,
    status: props.blog.status,
    published_at: props.blog.published_at ? new Date(props.blog.published_at).toISOString().slice(0, 16) : '',
    author_id: props.blog.author_id,
    meta_title: props.blog.meta_title || '',
    meta_description: props.blog.meta_description || '',
});

const featuredImagePreview = ref(props.blog.featured_image ? `/storage/${props.blog.featured_image}` : null);
const hasExistingImage = ref(!!props.blog.featured_image);

const submit = () => {
    form.put(route('admin.blogs.update', props.blog.id));
};

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.featured_image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            featuredImagePreview.value = e.target.result;
            hasExistingImage.value = false;
        };
        reader.readAsDataURL(file);
    }
};

const removeImage = () => {
    form.featured_image = null;
    featuredImagePreview.value = null;
    hasExistingImage.value = false;
    document.getElementById('featured_image').value = '';
};
</script>

<template>
    <Head title="Edit Blog" />

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
                        Edit Blog: {{ blog.title }}
                    </h2>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6">
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                            <!-- Main Content -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">
                                        Title *
                                    </label>
                                    <input
                                        id="title"
                                        v-model="form.title"
                                        type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        :class="{
                                            'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500': form.errors.title
                                        }"
                                        placeholder="Enter blog title"
                                        required
                                    />
                                    <div v-if="form.errors.title" class="mt-2 text-sm text-red-600">
                                        {{ form.errors.title }}
                                    </div>
                                </div>

                                <!-- Excerpt -->
                                <div>
                                    <label for="excerpt" class="block text-sm font-medium text-gray-700">
                                        Excerpt
                                    </label>
                                    <textarea
                                        id="excerpt"
                                        v-model="form.excerpt"
                                        rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        :class="{
                                            'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500': form.errors.excerpt
                                        }"
                                        placeholder="Brief description of the blog post"
                                    ></textarea>
                                    <div v-if="form.errors.excerpt" class="mt-2 text-sm text-red-600">
                                        {{ form.errors.excerpt }}
                                    </div>
                                </div>

                                <!-- Content -->
                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700">
                                        Content *
                                    </label>
                                    <textarea
                                        id="content"
                                        v-model="form.content"
                                        rows="15"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        :class="{
                                            'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500': form.errors.content
                                        }"
                                        placeholder="Write your blog content here..."
                                        required
                                    ></textarea>
                                    <div v-if="form.errors.content" class="mt-2 text-sm text-red-600">
                                        {{ form.errors.content }}
                                    </div>
                                </div>

                                <!-- SEO Section -->
                                <div class="border-t pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Settings</h3>
                                    
                                    <!-- Meta Title -->
                                    <div class="mb-4">
                                        <label for="meta_title" class="block text-sm font-medium text-gray-700">
                                            Meta Title
                                        </label>
                                        <input
                                            id="meta_title"
                                            v-model="form.meta_title"
                                            type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="SEO title for search engines"
                                        />
                                    </div>

                                    <!-- Meta Description -->
                                    <div>
                                        <label for="meta_description" class="block text-sm font-medium text-gray-700">
                                            Meta Description
                                        </label>
                                        <textarea
                                            id="meta_description"
                                            v-model="form.meta_description"
                                            rows="3"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="SEO description for search engines"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="space-y-6">
                                <!-- Publish Settings -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-900 mb-4">Publish Settings</h3>
                                    
                                    <!-- Status -->
                                    <div class="mb-4">
                                        <label for="status" class="block text-sm font-medium text-gray-700">
                                            Status *
                                        </label>
                                        <select
                                            id="status"
                                            v-model="form.status"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        >
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                        </select>
                                    </div>

                                    <!-- Author -->
                                    <div class="mb-4">
                                        <label for="author_id" class="block text-sm font-medium text-gray-700">
                                            Author *
                                        </label>
                                        <select
                                            id="author_id"
                                            v-model="form.author_id"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            :class="{
                                                'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500': form.errors.author_id
                                            }"
                                            required
                                        >
                                            <option value="">Select Author</option>
                                            <option v-for="author in authors" :key="author.id" :value="author.id">
                                                {{ author.name }}
                                            </option>
                                        </select>
                                        <div v-if="form.errors.author_id" class="mt-2 text-sm text-red-600">
                                            {{ form.errors.author_id }}
                                        </div>
                                    </div>

                                    <!-- Published Date -->
                                    <div v-if="form.status === 'published'">
                                        <label for="published_at" class="block text-sm font-medium text-gray-700">
                                            Published Date
                                        </label>
                                        <input
                                            id="published_at"
                                            v-model="form.published_at"
                                            type="datetime-local"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        />
                                        <p class="mt-1 text-xs text-gray-500">Leave empty to use current date/time</p>
                                    </div>
                                </div>

                                <!-- Featured Image -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-900 mb-4">Featured Image</h3>
                                    
                                    <div v-if="!featuredImagePreview" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                        <Upload class="mx-auto h-8 w-8 text-gray-400" />
                                        <div class="mt-2">
                                            <label for="featured_image" class="cursor-pointer">
                                                <span class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                                    Upload an image
                                                </span>
                                                <input
                                                    id="featured_image"
                                                    type="file"
                                                    class="sr-only"
                                                    accept="image/*"
                                                    @change="handleImageUpload"
                                                />
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                    </div>

                                    <div v-else class="relative">
                                        <img :src="featuredImagePreview" alt="Featured image preview" class="w-full h-32 object-cover rounded-lg" />
                                        <button
                                            type="button"
                                            @click="removeImage"
                                            class="absolute top-2 right-2 inline-flex items-center rounded-full bg-red-600 p-1 text-white hover:bg-red-700"
                                        >
                                            <X class="h-3 w-3" />
                                        </button>
                                        <div class="mt-2">
                                            <label for="featured_image" class="cursor-pointer text-sm text-indigo-600 hover:text-indigo-500">
                                                Change image
                                                <input
                                                    id="featured_image"
                                                    type="file"
                                                    class="sr-only"
                                                    accept="image/*"
                                                    @change="handleImageUpload"
                                                />
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div v-if="form.errors.featured_image" class="mt-2 text-sm text-red-600">
                                        {{ form.errors.featured_image }}
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end space-x-3">
                                    <Link
                                        :href="route('admin.blogs.index')"
                                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                                    >
                                        Cancel
                                    </Link>
                                    <button
                                        type="submit"
                                        :disabled="form.processing"
                                        class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 disabled:opacity-50"
                                    >
                                        <Save class="mr-2 h-4 w-4" />
                                        {{ form.processing ? 'Updating...' : 'Update Blog' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
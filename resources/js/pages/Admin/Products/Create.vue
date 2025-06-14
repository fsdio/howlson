<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { ArrowLeft, Save, Upload, X, Plus } from 'lucide-vue-next';
import { ref } from 'vue';

defineProps({
    categories: Array,
});

const form = useForm({
    name: '',
    description: '',
    short_description: '',
    sku: '',
    price: '',
    sale_price: '',
    stock_quantity: '',
    weight: '',
    dimensions: '',
    category_id: '',
    featured_image: null,
    gallery_images: [],
    status: 'active',
    is_featured: false,
    meta_title: '',
    meta_description: '',
});

const featuredImagePreview = ref(null);
const galleryPreviews = ref([]);

const submit = () => {
    form.post(route('admin.products.store'));
};

const handleFeaturedImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.featured_image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            featuredImagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const removeFeaturedImage = () => {
    form.featured_image = null;
    featuredImagePreview.value = null;
    document.getElementById('featured_image').value = '';
};

const handleGalleryUpload = (event) => {
    const files = Array.from(event.target.files);
    files.forEach(file => {
        form.gallery_images.push(file);
        const reader = new FileReader();
        reader.onload = (e) => {
            galleryPreviews.value.push(e.target.result);
        };
        reader.readAsDataURL(file);
    });
};

const removeGalleryImage = (index) => {
    form.gallery_images.splice(index, 1);
    galleryPreviews.value.splice(index, 1);
};

const formatPrice = (value) => {
    return value ? parseFloat(value).toFixed(2) : '';
};
</script>

<template>
    <Head title="Create Product" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <Link
                        :href="route('admin.products.index')"
                        class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-medium text-white hover:bg-gray-700"
                    >
                        <ArrowLeft class="mr-2 h-4 w-4" />
                        Back to Products
                    </Link>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Create New Product
                    </h2>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6">
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                            <!-- Main Content -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Basic Information -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                                    
                                    <!-- Product Name -->
                                    <div class="mb-4">
                                        <label for="name" class="block text-sm font-medium text-gray-700">
                                            Product Name *
                                        </label>
                                        <input
                                            id="name"
                                            v-model="form.name"
                                            type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            :class="{
                                                'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500': form.errors.name
                                            }"
                                            placeholder="Enter product name"
                                            required
                                        />
                                        <div v-if="form.errors.name" class="mt-2 text-sm text-red-600">
                                            {{ form.errors.name }}
                                        </div>
                                    </div>

                                    <!-- SKU -->
                                    <div class="mb-4">
                                        <label for="sku" class="block text-sm font-medium text-gray-700">
                                            SKU *
                                        </label>
                                        <input
                                            id="sku"
                                            v-model="form.sku"
                                            type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            :class="{
                                                'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500': form.errors.sku
                                            }"
                                            placeholder="Enter product SKU"
                                            required
                                        />
                                        <div v-if="form.errors.sku" class="mt-2 text-sm text-red-600">
                                            {{ form.errors.sku }}
                                        </div>
                                    </div>

                                    <!-- Short Description -->
                                    <div>
                                        <label for="short_description" class="block text-sm font-medium text-gray-700">
                                            Short Description
                                        </label>
                                        <textarea
                                            id="short_description"
                                            v-model="form.short_description"
                                            rows="3"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Brief description of the product"
                                        ></textarea>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">
                                        Description *
                                    </label>
                                    <textarea
                                        id="description"
                                        v-model="form.description"
                                        rows="10"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        :class="{
                                            'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500': form.errors.description
                                        }"
                                        placeholder="Detailed product description"
                                        required
                                    ></textarea>
                                    <div v-if="form.errors.description" class="mt-2 text-sm text-red-600">
                                        {{ form.errors.description }}
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
                                <!-- Pricing -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-900 mb-4">Pricing</h3>
                                    
                                    <!-- Regular Price -->
                                    <div class="mb-4">
                                        <label for="price" class="block text-sm font-medium text-gray-700">
                                            Regular Price *
                                        </label>
                                        <input
                                            id="price"
                                            v-model="form.price"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            :class="{
                                                'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500': form.errors.price
                                            }"
                                            placeholder="0.00"
                                            required
                                        />
                                        <div v-if="form.errors.price" class="mt-2 text-sm text-red-600">
                                            {{ form.errors.price }}
                                        </div>
                                    </div>

                                    <!-- Sale Price -->
                                    <div>
                                        <label for="sale_price" class="block text-sm font-medium text-gray-700">
                                            Sale Price
                                        </label>
                                        <input
                                            id="sale_price"
                                            v-model="form.sale_price"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="0.00"
                                        />
                                        <p class="mt-1 text-xs text-gray-500">Leave empty if no sale price</p>
                                    </div>
                                </div>

                                <!-- Inventory -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-900 mb-4">Inventory</h3>
                                    
                                    <!-- Stock Quantity -->
                                    <div class="mb-4">
                                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700">
                                            Stock Quantity *
                                        </label>
                                        <input
                                            id="stock_quantity"
                                            v-model="form.stock_quantity"
                                            type="number"
                                            min="0"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            :class="{
                                                'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500': form.errors.stock_quantity
                                            }"
                                            placeholder="0"
                                            required
                                        />
                                        <div v-if="form.errors.stock_quantity" class="mt-2 text-sm text-red-600">
                                            {{ form.errors.stock_quantity }}
                                        </div>
                                    </div>

                                    <!-- Weight -->
                                    <div class="mb-4">
                                        <label for="weight" class="block text-sm font-medium text-gray-700">
                                            Weight (kg)
                                        </label>
                                        <input
                                            id="weight"
                                            v-model="form.weight"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="0.00"
                                        />
                                    </div>

                                    <!-- Dimensions -->
                                    <div>
                                        <label for="dimensions" class="block text-sm font-medium text-gray-700">
                                            Dimensions
                                        </label>
                                        <input
                                            id="dimensions"
                                            v-model="form.dimensions"
                                            type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="L x W x H (cm)"
                                        />
                                    </div>
                                </div>

                                <!-- Category & Status -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-900 mb-4">Category & Status</h3>
                                    
                                    <!-- Category -->
                                    <div class="mb-4">
                                        <label for="category_id" class="block text-sm font-medium text-gray-700">
                                            Category *
                                        </label>
                                        <select
                                            id="category_id"
                                            v-model="form.category_id"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            :class="{
                                                'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500': form.errors.category_id
                                            }"
                                            required
                                        >
                                            <option value="">Select Category</option>
                                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                                {{ category.name }}
                                            </option>
                                        </select>
                                        <div v-if="form.errors.category_id" class="mt-2 text-sm text-red-600">
                                            {{ form.errors.category_id }}
                                        </div>
                                    </div>

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
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>

                                    <!-- Featured Product -->
                                    <div class="flex items-center">
                                        <input
                                            id="is_featured"
                                            v-model="form.is_featured"
                                            type="checkbox"
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                        />
                                        <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                            Featured Product
                                        </label>
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
                                                    @change="handleFeaturedImageUpload"
                                                />
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                    </div>

                                    <div v-else class="relative">
                                        <img :src="featuredImagePreview" alt="Featured image preview" class="w-full h-32 object-cover rounded-lg" />
                                        <button
                                            type="button"
                                            @click="removeFeaturedImage"
                                            class="absolute top-2 right-2 inline-flex items-center rounded-full bg-red-600 p-1 text-white hover:bg-red-700"
                                        >
                                            <X class="h-3 w-3" />
                                        </button>
                                    </div>
                                </div>

                                <!-- Gallery Images -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-900 mb-4">Gallery Images</h3>
                                    
                                    <div class="mb-4">
                                        <label for="gallery_images" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                            <Plus class="mr-2 h-4 w-4" />
                                            Add Images
                                            <input
                                                id="gallery_images"
                                                type="file"
                                                class="sr-only"
                                                accept="image/*"
                                                multiple
                                                @change="handleGalleryUpload"
                                            />
                                        </label>
                                    </div>

                                    <div v-if="galleryPreviews.length > 0" class="grid grid-cols-2 gap-2">
                                        <div v-for="(preview, index) in galleryPreviews" :key="index" class="relative">
                                            <img :src="preview" alt="Gallery image" class="w-full h-20 object-cover rounded" />
                                            <button
                                                type="button"
                                                @click="removeGalleryImage(index)"
                                                class="absolute top-1 right-1 inline-flex items-center rounded-full bg-red-600 p-1 text-white hover:bg-red-700"
                                            >
                                                <X class="h-2 w-2" />
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end space-x-3">
                                    <Link
                                        :href="route('admin.products.index')"
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
                                        {{ form.processing ? 'Creating...' : 'Create Product' }}
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
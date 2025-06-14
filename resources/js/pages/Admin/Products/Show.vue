<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { ArrowLeft, Edit, Trash2, Eye, Package, DollarSign, BarChart3, Calendar, Tag, Star } from 'lucide-vue-next';

const props = defineProps({
    product: Object,
});

const form = useForm({});

const deleteProduct = () => {
    if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        form.delete(route('admin.products.destroy', props.product.id));
    }
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(price);
};

const getStatusBadge = (status) => {
    const badges = {
        active: 'bg-green-100 text-green-800',
        inactive: 'bg-red-100 text-red-800',
        draft: 'bg-yellow-100 text-yellow-800'
    };
    return badges[status] || 'bg-gray-100 text-gray-800';
};

const getStockStatus = (quantity) => {
    if (quantity === 0) return { text: 'Out of Stock', class: 'bg-red-100 text-red-800' };
    if (quantity <= 10) return { text: 'Low Stock', class: 'bg-yellow-100 text-yellow-800' };
    return { text: 'In Stock', class: 'bg-green-100 text-green-800' };
};
</script>

<template>
    <Head :title="`Product: ${product.name}`" />

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
                        Product Details
                    </h2>
                </div>
                <div class="flex space-x-3">
                    <Link
                        :href="route('admin.products.edit', product.id)"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                    >
                        <Edit class="mr-2 h-4 w-4" />
                        Edit Product
                    </Link>
                    <button
                        @click="deleteProduct"
                        class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700"
                    >
                        <Trash2 class="mr-2 h-4 w-4" />
                        Delete
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Product Header -->
                        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h1 class="text-2xl font-bold text-gray-900">{{ product.name }}</h1>
                                        <p class="mt-2 text-sm text-gray-600">SKU: {{ product.sku }}</p>
                                        <div class="mt-4 flex items-center space-x-4">
                                            <span :class="getStatusBadge(product.status)" class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium">
                                                {{ product.status.charAt(0).toUpperCase() + product.status.slice(1) }}
                                            </span>
                                            <span v-if="product.is_featured" class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                                                <Star class="mr-1 h-3 w-3" />
                                                Featured
                                            </span>
                                            <span :class="getStockStatus(product.stock_quantity).class" class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium">
                                                {{ getStockStatus(product.stock_quantity).text }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-gray-900">
                                            {{ formatPrice(product.sale_price || product.price) }}
                                        </div>
                                        <div v-if="product.sale_price" class="text-sm text-gray-500 line-through">
                                            {{ formatPrice(product.price) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div v-if="product.featured_image" class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Featured Image</h3>
                                <img 
                                    :src="`/storage/${product.featured_image}`" 
                                    :alt="product.name" 
                                    class="w-full max-w-md mx-auto rounded-lg shadow-md"
                                />
                            </div>
                        </div>

                        <!-- Gallery Images -->
                        <div v-if="product.gallery_images && product.gallery_images.length > 0" class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Gallery Images</h3>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    <img 
                                        v-for="image in product.gallery_images" 
                                        :key="image.id"
                                        :src="`/storage/${image.path}`" 
                                        :alt="product.name" 
                                        class="w-full h-32 object-cover rounded-lg shadow-sm"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
                                <div v-if="product.short_description" class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Short Description</h4>
                                    <p class="text-gray-600">{{ product.short_description }}</p>
                                </div>
                                <div v-if="product.description">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Full Description</h4>
                                    <div class="prose max-w-none text-gray-600" v-html="product.description"></div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Information -->
                        <div v-if="product.meta_title || product.meta_description" class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Information</h3>
                                <div v-if="product.meta_title" class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Meta Title</h4>
                                    <p class="text-gray-600">{{ product.meta_title }}</p>
                                </div>
                                <div v-if="product.meta_description">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Meta Description</h4>
                                    <p class="text-gray-600">{{ product.meta_description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Quick Stats -->
                        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Stats</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <Package class="h-5 w-5 text-gray-400 mr-3" />
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Stock Quantity</p>
                                            <p class="text-sm text-gray-600">{{ product.stock_quantity }} units</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <DollarSign class="h-5 w-5 text-gray-400 mr-3" />
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Regular Price</p>
                                            <p class="text-sm text-gray-600">{{ formatPrice(product.price) }}</p>
                                        </div>
                                    </div>
                                    <div v-if="product.sale_price" class="flex items-center">
                                        <Tag class="h-5 w-5 text-gray-400 mr-3" />
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Sale Price</p>
                                            <p class="text-sm text-gray-600">{{ formatPrice(product.sale_price) }}</p>
                                        </div>
                                    </div>
                                    <div v-if="product.weight" class="flex items-center">
                                        <BarChart3 class="h-5 w-5 text-gray-400 mr-3" />
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Weight</p>
                                            <p class="text-sm text-gray-600">{{ product.weight }} kg</p>
                                        </div>
                                    </div>
                                    <div v-if="product.dimensions" class="flex items-center">
                                        <Package class="h-5 w-5 text-gray-400 mr-3" />
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Dimensions</p>
                                            <p class="text-sm text-gray-600">{{ product.dimensions }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Category Information -->
                        <div v-if="product.category" class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Category</h3>
                                <div class="flex items-center">
                                    <Tag class="h-5 w-5 text-gray-400 mr-3" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ product.category.name }}</p>
                                        <p v-if="product.category.description" class="text-sm text-gray-600">{{ product.category.description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Technical Details -->
                        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Technical Details</h3>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Product ID</p>
                                        <p class="text-sm text-gray-600">{{ product.id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">SKU</p>
                                        <p class="text-sm text-gray-600">{{ product.sku }}</p>
                                    </div>
                                    <div v-if="product.slug">
                                        <p class="text-sm font-medium text-gray-900">Slug</p>
                                        <p class="text-sm text-gray-600">{{ product.slug }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <Calendar class="h-4 w-4 text-gray-400 mr-2" />
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Created</p>
                                            <p class="text-sm text-gray-600">{{ formatDate(product.created_at) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <Calendar class="h-4 w-4 text-gray-400 mr-2" />
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                            <p class="text-sm text-gray-600">{{ formatDate(product.updated_at) }}</p>
                                        </div>
                                    </div>
                                </div>
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
    max-width: none;
}

.prose p {
    margin-bottom: 1rem;
}

.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.prose ul, .prose ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.25rem;
}
</style>
<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Plus, Edit, Trash2, Eye, Package, DollarSign, TrendingUp } from 'lucide-vue-next';

defineProps({
    products: Object,
    categories: Array,
    filters: Object,
});

const deleteProduct = (id) => {
    if (confirm('Are you sure you want to delete this product?')) {
        router.delete(route('admin.products.destroy', id));
    }
};

const formatPrice = (price) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(price);
};
</script>

<template>
    <Head title="Product Management" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Product Management
                </h2>
                <Link
                    :href="route('admin.products.create')"
                    class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                >
                    <Plus class="mr-2 h-4 w-4" />
                    Add New Product
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Stats Cards -->
                        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div class="rounded-lg bg-blue-50 p-4">
                                <div class="flex items-center">
                                    <Package class="h-8 w-8 text-blue-600" />
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-blue-600">Total Products</p>
                                        <p class="text-2xl font-semibold text-blue-900">{{ products.total }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="rounded-lg bg-green-50 p-4">
                                <div class="flex items-center">
                                    <DollarSign class="h-8 w-8 text-green-600" />
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-600">Categories</p>
                                        <p class="text-2xl font-semibold text-green-900">{{ categories ? categories.length : 0 }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="rounded-lg bg-purple-50 p-4">
                                <div class="flex items-center">
                                    <TrendingUp class="h-8 w-8 text-purple-600" />
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-purple-600">Active Products</p>
                                        <p class="text-2xl font-semibold text-purple-900">{{ products && products.data ? products.data.filter(p => p.status === 'active').length : 0 }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Product
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Category
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Price
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Stock
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Status
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
                                    <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img
                                                        v-if="product.image"
                                                        class="h-10 w-10 rounded-lg object-cover"
                                                        :src="product.image"
                                                        :alt="product.name"
                                                    />
                                                    <div v-else class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                                        <Package class="h-5 w-5 text-gray-400" />
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ product.name }}</div>
                                                    <div class="text-sm text-gray-500">{{ product.sku }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800">
                                                {{ product.category?.name || 'Uncategorized' }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                            {{ formatPrice(product.price) }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                            <span :class="{
                                                'text-red-600': product.stock < 10,
                                                'text-yellow-600': product.stock >= 10 && product.stock < 50,
                                                'text-green-600': product.stock >= 50
                                            }">
                                                {{ product.stock }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span :class="{
                                                'bg-green-100 text-green-800': product.status === 'active',
                                                'bg-red-100 text-red-800': product.status === 'inactive',
                                                'bg-yellow-100 text-yellow-800': product.status === 'draft'
                                            }" class="inline-flex rounded-full px-2 py-1 text-xs font-semibold">
                                                {{ product.status }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            {{ new Date(product.created_at).toLocaleDateString() }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <Link
                                                    :href="route('admin.products.show', product.id)"
                                                    class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-xs font-medium text-white hover:bg-blue-700"
                                                >
                                                    <Eye class="h-3 w-3" />
                                                </Link>
                                                <Link
                                                    :href="route('admin.products.edit', product.id)"
                                                    class="inline-flex items-center rounded-md bg-yellow-600 px-3 py-2 text-xs font-medium text-white hover:bg-yellow-700"
                                                >
                                                    <Edit class="h-3 w-3" />
                                                </Link>
                                                <button
                                                    @click="deleteProduct(product.id)"
                                                    class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-xs font-medium text-white hover:bg-red-700"
                                                >
                                                    <Trash2 class="h-3 w-3" />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-if="products.data.length === 0" class="py-12 text-center">
                                <Package class="mx-auto h-12 w-12 text-gray-400" />
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No products</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new product.</p>
                                <div class="mt-6">
                                    <Link
                                        :href="route('admin.products.create')"
                                        class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700"
                                    >
                                        <Plus class="mr-2 h-4 w-4" />
                                        Add New Product
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div v-if="products.links" class="mt-6 flex items-center justify-between">
                            <div class="flex flex-1 justify-between sm:hidden">
                                <Link
                                    v-if="products.prev_page_url"
                                    :href="products.prev_page_url"
                                    class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                >
                                    Previous
                                </Link>
                                <Link
                                    v-if="products.next_page_url"
                                    :href="products.next_page_url"
                                    class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                >
                                    Next
                                </Link>
                            </div>
                            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Showing {{ products.from }} to {{ products.to }} of {{ products.total }} results
                                    </p>
                                </div>
                                <div>
                                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                        <Link
                                            v-for="link in products.links"
                                            :key="link.label"
                                            :href="link.url"
                                            v-html="link.label"
                                            :class="{
                                                'bg-indigo-50 border-indigo-500 text-indigo-600': link.active,
                                                'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': !link.active
                                            }"
                                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium border"
                                        />
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
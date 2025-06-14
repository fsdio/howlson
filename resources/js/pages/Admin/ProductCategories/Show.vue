<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
import { ArrowLeftIcon, PencilIcon, TrashIcon, TagIcon, CubeIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    category: Object
})

const deleteCategory = () => {
    if (confirm(`Apakah Anda yakin ingin menghapus kategori "${props.category.name}"?`)) {
        router.delete(route('admin.product-categories.destroy', props.category.id))
    }
}

const getStatusBadge = (status) => {
    return status === 'active' 
        ? 'bg-green-100 text-green-800' 
        : 'bg-red-100 text-red-800'
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}
</script>

<template>
    <Head :title="`Detail Kategori: ${category.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <Link
                        :href="route('admin.product-categories.index')"
                        class="text-gray-600 hover:text-gray-900"
                    >
                        <ArrowLeftIcon class="w-5 h-5" />
                    </Link>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Detail Kategori: {{ category.name }}
                    </h2>
                </div>
                <div class="flex items-center space-x-3">
                    <Link
                        :href="route('admin.product-categories.edit', category.id)"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PencilIcon class="w-4 h-4 mr-2" />
                        Edit
                    </Link>
                    <button
                        @click="deleteCategory"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <TrashIcon class="w-4 h-4 mr-2" />
                        Hapus
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Category Information -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex items-start space-x-4">
                                    <!-- Category Image -->
                                    <div v-if="category.image" class="flex-shrink-0">
                                        <img
                                            :src="`/storage/${category.image}`"
                                            :alt="category.name"
                                            class="h-24 w-24 rounded-lg object-cover border border-gray-200"
                                        >
                                    </div>
                                    <div v-else class="flex-shrink-0">
                                        <div class="h-24 w-24 rounded-lg bg-gray-100 flex items-center justify-center border border-gray-200">
                                            <TagIcon class="w-8 h-8 text-gray-400" />
                                        </div>
                                    </div>

                                    <!-- Category Details -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <h1 class="text-2xl font-bold text-gray-900">{{ category.name }}</h1>
                                            <span :class="getStatusBadge(category.status)" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                                                {{ category.status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </div>
                                        
                                        <div class="text-sm text-gray-600 mb-2">
                                            <strong>Slug:</strong> {{ category.slug }}
                                        </div>

                                        <div v-if="category.parent" class="text-sm text-gray-600 mb-2">
                                            <strong>Parent Kategori:</strong> 
                                            <Link 
                                                :href="route('admin.product-categories.show', category.parent.id)"
                                                class="text-blue-600 hover:text-blue-800"
                                            >
                                                {{ category.parent.name }}
                                            </Link>
                                        </div>
                                        <div v-else class="text-sm text-gray-600 mb-2">
                                            <strong>Tipe:</strong> Kategori Utama
                                        </div>

                                        <div v-if="category.description" class="text-gray-700 mt-4">
                                            <strong class="text-gray-900">Deskripsi:</strong>
                                            <p class="mt-1">{{ category.description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sub Categories -->
                        <div v-if="category.children && category.children.length > 0" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Sub Kategori</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Kategori turunan dari {{ category.name }}
                                </p>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div v-for="child in category.children" :key="child.id" class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                        <div class="flex items-center space-x-3">
                                            <div v-if="child.image" class="flex-shrink-0">
                                                <img
                                                    :src="`/storage/${child.image}`"
                                                    :alt="child.name"
                                                    class="h-12 w-12 rounded-lg object-cover"
                                                >
                                            </div>
                                            <div v-else class="flex-shrink-0">
                                                <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                                    <TagIcon class="w-6 h-6 text-gray-400" />
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <Link 
                                                    :href="route('admin.product-categories.show', child.id)"
                                                    class="text-sm font-medium text-gray-900 hover:text-blue-600"
                                                >
                                                    {{ child.name }}
                                                </Link>
                                                <p v-if="child.description" class="text-sm text-gray-500 truncate">
                                                    {{ child.description }}
                                                </p>
                                                <div class="flex items-center space-x-2 mt-1">
                                                    <span :class="getStatusBadge(child.status)" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                                                        {{ child.status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products in Category -->
                        <div v-if="category.products && category.products.length > 0" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Produk dalam Kategori</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ category.products.length }} produk dalam kategori ini
                                </p>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div v-for="product in category.products.slice(0, 6)" :key="product.id" class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                        <div class="flex items-center space-x-3">
                                            <div v-if="product.featured_image" class="flex-shrink-0">
                                                <img
                                                    :src="product.featured_image"
                                                    :alt="product.name"
                                                    class="h-12 w-12 rounded-lg object-cover"
                                                >
                                            </div>
                                            <div v-else class="flex-shrink-0">
                                                <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                                    <CubeIcon class="w-6 h-6 text-gray-400" />
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <Link 
                                                    :href="route('admin.products.show', product.id)"
                                                    class="text-sm font-medium text-gray-900 hover:text-blue-600"
                                                >
                                                    {{ product.name }}
                                                </Link>
                                                <p class="text-sm text-gray-500">
                                                    {{ product.sku }}
                                                </p>
                                                <div class="flex items-center space-x-2 mt-1">
                                                    <span class="text-sm font-medium text-gray-900">
                                                        Rp {{ Number(product.price).toLocaleString('id-ID') }}
                                                    </span>
                                                    <span :class="product.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                                                        {{ product.status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="category.products.length > 6" class="mt-4 text-center">
                                    <Link 
                                        :href="route('admin.products.index', { category: category.id })"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                                    >
                                        Lihat semua {{ category.products.length }} produk →
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Information -->
                        <div v-if="category.meta_title || category.meta_description" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Informasi SEO</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <div v-if="category.meta_title">
                                    <label class="block text-sm font-medium text-gray-700">Meta Title</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ category.meta_title }}</p>
                                </div>
                                <div v-if="category.meta_description">
                                    <label class="block text-sm font-medium text-gray-700">Meta Description</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ category.meta_description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Quick Stats -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Statistik</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Total Produk</span>
                                    <span class="text-sm font-medium text-gray-900">{{ category.products?.length || 0 }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Sub Kategori</span>
                                    <span class="text-sm font-medium text-gray-900">{{ category.children?.length || 0 }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Urutan Tampilan</span>
                                    <span class="text-sm font-medium text-gray-900">{{ category.sort_order || 0 }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Technical Details -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Detail Teknis</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">ID</label>
                                    <p class="mt-1 text-sm text-gray-900 font-mono">{{ category.id }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Slug</label>
                                    <p class="mt-1 text-sm text-gray-900 font-mono">{{ category.slug }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Dibuat</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ formatDate(category.created_at) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Diperbarui</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ formatDate(category.updated_at) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
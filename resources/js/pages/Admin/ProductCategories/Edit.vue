<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'
import { ArrowLeftIcon, PhotoIcon, XMarkIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    category: Object,
    parentCategories: Array
})

const form = useForm({
    name: props.category.name,
    description: props.category.description || '',
    parent_id: props.category.parent_id || '',
    image: null,
    status: props.category.status,
    sort_order: props.category.sort_order || 0,
    meta_title: props.category.meta_title || '',
    meta_description: props.category.meta_description || ''
})

const imagePreview = ref(null)
const fileInput = ref(null)
const currentImage = ref(props.category.image)

const handleImageUpload = (event) => {
    const file = event.target.files[0]
    if (file) {
        form.image = file
        const reader = new FileReader()
        reader.onload = (e) => {
            imagePreview.value = e.target.result
        }
        reader.readAsDataURL(file)
    }
}

const removeImage = () => {
    form.image = null
    imagePreview.value = null
    currentImage.value = null
    if (fileInput.value) {
        fileInput.value.value = ''
    }
}

const removeCurrentImage = () => {
    currentImage.value = null
    form.image = null
}

const submit = () => {
    form.post(route('admin.product-categories.update', props.category.id), {
        _method: 'PUT',
        onSuccess: () => {
            // Form will be redirected by controller
        }
    })
}
</script>

<template>
    <Head title="Edit Kategori Produk" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <Link
                    :href="route('admin.product-categories.index')"
                    class="text-gray-600 hover:text-gray-900"
                >
                    <ArrowLeftIcon class="w-5 h-5" />
                </Link>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Kategori Produk: {{ category.name }}
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Informasi Dasar</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Edit informasi dasar untuk kategori produk.
                            </p>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Nama Kategori *
                                </label>
                                <input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500': form.errors.name
                                    }"
                                    placeholder="Masukkan nama kategori"
                                >
                                <div v-if="form.errors.name" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.name }}
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">
                                    Deskripsi
                                </label>
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    rows="3"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500': form.errors.description
                                    }"
                                    placeholder="Masukkan deskripsi kategori (opsional)"
                                />
                                <div v-if="form.errors.description" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.description }}
                                </div>
                            </div>

                            <!-- Parent Category -->
                            <div>
                                <label for="parent_id" class="block text-sm font-medium text-gray-700">
                                    Parent Kategori
                                </label>
                                <select
                                    id="parent_id"
                                    v-model="form.parent_id"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500': form.errors.parent_id
                                    }"
                                >
                                    <option value="">Pilih Parent Kategori (Opsional)</option>
                                    <option v-for="parentCategory in parentCategories" :key="parentCategory.id" :value="parentCategory.id">
                                        {{ parentCategory.name }}
                                    </option>
                                </select>
                                <div v-if="form.errors.parent_id" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.parent_id }}
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    Kosongkan jika ini adalah kategori utama
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Gambar Kategori</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Upload gambar untuk kategori produk (opsional).
                            </p>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <!-- Current Image -->
                                <div v-if="currentImage && !imagePreview" class="relative inline-block">
                                    <img
                                        :src="`/storage/${currentImage}`"
                                        alt="Current image"
                                        class="h-32 w-32 object-cover rounded-lg border border-gray-300"
                                    >
                                    <button
                                        @click="removeCurrentImage"
                                        type="button"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                    >
                                        <XMarkIcon class="w-4 h-4" />
                                    </button>
                                    <p class="mt-2 text-sm text-gray-500">Gambar saat ini</p>
                                </div>

                                <!-- New Image Preview -->
                                <div v-if="imagePreview" class="relative inline-block">
                                    <img
                                        :src="imagePreview"
                                        alt="Preview"
                                        class="h-32 w-32 object-cover rounded-lg border border-gray-300"
                                    >
                                    <button
                                        @click="removeImage"
                                        type="button"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                    >
                                        <XMarkIcon class="w-4 h-4" />
                                    </button>
                                    <p class="mt-2 text-sm text-gray-500">Gambar baru</p>
                                </div>

                                <!-- Upload Button -->
                                <div v-if="!currentImage && !imagePreview">
                                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <PhotoIcon class="w-8 h-8 mb-2 text-gray-400" />
                                            <p class="mb-2 text-sm text-gray-500">
                                                <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                                            </p>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                        </div>
                                        <input
                                            ref="fileInput"
                                            @change="handleImageUpload"
                                            type="file"
                                            accept="image/*"
                                            class="hidden"
                                        >
                                    </label>
                                </div>

                                <!-- Change Image Button -->
                                <div v-if="(currentImage && !imagePreview) || imagePreview">
                                    <label class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                                        <PhotoIcon class="w-4 h-4 mr-2" />
                                        {{ currentImage ? 'Ganti Gambar' : 'Pilih Gambar Lain' }}
                                        <input
                                            ref="fileInput"
                                            @change="handleImageUpload"
                                            type="file"
                                            accept="image/*"
                                            class="hidden"
                                        >
                                    </label>
                                </div>

                                <div v-if="form.errors.image" class="text-sm text-red-600">
                                    {{ form.errors.image }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Pengaturan</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Atur status dan urutan tampilan kategori.
                            </p>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">
                                        Status *
                                    </label>
                                    <select
                                        id="status"
                                        v-model="form.status"
                                        required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        :class="{
                                            'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500': form.errors.status
                                        }"
                                    >
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                    </select>
                                    <div v-if="form.errors.status" class="mt-2 text-sm text-red-600">
                                        {{ form.errors.status }}
                                    </div>
                                </div>

                                <!-- Sort Order -->
                                <div>
                                    <label for="sort_order" class="block text-sm font-medium text-gray-700">
                                        Urutan Tampilan
                                    </label>
                                    <input
                                        id="sort_order"
                                        v-model.number="form.sort_order"
                                        type="number"
                                        min="0"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        :class="{
                                            'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500': form.errors.sort_order
                                        }"
                                        placeholder="0"
                                    >
                                    <div v-if="form.errors.sort_order" class="mt-2 text-sm text-red-600">
                                        {{ form.errors.sort_order }}
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Angka yang lebih kecil akan ditampilkan lebih dulu
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Informasi SEO</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Optimasi untuk mesin pencari (opsional).
                            </p>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Meta Title -->
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-gray-700">
                                    Meta Title
                                </label>
                                <input
                                    id="meta_title"
                                    v-model="form.meta_title"
                                    type="text"
                                    maxlength="255"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500': form.errors.meta_title
                                    }"
                                    placeholder="Judul untuk SEO"
                                >
                                <div v-if="form.errors.meta_title" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.meta_title }}
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ form.meta_title.length }}/255 karakter
                                </p>
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
                                    maxlength="500"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500': form.errors.meta_description
                                    }"
                                    placeholder="Deskripsi untuk SEO"
                                />
                                <div v-if="form.errors.meta_description" class="mt-2 text-sm text-red-600">
                                    {{ form.errors.meta_description }}
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ form.meta_description.length }}/500 karakter
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-end space-x-4">
                                <Link
                                    :href="route('admin.product-categories.index')"
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    Batal
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <span v-if="form.processing">Menyimpan...</span>
                                    <span v-else>Update Kategori</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
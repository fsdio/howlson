<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { ref, computed } from 'vue';

// Generate random images from Unsplash with different categories
const randomImages = [
    { id: 1, title: 'Nature Landscape', url: 'https://picsum.photos/400/400?random=1', category: 'Nature' },
    { id: 2, title: 'Urban Architecture', url: 'https://picsum.photos/400/400?random=2', category: 'Architecture' },
    { id: 3, title: 'Abstract Art', url: 'https://picsum.photos/400/400?random=3', category: 'Abstract' },
    { id: 4, title: 'Wildlife Photography', url: 'https://picsum.photos/400/400?random=4', category: 'Wildlife' },
    { id: 5, title: 'Street Photography', url: 'https://picsum.photos/400/400?random=5', category: 'Street' },
    { id: 6, title: 'Minimalist Design', url: 'https://picsum.photos/400/400?random=6', category: 'Minimalist' },
    { id: 7, title: 'Food Photography', url: 'https://picsum.photos/400/400?random=7', category: 'Food' },
    { id: 8, title: 'Travel Destination', url: 'https://picsum.photos/400/400?random=8', category: 'Travel' },
    { id: 9, title: 'Portrait Photography', url: 'https://picsum.photos/400/400?random=9', category: 'Portrait' },
    { id: 10, title: 'Technology Concept', url: 'https://picsum.photos/400/400?random=10', category: 'Technology' },
    { id: 11, title: 'Vintage Style', url: 'https://picsum.photos/400/400?random=11', category: 'Vintage' },
    { id: 12, title: 'Modern Art', url: 'https://picsum.photos/400/400?random=12', category: 'Modern' }
];

// Current image index for navigation
const currentImageIndex = ref(0);

// Responsive images per page
const getImagesPerPage = () => {
    if (typeof window !== 'undefined') {
        if (window.innerWidth < 640) return 2; // Mobile: 2 images
        if (window.innerWidth < 1024) return 3; // Tablet: 3 images
        return 4; // Desktop: 4 images
    }
    return 4;
};

const imagesPerPage = ref(getImagesPerPage());

// Update images per page on window resize
if (typeof window !== 'undefined') {
    window.addEventListener('resize', () => {
        imagesPerPage.value = getImagesPerPage();
        // Adjust current index if needed
        const maxIndex = Math.max(0, randomImages.length - imagesPerPage.value);
        if (currentImageIndex.value > maxIndex) {
            currentImageIndex.value = Math.floor(maxIndex / imagesPerPage.value) * imagesPerPage.value;
        }
    });
}

// Computed properties for navigation
const currentImages = computed(() => {
    const start = currentImageIndex.value;
    const end = start + imagesPerPage.value;
    return randomImages.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(randomImages.length / imagesPerPage.value);
});

const currentPage = computed(() => {
    return Math.floor(currentImageIndex.value / imagesPerPage.value) + 1;
});

const canGoPrevious = computed(() => {
    return currentImageIndex.value > 0;
});

const canGoNext = computed(() => {
    return currentImageIndex.value + imagesPerPage.value < randomImages.length;
});

// Navigation functions
const goToPrevious = () => {
    if (canGoPrevious.value) {
        currentImageIndex.value = Math.max(0, currentImageIndex.value - imagesPerPage.value);
    }
};

const goToNext = () => {
    if (canGoNext.value) {
        currentImageIndex.value = Math.min(randomImages.length - imagesPerPage.value, currentImageIndex.value + imagesPerPage.value);
    }
};

const goToPage = (pageNumber) => {
    const newIndex = (pageNumber - 1) * imagesPerPage.value;
    if (newIndex >= 0 && newIndex < randomImages.length) {
        currentImageIndex.value = newIndex;
    }
};
</script>

<template>
    <Head title="Dashboard" />
    
    <AuthenticatedLayout>
        <div class="space-y-4 sm:space-y-6">
            <!-- About Howlson Section -->
            <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                <div class="text-center mb-4 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Tentang Howlson</h2>
                    <div class="w-12 sm:w-16 h-1 bg-gradient-to-r from-blue-500 to-purple-600 mx-auto rounded-full"></div>
                </div>
                
                <div class="max-w-3xl mx-auto">
                    <p class="text-sm sm:text-base text-gray-600 leading-relaxed text-center px-2 sm:px-0">
                        Howlson adalah platform inovatif yang dirancang untuk memberikan pengalaman terbaik dalam mengelola konten digital. 
                        Dengan antarmuka yang modern dan intuitif, Howlson memungkinkan pengguna untuk mengorganisir, mengelola, dan 
                        berbagi konten dengan mudah dan efisien.
                    </p>
                </div>
            </div>

            <!-- Image Gallery -->
            <div class="bg-white rounded-lg sm:rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6 gap-3 sm:gap-0">
                    <div class="text-center sm:text-left">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Gallery Inspirasi</h2>
                        <p class="text-sm sm:text-base text-gray-600 mt-1">Koleksi gambar dan konten kreatif</p>
                    </div>
                    <div class="flex items-center justify-center sm:justify-end gap-2 sm:gap-3">
                        <span class="text-xs sm:text-sm text-gray-500 bg-gray-100 px-2 sm:px-3 py-1 rounded-full">
                            {{ randomImages.length }} items
                        </span>
                        <span class="text-xs text-gray-400 hidden sm:inline">
                            Halaman {{ currentPage }} dari {{ totalPages }}
                        </span>
                    </div>
                </div>

                <!-- Navigation Controls -->
                <div class="flex flex-col sm:flex-row items-center justify-between mb-4 gap-3 sm:gap-0">
                    <!-- Mobile: Page indicator at top -->
                    <div class="flex sm:hidden items-center gap-2 order-1">
                        <span class="text-xs text-gray-500">Halaman {{ currentPage }} dari {{ totalPages }}</span>
                    </div>
                    
                    <!-- Navigation buttons -->
                    <div class="flex items-center justify-between w-full sm:w-auto gap-3 order-2 sm:order-none">
                        <button @click="goToPrevious" 
                                :disabled="!canGoPrevious"
                                :class="canGoPrevious ? 'bg-blue-500 hover:bg-blue-600 text-white' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                                class="flex items-center gap-1 sm:gap-2 px-2 sm:px-4 py-2 rounded-lg transition-all duration-300 text-sm">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span class="hidden sm:inline">Sebelumnya</span>
                            <span class="sm:hidden">Prev</span>
                        </button>
                        
                        <!-- Desktop pagination dots -->
                        <div class="hidden sm:flex gap-2">
                            <button v-for="page in totalPages" :key="page"
                                    @click="goToPage(page)"
                                    :class="page === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-600 hover:bg-gray-300'"
                                    class="w-8 h-8 rounded-full transition-all duration-300 text-sm font-medium">
                                {{ page }}
                            </button>
                        </div>
                        
                        <!-- Mobile pagination dots -->
                        <div class="flex sm:hidden gap-1">
                            <button v-for="page in totalPages" :key="page"
                                    @click="goToPage(page)"
                                    :class="page === currentPage ? 'bg-blue-500' : 'bg-gray-300'"
                                    class="w-2 h-2 rounded-full transition-all duration-300">
                            </button>
                        </div>
                        
                        <button @click="goToNext" 
                                :disabled="!canGoNext"
                                :class="canGoNext ? 'bg-blue-500 hover:bg-blue-600 text-white' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                                class="flex items-center gap-1 sm:gap-2 px-2 sm:px-4 py-2 rounded-lg transition-all duration-300 text-sm">
                            <span class="hidden sm:inline">Selanjutnya</span>
                            <span class="sm:hidden">Next</span>
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Image Grid -->
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4">
                    <div v-for="image in currentImages" :key="image.id"
                        class="group relative overflow-hidden rounded-lg sm:rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200">
                        <div class="aspect-square relative">
                            <!-- Random Image -->
                            <img :src="image.url" 
                                 :alt="image.title"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                 loading="lazy">
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300"></div>

                            <!-- Category Badge -->
                            <div class="absolute top-1 sm:top-2 left-1 sm:left-2">
                                <span class="bg-white/90 text-gray-800 text-xs px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full font-medium">
                                    {{ image.category }}
                                </span>
                            </div>

                            <!-- Content Overlay -->
                            <div class="absolute inset-0 flex items-end p-2 sm:p-4 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <div class="text-white">
                                    <div class="text-white/90 text-xs mb-1">
                                        #{{ image.id.toString().padStart(2, '0') }}
                                    </div>
                                    <h3 class="font-semibold text-xs sm:text-sm transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300 line-clamp-2">
                                        {{ image.title }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gallery Info -->
                <div class="mt-4 sm:mt-6 text-center">
                    <p class="text-xs sm:text-sm text-gray-500">
                        Menampilkan {{ currentImages.length }} dari {{ randomImages.length }} gambar
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

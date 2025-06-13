<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import ApplicationLogo from '@/components/ApplicationLogo.vue';
import Footer from '@/components/Footer.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const currentSlide = ref(0);
const totalSlides = 15;
const slidesToShow = 3;
const maxSlide = Math.max(0, totalSlides - slidesToShow);

const nextSlide = () => {
    if (currentSlide.value < maxSlide) {
        currentSlide.value += 1;
    } else {
        currentSlide.value = 0;
    }
};

const prevSlide = () => {
    if (currentSlide.value > 0) {
        currentSlide.value -= 1;
    } else {
        currentSlide.value = maxSlide;
    }
};

const goToSlide = (index) => {
    currentSlide.value = Math.min(index, maxSlide);
};

// Generate image data
const images = Array.from({ length: 17 }, (_, index) => ({
    id: index + 1,
    src: `https://picsum.photos/800/600?random=${index + 1}`,
    alt: `Gambar ${index + 1}`,
    title: `Foto ${index + 1}`,
    description: `Deskripsi untuk foto ke-${index + 1}`
}));
</script>

<template>
    <Head title="Welcome" />
    <div class="min-h-screen bg-gray-100">
        <!-- Header dengan logo dan tombol auth -->
        <div class="flex min-h-screen flex-col items-center justify-center px-6">
            <!-- Logo dan Brand -->
            <div class="mb-12 flex flex-col items-center justify-center">
                <div class="mb-6 flex h-32 w-32 items-center justify-center rounded-full bg-white shadow-lg border border-gray-200">
                    <ApplicationLogo class="h-20 w-20 fill-current text-gray-800" />
                </div>
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">howlson</h1>
                    <p class="text-lg text-gray-600">Platform Manajemen Peran & Izin</p>
                </div>
            </div>

            <!-- Tombol Login dan Register -->
            <div v-if="canLogin" class="mb-16 flex space-x-6">
                <template v-if="!$page.props.auth.user">
                    <Link
                        :href="route('login')"
                        class="rounded-lg bg-gray-800 px-8 py-3 text-white font-medium transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 shadow-md"
                    >
                        Masuk
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-lg border border-gray-300 bg-white px-8 py-3 text-gray-700 font-medium transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 shadow-md"
                    >
                        Daftar
                    </Link>
                </template>
                <template v-else>
                    <Link
                        :href="route('dashboard')"
                        class="rounded-lg bg-gray-800 px-8 py-3 text-white font-medium transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 shadow-md"
                    >
                        Dashboard
                    </Link>
                </template>
            </div>

            <!-- Image Slider -->
            <div class="relative max-w-5xl w-full">
                <!-- Slider Container -->
                <div class="overflow-hidden rounded-lg shadow-lg">
                    <div class="flex transition-transform duration-500 ease-in-out" :style="{ transform: `translateX(-${currentSlide * (100 / slidesToShow)}%)` }">
                        <!-- Dynamic Image Slides -->
                        <div 
                            v-for="(image, index) in images" 
                            :key="image.id"
                            class="flex-shrink-0 relative px-1"
                            :style="{ width: `${100 / slidesToShow}%` }"
                        >
                            <div class="relative group">
                                <img 
                                    :src="image.src" 
                                    :alt="image.alt"
                                    class="w-full h-96 object-cover transition-transform duration-300 group-hover:scale-105 rounded-lg"
                                    loading="lazy"
                                />
                                <!-- Overlay with image info -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg">
                                    <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                        <h3 class="text-lg font-semibold mb-1">{{ image.title }}</h3>
                                        <p class="text-xs opacity-90">{{ image.description }}</p>
                                    </div>
                                </div>
                                <!-- Image counter -->
                                <div class="absolute top-2 right-2 bg-black/50 text-white px-2 py-1 rounded-full text-xs">
                                    {{ index + 1 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <button 
                    @click="prevSlide" 
                    class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-4 bg-white rounded-full p-2 shadow-lg border border-gray-200 hover:bg-gray-50 transition-colors"
                >
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <button 
                    @click="nextSlide" 
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-4 bg-white rounded-full p-2 shadow-lg border border-gray-200 hover:bg-gray-50 transition-colors"
                >
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Dots Indicator -->
                <div class="flex justify-center mt-6 space-x-1 flex-wrap max-w-md mx-auto">
                    <button 
                        v-for="slideIndex in Math.ceil(totalSlides / slidesToShow)" 
                        :key="slideIndex - 1"
                        @click="goToSlide((slideIndex - 1) * slidesToShow)"
                        class="w-2 h-2 rounded-full transition-all duration-200 m-1"
                        :class="Math.floor(currentSlide / slidesToShow) === slideIndex - 1 ? 'bg-gray-800 scale-125' : 'bg-gray-300 hover:bg-gray-400'"
                        :title="`Slide ${slideIndex}`"
                    ></button>
                </div>
                
                <!-- Slide Info -->
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Menampilkan gambar {{ currentSlide + 1 }} sampai {{ Math.min(currentSlide + slidesToShow, totalSlides) }} dari total {{ totalSlides }} gambar
                        (Slide {{ Math.floor(currentSlide / slidesToShow) + 1 }} dari {{ Math.ceil(totalSlides / slidesToShow) }})
                    </p>
                </div>
            </div>

        </div>
        
        <!-- Footer -->
        <Footer />
    </div>
</template>

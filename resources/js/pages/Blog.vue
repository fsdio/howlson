<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Calendar, User, Clock, Search, Filter, ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { ref, computed, watch } from 'vue';

// State management
const searchQuery = ref('');
const selectedCategory = ref('');
const filterActive = ref(false);
const currentPage = ref(1);
const itemsPerPage = 8;

// Dummy blog articles data (expanded for pagination)
const allBlogArticles = [
    {
        id: 1,
        title: 'Menggali Makna Jeritan Jiwa dalam Seni Visual',
        excerpt: 'Eksplorasi mendalam tentang bagaimana seni visual dapat menjadi medium untuk mengekspresikan jeritan jiwa yang paling dalam.',
        author: 'Howlson Team',
        date: '2024-01-15',
        readTime: '5 min read',
        image: 'from-purple-500 to-pink-600',
        category: 'Seni & Filosofi'
    },
    {
        id: 2,
        title: 'Teknik Fotografi untuk Menangkap Emosi',
        excerpt: 'Panduan praktis menggunakan teknik fotografi untuk menangkap dan menyampaikan emosi yang mendalam dalam setiap frame.',
        author: 'Sarah Johnson',
        date: '2024-01-12',
        readTime: '7 min read',
        image: 'from-blue-500 to-cyan-600',
        category: 'Fotografi'
    },
    {
        id: 3,
        title: 'Warna sebagai Bahasa Universal Perasaan',
        excerpt: 'Memahami psikologi warna dan bagaimana setiap nuansa dapat menyampaikan pesan emosional yang berbeda.',
        author: 'Michael Chen',
        date: '2024-01-10',
        readTime: '4 min read',
        image: 'from-green-500 to-emerald-600',
        category: 'Psikologi Seni'
    },
    {
        id: 4,
        title: 'Perjalanan Kreatif: Dari Ide hingga Karya',
        excerpt: 'Mengikuti proses kreatif dari konsep awal hingga menjadi karya seni yang dapat menyentuh hati banyak orang.',
        author: 'Emma Rodriguez',
        date: '2024-01-08',
        readTime: '6 min read',
        image: 'from-orange-500 to-red-600',
        category: 'Proses Kreatif'
    },
    {
        id: 5,
        title: 'Minimalism dalam Era Digital',
        excerpt: 'Bagaimana pendekatan minimalis dapat memberikan dampak maksimal dalam karya seni digital modern.',
        author: 'David Kim',
        date: '2024-01-05',
        readTime: '5 min read',
        image: 'from-gray-500 to-slate-600',
        category: 'Seni Digital'
    },
    {
        id: 6,
        title: 'Storytelling Melalui Komposisi Visual',
        excerpt: 'Teknik menyusun elemen visual untuk menceritakan kisah yang kuat dan berkesan bagi penikmat seni.',
        author: 'Lisa Wang',
        date: '2024-01-03',
        readTime: '8 min read',
        image: 'from-indigo-500 to-purple-600',
        category: 'Komposisi'
    },
    {
        id: 7,
        title: 'Inspirasi dari Alam untuk Karya Abstrak',
        excerpt: 'Menemukan inspirasi dari keindahan alam dan mentransformasikannya menjadi karya seni abstrak yang memukau.',
        author: 'James Wilson',
        date: '2024-01-01',
        readTime: '6 min read',
        image: 'from-teal-500 to-green-600',
        category: 'Seni Abstrak'
    },
    {
        id: 8,
        title: 'Evolusi Seni Kontemporer Indonesia',
        excerpt: 'Menelusuri perkembangan seni kontemporer Indonesia dan pengaruhnya terhadap scene seni global.',
        author: 'Rina Sari',
        date: '2023-12-28',
        readTime: '9 min read',
        image: 'from-rose-500 to-pink-600',
        category: 'Seni Kontemporer'
    },
    {
        id: 9,
        title: 'Teknik Pencahayaan dalam Fotografi Portrait',
        excerpt: 'Menguasai berbagai teknik pencahayaan untuk menghasilkan foto portrait yang dramatis dan berkarakter.',
        author: 'Alex Thompson',
        date: '2023-12-25',
        readTime: '7 min read',
        image: 'from-amber-500 to-orange-600',
        category: 'Fotografi'
    },
    {
        id: 10,
        title: 'Seni Jalanan sebagai Ekspresi Sosial',
        excerpt: 'Bagaimana seni jalanan menjadi medium untuk menyampaikan pesan sosial dan politik di era modern.',
        author: 'Maya Putri',
        date: '2023-12-22',
        readTime: '6 min read',
        image: 'from-violet-500 to-purple-600',
        category: 'Seni & Filosofi'
    },
    {
        id: 11,
        title: 'Komposisi Warna dalam Desain Grafis',
        excerpt: 'Prinsip-prinsip dasar komposisi warna yang efektif untuk menciptakan desain grafis yang menarik.',
        author: 'Ryan Lee',
        date: '2023-12-20',
        readTime: '5 min read',
        image: 'from-cyan-500 to-blue-600',
        category: 'Seni Digital'
    },
    {
        id: 12,
        title: 'Meditasi Melalui Seni Lukis',
        excerpt: 'Menggunakan seni lukis sebagai bentuk meditasi untuk mencapai ketenangan dan fokus mental.',
        author: 'Sofia Martinez',
        date: '2023-12-18',
        readTime: '8 min read',
        image: 'from-emerald-500 to-teal-600',
        category: 'Psikologi Seni'
    },
    {
        id: 13,
        title: 'Fotografi Makro: Dunia dalam Detail',
        excerpt: 'Eksplorasi dunia fotografi makro untuk menangkap keindahan detail yang tersembunyi.',
        author: 'Kevin Zhang',
        date: '2023-12-15',
        readTime: '6 min read',
        image: 'from-lime-500 to-green-600',
        category: 'Fotografi'
    },
    {
        id: 14,
        title: 'Arsitektur sebagai Kanvas Kreatif',
        excerpt: 'Memahami bagaimana arsitektur modern dapat menjadi medium ekspresi artistik yang powerful.',
        author: 'Isabella Chen',
        date: '2023-12-12',
        readTime: '7 min read',
        image: 'from-stone-500 to-gray-600',
        category: 'Komposisi'
    },
    {
        id: 15,
        title: 'Seni Digital dalam Era AI',
        excerpt: 'Bagaimana kecerdasan buatan mengubah landscape seni digital dan kreativitas manusia.',
        author: 'Marcus Johnson',
        date: '2023-12-10',
        readTime: '9 min read',
        image: 'from-fuchsia-500 to-pink-600',
        category: 'Seni Digital'
    },
    {
        id: 16,
        title: 'Ekspresionisme dalam Seni Modern',
        excerpt: 'Menelusuri gerakan ekspresionisme dan pengaruhnya terhadap seni visual kontemporer.',
        author: 'Elena Rodriguez',
        date: '2023-12-08',
        readTime: '8 min read',
        image: 'from-red-500 to-rose-600',
        category: 'Seni Kontemporer'
    }
];

// Get unique categories
const categories = computed(() => {
    const cats = [...new Set(allBlogArticles.map(article => article.category))];
    return cats.sort();
});

// Filter and search functionality
const filteredArticles = computed(() => {
    let filtered = allBlogArticles;
    
    // Filter by category
    if (selectedCategory.value) {
        filtered = filtered.filter(article => article.category === selectedCategory.value);
    }
    
    // Filter by search query
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter(article => 
            article.title.toLowerCase().includes(query) ||
            article.excerpt.toLowerCase().includes(query) ||
            article.author.toLowerCase().includes(query) ||
            article.category.toLowerCase().includes(query)
        );
    }
    
    return filtered;
});

// Pagination computed properties
const totalPages = computed(() => {
    return Math.ceil(filteredArticles.value.length / itemsPerPage);
});

const displayedArticles = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return filteredArticles.value.slice(startIndex, endIndex);
});

const paginationInfo = computed(() => {
    const start = filteredArticles.value.length === 0 ? 0 : (currentPage.value - 1) * itemsPerPage + 1;
    const end = Math.min(currentPage.value * itemsPerPage, filteredArticles.value.length);
    return {
        start,
        end,
        total: filteredArticles.value.length
    };
});

// Pagination range for display
const paginationRange = computed(() => {
    const total = totalPages.value;
    const current = currentPage.value;
    const range = [];
    
    if (total <= 7) {
        // Show all pages if total is 7 or less
        for (let i = 1; i <= total; i++) {
            range.push(i);
        }
    } else {
        // Show smart pagination
        if (current <= 4) {
            // Show first 5 pages + ... + last page
            for (let i = 1; i <= 5; i++) range.push(i);
            if (total > 6) range.push('...');
            range.push(total);
        } else if (current >= total - 3) {
            // Show first page + ... + last 5 pages
            range.push(1);
            if (total > 6) range.push('...');
            for (let i = total - 4; i <= total; i++) range.push(i);
        } else {
            // Show first + ... + current-1, current, current+1 + ... + last
            range.push(1);
            range.push('...');
            for (let i = current - 1; i <= current + 1; i++) range.push(i);
            range.push('...');
            range.push(total);
        }
    }
    
    return range;
});

// Functions
const toggleFilter = () => {
    filterActive.value = !filterActive.value;
};

const clearFilters = () => {
    searchQuery.value = '';
    selectedCategory.value = '';
    currentPage.value = 1;
};

// Pagination functions
const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        // Scroll to top when changing page
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

const previousPage = () => {
    if (currentPage.value > 1) {
        goToPage(currentPage.value - 1);
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        goToPage(currentPage.value + 1);
    }
};

// Reset pagination when filters change
const resetPagination = () => {
    currentPage.value = 1;
};

// Watch for filter changes
watch(searchQuery, resetPagination);
watch(selectedCategory, resetPagination);
</script>

<template>
    <Head title="Blog" />
    
    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Blog Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Blog Howlson</h1>
                <p class="text-gray-600 mt-2">Eksplorasi seni, kreativitas, dan jeritan jiwa</p>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                <!-- Search Bar -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 mb-4">
                    <div class="relative flex-grow">
                        <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" />
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Cari artikel berdasarkan judul, konten, atau penulis..."
                            class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        />
                    </div>
                    <div class="flex gap-2 sm:gap-3">
                        <button
                            @click="toggleFilter"
                            :class="[
                                'flex-1 sm:flex-none flex items-center gap-2 px-3 sm:px-4 py-2 text-sm font-medium rounded-lg transition-colors whitespace-nowrap',
                                filterActive ? 'bg-indigo-700 text-white' : 'bg-indigo-600 text-white hover:bg-indigo-700'
                            ]"
                        >
                            <Filter class="w-4 h-4" />
                            <span class="hidden sm:inline">{{ filterActive ? 'Sembunyikan Filter' : 'Tampilkan Filter' }}</span>
                            <span class="sm:hidden">{{ filterActive ? 'Sembunyikan' : 'Filter' }}</span>
                        </button>
                        <button
                            @click="clearFilters"
                            class="flex-1 sm:flex-none bg-gray-500 text-white px-3 sm:px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-600 transition-colors whitespace-nowrap"
                        >
                            <span class="hidden sm:inline">Reset Filter</span>
                            <span class="sm:hidden">Reset</span>
                        </button>
                    </div>
                </div>

                <!-- Advanced Filters -->
                <div v-show="filterActive" class="bg-gray-50 rounded-lg p-4 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Category Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select
                                v-model="selectedCategory"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >
                                <option value="">Semua Kategori</option>
                                <option v-for="category in categories" :key="category" :value="category">
                                    {{ category }}
                                </option>
                            </select>
                        </div>

                        <!-- Results Info -->
                        <div class="flex items-end">
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">{{ filteredArticles.length }}</span> artikel ditemukan
                                <span v-if="totalPages > 1" class="block text-xs text-gray-500 mt-1">
                                    Halaman {{ currentPage }} dari {{ totalPages }} • Menampilkan {{ paginationInfo.start }}-{{ paginationInfo.end }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blog Articles Section -->
            <div v-if="displayedArticles.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <Link v-for="article in displayedArticles" :key="article.id" :href="route('blog.detail', article.id)"
                            class="group bg-white rounded-lg shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200 overflow-hidden cursor-pointer block">

                        <!-- Article Image/Gradient -->
                        <div :class="['bg-gradient-to-br', article.image]"
                            class="h-48 w-full flex items-center justify-center relative">
                            <!-- Overlay -->
                            <div
                                class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-all duration-300">
                            </div>

                            <!-- Category Badge -->
                            <div
                                class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium text-gray-700">
                                {{ article.category }}
                            </div>

                            <!-- Content Overlay -->
                            <div
                                class="relative z-10 text-center p-4 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <div class="text-white text-sm font-semibold">
                                    Baca Artikel
                                </div>
                            </div>
                        </div>

                        <!-- Article Content -->
                        <div class="p-6">
                            <h3
                                class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-indigo-600 transition-colors duration-300">
                                {{ article.title }}
                            </h3>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ article.excerpt }}
                            </p>

                            <!-- Article Meta -->
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-1">
                                        <User class="w-3 h-3" />
                                        <span>{{ article.author }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <Clock class="w-3 h-3" />
                                        <span>{{ article.readTime }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    <Calendar class="w-3 h-3" />
                                    <span>{{ new Date(article.date).toLocaleDateString('id-ID', {
                                        day: 'numeric', month:
                                        'short', year: 'numeric' }) }}</span>
                                </div>
                            </div>
                        </div>
                        </Link>
                    </div>

                    <!-- Pagination Section -->
                    <div v-if="displayedArticles.length > 0 && totalPages > 1" class="mt-8">
                        <!-- Pagination Info -->
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                            <div class="text-sm text-gray-600">
                                Menampilkan {{ paginationInfo.start }} - {{ paginationInfo.end }} dari {{ paginationInfo.total }} artikel
                            </div>
                            
                            <!-- Items per page selector (optional) -->
                            <div class="text-sm text-gray-500">
                                Halaman {{ currentPage }} dari {{ totalPages }}
                            </div>
                        </div>
                        
                        <!-- Pagination Controls -->
                        <div class="flex justify-center">
                            <nav class="flex items-center gap-1" aria-label="Pagination">
                                <!-- Previous Button -->
                                <button
                                    @click="previousPage"
                                    :disabled="currentPage === 1"
                                    class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-50 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-500 transition-colors"
                                >
                                    <ChevronLeft class="w-4 h-4" />
                                    <span class="hidden sm:inline">Sebelumnya</span>
                                </button>
                                
                                <!-- Page Numbers -->
                                <template v-for="(page, index) in paginationRange" :key="index">
                                    <button
                                        v-if="page !== '...'"
                                        @click="goToPage(page)"
                                        :class="[
                                            'px-3 py-2 text-sm font-medium border-t border-b transition-colors',
                                            currentPage === page
                                                ? 'bg-indigo-600 text-white border-indigo-600 hover:bg-indigo-700'
                                                : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 hover:text-gray-900'
                                        ]"
                                    >
                                        {{ page }}
                                    </button>
                                    <span
                                        v-else
                                        class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border-t border-b border-gray-300"
                                    >
                                        ...
                                    </span>
                                </template>
                                
                                <!-- Next Button -->
                                <button
                                    @click="nextPage"
                                    :disabled="currentPage === totalPages"
                                    class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-50 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-500 transition-colors"
                                >
                                    <span class="hidden sm:inline">Selanjutnya</span>
                                    <ChevronRight class="w-4 h-4" />
                                </button>
                            </nav>
                        </div>
                    </div>

            <!-- Empty State -->
            <div v-else class="text-center py-12">
                <div class="max-w-md mx-auto">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <Search class="w-8 h-8 text-gray-400" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada artikel ditemukan</h3>
                    <p class="text-gray-500 mb-4">
                        <span v-if="searchQuery || selectedCategory">
                            Coba ubah kata kunci pencarian atau filter kategori.
                        </span>
                        <span v-else>
                            Belum ada artikel yang tersedia saat ini.
                        </span>
                    </p>
                    <button
                        v-if="searchQuery || selectedCategory"
                        @click="clearFilters"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                    >
                        Reset Filter
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
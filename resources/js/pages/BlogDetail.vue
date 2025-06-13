<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { ArrowLeft, Calendar, Clock, User, Heart, Share2, Bookmark, Eye } from 'lucide-vue-next'
import { DropdownMenu, DropdownMenuContent, DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Button } from '@/components/ui/button'
import { Settings, LogOut } from 'lucide-vue-next'
import Footer from '@/components/Footer.vue'

const { props } = usePage()
const user = computed(() => props.auth?.user)
const isAdmin = computed(() => user.value?.roles?.some(role => role.name === 'admin'))
const articleId = computed(() => props.articleId)

const handleLogout = () => {
    // Handle logout logic here
    console.log('Logging out...')
}

const getInitials = (name) => {
    if (!name) return 'U'
    return name.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2)
}

// Dummy blog articles data (same as Blog.vue)
const dummyArticles = [
    {
        id: 1,
        title: 'Menggali Makna Jeritan Jiwa dalam Seni Visual',
        excerpt: 'Eksplorasi mendalam tentang bagaimana seni visual dapat menjadi medium untuk mengekspresikan jeritan jiwa yang paling dalam.',
        content: `
            <p>Seni visual telah menjadi bahasa universal yang mampu menyampaikan perasaan dan emosi yang sulit diungkapkan dengan kata-kata. Dalam konteks "jeritan jiwa", seni visual berperan sebagai medium yang memungkinkan seniman untuk mengekspresikan pergolakan batin, kegelisahan, dan pencarian makna hidup.</p>
            
            <h2>Definisi Jeritan Jiwa dalam Konteks Seni</h2>
            <p>Jeritan jiwa bukanlah sekadar ekspresi emosi negatif, melainkan manifestasi dari kedalaman pengalaman manusia. Dalam seni visual, jeritan jiwa dapat diwujudkan melalui berbagai elemen seperti warna, komposisi, tekstur, dan simbolisme.</p>
            
            <h2>Teknik Visualisasi Emosi</h2>
            <p>Seniman menggunakan berbagai teknik untuk menvisualisasikan jeritan jiwa:</p>
            <ul>
                <li><strong>Kontras Warna:</strong> Penggunaan warna-warna kontras untuk menciptakan ketegangan visual</li>
                <li><strong>Distorsi Bentuk:</strong> Memanipulasi bentuk untuk mengekspresikan ketidakstabilan emosi</li>
                <li><strong>Tekstur Kasar:</strong> Menciptakan permukaan yang tidak rata untuk menggambarkan pergolakan</li>
                <li><strong>Komposisi Asimetris:</strong> Menggunakan ketidakseimbangan untuk mencerminkan kekacauan internal</li>
            </ul>
            
            <h2>Dampak Psikologis pada Penikmat Seni</h2>
            <p>Karya seni yang berhasil mengekspresikan jeritan jiwa tidak hanya memberikan katarsis bagi penciptanya, tetapi juga mampu menciptakan resonansi emosional dengan penikmatnya. Hal ini terjadi karena pengalaman universal manusia dalam menghadapi penderitaan, keraguan, dan pencarian makna.</p>
            
            <p>Melalui seni visual, jeritan jiwa menjadi jembatan yang menghubungkan pengalaman individual dengan pengalaman kolektif manusia, menciptakan pemahaman dan empati yang mendalam.</p>
        `,
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
        content: `
            <p>Fotografi emosional adalah seni menangkap momen yang tidak hanya indah secara visual, tetapi juga mampu menyampaikan perasaan dan cerita yang mendalam. Teknik ini memerlukan pemahaman yang baik tentang komposisi, pencahayaan, dan timing.</p>
            
            <h2>Elemen Kunci dalam Fotografi Emosional</h2>
            <p>Untuk menciptakan foto yang bermuatan emosi, fotografer perlu memperhatikan beberapa elemen penting:</p>
            
            <h3>1. Pencahayaan yang Tepat</h3>
            <p>Cahaya adalah jiwa dari fotografi. Pencahayaan yang dramatis dapat menciptakan mood yang kuat, sementara cahaya lembut dapat menghasilkan perasaan tenang dan damai.</p>
            
            <h3>2. Komposisi yang Bercerita</h3>
            <p>Setiap elemen dalam frame harus memiliki tujuan. Gunakan rule of thirds, leading lines, dan framing untuk mengarahkan perhatian viewer ke subjek utama.</p>
            
            <h3>3. Momen yang Tepat</h3>
            <p>Timing adalah segalanya dalam fotografi emosional. Menangkap ekspresi spontan atau momen candid sering kali menghasilkan foto yang lebih autentik dan berkesan.</p>
            
            <h2>Teknik Praktis</h2>
            <ul>
                <li>Gunakan depth of field yang shallow untuk mengisolasi subjek</li>
                <li>Eksperimen dengan angle yang tidak biasa</li>
                <li>Manfaatkan refleksi dan bayangan untuk menambah dimensi</li>
                <li>Perhatikan background dan pastikan tidak mengganggu</li>
            </ul>
        `,
        author: 'Sarah Johnson',
        date: '2024-01-12',
        readTime: '7 min read',
        image: 'from-blue-500 to-cyan-600',
        category: 'Fotografi'
    },
    {
        id: 3,
        title: 'Perjalanan Spiritual Melalui Seni Lukis',
        excerpt: 'Bagaimana seni lukis dapat menjadi jembatan untuk memahami diri sendiri dan alam semesta. Sebuah refleksi mendalam tentang kreativitas dan spiritualitas.',
        content: `
            <p>Seni lukis telah menjadi bagian integral dari perjalanan spiritual manusia selama berabad-abad. Melalui goresan kuas dan permainan warna, kita dapat mengekspresikan hal-hal yang sulit diungkapkan dengan kata-kata.</p>
            
            <h2>Menemukan Diri Melalui Kanvas</h2>
            <p>Ketika kita berdiri di depan kanvas kosong, kita sebenarnya berdiri di depan cermin jiwa kita sendiri. Setiap goresan yang kita buat adalah refleksi dari perasaan, pemikiran, dan pengalaman yang tersimpan dalam diri kita.</p>
            
            <p>Proses melukis mengajarkan kita untuk:</p>
            <ul>
                <li>Melepaskan kontrol dan membiarkan intuisi memandu</li>
                <li>Menerima ketidaksempurnaan sebagai bagian dari keindahan</li>
                <li>Menemukan ketenangan dalam fokus dan konsentrasi</li>
                <li>Mengekspresikan emosi tanpa kata-kata</li>
            </ul>
            
            <h2>Warna sebagai Bahasa Jiwa</h2>
            <p>Setiap warna memiliki energi dan makna tersendiri. Biru dapat menenangkan jiwa yang gelisah, merah dapat membangkitkan semangat yang padam, dan hijau dapat memberikan kedamaian seperti alam.</p>
            
            <p>Dalam perjalanan spiritual melalui seni lukis, kita belajar untuk mendengarkan bahasa warna dan membiarkannya berbicara melalui karya kita.</p>
        `,
        author: 'Maya Sari',
        date: '2024-01-10',
        readTime: '8 min read',
        image: 'from-purple-600 to-blue-600',
        category: 'Spiritualitas'
    }
];

// Find current article
const currentArticle = computed(() => {
    const id = parseInt(articleId.value) || 1;
    return dummyArticles.find(article => article.id === id) || dummyArticles[0];
});

// Related articles (exclude current article)
const relatedArticles = computed(() => {
    return dummyArticles.filter(article => article.id !== articleId.value).slice(0, 3);
});
</script>

<template>
    <Head :title="`${currentArticle.title} - howlson Blog`" />

    <div class="min-h-screen bg-gray-100">
        <!-- Navigation Bar -->
        <nav class="border-b border-gray-100 bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex shrink-0 items-center">
                            <Link :href="route('dashboard')" class="block h-9 w-auto fill-current text-gray-800">
                                <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg" class="w-9 h-9">
                                    <path
                                        d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.72 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.155C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.39 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.9 81.495 305.8 81.125ZM144.2 227.205L100.57 202.515L146.39 176.135L196.66 147.195L240.33 172.335L208.29 190.625L144.2 227.205ZM244.75 114.995V164.795L226.39 154.225L201.03 139.625V89.825L219.39 100.395L244.75 114.995ZM249.12 57.105L292.81 82.265L249.12 107.425L205.43 82.265L249.12 57.105ZM114.49 184.425L96.13 194.995V85.305L121.49 70.705L139.85 60.135V169.815L114.49 184.425ZM91.76 27.925L135.45 53.085L91.76 78.245L48.07 53.085L91.76 27.925ZM202.49 213.655L144.2 252.125L85.91 213.655V81.875L144.2 43.405L202.49 81.875V213.655Z" />
                                </svg>
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <Link :href="route('dashboard')"
                                class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out hover:border-gray-300 hover:text-gray-700 focus:border-gray-300 focus:text-gray-700 focus:outline-none">
                                Dashboard
                            </Link>
                            <a href="#"
                                class="inline-flex items-center border-b-2 border-indigo-400 px-1 pt-1 text-sm font-medium leading-5 text-gray-900 transition duration-150 ease-in-out focus:border-indigo-700 focus:outline-none">
                                Blog
                            </a>
                        </div>
                    </div>

                    <div class="hidden sm:ms-6 sm:flex sm:items-center">
                        <!-- Settings Dropdown -->
                        <div class="relative ms-3 z-50">
                            <DropdownMenu>
                                <DropdownMenuTrigger :as-child="true">
                                    <Button
                                        variant="ghost"
                                        class="relative h-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary"
                                    >
                                        <div class="flex items-center gap-2 px-2">
                                            <Avatar class="size-8 overflow-hidden rounded-full">
                                                <AvatarImage v-if="user?.avatar" :src="user.avatar" :alt="user.name" />
                                                <AvatarFallback class="rounded-lg bg-neutral-200 font-semibold text-black">
                                                    {{ getInitials(user?.name) }}
                                                </AvatarFallback>
                                            </Avatar>
                                            <span class="text-sm font-medium text-gray-700">{{ user?.name }}</span>
                                            <svg class="-me-0.5 ms-1 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent align="end" class="w-56">
                                    <DropdownMenuLabel class="p-0 font-normal">
                                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                            <Avatar class="size-8 overflow-hidden rounded-full">
                                                <AvatarImage v-if="user?.avatar" :src="user.avatar" :alt="user.name" />
                                                <AvatarFallback class="rounded-lg bg-neutral-200 font-semibold text-black">
                                                    {{ getInitials(user?.name) }}
                                                </AvatarFallback>
                                            </Avatar>
                                            <div class="grid flex-1 text-left text-sm leading-tight">
                                                <span class="truncate font-semibold">{{ user?.name }}</span>
                                                <span class="truncate text-xs text-muted-foreground">{{ user?.email }}</span>
                                            </div>
                                        </div>
                                    </DropdownMenuLabel>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuGroup>
                                        <DropdownMenuItem :as-child="true">
                                            <Link class="block w-full" :href="route('profile.edit')" prefetch as="button">
                                                <Settings class="mr-2 h-4 w-4" />
                                                Settings
                                            </Link>
                                        </DropdownMenuItem>
                                    </DropdownMenuGroup>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem :as-child="true">
                                        <Link class="block w-full" method="post" :href="route('logout')" @click="handleLogout" as="button">
                                            <LogOut class="mr-2 h-4 w-4" />
                                            Log out
                                        </Link>
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="relative bg-white">
            <!-- Back Button -->
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                <Link :href="route('blog.index')" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                    <ArrowLeft class="w-4 h-4" />
                    <span>Kembali ke Blog</span>
                </Link>
            </div>

            <!-- Article Header -->
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <!-- Category Badge -->
                <div class="mb-4">
                    <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium">
                        {{ currentArticle.category }}
                    </span>
                </div>
                
                <!-- Title -->
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    {{ currentArticle.title }}
                </h1>
                
                <!-- Meta Information -->
                <div class="flex items-center gap-6 text-gray-600 mb-8">
                    <div class="flex items-center gap-2">
                        <User class="w-4 h-4" />
                        <span>{{ currentArticle.author }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <Calendar class="w-4 h-4" />
                        <span>{{ new Date(currentArticle.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <Clock class="w-4 h-4" />
                        <span>{{ currentArticle.readTime }}</span>
                    </div>
                </div>
                
                <!-- Social Actions -->
                <div class="flex items-center gap-4 mb-8 pb-8 border-b border-gray-200">
                    <button class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200">
                        <Heart class="w-4 h-4" />
                        <span>Suka</span>
                    </button>
                    <button class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200">
                        <MessageCircle class="w-4 h-4" />
                        <span>Komentar</span>
                    </button>
                    <button class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200">
                        <Share2 class="w-4 h-4" />
                        <span>Bagikan</span>
                    </button>
                </div>
            </div>

            <!-- Article Image -->
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
                <div :class="['bg-gradient-to-br', currentArticle.image, 'h-96 rounded-lg flex items-center justify-center']">
                    <div class="text-white text-center">
                        <h2 class="text-2xl font-bold mb-2">{{ currentArticle.title }}</h2>
                        <p class="text-white/80">{{ currentArticle.category }}</p>
                    </div>
                </div>
            </div>

            <!-- Article Content -->
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
                <div class="prose prose-lg max-w-none" v-html="currentArticle.content"></div>
            </div>
        </div>

        <!-- Related Articles -->
        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Artikel Terkait</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div v-for="article in relatedArticles" :key="article.id"
                        class="group bg-white rounded-lg shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200 overflow-hidden cursor-pointer"
                        @click="router.visit(`/blog/${article.id}`)">
                        
                        <!-- Article Image/Gradient -->
                        <div :class="['bg-gradient-to-br', article.image]"
                            class="h-48 w-full flex items-center justify-center relative">
                            <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-all duration-300"></div>
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium text-gray-700">
                                {{ article.category }}
                            </div>
                        </div>
                        
                        <!-- Article Content -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-indigo-600 transition-colors duration-300">
                                {{ article.title }}
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ article.excerpt }}
                            </p>
                            
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>{{ article.author }}</span>
                                <span>{{ article.readTime }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <Footer />
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prose {
    color: #374151;
    line-height: 1.75;
}

.prose h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #111827;
}

.prose h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    color: #111827;
}

.prose p {
    margin-bottom: 1.25rem;
}

.prose ul {
    margin: 1.25rem 0;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
}

.prose strong {
    font-weight: 600;
    color: #111827;
}
</style>
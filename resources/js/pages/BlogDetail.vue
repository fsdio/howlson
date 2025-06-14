<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { ArrowLeft, Calendar, Clock, User, Heart, Share2, Bookmark, Eye } from 'lucide-vue-next'
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue'

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

    <AuthenticatedLayout>
        <!-- Back to Blog Button -->
        <div class="mb-6">
            <Link :href="route('blog')" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors">
                <ArrowLeft class="w-4 h-4 mr-2" />
                Kembali ke Blog
            </Link>
        </div>

        <!-- Main Content -->
        <div class="relative bg-white">
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
    </AuthenticatedLayout>
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
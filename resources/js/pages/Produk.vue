<script setup>
import { ref, watch, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';

const searchQuery = ref('');
const selectedCategory = ref('');
const minPrice = ref('');
const maxPrice = ref('');
const sortBy = ref('name');

const products = ref([
  { id: 1, name: 'Smartphone Gaming Pro', description: 'Smartphone gaming dengan performa tinggi dan layar AMOLED 120Hz', price: 'Rp 8.500.000', priceValue: 8500000, category: 'Elektronik', image: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 2, name: 'Laptop Ultrabook Premium', description: 'Laptop tipis dan ringan dengan prosesor Intel Core i7 generasi terbaru', price: 'Rp 15.000.000', priceValue: 15000000, category: 'Elektronik', image: 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 3, name: 'Sepatu Sneakers Limited', description: 'Sepatu sneakers edisi terbatas dengan desain eksklusif dan nyaman', price: 'Rp 2.500.000', priceValue: 2500000, category: 'Fashion', image: 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 4, name: 'Kamera Mirrorless 4K', description: 'Kamera mirrorless dengan kemampuan video 4K dan autofocus cepat', price: 'Rp 12.000.000', priceValue: 12000000, category: 'Elektronik', image: 'https://images.unsplash.com/photo-1606983340126-99ab4feaa64a?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 5, name: 'Jam Tangan Smart Watch', description: 'Smartwatch dengan fitur kesehatan lengkap dan tahan air', price: 'Rp 3.500.000', priceValue: 3500000, category: 'Elektronik', image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 6, name: 'Tas Backpack Travel', description: 'Tas ransel travel dengan banyak kompartemen dan anti air', price: 'Rp 850.000', priceValue: 850000, category: 'Fashion', image: 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 7, name: 'Headphone Wireless Premium', description: 'Headphone nirkabel dengan noise cancelling dan kualitas audio Hi-Fi', price: 'Rp 4.200.000', priceValue: 4200000, category: 'Elektronik', image: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 8, name: 'Jaket Hoodie Premium', description: 'Jaket hoodie dengan bahan berkualitas tinggi dan desain modern', price: 'Rp 650.000', priceValue: 650000, category: 'Fashion', image: 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 9, name: 'Tablet Drawing Pro', description: 'Tablet untuk menggambar digital dengan stylus pressure sensitive', price: 'Rp 7.500.000', priceValue: 7500000, category: 'Elektronik', image: 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 10, name: 'Parfum Luxury Edition', description: 'Parfum mewah dengan aroma tahan lama dan kemasan eksklusif', price: 'Rp 1.200.000', priceValue: 1200000, category: 'Kecantikan', image: 'https://images.unsplash.com/photo-1541643600914-78b084683601?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 11, name: 'Keyboard Mechanical RGB', description: 'Keyboard mekanik gaming dengan lampu RGB dan switch premium', price: 'Rp 1.800.000', priceValue: 1800000, category: 'Elektronik', image: 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 12, name: 'Skincare Set Premium', description: 'Set perawatan kulit lengkap dengan bahan alami dan teruji dermatologi', price: 'Rp 950.000', priceValue: 950000, category: 'Kecantikan', image: 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 13, name: 'Drone Camera 4K', description: 'Drone dengan kamera 4K dan stabilizer gimbal untuk aerial photography', price: 'Rp 9.500.000', priceValue: 9500000, category: 'Elektronik', image: 'https://images.unsplash.com/photo-1473968512647-3e447244af8f?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 14, name: 'Celana Jeans Premium', description: 'Celana jeans dengan bahan denim berkualitas tinggi dan potongan modern', price: 'Rp 750.000', priceValue: 750000, category: 'Fashion', image: 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 15, name: 'Power Bank Fast Charge', description: 'Power bank kapasitas besar dengan teknologi fast charging dan wireless', price: 'Rp 450.000', priceValue: 450000, category: 'Elektronik', image: 'https://images.unsplash.com/photo-1609592806596-b7c5c6c4e8b5?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
  { id: 16, name: 'Makeup Palette Professional', description: 'Palette makeup profesional dengan 48 warna eyeshadow dan brush set', price: 'Rp 1.100.000', priceValue: 1100000, category: 'Kecantikan', image: 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400&h=300&fit=crop', tiktokLink: '#', shopeeLink: '#' },
]);

const filterActive = ref(false);
const selectedProduct = ref(null);
const showProductModal = ref(false);

// Get unique categories for filter dropdown
const categories = computed(() => {
  const uniqueCategories = [...new Set(products.value.map(product => product.category))];
  return uniqueCategories.sort();
});

// Computed property for filtered and sorted products
const filteredProducts = computed(() => {
  let filtered = products.value;

  // Filter by search query
  if (searchQuery.value.trim()) {
    const query = searchQuery.value.trim().toLowerCase();
    filtered = filtered.filter(product =>
      product.name.toLowerCase().includes(query) ||
      product.description.toLowerCase().includes(query)
    );
  }

  // Filter by category
  if (selectedCategory.value) {
    filtered = filtered.filter(product => product.category === selectedCategory.value);
  }

  // Filter by price range
  if (minPrice.value) {
    const min = parseInt(minPrice.value.replace(/\D/g, ''));
    filtered = filtered.filter(product => product.priceValue >= min);
  }

  if (maxPrice.value) {
    const max = parseInt(maxPrice.value.replace(/\D/g, ''));
    filtered = filtered.filter(product => product.priceValue <= max);
  }

  // Sort products
  filtered.sort((a, b) => {
    switch (sortBy.value) {
      case 'name':
        return a.name.localeCompare(b.name);
      case 'price-low':
        return a.priceValue - b.priceValue;
      case 'price-high':
        return b.priceValue - a.priceValue;
      case 'category':
        return a.category.localeCompare(b.category);
      default:
        return 0;
    }
  });

  return filtered;
});

function toggleFilter() {
  filterActive.value = !filterActive.value;
}

function clearFilters() {
  searchQuery.value = '';
  selectedCategory.value = '';
  minPrice.value = '';
  maxPrice.value = '';
  sortBy.value = 'name';
}

function openDetail(product) {
  selectedProduct.value = product;
  showProductModal.value = true;
}

function closeModal() {
  showProductModal.value = false;
  selectedProduct.value = null;
}
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Produk" />
    <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <!-- Search Bar -->
          <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 mb-4">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Cari produk berdasarkan nama atau deskripsi..."
              class="flex-grow rounded-lg px-4 py-2 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            />
            <div class="flex gap-2 sm:gap-3">
              <button
                @click="toggleFilter"
                :class="[
                  'flex-1 sm:flex-none px-3 sm:px-4 py-2 text-sm font-medium rounded-lg transition-colors whitespace-nowrap',
                  filterActive ? 'bg-indigo-700 text-white' : 'bg-indigo-600 text-white hover:bg-indigo-700'
                ]"
              >
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
          <div v-show="filterActive" class="bg-gray-50 rounded-lg p-4 mb-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
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

              <!-- Min Price Filter -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Minimum</label>
                <input
                  v-model="minPrice"
                  type="text"
                  placeholder="Contoh: 100000"
                  class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                />
              </div>

              <!-- Max Price Filter -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Maksimum</label>
                <input
                  v-model="maxPrice"
                  type="text"
                  placeholder="Contoh: 500000"
                  class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                />
              </div>

              <!-- Sort By -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan Berdasarkan</label>
                <select
                  v-model="sortBy"
                  class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
                  <option value="name">Nama (A-Z)</option>
                  <option value="price-low">Harga (Terendah)</option>
                  <option value="price-high">Harga (Tertinggi)</option>
                  <option value="category">Kategori</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Results Info -->
          <div class="mb-4">
            <p class="text-sm text-gray-600">
              Menampilkan {{ filteredProducts.length }} dari {{ products.length }} produk
            </p>
          </div>

          <!-- Product List -->
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-h-[600px] overflow-y-auto">
            <div
              v-for="product in filteredProducts"
              :key="product.id"
              class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-1 overflow-hidden"
              @click="openDetail(product)"
            >
              <div class="relative overflow-hidden">
                <img
                  :src="product.image"
                  :alt="product.name"
                  class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105"
                  loading="lazy"
                />
                <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm rounded-full px-2 py-1">
                  <span class="text-xs font-medium text-gray-700">{{ product.category }}</span>
                </div>
              </div>
              <div class="p-4">
                <h3 class="text-gray-900 font-bold text-lg mb-2 line-clamp-1">{{ product.name }}</h3>
                <p class="text-gray-600 text-sm mb-3 line-clamp-2 leading-relaxed">{{ product.description }}</p>
                <div class="flex items-center justify-between mb-3">
                  <p class="text-indigo-600 font-bold text-xl">{{ product.price }}</p>
                </div>
                <div class="flex space-x-2 w-full">
                  <a
                    :href="product.tiktokLink"
                    target="_blank"
                    class="flex-1 bg-gradient-to-r from-pink-500 to-red-500 hover:from-pink-600 hover:to-red-600 text-white rounded-lg px-3 py-2 text-xs font-medium text-center transition-all duration-200"
                    @click.stop
                  >
                    TikTok
                  </a>
                  <a
                    :href="product.shopeeLink"
                    target="_blank"
                    class="flex-1 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white rounded-lg px-3 py-2 text-xs font-medium text-center transition-all duration-200"
                    @click.stop
                  >
                    Shopee
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Product Detail Modal -->
          <div
            v-if="showProductModal && selectedProduct"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
            @click="closeModal"
          >
            <div
              class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
              @click.stop
            >
              <div class="relative">
                <img
                  :src="selectedProduct.image"
                  :alt="selectedProduct.name"
                  class="w-full h-64 md:h-80 object-cover rounded-t-2xl"
                />
                <button
                  @click="closeModal"
                  class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-full p-2 hover:bg-white transition-colors"
                >
                  <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>
              
              <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                  <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ selectedProduct.name }}</h2>
                    <span class="inline-block bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded-full">
                      {{ selectedProduct.category }}
                    </span>
                  </div>
                  <p class="text-3xl font-bold text-indigo-600">{{ selectedProduct.price }}</p>
                </div>
                
                <div class="mb-6">
                  <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi Produk</h3>
                  <p class="text-gray-600 leading-relaxed">{{ selectedProduct.description }}</p>
                </div>
                
                <div class="flex space-x-4">
                  <a
                    :href="selectedProduct.tiktokLink"
                    target="_blank"
                    class="flex-1 bg-gradient-to-r from-pink-500 to-red-500 hover:from-pink-600 hover:to-red-600 text-white rounded-xl px-6 py-3 font-medium text-center transition-all duration-200 transform hover:scale-105"
                  >
                    Lihat di TikTok
                  </a>
                  <a
                    :href="selectedProduct.shopeeLink"
                    target="_blank"
                    class="flex-1 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white rounded-xl px-6 py-3 font-medium text-center transition-all duration-200 transform hover:scale-105"
                  >
                    Beli di Shopee
                  </a>
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
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>

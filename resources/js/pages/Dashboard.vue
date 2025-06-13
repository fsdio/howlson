<script setup>
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Footer from '@/components/Footer.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { getInitials } from '@/composables/useInitials';
import { LogOut, Settings } from 'lucide-vue-next';

const page = usePage();
const user = computed(() => page.props.auth.user);
const isAdmin = computed(() => user.value?.roles?.some(role => role.name === 'admin') || false);

const handleLogout = () => {
    router.flushAll();
};

// Generate 20 dummy images with different colors and patterns
const dummyImages = [
    { id: 1, title: 'Sunset Landscape', color: 'from-orange-400 to-red-500', pattern: 'bg-gradient-to-br' },
    { id: 2, title: 'Ocean Waves', color: 'from-blue-400 to-cyan-500', pattern: 'bg-gradient-to-tr' },
    { id: 3, title: 'Forest Path', color: 'from-green-400 to-emerald-600', pattern: 'bg-gradient-to-bl' },
    { id: 4, title: 'Mountain Peak', color: 'from-gray-400 to-slate-600', pattern: 'bg-gradient-to-tl' },
    { id: 5, title: 'Desert Dunes', color: 'from-yellow-400 to-orange-500', pattern: 'bg-gradient-to-r' },
    { id: 6, title: 'Purple Sky', color: 'from-purple-400 to-pink-500', pattern: 'bg-gradient-to-l' },
    { id: 7, title: 'City Lights', color: 'from-indigo-400 to-blue-600', pattern: 'bg-gradient-to-br' },
    { id: 8, title: 'Autumn Leaves', color: 'from-red-400 to-yellow-500', pattern: 'bg-gradient-to-tr' },
    { id: 9, title: 'Coral Reef', color: 'from-teal-400 to-blue-500', pattern: 'bg-gradient-to-bl' },
    { id: 10, title: 'Snowy Hills', color: 'from-slate-300 to-blue-400', pattern: 'bg-gradient-to-tl' },
    { id: 11, title: 'Cherry Blossom', color: 'from-pink-300 to-rose-400', pattern: 'bg-gradient-to-r' },
    { id: 12, title: 'Tropical Beach', color: 'from-cyan-300 to-teal-500', pattern: 'bg-gradient-to-l' },
    { id: 13, title: 'Lavender Field', color: 'from-violet-400 to-purple-600', pattern: 'bg-gradient-to-br' },
    { id: 14, title: 'Golden Hour', color: 'from-amber-400 to-orange-600', pattern: 'bg-gradient-to-tr' },
    { id: 15, title: 'Misty Morning', color: 'from-gray-300 to-slate-500', pattern: 'bg-gradient-to-bl' },
    { id: 16, title: 'Northern Lights', color: 'from-green-300 to-blue-500', pattern: 'bg-gradient-to-tl' },
    { id: 17, title: 'Rose Garden', color: 'from-rose-400 to-pink-600', pattern: 'bg-gradient-to-r' },
    { id: 18, title: 'Starry Night', color: 'from-indigo-600 to-purple-800', pattern: 'bg-gradient-to-l' },
    { id: 19, title: 'Spring Meadow', color: 'from-lime-400 to-green-500', pattern: 'bg-gradient-to-br' },
    { id: 20, title: 'Fire Sunset', color: 'from-red-500 to-orange-700', pattern: 'bg-gradient-to-tr' }
];
</script>

<template>

    <Head title="Dashboard" />

    <div class="min-h-screen bg-gray-100">
        <!-- Navigation Bar using AuthenticatedLayout style -->
        <nav class="border-b border-gray-100 bg-white">
            <!-- Primary Navigation Menu -->
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex shrink-0 items-center">
                            <div class="block h-9 w-auto fill-current text-gray-800">
                                <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg" class="w-9 h-9">
                                    <path
                                        d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.72 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.485C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.39 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.9 81.495 305.8 81.125ZM144.2 227.205L100.57 202.515L146.39 176.135L196.66 147.195L240.33 172.335L208.29 190.625L144.2 227.205ZM244.75 114.995V164.795L226.39 154.225L201.03 139.625V89.825L219.39 100.395L244.75 114.995ZM249.12 57.105L292.81 82.265L249.12 107.425L205.43 82.265L249.12 57.105ZM114.49 184.425L96.13 194.995V85.305L121.49 70.705L139.85 60.135V169.815L114.49 184.425ZM91.76 27.925L135.45 53.085L91.76 78.245L48.07 53.085L91.76 27.925ZM202.49 213.655L144.2 252.125L85.91 213.655V81.875L144.2 43.405L202.49 81.875V213.655Z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <a href="#"
                                class="inline-flex items-center border-b-2 border-indigo-400 px-1 pt-1 text-sm font-medium leading-5 text-gray-900 transition duration-150 ease-in-out focus:border-indigo-700 focus:outline-none">
                                Dashboard
                            </a>

                            <!-- User Navigation -->
                            <template v-if="!isAdmin">
                                <Link :href="route('blog.index')"
                                    class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out hover:border-gray-300 hover:text-gray-700 focus:border-gray-300 focus:text-gray-700 focus:outline-none">
                                    Blog
                                </Link>
                                <Link :href="route('produk.index')"
                                    class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out hover:border-gray-300 hover:text-gray-700 focus:border-gray-300 focus:text-gray-700 focus:outline-none">
                                    Produk
                                </Link>
                            </template>

                            <!-- Admin Navigation -->
                            <template v-if="isAdmin">
                                <a href="#"
                                    class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out hover:border-gray-300 hover:text-gray-700 focus:border-gray-300 focus:text-gray-700 focus:outline-none">
                                    Roles
                                </a>
                                <a href="#"
                                    class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out hover:border-gray-300 hover:text-gray-700 focus:border-gray-300 focus:text-gray-700 focus:outline-none">
                                    Permissions
                                </a>
                                <Link :href="route('blog.index')"
                                    class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out hover:border-gray-300 hover:text-gray-700 focus:border-gray-300 focus:text-gray-700 focus:outline-none">
                                    Blog
                                </Link>
                            </template>
                        </div>
                    </div>

                    <div class="hidden sm:ms-6 sm:flex sm:items-center">
                        <!-- Settings Dropdown -->
                        <div class="relative ms-3 z-50">
                            <DropdownMenu>
                                <DropdownMenuTrigger :as-child="true">
                                    <Button variant="ghost"
                                        class="relative h-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary">
                                        <div class="flex items-center gap-2 px-2">
                                            <Avatar class="size-8 overflow-hidden rounded-full">
                                                <AvatarImage v-if="user?.avatar" :src="user.avatar" :alt="user.name" />
                                                <AvatarFallback
                                                    class="rounded-lg bg-neutral-200 font-semibold text-black">
                                                    {{ getInitials(user?.name) }}
                                                </AvatarFallback>
                                            </Avatar>
                                            <span class="text-sm font-medium text-gray-700">{{ user?.name }}</span>
                                            <svg class="-me-0.5 ms-1 h-4 w-4 text-gray-500"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor">
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
                                                <AvatarFallback
                                                    class="rounded-lg bg-neutral-200 font-semibold text-black">
                                                    {{ getInitials(user?.name) }}
                                                </AvatarFallback>
                                            </Avatar>
                                            <div class="grid flex-1 text-left text-sm leading-tight">
                                                <span class="truncate font-semibold">{{ user?.name }}</span>
                                                <span class="truncate text-xs text-muted-foreground">{{ user?.email
                                                    }}</span>
                                            </div>
                                        </div>
                                    </DropdownMenuLabel>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuGroup>
                                        <DropdownMenuItem :as-child="true">
                                            <Link class="block w-full" :href="route('profile.edit')" prefetch
                                                as="button">
                                            <Settings class="mr-2 h-4 w-4" />
                                            Settings
                                            </Link>
                                        </DropdownMenuItem>
                                    </DropdownMenuGroup>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem :as-child="true">
                                        <Link class="block w-full" method="post" :href="route('logout')"
                                            @click="handleLogout" as="button">
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
        <div class="relative">
            <!-- Hero Section -->
            <div class="relative bg-white py-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <div class="animate-fade-in-up">
                        <h1 class="text-6xl md:text-8xl font-bold text-gray-900 mb-4 tracking-tight">
                            howlson
                        </h1>
                        <p class="text-xl md:text-2xl text-gray-600 mb-8 italic">
                            "Jeritan Jiwa"
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-4 sm:px-6 lg:px-8 py-8">
                <div class="max-w-7xl mx-auto">

                    <!-- About Section -->
                    <div class="mb-16">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                            <h2 class="text-gray-900 text-3xl font-bold mb-6 text-center">
                                About howlson
                            </h2>
                            <p class="text-gray-600 text-lg leading-relaxed text-center max-w-4xl mx-auto">
                                howlson adalah sebuah perjalanan eksplorasi jiwa melalui seni visual dan narasi yang
                                mendalam.
                                Setiap karya merupakan jeritan jiwa yang dituangkan dalam bentuk kreativitas tanpa
                                batas,
                                menghadirkan pengalaman yang menyentuh hati dan merangsang pikiran.
                            </p>
                        </div>
                    </div>

                    <!-- Gallery Section -->
                    <div class="mb-16">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-6">
                            <div v-for="image in dummyImages" :key="image.id"
                                class="group relative overflow-hidden rounded-lg shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200">
                                <div :class="[image.pattern, image.color]"
                                    class="aspect-square w-full flex items-center justify-center relative">
                                    <!-- Overlay -->
                                    <div
                                        class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-all duration-300">
                                    </div>

                                    <!-- Content -->
                                    <div class="relative z-10 text-center p-4">
                                        <div
                                            class="text-white/90 text-xs mb-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                            #{{ image.id.toString().padStart(2, '0') }}
                                        </div>
                                        <h3
                                            class="text-white font-semibold text-sm mb-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                            {{ image.title }}
                                        </h3>
                                    </div>
                                </div>
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

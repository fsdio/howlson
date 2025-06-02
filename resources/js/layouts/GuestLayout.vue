<script setup>
import ApplicationLogo from '@/components/ApplicationLogo.vue';
import Footer from '@/components/Footer.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <div
            class="flex min-h-screen flex-col items-center pt-6 sm:justify-center sm:pt-0"
        >
            <div>
                <Link href="/">
                    <ApplicationLogo class="h-20 w-20 fill-current text-gray-500" />
                </Link>
            </div>

            <div
                class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
            >
                <slot />
            </div>
        </div>
        
        <!-- Footer -->
        <Footer />
    </div>
</template>

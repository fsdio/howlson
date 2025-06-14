<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import UniversalNavbar from '@/components/UniversalNavbar.vue';
import Footer from '@/components/Footer.vue';
import type { SharedData } from '@/types';

interface Props {
    variant?: 'default' | 'transparent' | 'minimal';
    showFooter?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    variant: 'default',
    showFooter: true,
});

const page = usePage<SharedData>();
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Universal Navigation Bar -->
        <UniversalNavbar :variant="variant" />
        
        <!-- Main Content Area -->
        <main class="flex-1">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>
        
        <!-- Footer -->
        <Footer v-if="showFooter" />
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import UniversalNavbar from '@/components/UniversalNavbar.vue';
import Footer from '@/components/Footer.vue';
import type { SharedData } from '@/types';

interface Props {
    variant?: 'default' | 'transparent' | 'minimal';
    showFooter?: boolean;
    containerClass?: string;
    contentClass?: string;
}

const props = withDefaults(defineProps<Props>(), {
    variant: 'default',
    showFooter: true,
    containerClass: '',
    contentClass: '',
});

const page = usePage<SharedData>();

// Dynamic container classes based on variant
const containerClasses = computed(() => {
    const baseClasses = 'min-h-screen bg-gray-50';
    const customClasses = props.containerClass;
    
    switch (props.variant) {
        case 'transparent':
            return `${baseClasses} bg-gradient-to-br from-blue-50 via-white to-purple-50 ${customClasses}`;
        case 'minimal':
            return `${baseClasses} bg-white ${customClasses}`;
        default:
            return `${baseClasses} ${customClasses}`;
    }
});

// Dynamic content classes
const contentClasses = computed(() => {
    const baseClasses = 'flex-1';
    const customClasses = props.contentClass;
    
    return `${baseClasses} ${customClasses}`;
});
</script>

<template>
    <div :class="containerClasses">
        <!-- Universal Navigation Bar -->
        <UniversalNavbar :variant="variant" />
        
        <!-- Main Content Area -->
        <main :class="contentClasses">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>
        
        <!-- Footer -->
        <Footer v-if="showFooter" />
    </div>
</template>

<style scoped>
/* Custom styles for enhanced visual appeal */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
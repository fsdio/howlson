<script setup>
import { ref } from 'vue';
import UniversalLayout from '@/layouts/UniversalLayout.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { useNavigation } from '@/composables/useNavigation';
import { Palette, Zap, Shield, Users, Settings, Star } from 'lucide-vue-next';

const { isAdmin, userRole, dynamicNavItems } = useNavigation();
const currentVariant = ref('default');

const variants = [
    { name: 'default', label: 'Default', description: 'Standard navbar with clean design' },
    { name: 'transparent', label: 'Transparent', description: 'Glassmorphism effect with backdrop blur' },
    { name: 'minimal', label: 'Minimal', description: 'Clean and minimal design' },
];

const features = [
    {
        icon: Shield,
        title: 'Role-Based Navigation',
        description: 'Automatically adapts navigation items based on user roles (Admin/User)',
        color: 'text-purple-600',
        bgColor: 'bg-purple-100',
    },
    {
        icon: Zap,
        title: 'Dynamic & Efficient',
        description: 'Single universal navbar component reduces code redundancy',
        color: 'text-blue-600',
        bgColor: 'bg-blue-100',
    },
    {
        icon: Palette,
        title: 'Multiple Variants',
        description: 'Choose from default, transparent, or minimal design variants',
        color: 'text-green-600',
        bgColor: 'bg-green-100',
    },
    {
        icon: Users,
        title: 'User Experience',
        description: 'Responsive design with mobile-friendly hamburger menu',
        color: 'text-orange-600',
        bgColor: 'bg-orange-100',
    },
    {
        icon: Settings,
        title: 'Highly Configurable',
        description: 'Customizable props for different use cases and layouts',
        color: 'text-indigo-600',
        bgColor: 'bg-indigo-100',
    },
    {
        icon: Star,
        title: 'Modern Design',
        description: 'Bold HOWLSON branding with gradient effects and smooth animations',
        color: 'text-pink-600',
        bgColor: 'bg-pink-100',
    },
];
</script>

<template>
    <UniversalLayout :variant="currentVariant">
        <div class="space-y-8">
            <!-- Header Section -->
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                    Universal Navbar
                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Demo
                    </span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-gray-600 max-w-3xl mx-auto">
                    Experience the power of our new universal navbar system. One component, multiple variants, 
                    role-based navigation, and enhanced user experience across your entire Laravel application.
                </p>
                
                <!-- Current User Info -->
                <div class="mt-6 flex justify-center">
                    <div class="flex items-center space-x-4">
                        <Badge 
                            :variant="isAdmin ? 'destructive' : 'default'"
                            class="text-sm px-3 py-1"
                        >
                            {{ isAdmin ? 'Admin User' : 'Regular User' }}
                        </Badge>
                        <span class="text-sm text-gray-500">
                            Role: {{ userRole }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Variant Selector -->
            <Card>
                <CardHeader>
                    <CardTitle class="flex items-center">
                        <Palette class="mr-2 h-5 w-5" />
                        Navbar Variants
                    </CardTitle>
                    <CardDescription>
                        Try different navbar variants to see how they look and feel
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div 
                            v-for="variant in variants" 
                            :key="variant.name"
                            class="cursor-pointer"
                            @click="currentVariant = variant.name"
                        >
                            <div 
                                :class="[
                                    'p-4 border-2 rounded-lg transition-all duration-200 hover:shadow-md',
                                    currentVariant === variant.name 
                                        ? 'border-blue-500 bg-blue-50' 
                                        : 'border-gray-200 hover:border-gray-300'
                                ]"
                            >
                                <h3 class="font-semibold text-lg mb-2">{{ variant.label }}</h3>
                                <p class="text-sm text-gray-600">{{ variant.description }}</p>
                                <div class="mt-2">
                                    <Badge 
                                        v-if="currentVariant === variant.name" 
                                        variant="default" 
                                        class="text-xs"
                                    >
                                        Active
                                    </Badge>
                                </div>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <Card v-for="feature in features" :key="feature.title" class="hover:shadow-lg transition-shadow duration-200">
                    <CardHeader>
                        <div class="flex items-center space-x-3">
                            <div :class="[feature.bgColor, 'p-2 rounded-lg']">
                                <component :is="feature.icon" :class="[feature.color, 'h-6 w-6']" />
                            </div>
                            <CardTitle class="text-lg">{{ feature.title }}</CardTitle>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <CardDescription class="text-sm leading-relaxed">
                            {{ feature.description }}
                        </CardDescription>
                    </CardContent>
                </Card>
            </div>

            <!-- Navigation Items Preview -->
            <Card>
                <CardHeader>
                    <CardTitle class="flex items-center">
                        <Users class="mr-2 h-5 w-5" />
                        Current Navigation Items
                    </CardTitle>
                    <CardDescription>
                        These are the navigation items available to your current user role
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div 
                            v-for="item in dynamicNavItems" 
                            :key="item.title"
                            class="flex items-center space-x-3 p-3 border rounded-lg hover:bg-gray-50 transition-colors duration-200"
                        >
                            <component 
                                v-if="item.icon" 
                                :is="item.icon" 
                                class="h-5 w-5 text-gray-600" 
                            />
                            <div>
                                <h4 class="font-medium text-sm">{{ item.title }}</h4>
                                <p class="text-xs text-gray-500">{{ item.href }}</p>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <!-- Implementation Guide -->
            <Card>
                <CardHeader>
                    <CardTitle>Implementation Guide</CardTitle>
                    <CardDescription>
                        How to use the Universal Navbar in your components
                    </CardDescription>
                </CardHeader>
                <CardContent class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Basic Usage:</h4>
                        <pre class="text-sm text-gray-700 overflow-x-auto"><code>&lt;script setup&gt;
import UniversalLayout from '@/layouts/UniversalLayout.vue';
&lt;/script&gt;

&lt;template&gt;
  &lt;UniversalLayout&gt;
    &lt;!-- Your page content --&gt;
  &lt;/UniversalLayout&gt;
&lt;/template&gt;</code></pre>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">With Variants:</h4>
                        <pre class="text-sm text-gray-700 overflow-x-auto"><code>&lt;UniversalLayout variant="transparent"&gt;
  &lt;!-- Content with transparent navbar --&gt;
&lt;/UniversalLayout&gt;

&lt;UniversalLayout variant="minimal"&gt;
  &lt;!-- Content with minimal navbar --&gt;
&lt;/UniversalLayout&gt;</code></pre>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Standalone Navbar:</h4>
                        <pre class="text-sm text-gray-700 overflow-x-auto"><code>&lt;script setup&gt;
import UniversalNavbar from '@/components/UniversalNavbar.vue';
&lt;/script&gt;

&lt;template&gt;
  &lt;UniversalNavbar 
    variant="transparent" 
    :show-logo="true" 
    :show-user-menu="true" 
  /&gt;
&lt;/template&gt;</code></pre>
                    </div>
                </CardContent>
            </Card>
        </div>
    </UniversalLayout>
</template>

<style scoped>
pre {
    white-space: pre-wrap;
    word-wrap: break-word;
}
</style>
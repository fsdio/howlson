<script setup lang="ts">
import { computed, ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { useNavigation } from '@/composables/useNavigation';
import ApplicationLogo from '@/components/ApplicationLogo.vue';
import Dropdown from '@/components/Dropdown.vue';
import DropdownLink from '@/components/DropdownLink.vue';
import NavLink from '@/components/NavLink.vue';
import ResponsiveNavLink from '@/components/ResponsiveNavLink.vue';
import { Menu, X, ChevronDown, LayoutGrid, User, LogOut } from 'lucide-vue-next';
import type { SharedData } from '@/types';

interface Props {
    variant?: 'default' | 'transparent' | 'minimal';
    showLogo?: boolean;
    showUserMenu?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    variant: 'default',
    showLogo: true,
    showUserMenu: true,
});

const showingNavigationDropdown = ref(false);
const page = usePage<SharedData>();
const { mainNavItems, adminNavItems, isAdmin } = useNavigation();

// Determine which navigation items to show based on user role
const navigationItems = computed(() => {
    return isAdmin.value ? adminNavItems : mainNavItems;
});

// Dynamic navbar classes based on variant
const navbarClasses = computed(() => {
    const baseClasses = 'border-b transition-all duration-300 ease-in-out';
    
    switch (props.variant) {
        case 'transparent':
            return `${baseClasses} bg-white/80 backdrop-blur-md border-gray-200/50`;
        case 'minimal':
            return `${baseClasses} bg-white border-gray-100 shadow-sm`;
        default:
            return `${baseClasses} bg-white border-gray-200 shadow-sm`;
    }
});

// Logo text styling
const logoTextClasses = 'text-2xl font-bold tracking-wide bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent hover:from-blue-700 hover:to-purple-700 transition-all duration-300';

// Check if current route matches navigation item
const isActiveRoute = (href: string) => {
    const currentRoute = route().current();
    const cleanHref = href.replace(/^\//, '').replace(/\//g, '.');
    const adminHref = 'admin.' + href.replace(/^\/admin\//, '').replace(/\//g, '.');
    
    return currentRoute === cleanHref || currentRoute === adminHref;
};
</script>

<template>
    <nav :class="navbarClasses">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <!-- Logo -->
                    <div v-if="showLogo" class="flex shrink-0 items-center">
                        <Link :href="route('dashboard')" class="flex items-center space-x-3 group">
                            <ApplicationLogo class="block h-10 w-auto fill-current text-gray-800 group-hover:text-blue-600 transition-colors duration-300" />
                            <span :class="logoTextClasses">HOWLSON</span>
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <NavLink
                            v-for="item in navigationItems"
                            :key="item.title"
                            :href="item.href"
                            :active="isActiveRoute(item.href)"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium transition-all duration-200 hover:scale-105"
                        >
                            <component 
                                v-if="item.icon" 
                                :is="item.icon" 
                                class="mr-2 h-4 w-4" 
                            />
                            {{ item.title }}
                        </NavLink>
                    </div>
                </div>

                <!-- User Menu -->
                <div v-if="showUserMenu" class="hidden sm:ms-6 sm:flex sm:items-center">
                    <!-- Role Badge -->
                    <div class="mr-4">
                        <span 
                            v-if="isAdmin" 
                            class="inline-flex items-center rounded-full bg-gradient-to-r from-purple-500 to-pink-500 px-3 py-1 text-xs font-medium text-white shadow-sm"
                        >
                            Admin
                        </span>
                        <span 
                            v-else 
                            class="inline-flex items-center rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 px-3 py-1 text-xs font-medium text-white shadow-sm"
                        >
                            User
                        </span>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="relative ms-3">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    >
                                        {{ page.props.auth.user.name }}
                                        <ChevronDown class="-me-0.5 ms-2 h-4 w-4" />
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink
                                    v-if="isAdmin"
                                    :href="route('admin.dashboard')"
                                    class="flex items-center"
                                >
                                    <LayoutGrid class="mr-2 h-4 w-4" />
                                    Admin Dashboard
                                </DropdownLink>
                                <DropdownLink
                                    v-if="isAdmin && !route().current('admin.*')"
                                    :href="route('dashboard')"
                                    class="flex items-center"
                                >
                                    <LayoutGrid class="mr-2 h-4 w-4" />
                                    User Dashboard
                                </DropdownLink>
                                <DropdownLink
                                    :href="route('profile.edit')"
                                    class="flex items-center"
                                >
                                    <User class="mr-2 h-4 w-4" />
                                    Profile
                                </DropdownLink>
                                <div class="border-t border-gray-100"></div>
                                <DropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="flex items-center text-red-600 hover:text-red-700 hover:bg-red-50"
                                >
                                    <LogOut class="mr-2 h-4 w-4" />
                                    Log Out
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        <Menu v-if="!showingNavigationDropdown" class="h-6 w-6" />
                        <X v-else class="h-6 w-6" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
            :class="{
                block: showingNavigationDropdown,
                hidden: !showingNavigationDropdown,
            }"
            class="sm:hidden"
        >
            <div class="space-y-1 pb-3 pt-2">
                <ResponsiveNavLink
                    v-for="item in navigationItems"
                    :key="item.title"
                    :href="item.href"
                    :active="isActiveRoute(item.href)"
                    class="flex items-center"
                >
                    <component 
                        v-if="item.icon" 
                        :is="item.icon" 
                        class="mr-3 h-4 w-4" 
                    />
                    {{ item.title }}
                </ResponsiveNavLink>
            </div>

            <!-- Responsive Settings Options -->
            <div v-if="showUserMenu" class="border-t border-gray-200 pb-1 pt-4">
                <div class="px-4">
                    <div class="text-base font-medium text-gray-800">
                        {{ page.props.auth.user.name }}
                    </div>
                    <div class="text-sm font-medium text-gray-500">
                        {{ page.props.auth.user.email }}
                    </div>
                    <div class="mt-2">
                        <span 
                            v-if="isAdmin" 
                            class="inline-flex items-center rounded-full bg-gradient-to-r from-purple-500 to-pink-500 px-2 py-1 text-xs font-medium text-white"
                        >
                            Admin
                        </span>
                        <span 
                            v-else 
                            class="inline-flex items-center rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 px-2 py-1 text-xs font-medium text-white"
                        >
                            User
                        </span>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <ResponsiveNavLink
                        v-if="isAdmin"
                        :href="route('admin.dashboard')"
                        class="flex items-center"
                    >
                        <LayoutGrid class="mr-3 h-4 w-4" />
                        Admin Dashboard
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        v-if="isAdmin && !route().current('admin.*')"
                        :href="route('dashboard')"
                        class="flex items-center"
                    >
                        <LayoutGrid class="mr-3 h-4 w-4" />
                        User Dashboard
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        :href="route('profile.edit')"
                        class="flex items-center"
                    >
                        <User class="mr-3 h-4 w-4" />
                        Profile
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="flex items-center text-red-600 hover:text-red-700"
                    >
                        <LogOut class="mr-3 h-4 w-4" />
                        Log Out
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>
/* Additional custom styles for enhanced visual appeal */
.nav-link-active {
    @apply border-b-2 border-blue-500 text-blue-600;
}

.nav-link-hover {
    @apply hover:border-b-2 hover:border-gray-300 hover:text-gray-700;
}
</style>
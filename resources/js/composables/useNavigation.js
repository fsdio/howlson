import { LayoutGrid, FileText, Package, Folder, BookOpen, Users, Shield, Settings, FolderTree } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

/**
 * Composable for centralized application navigation management
 * Ensures navigation consistency across the entire application
 * Supports role-based navigation with dynamic menu generation
 */
export function useNavigation() {
    const page = usePage();
    
    // Check if user is admin
    const isAdmin = computed(() => {
        const user = page.props.auth?.user;
        return user && user.roles && user.roles.some(role => role.name === 'admin');
    });
    
    // Get current user role
    const userRole = computed(() => {
        const user = page.props.auth?.user;
        if (!user || !user.roles || user.roles.length === 0) return 'guest';
        return user.roles[0].name;
    });
    
    // Check if user has specific permission
    const hasPermission = (permission) => {
        const user = page.props.auth?.user;
        if (!user || !user.permissions) return false;
        return user.permissions.some(perm => perm.name === permission);
    };

    // Main navigation items yang akan digunakan di sidebar dan header
    const mainNavItems = [
        {
            title: 'Dashboard',
            href: '/dashboard',
            icon: LayoutGrid,
        },
        {
            title: 'Blog',
            href: '/blog',
            icon: FileText,
        },
        {
            title: 'Produk',
            href: '/produk',
            icon: Package,
        },
    ];
    
    // Admin navigation items
    const adminNavItems = [
        {
            title: 'Admin Dashboard',
            href: '/admin/dashboard',
            icon: LayoutGrid,
        },
        {
            title: 'Role Management',
            href: '/admin/roles',
            icon: Users,
        },
        {
            title: 'Permission Management',
            href: '/admin/permissions',
            icon: Shield,
        },
        {
            title: 'Blog Management',
            href: '/admin/blogs',
            icon: FileText,
        },
        {
            title: 'Product Management',
            href: '/admin/products',
            icon: Package,
        },
        {
            title: 'Category Management',
            href: '/admin/product-categories',
            icon: FolderTree,
        },
    ];

    // Footer navigation items
    const footerNavItems = [
        {
            title: 'Github Repo',
            href: 'https://github.com/laravel/vue-starter-kit',
            icon: Folder,
        },
        {
            title: 'Documentation',
            href: 'https://laravel.com/docs/starter-kits#vue',
            icon: BookOpen,
        },
    ];

    // Right navigation items untuk header
    const rightNavItems = [
        {
            title: 'Repository',
            href: 'https://github.com/laravel/vue-starter-kit',
            icon: Folder,
        },
        {
            title: 'Documentation',
            href: 'https://laravel.com/docs/starter-kits#vue',
            icon: BookOpen,
        },
    ];

    // Dynamic navigation based on user role and permissions
    const dynamicNavItems = computed(() => {
        if (isAdmin.value) {
            return adminNavItems.filter(item => {
                // Add permission-based filtering here if needed
                return true;
            });
        }
        return mainNavItems;
    });
    
    // Get navigation items for current context
    const getNavigationItems = (context = 'main') => {
        switch (context) {
            case 'admin':
                return adminNavItems;
            case 'user':
            case 'main':
            default:
                return mainNavItems;
        }
    };

    return {
        mainNavItems,
        adminNavItems,
        footerNavItems,
        rightNavItems,
        dynamicNavItems,
        isAdmin,
        userRole,
        hasPermission,
        getNavigationItems,
    };
}
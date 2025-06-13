import { LayoutGrid, FileText, Package, Folder, BookOpen } from 'lucide-vue-next';

/**
 * Composable untuk mengelola navigasi aplikasi secara terpusat
 * Ini memastikan konsistensi navigasi di seluruh aplikasi
 */
export function useNavigation() {
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

    return {
        mainNavItems,
        footerNavItems,
        rightNavItems,
    };
}
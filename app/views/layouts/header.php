<?php
/**
 * Header Layout Component
 * N.A Fresh Fruits & Coconuts
 */
$cartData = CartService::getCart();
$cartCount = $cartData['count'];
$activePage = $activePage ?? 'home';
$storeName = Setting::get('store_name', 'N.A Fresh Fruits & Coconuts');
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-[#f8faf8]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?= e($pageTitle ?? 'Fresh Coconut Water - N.A Fresh Fruits & Coconuts') ?></title>
    <meta name="description" content="Pure, natural and refreshing fresh tender coconut water delivered straight from farm. No chemicals, no added sugar.">
    <meta property="og:title" content="<?= e($pageTitle ?? 'N.A Fresh Fruits & Coconuts') ?>">
    <meta property="og:description" content="Pure, natural and refreshing fresh tender coconut water.">
    <link rel="icon" href="/assets/images/product-main.png" type="image/png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0fdf4',
                            100: '#ebf5ed',
                            200: '#d1ead6',
                            300: '#a3d5ad',
                            400: '#529762',
                            500: '#2e7d32',
                            600: '#235d3a', // Primary reference green
                            700: '#1b4a2e',
                            800: '#173c26',
                            900: '#143220',
                        },
                        bgsoft: '#f8faf8',
                    },
                    fontFamily: {
                        serif: ['Playfair Display', 'Georgia', 'serif'],
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        /* Safe area support for mobile devices */
        .pb-safe {
            padding-bottom: env(safe-area-inset-bottom, 1rem);
        }
        .bottom-nav-spacer {
            height: 4.5rem;
        }
        @media (min-width: 768px) {
            .bottom-nav-spacer {
                display: none;
            }
        }
    </style>
</head>
<body class="min-h-full flex flex-col text-gray-800 antialiased bg-[#f8faf8] selection:bg-brand-100 selection:text-brand-700" x-data="{ mobileMenuOpen: false, searchOpen: false }">

<!-- Top Navigation Bar -->
<header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-20">
            
            <!-- Logo Section -->
            <a href="/" class="flex items-center gap-2.5 group">
                <!-- Palm Tree SVG Icon -->
                <div class="w-9 h-9 sm:w-10 sm:h-10 text-brand-600 flex items-center justify-center transition-transform group-hover:scale-105">
                    <svg viewBox="0 0 48 48" fill="none" class="w-full h-full" stroke="currentColor">
                        <path d="M24 44V26" stroke="#235d3a" stroke-width="3.5" stroke-linecap="round"/>
                        <path d="M24 26C16 26 8 20 8 10C16 10 22 17 24 26Z" fill="#235d3a" fill-opacity="0.2" stroke="#235d3a" stroke-width="2.5" stroke-linejoin="round"/>
                        <path d="M24 26C32 26 40 20 40 10C32 10 26 17 24 26Z" fill="#235d3a" fill-opacity="0.2" stroke="#235d3a" stroke-width="2.5" stroke-linejoin="round"/>
                        <path d="M24 26C24 16 19 8 10 6C15 15 20 22 24 26Z" stroke="#235d3a" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M24 26C24 16 29 8 38 6C33 15 28 22 24 26Z" stroke="#235d3a" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="24" cy="24" r="2.5" fill="#235d3a"/>
                        <circle cx="21" cy="27" r="2.5" fill="#235d3a"/>
                        <circle cx="27" cy="27" r="2.5" fill="#235d3a"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-xl sm:text-2xl tracking-tight text-gray-900 leading-none">N.A</span>
                    <span class="text-[10px] sm:text-xs font-medium text-gray-500 tracking-wide">Fresh Fruits & Coconuts</span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-medium">
                <a href="/" class="<?= $activePage === 'home' ? 'text-brand-600 font-semibold border-b-2 border-brand-600 pb-1' : 'text-gray-600 hover:text-brand-600 transition' ?>">
                    Home
                </a>
                <a href="/shop" class="<?= $activePage === 'shop' ? 'text-brand-600 font-semibold border-b-2 border-brand-600 pb-1' : 'text-gray-600 hover:text-brand-600 transition' ?>">
                    Shop
                </a>
                <a href="/track" class="<?= $activePage === 'track' ? 'text-brand-600 font-semibold border-b-2 border-brand-600 pb-1' : 'text-gray-600 hover:text-brand-600 transition' ?>">
                    My Orders
                </a>
                <a href="/#why-choose-us" class="text-gray-600 hover:text-brand-600 transition">
                    About
                </a>
                <a href="/#contact" class="text-gray-600 hover:text-brand-600 transition">
                    Contact
                </a>
            </nav>

            <!-- Right Icons (Search, Cart, Profile, Admin) -->
            <div class="flex items-center space-x-4 sm:space-x-5">
                <!-- Search Button -->
                <button type="button" @click="searchOpen = !searchOpen" class="text-gray-600 hover:text-brand-600 p-1.5 transition" aria-label="Search">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.3-4.3"></path>
                    </svg>
                </button>

                <!-- Cart Button with Counter Badge -->
                <a href="/cart" class="relative text-gray-600 hover:text-brand-600 p-1.5 transition" aria-label="Shopping Cart">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 0 0-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <?php if ($cartCount > 0): ?>
                    <span class="absolute -top-1 -right-1 bg-brand-600 text-white text-[10px] sm:text-xs font-bold rounded-full h-4 w-4 sm:h-5 sm:w-5 flex items-center justify-center shadow-xs">
                        <?= $cartCount ?>
                    </span>
                    <?php endif; ?>
                </a>

                <!-- Profile / Track Order Button -->
                <a href="/track" class="hidden sm:inline-flex text-gray-600 hover:text-brand-600 p-1.5 transition" aria-label="Order Tracking & Profile">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>

                <!-- Admin Link -->
                <a href="/admin" class="hidden lg:inline-flex items-center gap-1.5 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-brand-50 hover:text-brand-700 px-3 py-1.5 rounded-full border border-gray-200 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>Admin</span>
                </a>

                <!-- Mobile Hamburger Menu Button -->
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-700 hover:text-brand-600 p-1.5" aria-label="Toggle menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Inline Search Drawer -->
        <div x-show="searchOpen" x-cloak class="py-3 border-t border-gray-100">
            <form action="/shop" method="GET" class="flex gap-2">
                <input type="text" name="q" placeholder="Search fresh tender coconut water..." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                <button type="submit" class="bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-700">Search</button>
            </form>
        </div>
    </div>

    <!-- Mobile Slideover Drawer -->
    <div x-show="mobileMenuOpen" x-cloak class="md:hidden border-t border-gray-100 bg-white px-4 pt-3 pb-6 space-y-3 shadow-lg">
        <div class="flex justify-between items-center pb-2 border-b border-gray-100">
            <span class="text-xs uppercase font-semibold text-gray-400">Navigation</span>
            <button @click="mobileMenuOpen = false" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <a href="/" class="block text-base font-medium <?= $activePage === 'home' ? 'text-brand-600' : 'text-gray-700' ?>">Home</a>
        <a href="/shop" class="block text-base font-medium <?= $activePage === 'shop' ? 'text-brand-600' : 'text-gray-700' ?>">Shop Tender Coconut</a>
        <a href="/cart" class="block text-base font-medium <?= $activePage === 'cart' ? 'text-brand-600' : 'text-gray-700' ?>">Cart (<?= $cartCount ?>)</a>
        <a href="/track" class="block text-base font-medium <?= $activePage === 'track' ? 'text-brand-600' : 'text-gray-700' ?>">Track My Order</a>
        <a href="/#why-choose-us" @click="mobileMenuOpen = false" class="block text-base font-medium text-gray-700">Why Choose Us</a>
        <a href="/#contact" @click="mobileMenuOpen = false" class="block text-base font-medium text-gray-700">Store Hours & Contact</a>
        <div class="pt-3 border-t border-gray-100">
            <a href="/admin" class="flex items-center gap-2 text-sm font-semibold text-brand-700 bg-brand-50 p-2.5 rounded-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <span>Store Admin Portal</span>
            </a>
        </div>
    </div>
</header>

<!-- Flash notification banner -->
<?php $flash = get_flash(); if ($flash): ?>
<div class="max-w-4xl mx-auto px-4 mt-3">
    <div class="p-3.5 rounded-xl text-sm font-medium flex items-center gap-2.5 <?= $flash['type'] === 'error' ? 'bg-red-50 text-red-800 border border-red-200' : 'bg-emerald-50 text-emerald-800 border border-emerald-200' ?>">
        <?php if ($flash['type'] === 'error'): ?>
            <svg class="w-5 h-5 shrink-0 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <?php else: ?>
            <svg class="w-5 h-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <?php endif; ?>
        <span><?= e($flash['message']) ?></span>
    </div>
</div>
<?php endif; ?>

<!-- Main Content Area -->
<main class="flex-grow">

<?php
/**
 * Admin Panel Header Layout
 * N.A Fresh Fruits & Coconuts
 */
$adminUser = AuthService::user();
$activeAdminTab = $activeAdminTab ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($adminTitle ?? 'Admin Dashboard - N.A Fresh Fruits & Coconuts') ?></title>
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
                            500: '#2e7d32',
                            600: '#235d3a',
                            700: '#1b4a2e',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Chart.js for Reports -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="min-h-full flex flex-col text-gray-800 antialiased" x-data="{ sidebarOpen: false }">

<!-- Top Admin Header -->
<header class="bg-brand-700 text-white shadow-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <div class="flex items-center gap-3">
                <a href="/" class="flex items-center gap-2 group" title="Visit Storefront">
                    <span class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center font-bold text-white text-sm">NA</span>
                    <span class="font-bold text-lg tracking-tight">N.A Admin</span>
                </a>
                <span class="hidden sm:inline-block text-xs bg-white/20 text-white/90 px-2.5 py-0.5 rounded-full">Store Manager</span>
            </div>

            <!-- Admin Nav Links (Desktop) -->
            <nav class="hidden md:flex items-center space-x-1 text-sm font-medium">
                <a href="/admin" class="px-3 py-1.5 rounded-lg <?= $activeAdminTab === 'dashboard' ? 'bg-white/20 text-white font-bold' : 'text-white/80 hover:bg-white/10 hover:text-white' ?>">
                    Dashboard
                </a>
                <a href="/admin/orders" class="px-3 py-1.5 rounded-lg <?= $activeAdminTab === 'orders' ? 'bg-white/20 text-white font-bold' : 'text-white/80 hover:bg-white/10 hover:text-white' ?>">
                    Orders
                </a>
                <a href="/admin/products" class="px-3 py-1.5 rounded-lg <?= $activeAdminTab === 'products' ? 'bg-white/20 text-white font-bold' : 'text-white/80 hover:bg-white/10 hover:text-white' ?>">
                    Products & Stock
                </a>
                <a href="/admin/settings" class="px-3 py-1.5 rounded-lg <?= $activeAdminTab === 'settings' ? 'bg-white/20 text-white font-bold' : 'text-white/80 hover:bg-white/10 hover:text-white' ?>">
                    Delivery Settings
                </a>
                <a href="/admin/reports" class="px-3 py-1.5 rounded-lg <?= $activeAdminTab === 'reports' ? 'bg-white/20 text-white font-bold' : 'text-white/80 hover:bg-white/10 hover:text-white' ?>">
                    Sales Reports
                </a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="/" target="_blank" class="text-xs bg-white/10 hover:bg-white/20 text-white px-2.5 py-1.5 rounded-lg transition inline-flex items-center gap-1">
                    <span>Live Store</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
                <form action="/admin/logout" method="POST" class="inline">
                    <input type="hidden" name="<?= CSRF_TOKEN_KEY ?>" value="<?= csrf_token() ?>">
                    <button type="submit" class="text-xs text-red-200 hover:text-white hover:bg-red-900/40 px-2.5 py-1.5 rounded-lg transition">
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</header>

<!-- Mobile Sub-Navigation -->
<div class="md:hidden bg-brand-800 text-white px-4 py-2 flex items-center justify-between text-xs font-medium overflow-x-auto gap-3">
    <a href="/admin" class="<?= $activeAdminTab === 'dashboard' ? 'text-white font-bold underline' : 'text-white/80' ?>">Dashboard</a>
    <a href="/admin/orders" class="<?= $activeAdminTab === 'orders' ? 'text-white font-bold underline' : 'text-white/80' ?>">Orders</a>
    <a href="/admin/products" class="<?= $activeAdminTab === 'products' ? 'text-white font-bold underline' : 'text-white/80' ?>">Products</a>
    <a href="/admin/settings" class="<?= $activeAdminTab === 'settings' ? 'text-white font-bold underline' : 'text-white/80' ?>">Settings</a>
    <a href="/admin/reports" class="<?= $activeAdminTab === 'reports' ? 'text-white font-bold underline' : 'text-white/80' ?>">Reports</a>
</div>

<!-- Flash message inside admin -->
<?php $flash = get_flash(); if ($flash): ?>
<div class="max-w-7xl mx-auto px-4 mt-4">
    <div class="p-3.5 rounded-xl text-sm font-medium <?= $flash['type'] === 'error' ? 'bg-red-50 text-red-800 border border-red-200' : 'bg-emerald-50 text-emerald-800 border border-emerald-200' ?>">
        <?= e($flash['message']) ?>
    </div>
</div>
<?php endif; ?>

<main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 w-full">

<<?php
// product_list.php
$dataFile = 'data/products.json';
$products = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Catalog | Peak Lineup</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #0f172a; }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="index.html" class="flex items-center gap-2 group">
                <span class="text-2xl font-extrabold tracking-tight text-gray-900 group-hover:text-blue-600 transition-colors uppercase">
                    PEAK LINEUP
                </span>
            </a>

            <!-- Desktop Nav Tabs -->
            <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                <a href="index.html" class="px-4 py-2 rounded-full text-sm font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-all">Filming</a>
                <a href="product_list.php" class="px-4 py-2 rounded-full text-sm font-semibold bg-gray-900 text-white transition-all shadow-sm">Store</a>
                <a href="#" class="px-4 py-2 rounded-full text-sm font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-all">Upload</a>
                <a href="#" class="px-4 py-2 rounded-full text-sm font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-all">Rankings</a>
                <a href="#" class="px-4 py-2 rounded-full text-sm font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-all">Account</a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="cart.php" class="relative p-2.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-900 transition-colors">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="p-2 text-gray-600 hover:text-gray-900 focus:outline-none">
                        <i class="fa-solid fa-bars text-xl" id="menu-icon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden border-b border-gray-100 bg-white px-4 pt-2 pb-4 space-y-2">
            <a href="index.html" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-gray-600 hover:bg-gray-100">Filming</a>
            <a href="product_list.php" class="block px-4 py-2.5 rounded-xl text-base font-semibold bg-gray-900 text-white">Store</a>
            <a href="#" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-gray-600 hover:bg-gray-100">Upload</a>
            <a href="#" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-gray-600 hover:bg-gray-100">Rankings</a>
            <a href="#" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-gray-600 hover:bg-gray-100">Account</a>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-20 flex-grow w-full">
        <div class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                Surf Equipment & Pro Gear
            </h1>
            <p class="text-gray-500 text-sm sm:text-base mt-2">
                Explore our curated selection of high-performance longboards, fins, travel accessories, and drone session packages.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (empty($products)): ?>
                <p class="col-span-full text-center text-gray-500 py-12">No products available at the moment.</p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div>
                            <?php if (!empty($product['image'])): ?>
                                <div class="w-full h-48 bg-gray-100 overflow-hidden">
                                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover">
                                </div>
                            <?php endif; ?>
                            <div class="p-6">
                                <h3 class="font-bold text-lg text-gray-900 mb-1"><?= htmlspecialchars($product['name']) ?></h3>
                                <p class="text-blue-600 font-extrabold text-xl mb-3">$<?= number_format($product['price'], 2) ?></p>
                                <p class="text-gray-500 text-sm line-clamp-2"><?= htmlspecialchars($product['description'] ?? '') ?></p>
                            </div>
                        </div>
                        <div class="p-6 pt-0">
                            <a href="product_item.php?id=<?= htmlspecialchars($product['id']) ?>" class="w-full py-3 rounded-xl bg-gray-900 hover:bg-blue-600 text-white font-semibold text-sm transition-all flex items-center justify-center gap-2">
                                <span>View Details</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-500 font-medium">&copy; 2026 PEAK LINEUP. All rights reserved.</p>
            <div class="flex items-center space-x-6 text-xs text-gray-400">
                <a href="#" class="hover:text-gray-600 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-gray-600 transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-gray-600 transition-colors">Contact Support</a>
            </div>
        </div>
    </footer>

    <script>
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
        }
    </script>
</body>
</html>
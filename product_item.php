<?php
// product_item.php
$id = $_GET['id'] ?? null;
$dataFile = 'data/products.json';
$products = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

$product = null;
foreach ($products as $p) {
    if ($p['id'] === $id) {
        $product = $p;
        break;
    }
}

if (!$product) {
    http_response_code(404);
    echo "Product not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> | Peak Lineup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #0f172a; }
        .select-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #cbd5e1;
            background-color: #ffffff;
            font-size: 0.95rem;
            color: #1e293b;
        }
        .select-input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15); }
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
            <div class="flex items-center gap-4">
                <a href="cart.php" class="relative p-2.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-900 transition-colors">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-20 flex-grow w-full">
        
        <div class="mb-6">
            <a href="product_list.php" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i> Back to Catalog
            </a>
        </div>

        <div class="bg-white rounded-2xl p-6 sm:p-10 border border-gray-200 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <?php if (!empty($product['image'])): ?>
                <div class="w-full h-80 bg-gray-100 rounded-xl overflow-hidden border border-gray-100">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover">
                </div>
            <?php endif; ?>

            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mb-3"><?= htmlspecialchars($product['name']) ?></h1>
                <p class="text-3xl font-extrabold text-blue-600 mb-4">$<?= number_format($product['price'], 2) ?></p>
                <p class="text-gray-600 text-base mb-6 leading-relaxed"><?= htmlspecialchars($product['description'] ?? 'No description available.') ?></p>
                
                <form action="cart.php" method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
                    
                    <div>
                        <label for="quantity" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Quantity</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" class="select-input">
                    </div>

                    <button type="submit" class="w-full py-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-base transition-all shadow-md hover:shadow-lg active:scale-[0.99] flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cart-plus text-sm"></i>
                        <span>Add to Cart</span>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-500 font-medium">&copy; 2026 PEAK LINEUP. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
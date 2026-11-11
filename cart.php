<?php
// cart.php
session_start();

$dataFile = 'data/products.json';
$products = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';
    $quantity = intval($_POST['quantity'] ?? 1);

    if ($action === 'add' && $id) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] += $quantity;
        } else {
            $_SESSION['cart'][$id] = $quantity;
        }
    } elseif ($action === 'update' && $id) {
        if ($quantity > 0) {
            $_SESSION['cart'][$id] = $quantity;
        } else {
            unset($_SESSION['cart'][$id]);
        }
    } elseif ($action === 'remove' && $id) {
        unset($_SESSION['cart'][$id]);
    }
    
    header('Location: cart.php');
    exit;
}

$cartItems = [];
$total = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    foreach ($products as $p) {
        if ($p['id'] === $id) {
            $subtotal = $p['price'] * $qty;
            $total += $subtotal;
            $cartItems[] = [
                'product' => $p,
                'quantity' => $qty,
                'subtotal' => $subtotal
            ];
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | Peak Lineup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            <div class="flex items-center gap-4">
                <a href="product_list.php" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors">Continue Shopping</a>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-20 flex-grow w-full">
        <div class="mb-6">
            <a href="product_list.php" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i> Back to Store
            </a>
        </div>

        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-8">Shopping Cart</h1>

        <?php if (empty($cartItems)): ?>
            <div class="bg-white rounded-2xl p-12 border border-gray-200 shadow-sm text-center">
                <i class="fa-solid fa-cart-shopping text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg mb-6">Your cart is currently empty.</p>
                <a href="product_list.php" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm transition-all shadow-md">
                    Browse Catalog
                </a>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8">
                <div class="divide-y divide-gray-100">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-4 w-full sm:w-auto">
                                <?php if (!empty($item['product']['image'])): ?>
                                    <img src="<?= htmlspecialchars($item['product']['image']) ?>" alt="" class="w-16 h-16 object-cover rounded-xl border border-gray-100 flex-shrink-0">
                                <?php endif; ?>
                                <div>
                                    <h3 class="font-bold text-gray-900"><?= htmlspecialchars($item['product']['name']) ?></h3>
                                    <p class="text-sm text-gray-500">$<?= number_format($item['product']['price'], 2) ?> each</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                                <form action="cart.php" method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($item['product']['id']) ?>">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="w-16 px-3 py-1.5 rounded-lg border border-gray-300 text-center text-sm font-semibold">
                                    <button type="submit" class="text-xs font-semibold text-blue-600 hover:underline">Update</button>
                                </form>

                                <span class="font-bold text-gray-900 w-24 text-right">$<?= number_format($item['subtotal'], 2) ?></span>

                                <form action="cart.php" method="POST">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($item['product']['id']) ?>">
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                                        <i class="fa-solid fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Amount</p>
                    <p class="text-3xl font-extrabold text-gray-900">$<?= number_format($total, 2) ?></p>
                </div>
                <a href="checkout.html" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-base transition-all shadow-md text-center">
                    Proceed to Checkout
                </a>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-500 font-medium">&copy; 2026 PEAK LINEUP. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
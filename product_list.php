<?php
// product_list.php
$dataFile = 'data/products.json';
$products = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Peak Lineup - Product Catalog</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Peak Lineup Store</h1>
        <a href="cart.php">View Cart</a>
    </header>
    <main>
        <h2>Available Surf Assets & Gear</h2>
        <div class="product-grid">
            <?php if (empty($products)): ?>
                <p>No products available at the moment.</p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p>$<?= number_format($product['price'], 2) ?></p>
                        <a href="product_item.php?id=<?= htmlspecialchars($product['id']) ?>">View Details</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
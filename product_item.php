<?php
// product_item.php
// Individual item page 

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
    <title><= htmlspecialchars($product['name']) ?> - Peak Lineup</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <a href="product_list.php">&larr; Back to Catalog</a>
        <a href="cart.php">View Cart</a>
    </header>
    <main>
        <div class="product-detail">
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            <p class="price">$<?= number_format($product['price'], 2) ?></p>
            <p><%= htmlspecialchars($product['description'] ?? 'No description available.') ?></p>
            
            <form action="cart.php" method="POST">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1">
                <button type="submit">Add to Cart</button>
            </form>
        </div>
    </main>
</body>
</html>
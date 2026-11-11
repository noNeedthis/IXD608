<?php
// cart.php
// Manages shopping cart

session_start();

$dataFile = 'data/products.json';
$products = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// form submissions
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

// cart display list
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
    <title>Your Cart - Peak Lineup</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <a href="product_list.php">&larr; Continue Shopping</a>
    </header>
    <main>
        <h1>Shopping Cart</h1>
        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['product']['name']) ?></td>
                            <td>$<?= number_format($item['product']['price'], 2) ?></td>
                            <td>
                                <form action="cart.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($item['product']['id']) ?>">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" style="width: 50px;">
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                            <td>$<?= number_format($item['subtotal'], 2) ?></td>
                            <td>
                                <form action="cart.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($item['product']['id']) ?>">
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Total: $<?= number_format($total, 2) ?></h3>
        <?php endif; ?>
    </main>
</body>
</html>
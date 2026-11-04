<?php
// Product data array 12 products
$products = [
    ["id" => 1, "name" => "singlefin98", "category" => "Boards", "price" => 1200.00, "description" => "Classic 9'8 single fin noserider surfboard."],
    ["id" => 2, "name" => "noserider96", "category" => "Boards", "price" => 1150.00, "description" => "9'6 performance noserider built for tip time."],
    ["id" => 3, "name" => "flexfin10", "category" => "Fins", "price" => 95.00, "description" => "10.5-inch flex single fin template."],
    ["id" => 4, "name" => "travelbag2board", "category" => "Accessories", "price" => 210.00, "description" => "Custom padded travel bag designed for two boards."],
    ["id" => 5, "name" => "leash9ft", "category" => "Accessories", "price" => 36.00, "description" => "9ft heavy duty ankle surf leash."],
    ["id" => 6, "name" => "boardwaxcold", "category" => "Accessories", "price" => 4.50, "description" => "Cold water sticky surf wax bar."],
    ["id" => 7, "name" => "boardwaxwarm", "category" => "Accessories", "price" => 4.50, "description" => "Warm water tropical surf wax bar."],
    ["id" => 8, "name" => "deckpadtail", "category" => "Accessories", "price" => 38.00, "description" => "High-traction foam tail deck pad."],
    ["id" => 9, "name" => "dronefilmingpack", "category" => "Media", "price" => 450.00, "description" => "Single session ocean drone videography package."],
    ["id" => 10, "name" => "surfphotopack", "category" => "Media", "price" => 250.00, "description" => "HD digital photo package for ocean sessions."],
    ["id" => 11, "name" => "rashguardl", "category" => "Apparel", "price" => 48.00, "description" => "UPF 50+ quick-dry long sleeve rashguard."],
    ["id" => 12, "name" => "sunscreenzinc", "category" => "Accessories", "price" => 18.00, "description" => "Mineral ocean-safe SPF 50 sunscreen stick."]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peak Lineup - Products Admin</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background: #fff;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eaeaea;
        }
        .logo {
            font-weight: 900;
            font-size: 20px;
            letter-spacing: 1px;
            text-decoration: none;
            color: #000;
        }
        nav a {
            margin-left: 20px;
            text-decoration: none;
            color: #555;
            font-weight: 500;
        }
        nav a:hover {
            color: #2563eb;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .card {
            background: #fff;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: 1px solid #eee;
        }
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
        }
        .subtitle {
            color: #777;
            font-size: 14px;
            margin-top: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }
        th {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #888;
            text-transform: uppercase;
        }
        .code-name {
            font-family: monospace;
            background: #f1f5f9;
            color: #0f172a;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 13px;
        }
        .badge {
            font-size: 12px;
            padding: 4px 10px;
            background: #f1f5f9;
            color: #475569;
            border-radius: 20px;
        }
    </style>
</head>
<body>

<header>
    <a href="users.php" class="logo">PEAK LINEUP</a>
    <nav>
        <a href="users.php">User List</a>
        <a href="products.php" style="color: #2563eb; font-weight:700;">Products</a>
    </nav>
</header>

<div class="container">
    <div class="card">
        <div class="header-row">
            <div>
                <h1>Products Catalog</h1>
                <div class="subtitle"></div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><span class="code-name"><?= htmlspecialchars($p['name']) ?></span></td>
                        <td><span class="badge"><?= htmlspecialchars($p['category']) ?></span></td>
                        <td>$<?= number_format($p['price'], 2) ?></td>
                        <td><?= htmlspecialchars($p['description']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
<?php
// Enable error reporting during setup
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Path to JSON relative from admin/
$json_path = '../data/users.json';

// Load JSON data
$users = [];
if (file_exists($json_path)) {
    $json_data = file_get_contents($json_path);
    $users = json_decode($json_data, true) ?? [];
}

// Check if a specific user ID is passed in the URL 
$selected_id = isset($_GET['id']) && $_GET['id'] !== '' ? $_GET['id'] : null;
$selected_user = null;

if ($selected_id !== null) {
    foreach ($users as $u) {
        if ($u['id'] == $selected_id) {
            $selected_user = $u;
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
    <title>Peak Lineup - User Admin</title>
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
        .container {
            max-width: 650px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }
        .card {
            background: #fff;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: 1px solid #eee;
        }
        h1 {
            margin-top: 0;
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 5px;
        }
        .subtitle {
            color: #777;
            font-size: 14px;
            margin-bottom: 25px;
        }
        
        /* List Styles */
        .user-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .user-item {
            border-bottom: 1px solid #f0f0f0;
        }
        .user-item:last-child {
            border-bottom: none;
        }
        .user-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 8px;
            text-decoration: none;
            color: #111;
            font-weight: 600;
            font-size: 16px;
            transition: background 0.2s;
            border-radius: 8px;
        }
        .user-link:hover {
            background: #f4f6f8;
            color: #2563eb;
        }
        .badge {
            font-size: 12px;
            font-weight: 500;
            padding: 4px 10px;
            background: #f1f5f9;
            color: #475569;
            border-radius: 20px;
        }

        /* Form Styles */
        label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #888;
            margin-top: 15px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 15px;
            box-sizing: border-box;
            background: #fcfcfc;
        }
        .row {
            display: flex;
            gap: 15px;
        }
        .row > div {
            flex: 1;
        }
        .btn-submit {
            width: 100%;
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 14px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            margin-top: 25px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>

<header>
    <a href="users.php" class="logo">PEAK LINEUP</a>
    <nav>
        <a href="users.php">User List</a>
    </nav>
</header>

<div class="container">

    <?php if ($selected_user): ?>
        <!-- VIEW 1: USER ACCOUNT EDITOR -->
        <a href="users.php" class="back-link">&larr; Back to User List</a>

        <div class="card">
            <h1>User Account Editor</h1>
            <div class="subtitle"></div>

            <form method="POST" action="users.php">
                <input type="hidden" name="id" value="<?= htmlspecialchars($selected_user['id']) ?>">

                <label>NAME</label>
                <input type="text" name="name" value="<?= htmlspecialchars($selected_user['name']) ?>">

                <div class="row">
                    <div>
                        <label>TYPE</label>
                        <input type="text" name="type" value="<?= htmlspecialchars($selected_user['type']) ?>">
                    </div>
                    <div>
                        <label>CLASSES</label>
                        <input type="text" name="classes" value="<?= htmlspecialchars(is_array($selected_user['classes']) ? implode(', ', $selected_user['classes']) : $selected_user['classes']) ?>">
                    </div>
                </div>

                <label>EMAIL</label>
                <input type="email" name="email" value="<?= htmlspecialchars($selected_user['email']) ?>">

                <button type="submit" class="btn-submit">Save Changes to JSON</button>
            </form>
        </div>

    <?php else: ?>
        <!-- VIEW 2: USER LIST -->
        <div class="card">
            <h1>User List</h1>
            <div class="subtitle"></div>

            <ul class="user-list">
                <?php foreach ($users as $user): ?>
                    <li class="user-item">
                        <a href="users.php?id=<?= $user['id'] ?>" class="user-link">
                            <span><?= htmlspecialchars($user['name']) ?></span>
                            <span class="badge"><?= htmlspecialchars($user['type'] ?? 'User') ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
</body>
</html>
<?php
// Path from admin/ folder to data/ folder
$json_path = '../data/users.json';

// Read existing JSON data
$users = [];
if (file_exists($json_path)) {
    $json_data = file_get_contents($json_path);
    $users = json_decode($json_data, true) ?? [];
}

// Check if an ID was selected from the list 
$selected_id = $_GET['id'] ?? null;
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
    <title>User Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #666;
            color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
        }
        header a {
            color: #fff;
            text-decoration: none;
        }
        .card {
            background-color: #fff;
            max-width: 700px;
            margin: 40px auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }
        h1 {
            font-family: serif;
            margin-top: 0;
            font-size: 28px;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        li {
            margin: 12px 0;
        }
        li a {
            color: #000;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
        }
        li a:hover {
            color: #0066cc;
            text-decoration: underline;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #666;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <div>User Admin</div>
    <div><a href="users.php">User List</a></div>
</header>

<div class="card">
    <?php if ($selected_user): ?>
        <!-- EDIT FORM VIEW -->
        <h1>Edit User: <?= htmlspecialchars($selected_user['name']) ?></h1>
        
        <form method="POST" action="users.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($selected_user['id']) ?>">

            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($selected_user['name']) ?>">

            <label>Type</label>
            <input type="text" name="type" value="<?= htmlspecialchars($selected_user['type']) ?>">

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($selected_user['email']) ?>">

            <label>Classes</label>
            <input type="text" name="classes" value="<?= htmlspecialchars(is_array($selected_user['classes']) ? implode(', ', $selected_user['classes']) : $selected_user['classes']) ?>">

            <a class="back-link" href="users.php">&larr; Back to User List</a>
        </form>

    <?php else: ?>
        <!-- USER LIST VIEW -->
        <h1>User List</h1>
        <ul>
            <?php foreach ($users as $user): ?>
                <li>
                    <a href="users.php?id=<?= $user['id'] ?>">
                        <?= htmlspecialchars($user['name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

</body>
</html>
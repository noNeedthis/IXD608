<?php
// 1. Path to JSON file
$jsonFilePath = 'data/users.json';

// 2. Handle form submission (saving updated JSON data)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (file_exists($jsonFilePath)) {
        $jsonContent = file_get_contents($jsonFilePath);
        $usersData = json_decode($jsonContent);

        if (!empty($usersData)) {
            $usersData[0]->name = $_POST['name'];
            $usersData[0]->type = $_POST['type'];
            $usersData[0]->email = $_POST['email'];

            // Convert comma-separated classes input string into an array
            $classesArray = array_map('trim', explode(',', $_POST['classes']));
            $usersData[0]->classes = $classesArray;

            // Save updated array back to data/users.json
            file_put_contents($jsonFilePath, json_encode($usersData, JSON_PRETTY_PRINT));
            $successMessage = "User updated successfully!";
        }
    }
}

// 3. Load user data from JSON file to display in form
if (file_exists($jsonFilePath)) {
    $jsonContent = file_get_contents($jsonFilePath);
    $usersData = json_decode($jsonContent);
    $user = $usersData[0]; // Load Ross Gellar
} else {
    die("Error: data/users.json file not found.");
}

// 4. Function 
function showUserPage($user) {
    $classes = implode(", ", $user->classes);

    // heredoc
    echo <<<HTML
    <nav class="nav nav-crumbs">
        <ul>
            <li><a href="index.html">Back</a></li>
        </ul>
    </nav>
    <div style="background:#fff; padding:2rem; border-radius:16px; max-width:600px; margin:2rem auto; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
        
        <form method="POST" action="user_editor.php">
            
            <div style="margin-bottom:1.5rem;">
                <label style="display:block; font-weight:bold; margin-bottom:0.25rem;">Name</label>
                <input type="text" name="name" value="{$user->name}" style="width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:8px; font-size:1.25rem; font-weight:bold;">
            </div>

            <div style="margin-bottom:1rem;">
                <strong style="display:inline-block; width:80px;">Type</strong>
                <input type="text" name="type" value="{$user->type}" style="padding:0.5rem; border:1px solid #ccc; border-radius:6px;">
            </div>

            <div style="margin-bottom:1rem;">
                <strong style="display:inline-block; width:80px;">Email</strong>
                <input type="email" name="email" value="{$user->email}" style="padding:0.5rem; border:1px solid #ccc; border-radius:6px; width:250px;">
            </div>

            <div style="margin-bottom:1.5rem;">
                <strong style="display:inline-block; width:80px;">Classes</strong>
                <input type="text" name="classes" value="{$classes}" style="padding:0.5rem; border:1px solid #ccc; border-radius:6px; width:200px;">
            </div>

            <button type="submit" style="background:#0f172a; color:#fff; padding:0.75rem 1.5rem; border:none; border-radius:8px; font-weight:bold; cursor:pointer;">
                Save Changes
            </button>
        </form>
    </div>
    HTML;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Admin - Editor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <header class="bg-gray-700 text-white p-4 font-bold flex justify-between max-w-4xl mx-auto rounded-t-lg">
        <div>User Admin</div>
        <div>User List</div>
    </header>

    <main class="max-w-4xl mx-auto bg-white p-6 rounded-b-lg shadow-sm">
        <?php 
        if (isset($successMessage)) {
            echo "<div style='color:green; font-weight:bold; margin-bottom:1rem;'>$successMessage</div>";
        }
        
        // Call the showUserPage function to render the form
        showUserPage($user); 
        ?>
    </main>

</body>
</html>
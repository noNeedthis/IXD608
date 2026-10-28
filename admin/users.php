<?php
// Path to JSON data file from inside the admin folder
$jsonFilePath = '../data/users.json';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (file_exists($jsonFilePath)) {
        $jsonContent = file_get_contents($jsonFilePath);
        $usersData = json_decode($jsonContent);

        if (!empty($usersData)) {
            $usersData[0]->name = $_POST['name'];
            $usersData[0]->type = $_POST['type'];
            $usersData[0]->email = $_POST['email'];

            // Convert comma-separated string back into an array
            $classesArray = array_map('trim', explode(',', $_POST['classes']));
            $usersData[0]->classes = $classesArray;

            // Save back to JSON file
            file_put_contents($jsonFilePath, json_encode($usersData, JSON_PRETTY_PRINT));
            $successMessage = "Account updated successfully!";
        }
    }
}

// Load user data
if (file_exists($jsonFilePath)) {
    $jsonContent = file_get_contents($jsonFilePath);
    $usersData = json_decode($jsonContent);
    $user = $usersData[0];
} else {
    // Default fallback if JSON doesn't exist yet
    $user = (object)[
        'name' => 'Ross Gellar',
        'type' => 'Professor',
        'email' => 'rgellar1971@hotmail.com',
        'classes' => ['601', '608']
    ];
}

$classesStr = implode(", ", $user->classes);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Admin | Peak Lineup</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #cbd5e1;
            background-color: #ffffff;
            font-size: 0.95rem;
            color: #1e293b;
            transition: all 0.2s ease;
        }
        .form-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="../index.html" class="flex items-center gap-2 group">
                <span class="text-2xl font-extrabold tracking-tight text-gray-900 group-hover:text-blue-600 transition-colors uppercase">
                    PEAK LINEUP
                </span>
            </a>
            <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                <a href="../index.html" class="px-4 py-2 rounded-full text-sm font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-all">
                    Filming
                </a>
                <a href="#" class="px-4 py-2 rounded-full text-sm font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-all">
                    Upload
                </a>
                <a href="#" class="px-4 py-2 rounded-full text-sm font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-all">
                    Rankings
                </a>
                <a href="users.php" class="px-4 py-2 rounded-full text-sm font-semibold bg-gray-900 text-white transition-all shadow-sm">
                    Account
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-20 flex-grow w-full">
        
        <div class="mb-6">
            <a href="../index.html" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i> Back to Filming
            </a>
        </div>

        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-200 shadow-sm">
            
            <h1 class="text-2xl font-extrabold text-gray-900 mb-2">User Account Editor</h1>
            <p class="text-gray-500 text-sm mb-6">Modify user profile data stored in JSON.</p>

            <?php if (isset($successMessage)): ?>
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-semibold">
                    <i class="fa-solid fa-circle-check mr-1.5"></i> <?php echo $successMessage; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="users.php" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user->name); ?>" required class="form-input font-bold text-lg">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Type</label>
                        <input type="text" name="type" value="<?php echo htmlspecialchars($user->type); ?>" required class="form-input">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Classes</label>
                        <input type="text" name="classes" value="<?php echo htmlspecialchars($classesStr); ?>" required class="form-input">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user->email); ?>" required class="form-input">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-base transition-all shadow-md">
                        Save Changes to JSON
                    </button>
                </div>
            </form>

        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-gray-500">
            &copy; 2026 PEAK LINEUP. All rights reserved.
        </div>
    </footer>
</body>
</html>
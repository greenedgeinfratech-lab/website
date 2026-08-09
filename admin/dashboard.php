<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
  <nav class="bg-green-600 text-white p-4 flex justify-between">
    <h1 class="font-bold text-xl">Admin Dashboard</h1>
    <a href="logout.php" class="bg-red-500 px-4 py-1 rounded">Logout</a>
  </nav>

  <div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Welcome, Admin</h2>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
       <a href="manage_blogs.php" class="p-6 bg-white shadow rounded text-center hover:bg-green-50">
        <h3 class="font-semibold text-lg">📑 Manage Blogs</h3>
        <p class="text-gray-600">Add, edit, or delete blog posts.</p>
      </a>
      <a href="add-blog.php" class="p-6 bg-white shadow rounded text-center hover:bg-green-50">
        <h3 class="font-semibold text-lg">✍️ Add New Blog</h3>
        <p class="text-gray-600">Create a fresh blog article.</p>
      </a>
      <!-- <a href="settings.php" class="p-6 bg-white shadow rounded text-center hover:bg-green-50">
        <h3 class="font-semibold text-lg">⚙️ Settings</h3>
        <p class="text-gray-600">Update account or site settings.</p>
      </a> -->
    </div>
  </div>
</body>
</html>

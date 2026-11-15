<?php
// Old blog URL: /blog_details?id=N -> /blog/<slug>
$_GET['slug'] = '';
require __DIR__ . '/blog.php';

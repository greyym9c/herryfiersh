<?php
// Simple Router
// Compat for PHP Built-in Server
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file(__DIR__ . $path)) {
        return false;
    }
}

// Simple Router
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Valid pages whitelist to prevent LFI
$allowed_pages = ['home', 'barcode', 'gold', 'struk', 'zakat', 'treasury', 'saham', 'crypto', 'about'];

if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}

require_once 'includes/header.php';
require_once 'includes/navbar.php';
?>

<main>
    <?php
    $file = "pages/{$page}/index.php";
    if (file_exists($file)) {
        include $file;
    } else {
        echo "<div class='container' style='padding: 5rem 0; text-align: center;'><h2>404 - Halaman tidak ditemukan</h2></div>";
    }
    ?>
</main>

<?php
require_once 'includes/footer.php';
?>

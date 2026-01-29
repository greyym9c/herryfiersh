<?php
// Simple Router
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Valid pages whitelist to prevent LFI
$allowed_pages = ['home', 'barcode', 'gold', 'struk', 'zakat', 'treasury', 'about'];

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

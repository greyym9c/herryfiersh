<?php
$current_page = $page ?? 'home';
?>
<nav class="navbar navbar-expand-lg navbar-dark glass-header fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="?page=home">
            <i class="fa-solid fa-dollar-sign me-2 text-primary-gradient"></i>
            <span class="bg-gradient-primary text-transparent bg-clip-text">HERRYFIERSH</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-2">
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'home' ? 'active' : ''; ?>" href="?page=home">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'barcode' ? 'active' : ''; ?>" href="?page=barcode">Barcode</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'treasury' ? 'active' : ''; ?>" href="?page=treasury">Treasury</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'saham' ? 'active' : ''; ?>" href="?page=saham">Saham</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'crypto' ? 'active' : ''; ?>" href="?page=crypto">Crypto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'struk' ? 'active' : ''; ?>" href="?page=struk">Struk</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'garapan' || $current_page == 'garapan_input') ? 'active' : ''; ?>" href="?page=garapan">Garapan</a>
                </li>

            </ul>
        </div>
    </div>
</nav>
<div style="margin-top: 80px;"></div> <!-- Spacer for fixed navbar -->

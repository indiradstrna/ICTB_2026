<?php
// Base URL or configurations can be set here
$site_title = "5th International Conference on Tropical Biology";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_title; ?></title>
    <meta name="description" content="Biodiversity Beyond Boundaries: Advancing Global Education, Bio-Science, and Sustainable Landscapes">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header class="header" id="header">
        <div class="nav-container" style="width: 100%; padding: 0 50px;">
            <!-- Logo -->
            <a href="index2.php" class="custom-logo">
                <div class="custom-logo-top">
                    <span class="custom-logo-year">2026</span>
                    <img src="assets/img/ICTB.jpeg" alt="ICTB Logo" class="custom-logo-img">
                </div>
                <div class="custom-logo-text">
                    International Conference
                </div>
            </a>

            <!-- Desktop Navigation -->
            <ul class="nav-links">
                <li><a href="#about" class="nav-link">About</a></li>
                <li><a href="#speakers" class="nav-link">Speakers</a></li>
                <li><a href="#schedule" class="nav-link">Schedule</a></li>
                <li><a href="#pricing" class="nav-link">Tickets</a></li>
                <li><a href="#contacts" class="nav-link">Contacts</a></li>
            </ul>

            <!-- Nav Actions -->
            <div class="nav-actions">
                <a href="#pricing" class="btn btn-outline">Register Now</a>
                <div class="mobile-menu-btn" id="mobile-menu-btn">
                    <i class="ph ph-list"></i>
                </div>
            </div>
        </div>
    </header>

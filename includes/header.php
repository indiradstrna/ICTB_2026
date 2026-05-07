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
    <?php $is_home = (basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == 'index.php'); ?>
    <header class="header <?php echo !$is_home ? 'scrolled' : ''; ?>" id="header" data-is-home="<?php echo $is_home ? 'true' : 'false'; ?>">
        <div class="nav-container" style="width: 100%; padding: 0 50px;">
            <!-- Logo -->
            <a href="index.php" class="custom-logo">
                <div class="custom-logo-top">
                    <span class="custom-logo-year">2026</span>
                    <img src="assets/img/ICTB.jpeg" alt="ICTB Logo" class="custom-logo-img">
                </div>
                <div class="custom-logo-text">
                    International Conference
                </div>
            </a>

            <!-- Desktop Navigation -->
            <ul class="nav-links" style="margin-left: auto; margin-right: 32px;">
                <li><a href="index.php" class="nav-link">HOME</a></li>
                <li class="has-dropdown">
                    <a href="index.php#about" class="nav-link">SCIENTIFIC PROGRAM</a>
                    <ul class="dropdown-menu">
                        <li><a href="about.php">INTRODUCTION</a></li>
                        <li><a href="theme.php">SUB THEMES AND TOPICS</a></li>
                        <li class="has-sub-dropdown">
                            <a href="#">PARTICIPATION GUIDELINES</a>
                            <ul class="sub-dropdown-menu">
                                <li><a href="registration_guidelines.php">REGISTRATION</a></li>
                                <li><a href="author_guidelines.php">AUTHOR GUIDELINES</a></li>
                            </ul>
                        </li>
                        <li><a href="schedule.php">SCHEDULE & PROGRAM</a></li>
                        <li><a href="committee.php">COMMITTEE</a></li>
                    </ul>
                </li>
                <li class="has-dropdown">
                    <a href="index.php#location" class="nav-link">CONFERENCE VENUE</a>
                    <ul class="dropdown-menu">
                        <li><a href="venue.php">VENUE</a></li>
                        <li><a href="accomodation.php">ACCOMMODATION</a></li>
                        <li><a href="exhibition.php">EXHIBITION & SPONSORSHIP</a></li>
                    </ul>
                </li>
                <li class="has-dropdown">
                    <a href="#" class="nav-link">LOGIN</a>
                    <ul class="dropdown-menu">
                        <li><a href="login.php">LOGIN</a></li>
                        <li><a href="registration.php">REGISTER</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Nav Actions -->
            <div class="nav-actions">
                <div class="mobile-menu-btn" id="mobile-menu-btn">
                    <i class="ph ph-list"></i>
                </div>
            </div>
        </div>
    </header>

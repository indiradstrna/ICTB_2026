<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="assets/css/article.css">

<!-- Page Header -->
<section class="page-header" style="background-image: url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&q=80&w=1000'); background-position: center 30%;">
    <div class="cover-overlay"></div>
    <div class="container page-header-content text-center reveal-up">
        <h1 class="section-title text-white">Conference Speakers</h1>
        <p class="text-white" style="font-size: 1.1rem; opacity: 0.9;">Leading experts in Tropical Biology and Sustainable Ecosystems</p>
    </div>
</section>

<!-- Speakers Content -->
<section class="section-padding" style="background-color: var(--bg-light);">
    <div class="container">
        
        <!-- Keynote Speakers -->
        <div class="reveal-up" style="margin-bottom: 80px;">
            <div class="section-header text-center">
                <span class="section-subtitle">Experts</span>
                <h2 class="section-title">Keynote Speakers</h2>
            </div>
            
            <div class="speakers-grid">
                <?php
                $keynote_speakers = [
                    ['name' => 'Dr. Elis Rosdiawati M.Pd', 'role' => 'Deputy Director of Administration', 'org' => 'SEAMEO BIOTROP', 'img' => 'https://biotrop.org/images/bod/bu%20elis.png'],
                    ['name' => 'Prof. Dr. Edi Santosa S.P, M.Si', 'role' => 'Director', 'org' => 'SEAMEO BIOTROP', 'img' => 'https://biotrop.org/images/bod/Pak_Edi.jpeg'],
                    ['name' => 'Dr. Doni Yusri S.P, M.M', 'role' => 'Deputy Director of Program', 'org' => 'SEAMEO BIOTROP', 'img' => 'https://biotrop.org/images/bod/pak%20doni.png'],
                ];
                
                foreach($keynote_speakers as $index => $speaker): ?>
                <div class="speaker-card reveal-up" style="transition-delay: <?php echo $index * 0.1; ?>s;">
                    <div class="speaker-img-wrapper">
                        <img src="<?php echo $speaker['img']; ?>" alt="<?php echo $speaker['name']; ?>" class="speaker-img">
                    </div>
                    <div class="speaker-info">
                        <h3 class="speaker-name"><?php echo $speaker['name']; ?></h3>
                        <p class="speaker-role"><?php echo $speaker['role']; ?></p>
                        <p class="speaker-org"><?php echo $speaker['org']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Invited Speakers -->
        <div class="reveal-up">
            <div class="section-header text-center">
                <span class="section-subtitle">Global Network</span>
                <h2 class="section-title">Invited Speakers</h2>
            </div>
            
            <div class="speakers-grid">
                <div class="speaker-card reveal-up">
                    <div class="speaker-img-wrapper">
                        <img src="https://placehold.co/400x400/0d9488/ffffff?text=To+Be+Announced" alt="Speaker" class="speaker-img">
                    </div>
                    <div class="speaker-info">
                        <h3 class="speaker-name">To Be Announced</h3>
                        <p class="speaker-role">Invited Speaker</p>
                        <p class="speaker-org">Various Institutions</p>
                    </div>
                </div>
                <div class="speaker-card reveal-up" style="transition-delay: 0.1s;">
                    <div class="speaker-img-wrapper">
                        <img src="https://placehold.co/400x400/0d9488/ffffff?text=To+Be+Announced" alt="Speaker" class="speaker-img">
                    </div>
                    <div class="speaker-info">
                        <h3 class="speaker-name">To Be Announced</h3>
                        <p class="speaker-role">Invited Speaker</p>
                        <p class="speaker-org">Various Institutions</p>
                    </div>
                </div>
                <div class="speaker-card reveal-up" style="transition-delay: 0.2s;">
                    <div class="speaker-img-wrapper">
                        <img src="https://placehold.co/400x400/0d9488/ffffff?text=To+Be+Announced" alt="Speaker" class="speaker-img">
                    </div>
                    <div class="speaker-info">
                        <h3 class="speaker-name">To Be Announced</h3>
                        <p class="speaker-role">Invited Speaker</p>
                        <p class="speaker-org">Various Institutions</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>

<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section class="page-header" style="background-image: url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&q=80&w=1000'); background-position: center 30%;">
    <div class="cover-overlay"></div>
    <div class="container page-header-content text-center reveal-up">
        <h1 class="section-title text-white">Conference Venue</h1>
        <p class="text-white" style="font-size: 1.1rem; opacity: 0.9;">IPB International Convention Center</p>
    </div>
</section>

<style>
.venue-section-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 30px;
}
.venue-section-header h2 {
    color: var(--primary-color);
    font-size: 20px;
    font-family: var(--font-subheading);
    margin: 0;
    white-space: nowrap;
}
.venue-section-header .line {
    flex-grow: 1;
    height: 1px;
    background-color: #eaeaea;
}
.divider-icon {
    text-align: center;
    margin: 40px 0;
    position: relative;
}
.divider-icon::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background-color: #eaeaea;
    z-index: 1;
}
.divider-icon i {
    background: #fff;
    padding: 0 15px;
    color: #cbd5e1;
    font-size: 24px;
    position: relative;
    z-index: 2;
}
.venue-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: var(--shadow-sm);
    display: block;
}
.venue-map iframe {
    width: 100%;
    height: 400px;
    border: none;
    border-radius: 8px;
    box-shadow: var(--shadow-sm);
    display: block;
}
.secretariat-info {
    font-size: 15px;
    color: var(--text-dark);
    line-height: 1.8;
}
.secretariat-info h4 {
    color: var(--primary-color);
    margin-top: 15px;
    margin-bottom: 5px;
    font-size: 16px;
    text-transform: uppercase;
}
.secretariat-info p {
    margin-bottom: 5px;
}
</style>

<section class="section-padding" style="background-color: #fff;">
    <div class="container" style="max-width: 900px;">
        
        <!-- Venue Section -->
        <div class="reveal-up">
            <div class="venue-section-header">
                <h2>Venue</h2>
                <div class="line"></div>
            </div>
            <!-- Gambar ICC -->
            <img src="assets/img/ipbicc.jpeg" onerror="this.src='https://images.unsplash.com/photo-1540304892644-8d4e414f6b21?auto=format&fit=crop&q=80&w=1200'" alt="IPB International Convention Center" class="venue-image">
        </div>

        <div class="divider-icon reveal-up">
            <i class="ph-fill ph-map-pin"></i>
        </div>

        <!-- How to Get There Section -->
        <div class="reveal-up">
            <div class="venue-section-header">
                <h2>How to Get There</h2>
                <div class="line"></div>
            </div>
            
            <div class="venue-map">
                <!-- IPB ICC Google Maps Embed -->
                <iframe src="https://maps.google.com/maps?q=IPB%20International%20Convention%20Center,%20Bogor&t=&z=15&ie=UTF8&iwloc=&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <div class="divider-icon reveal-up">
            <i class="ph-fill ph-circle"></i>
        </div>

        <!-- Secretariat Info Section -->
        <div class="reveal-up secretariat-info">
            <p style="font-weight: 600; margin-bottom: 20px;">Secretariat of SEAMEO BIOTROP 5th International Conference on Tropical Biology</p>
            
            <h4>SEAMEO BIOTROP</h4>
            <p>Jl. Raya Tajur Km. 6 Bogor 16134, INDONESIA</p>
            <p>E-mail: <a href="mailto:cb.symposium@biotrop.org" style="color: var(--primary-color); text-decoration: none;">cb.symposium@biotrop.org</a></p>
            <p>Tel: +62-251-8323848</p>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>

document.addEventListener('DOMContentLoaded', () => {
    // 1. Header Scroll Effect
    const header = document.getElementById('header');
    
    if (header) {
        const isHome = header.getAttribute('data-is-home') === 'true';
        
        window.addEventListener('scroll', () => {
            if (isHome) {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }
        });
    }

    // 2. Active Nav Link based on Scroll Position
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.nav-link');

    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (scrollY >= (sectionTop - sectionHeight / 3)) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });

    // 3. Scroll Reveal Animations
    const reveals = document.querySelectorAll('.reveal-up, .reveal-left, .reveal-right');

    const revealOnScroll = () => {
        const windowHeight = window.innerHeight;
        const elementVisible = 100;

        reveals.forEach(reveal => {
            const elementTop = reveal.getBoundingClientRect().top;
            if (elementTop < windowHeight - elementVisible) {
                reveal.classList.add('reveal-active');
            }
        });
    };

    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll(); // Trigger once on load

    // 4. Schedule Tabs Logic
    const tabBtns = document.querySelectorAll('.tab-btn');
    const schedulePanes = document.querySelectorAll('.schedule-pane');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active from all buttons and panes
            tabBtns.forEach(b => b.classList.remove('active'));
            schedulePanes.forEach(p => p.classList.remove('active'));

            // Add active to clicked button and corresponding pane
            btn.classList.add('active');
            const target = btn.getAttribute('data-target');
            document.getElementById(target).classList.add('active');
        });
    });

    // 5. Mobile Menu Toggle
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const navLinksContainer = document.querySelector('.nav-links');
    
    if(mobileBtn && navLinksContainer) {
        mobileBtn.addEventListener('click', () => {
            navLinksContainer.classList.toggle('active');
            
            // Toggle icon
            const icon = mobileBtn.querySelector('i');
            if (navLinksContainer.classList.contains('active')) {
                icon.classList.remove('ph-list');
                icon.classList.add('ph-x');
            } else {
                icon.classList.remove('ph-x');
                icon.classList.add('ph-list');
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileBtn.contains(e.target) && !navLinksContainer.contains(e.target)) {
                navLinksContainer.classList.remove('active');
                const icon = mobileBtn.querySelector('i');
                icon.classList.remove('ph-x');
                icon.classList.add('ph-list');
            }
        });
    }
    // 6. Countdown Timer
    if (document.getElementById('countdown')) {
        const targetDate = new Date("October 5, 2026 08:00:00").getTime();
        let intervalId;

        const updateCountdown = () => {
            const now = new Date().getTime();
            const distance = targetDate - now;
            
            const cdDays = document.getElementById('cd-days');
            const cdHours = document.getElementById('cd-hours');
            const cdMinutes = document.getElementById('cd-minutes');
            const cdSeconds = document.getElementById('cd-seconds');

            if (distance < 0) {
                if(intervalId) clearInterval(intervalId);
                const countdownWrapper = document.getElementById('countdown');
                if (countdownWrapper) {
                    countdownWrapper.innerHTML = "<span style='font-weight: bold; color: #fff; font-size: 16px;'>The countdown is finished</span>";
                }
                return;
            }

            if(cdDays && cdHours && cdMinutes && cdSeconds) {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                cdDays.innerText = days.toString().padStart(2, '0');
                cdHours.innerText = hours.toString().padStart(2, '0');
                cdMinutes.innerText = minutes.toString().padStart(2, '0');
                cdSeconds.innerText = seconds.toString().padStart(2, '0');
            }
        };

        updateCountdown();
        intervalId = setInterval(updateCountdown, 1000);
    }

    // 7. Partners Slider Logic
    const partnerTrack = document.getElementById('partner-slider-track');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const dots = document.querySelectorAll('.slider-dot');
    
    if (partnerTrack && prevBtn && nextBtn) {
        let currentSlide = 0;
        
        const updateSlider = () => {
            const cardWidth = partnerTrack.querySelector('.slider-card').offsetWidth + 20; // 20 is gap
            // Calculate how many cards are visible
            const visibleCards = window.innerWidth <= 600 ? 1 : (window.innerWidth <= 900 ? 2 : 3);
            const cards = partnerTrack.querySelectorAll('.slider-card');
            const totalCards = cards.length;
            const maxSlides = Math.max(0, totalCards - visibleCards);
            
            if (currentSlide > maxSlides) currentSlide = maxSlides;
            if (currentSlide < 0) currentSlide = 0;
            
            const scrollAmount = currentSlide * cardWidth;
            partnerTrack.style.transform = `translateX(-${scrollAmount}px)`;
            
            // Fade in style for visible cards
            cards.forEach((card, index) => {
                if (index >= currentSlide && index < currentSlide + visibleCards) {
                    card.classList.add('active-card');
                } else {
                    card.classList.remove('active-card');
                }
            });
            
            // Update dots
            dots.forEach((dot, index) => {
                if (index === Math.floor(currentSlide / visibleCards) || (index === dots.length - 1 && currentSlide === maxSlides)) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        };
        
        // Initialize active cards
        updateSlider();
        
        nextBtn.addEventListener('click', () => {
            currentSlide++;
            updateSlider();
        });
        
        prevBtn.addEventListener('click', () => {
            currentSlide--;
            updateSlider();
        });
        
        window.addEventListener('resize', updateSlider);
        
        // Optional: Dot click logic
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                const visibleCards = window.innerWidth <= 600 ? 1 : (window.innerWidth <= 900 ? 2 : 3);
                currentSlide = index * visibleCards;
                updateSlider();
            });
        });
    }
});

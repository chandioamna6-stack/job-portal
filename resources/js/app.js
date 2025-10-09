import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// ================= Custom Job Portal Scripts =================

// Mobile Navigation
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');

if (hamburger) {
    hamburger.addEventListener('click', () => {
        navMenu.classList.toggle('hidden'); // Tailwind hidden/show
        hamburger.classList.toggle('open');
    });
}

// Close mobile menu when clicking a link
document.querySelectorAll('.nav-link').forEach((link) => {
    link.addEventListener('click', () => {
        navMenu.classList.add('hidden');
        hamburger.classList.remove('open');
    });
});

// Header scroll effect
window.addEventListener('scroll', () => {
    const header = document.querySelector('header');
    if (window.scrollY > 100) {
        header.classList.add('bg-white', 'shadow', 'transition');
    } else {
        header.classList.remove('bg-white', 'shadow', 'transition');
    }
});

// ================= Swiper Sliders =================
if (typeof Swiper !== 'undefined') {
    // Companies slider
    new Swiper('.companies-slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        pagination: { el: '.swiper-pagination', clickable: true },
        breakpoints: {
            640: { slidesPerView: 2 },
            992: { slidesPerView: 3 },
            1200: { slidesPerView: 4 },
        },
        autoplay: { delay: 3000, disableOnInteraction: false },
    });

    // Testimonials slider
    new Swiper('.testimonials-slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        pagination: { el: '.swiper-pagination', clickable: true },
        breakpoints: { 768: { slidesPerView: 2 } },
        autoplay: { delay: 5000, disableOnInteraction: false },
    });
}

// ================= Job Filter Buttons =================
const filterButtons = document.querySelectorAll('.filter-btn');
filterButtons.forEach((button) => {
    button.addEventListener('click', () => {
        filterButtons.forEach((btn) => btn.classList.remove('active'));
        button.classList.add('active');
        console.log(`Filtering by: ${button.textContent}`);
    });
});

// ================= CTA Form Validation =================
const ctaForm = document.querySelector('.cta-form');
if (ctaForm) {
    ctaForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const email = ctaForm.querySelector('input[type="email"]').value;

        if (validateEmail(email)) {
            alert('Thank you for subscribing! We will be in touch soon.');
            ctaForm.reset();
        } else {
            alert('Please enter a valid email address.');
        }
    });
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// ================= Enhanced Dropdowns =================
document.querySelectorAll('.search-dropdown select').forEach((dropdown) => {
    dropdown.addEventListener('focus', () => {
        dropdown.parentElement.style.boxShadow = '0 0 0 2px var(--tw-ring-color, #3b82f6)';
    });

    dropdown.addEventListener('blur', () => {
        dropdown.parentElement.style.boxShadow = 'none';
    });

    dropdown.addEventListener('change', () => {
        console.log(`Selected: ${dropdown.value}`);
    });
});

// ================= Animation on Scroll =================
const animatedElements = document.querySelectorAll('.feature-card, .job-card, .company-slide');

function checkScroll() {
    animatedElements.forEach((element) => {
        const elementPosition = element.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;

        if (elementPosition < screenPosition) {
            element.classList.add('opacity-100', 'translate-y-0');
        }
    });
}

// Initialize animation styles
animatedElements.forEach((element) => {
    element.classList.add('opacity-0', 'translate-y-5', 'transition', 'duration-500');
});

window.addEventListener('scroll', checkScroll);
window.addEventListener('load', checkScroll);

// This file contains the JavaScript code for the Flormar Slider, handling interactive features such as transitions, navigation, and responsiveness.

document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.flormar-slider .slide');
    const nextButton = document.querySelector('.flormar-slider .next');
    const prevButton = document.querySelector('.flormar-slider .prev');
    let currentSlide = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.display = (i === index) ? 'block' : 'none';
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }

    nextButton.addEventListener('click', nextSlide);
    prevButton.addEventListener('click', prevSlide);

    showSlide(currentSlide);
});
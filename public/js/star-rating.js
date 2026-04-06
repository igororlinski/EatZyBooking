document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.star-rating').forEach(function(container) {
        const stars = container.querySelectorAll('.star-btn');
        const input = container.querySelector('input[type="hidden"]');

        if (!input) return;

        stars.forEach(function(star, index) {
            star.addEventListener('mouseenter', function() {
                stars.forEach(function(s, i) {
                    s.classList.toggle('hovered', i <= index);
                    s.classList.remove('active');
                });
            });

            container.addEventListener('mouseleave', function() {
                const selected = parseInt(input.value);
                stars.forEach(function(s, i) {
                    s.classList.remove('hovered');
                    s.classList.toggle('active', i < selected);
                });
            });

            star.addEventListener('click', function() {
                const value = parseInt(star.dataset.value);
                input.value = value;
                stars.forEach(function(s, i) {
                    s.classList.toggle('active', i < value);
                    s.classList.remove('hovered');
                });
            });
        });
    });
});
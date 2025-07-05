document.addEventListener('DOMContentLoaded', function() {
    const serviceCards = document.querySelectorAll('.service-card');

    serviceCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.querySelector('.card-3d').style.transform = 'rotateY(15deg) translateZ(20px)';
            this.querySelector('.card-3d').style.boxShadow = '15px 15px 30px rgba(0, 0, 0, 0.3)';
        });

        card.addEventListener('mouseleave', function() {
            this.querySelector('.card-3d').style.transform = 'rotateY(0) translateZ(0)';
            this.querySelector('.card-3d').style.boxShadow = '8px 8px 20px rgba(0, 0, 0, 0.2)';
        });
    });
});

window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: form.method,
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data === 'success') {
            document.getElementById('messageDisplay').innerHTML = '<div class="alert alert-success">Message envoyé avec succès!</div>';
            form.reset();
        } else {
            document.getElementById('messageDisplay').innerHTML = '<div class="alert alert-danger">Erreur lors de l\'envoi du message. Veuillez réessayer.</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('messageDisplay').innerHTML = '<div class="alert alert-danger">Une erreur s\'est produite. Veuillez réessayer plus tard.</div>';
    });
});
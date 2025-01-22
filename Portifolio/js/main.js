// Função para animar elementos quando eles entram na viewport
function animateOnScroll() {
    const elements = document.querySelectorAll('.fade-up');
    const windowHeight = window.innerHeight;

    elements.forEach(element => {
        const elementPosition = element.getBoundingClientRect().top;
        
        if (elementPosition < windowHeight - 100) {
            element.classList.add('animate');
        }
    });
}

// Adicionar classe fade-up aos elementos que queremos animar
document.addEventListener('DOMContentLoaded', function() {
    const skillCards = document.querySelectorAll('.skill-card');
    const projectCards = document.querySelectorAll('.project-card');
    const sectionTitles = document.querySelectorAll('.section-title');
    const aboutStats = document.querySelectorAll('.stat-item');

    // Adicionar classe fade-up aos elementos
    [...skillCards, ...projectCards, ...sectionTitles, ...aboutStats].forEach(element => {
        element.classList.add('fade-up');
    });

    // Iniciar animações
    animateOnScroll();
});

// Listener para scroll
window.addEventListener('scroll', animateOnScroll);

// Menu mobile
const navMenu = document.querySelector('.nav-menu');
const navToggle = document.createElement('button');
navToggle.className = 'nav-toggle';
navToggle.innerHTML = '<i class="fas fa-bars"></i>';

document.querySelector('.nav').appendChild(navToggle);

navToggle.addEventListener('click', () => {
    navMenu.classList.toggle('show');
});

// Fechar menu ao clicar em um link
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
        navMenu.classList.remove('show');
    });
});

// Navbar ativa baseada na seção atual
function updateActiveNavLink() {
    const sections = document.querySelectorAll('section[id]');
    const scrollY = window.pageYOffset;

    sections.forEach(section => {
        const sectionHeight = section.offsetHeight;
        const sectionTop = section.offsetTop - 100;
        const sectionId = section.getAttribute('id');
        const navLink = document.querySelector(`.nav-link[href="#${sectionId}"]`);

        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
            navLink?.classList.add('active');
        } else {
            navLink?.classList.remove('active');
        }
    });
}

window.addEventListener('scroll', updateActiveNavLink); 
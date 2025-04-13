// Ajout d'un script pour l'interface d'administration
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation du mode sombre/clair
    initDarkMode();
    
    // Ajout d'écouteurs d'événements pour les liens de navigation
    setupNavigationEvents();
    
    // Initialisation du menu mobile
    initMobileMenu();
});

// Fonction pour initialiser le mode sombre/clair
function initDarkMode() {
    // Vérifier si le thème est déjà défini dans le localStorage
    const darkModeToggle = document.querySelector('[aria-label="Toggle dark mode"]');
    
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            
            // Mettre à jour l'apparence du bouton
            updateDarkModeButton();
        });
        
        // Initialiser l'apparence du bouton au chargement
        updateDarkModeButton();
    }
}

// Fonction pour mettre à jour l'apparence du bouton de mode sombre/clair
function updateDarkModeButton() {
    const sunIcon = document.querySelector('[aria-label="Toggle dark mode"] .dark\\:block');
    const moonIcon = document.querySelector('[aria-label="Toggle dark mode"] .block.dark\\:hidden');
    
    if (document.documentElement.classList.contains('dark')) {
        if (sunIcon) sunIcon.classList.remove('hidden');
        if (moonIcon) moonIcon.classList.add('hidden');
    } else {
        if (sunIcon) sunIcon.classList.add('hidden');
        if (moonIcon) moonIcon.classList.remove('hidden');
    }
}

// Fonction pour configurer les événements de navigation
function setupNavigationEvents() {
    // Ajouter des écouteurs d'événements pour les liens de navigation
    const navLinks = document.querySelectorAll('nav a');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Ajouter une classe pour l'animation de transition si nécessaire
            document.body.classList.add('page-transition');
        });
    });
    
    // Ajouter des écouteurs d'événements pour les boutons d'action rapide
    const actionButtons = document.querySelectorAll('.grid-cols-2 a');
    
    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Ne pas ajouter d'animation pour les liens qui s'ouvrent dans un nouvel onglet
            if (!this.hasAttribute('target')) {
                document.body.classList.add('page-transition');
            }
        });
    });
}

// Fonction pour initialiser le menu mobile
function initMobileMenu() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const closeMobileMenuButton = document.getElementById('close-mobile-menu');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu && closeMobileMenuButton) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.remove('hidden');
            mobileMenu.querySelector('div').classList.add('translate-x-0');
            mobileMenu.querySelector('div').classList.remove('translate-x-full');
        });
        
        closeMobileMenuButton.addEventListener('click', function() {
            mobileMenu.querySelector('div').classList.remove('translate-x-0');
            mobileMenu.querySelector('div').classList.add('translate-x-full');
            setTimeout(function() {
                mobileMenu.classList.add('hidden');
            }, 300);
        });
    }
}

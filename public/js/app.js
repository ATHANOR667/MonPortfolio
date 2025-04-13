// Ajout d'un composant de navigation pour toutes les pages
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation du mode sombre/clair
    initDarkMode();
    
    // Ajout d'écouteurs d'événements pour les liens de navigation
    setupNavigationEvents();
    
    // Amélioration de la responsivité de la navbar
    setupResponsiveNavbar();
    
    // Configuration des menus déroulants
    setupDropdownMenus();
});

// Fonction pour initialiser le mode sombre/clair
function initDarkMode() {
    // Vérifier si le thème est déjà défini dans le localStorage
    const darkModeToggle = document.getElementById('theme-toggle');
    const darkModeToggleMobile = document.getElementById('theme-toggle-mobile');
    const adminDarkModeToggle = document.getElementById('admin-theme-toggle');
    
    if (darkModeToggle) {
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');
        
        // Initialiser l'état des icônes en fonction du thème actuel
        if (document.documentElement.classList.contains('dark')) {
            darkIcon.classList.remove('hidden');
            lightIcon.classList.add('hidden');
        } else {
            darkIcon.classList.add('hidden');
            lightIcon.classList.remove('hidden');
        }
        
        darkModeToggle.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            
            // Mettre à jour l'apparence du bouton
            if (document.documentElement.classList.contains('dark')) {
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            } else {
                darkIcon.classList.add('hidden');
                lightIcon.classList.remove('hidden');
            }
        });
    }
    
    if (darkModeToggleMobile) {
        const darkIconMobile = document.getElementById('theme-toggle-dark-icon-mobile');
        const lightIconMobile = document.getElementById('theme-toggle-light-icon-mobile');
        
        // Initialiser l'état des icônes en fonction du thème actuel
        if (document.documentElement.classList.contains('dark')) {
            darkIconMobile.classList.remove('hidden');
            lightIconMobile.classList.add('hidden');
        } else {
            darkIconMobile.classList.add('hidden');
            lightIconMobile.classList.remove('hidden');
        }
        
        darkModeToggleMobile.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            
            // Mettre à jour l'apparence du bouton
            if (document.documentElement.classList.contains('dark')) {
                darkIconMobile.classList.remove('hidden');
                lightIconMobile.classList.add('hidden');
            } else {
                darkIconMobile.classList.add('hidden');
                lightIconMobile.classList.remove('hidden');
            }
        });
    }
    
    if (adminDarkModeToggle) {
        const adminDarkIcon = document.getElementById('admin-theme-toggle-dark-icon');
        const adminLightIcon = document.getElementById('admin-theme-toggle-light-icon');
        
        // Initialiser l'état des icônes en fonction du thème actuel
        if (document.documentElement.classList.contains('dark')) {
            adminDarkIcon.classList.remove('hidden');
            adminLightIcon.classList.add('hidden');
        } else {
            adminDarkIcon.classList.add('hidden');
            adminLightIcon.classList.remove('hidden');
        }
        
        adminDarkModeToggle.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            
            // Mettre à jour l'apparence du bouton admin
            if (document.documentElement.classList.contains('dark')) {
                adminDarkIcon.classList.remove('hidden');
                adminLightIcon.classList.add('hidden');
            } else {
                adminDarkIcon.classList.add('hidden');
                adminLightIcon.classList.remove('hidden');
            }
        });
    }
}

// Fonction pour configurer les événements de navigation
function setupNavigationEvents() {
    // Ajouter des écouteurs d'événements pour les liens de navigation
    const projectsLink = document.querySelector('a[href*="projects"]');
    const contactLink = document.querySelector('a[href*="contact"]');
    
    if (projectsLink) {
        projectsLink.addEventListener('click', function(e) {
            // Animation de transition
            document.body.classList.add('page-transition');
        });
    }
    
    if (contactLink) {
        contactLink.addEventListener('click', function(e) {
            // Animation de transition
            document.body.classList.add('page-transition');
        });
    }
}

// Fonction pour améliorer la responsivité de la navbar
function setupResponsiveNavbar() {
    // Gestion du menu mobile
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        console.log('Mobile menu elements found');
        
        // Amélioration de la gestion du clic sur le bouton du menu mobile
        mobileMenuButton.addEventListener('click', function() {
            console.log('Mobile menu button clicked');
            mobileMenu.classList.toggle('hidden');
            
            // Mise à jour de l'attribut aria-expanded pour l'accessibilité
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
            
            // Animation des icônes du menu
            const menuIcons = mobileMenuButton.querySelectorAll('svg');
            menuIcons.forEach(icon => icon.classList.toggle('hidden'));
            
            // Ajouter une classe au body pour empêcher le défilement quand le menu est ouvert
            document.body.classList.toggle('overflow-hidden', !isExpanded);
        });
        
        // Fermer le menu mobile lors du clic sur un lien
        const mobileMenuLinks = mobileMenu.querySelectorAll('a');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                
                // Rétablir les icônes du menu
                const menuIcons = mobileMenuButton.querySelectorAll('svg');
                if (menuIcons.length >= 2) {
                    menuIcons[0].classList.remove('hidden');
                    menuIcons[1].classList.add('hidden');
                }
                
                // Permettre à nouveau le défilement
                document.body.classList.remove('overflow-hidden');
            });
        });
        
        // Fermer le menu mobile lors du redimensionnement de la fenêtre
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 640 && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                
                // Rétablir les icônes du menu
                const menuIcons = mobileMenuButton.querySelectorAll('svg');
                if (menuIcons.length >= 2) {
                    menuIcons[0].classList.remove('hidden');
                    menuIcons[1].classList.add('hidden');
                }
                
                // Permettre à nouveau le défilement
                document.body.classList.remove('overflow-hidden');
            }
        });
    } else {
        console.log('Mobile menu elements not found');
    }
    
    // Gestion du menu admin mobile
    const adminMobileMenuButton = document.getElementById('mobile-menu-button');
    const adminMobileMenu = document.getElementById('mobile-menu');
    const closeMobileMenuButton = document.getElementById('close-mobile-menu');
    
    if (adminMobileMenuButton && adminMobileMenu) {
        adminMobileMenuButton.addEventListener('click', function() {
            adminMobileMenu.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
        
        if (closeMobileMenuButton) {
            closeMobileMenuButton.addEventListener('click', function() {
                adminMobileMenu.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });
        }
        
        // Fermer le menu admin mobile lors du clic en dehors du menu
        adminMobileMenu.addEventListener('click', function(e) {
            if (e.target === adminMobileMenu) {
                adminMobileMenu.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
        
        // Fermer le menu admin mobile lors du redimensionnement de la fenêtre
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768 && !adminMobileMenu.classList.contains('hidden')) {
                adminMobileMenu.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    }
}

// Fonction pour configurer les menus déroulants
function setupDropdownMenus() {
    // Gestion des menus déroulants sans Alpine.js (fallback)
    const dropdownButtons = document.querySelectorAll('.dropdown-button');
    
    dropdownButtons.forEach(button => {
        const dropdown = button.nextElementSibling;
        
        if (dropdown && dropdown.classList.contains('dropdown-menu')) {
            // Gestion du clic
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
                
                // Fermer les autres menus déroulants
                dropdownButtons.forEach(otherButton => {
                    if (otherButton !== button) {
                        const otherDropdown = otherButton.nextElementSibling;
                        if (otherDropdown && otherDropdown.classList.contains('dropdown-menu')) {
                            otherDropdown.classList.add('hidden');
                        }
                    }
                });
            });
            
            // Gestion du survol
            button.addEventListener('mouseenter', function() {
                dropdown.classList.remove('hidden');
            });
            
            dropdown.addEventListener('mouseenter', function() {
                dropdown.classList.remove('hidden');
            });
            
            button.addEventListener('mouseleave', function(e) {
                // Vérifier si la souris est entrée dans le menu déroulant
                const rect = dropdown.getBoundingClientRect();
                const isInDropdown = e.clientX >= rect.left && e.clientX <= rect.right && 
                                    e.clientY >= rect.top && e.clientY <= rect.bottom;
                
                if (!isInDropdown) {
                    setTimeout(() => {
                        if (!dropdown.matches(':hover')) {
                            dropdown.classList.add('hidden');
                        }
                    }, 100);
                }
            });
            
            dropdown.addEventListener('mouseleave', function() {
                dropdown.classList.add('hidden');
            });
            
            // Fermer le menu déroulant lors du clic en dehors
            document.addEventListener('click', function() {
                dropdown.classList.add('hidden');
            });
        }
    });
    
    // Support spécifique pour le menu utilisateur dans l'admin
    const userDropdownButton = document.querySelector('button[aria-label="User menu"]');
    const userDropdownMenu = document.getElementById('user-dropdown');
    
    if (userDropdownButton && userDropdownMenu) {
        // Gestion du clic
        userDropdownButton.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdownMenu.classList.toggle('hidden');
        });
        
        // Gestion du survol
        userDropdownButton.addEventListener('mouseenter', function() {
            userDropdownMenu.classList.remove('hidden');
        });
        
        userDropdownMenu.addEventListener('mouseenter', function() {
            userDropdownMenu.classList.remove('hidden');
        });
        
        userDropdownButton.addEventListener('mouseleave', function(e) {
            // Vérifier si la souris est entrée dans le menu déroulant
            const rect = userDropdownMenu.getBoundingClientRect();
            const isInDropdown = e.clientX >= rect.left && e.clientX <= rect.right && 
                                e.clientY >= rect.top && e.clientY <= rect.bottom;
            
            if (!isInDropdown) {
                setTimeout(() => {
                    if (!userDropdownMenu.matches(':hover')) {
                        userDropdownMenu.classList.add('hidden');
                    }
                }, 100);
            }
        });
        
        userDropdownMenu.addEventListener('mouseleave', function() {
            userDropdownMenu.classList.add('hidden');
        });
        
        // Fermer le menu déroulant lors du clic en dehors
        document.addEventListener('click', function() {
            userDropdownMenu.classList.add('hidden');
        });
    }
    
    // Support pour les menus déroulants dans l'interface admin (sans Alpine.js)
    document.querySelectorAll('.admin-dropdown-toggle').forEach(button => {
        const menu = button.nextElementSibling;
        
        if (menu && menu.classList.contains('admin-dropdown-menu')) {
            // Gestion du clic
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });
            
            // Gestion du survol
            button.addEventListener('mouseenter', function() {
                menu.classList.remove('hidden');
            });
            
            menu.addEventListener('mouseenter', function() {
                menu.classList.remove('hidden');
            });
            
            button.addEventListener('mouseleave', function() {
                setTimeout(() => {
                    if (!menu.matches(':hover')) {
                        menu.classList.add('hidden');
                    }
                }, 100);
            });
            
            menu.addEventListener('mouseleave', function() {
                menu.classList.add('hidden');
            });
            
            // Fermer le menu déroulant lors du clic en dehors
            document.addEventListener('click', function() {
                menu.classList.add('hidden');
            });
        }
    });
}

// Exécuter le code une fois que le DOM est complètement chargé
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM fully loaded');
        setupResponsiveNavbar();
    });
} else {
    // Le DOM est déjà chargé
    console.log('DOM already loaded');
    setupResponsiveNavbar();
}

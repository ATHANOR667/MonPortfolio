<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Category;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\Visitor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création de l'utilisateur administrateur
        $user = User::create([
            'name' => 'Admin',
            'email' => null,
            'password' => Hash::make('0000'),
            'email_verified_at' => now(),
        ]);

       /* // Création du profil
        $profile = Profile::create([
            'user_id' => $user->id,
            'full_name' => 'Jean Dupont',
            'title' => 'Développeur Web Full Stack',
            'bio' => 'Développeur passionné avec plus de 5 ans d\'expérience dans la création d\'applications web modernes et performantes. Spécialisé en PHP/Laravel, JavaScript et Vue.js.',
            'email' => 'contact@jeandupont.fr',
            'phone' => '+33 6 12 34 56 78',
            'location' => 'Paris, France',
            'website' => 'https://jeandupont.fr',
            'linkedin' => 'https://linkedin.com/in/jeandupont',
            'github' => 'https://github.com/jeandupont',
            'twitter' => 'https://twitter.com/jeandupont',
        ]);

        // Création des formations
        $educations = [
            [
                'profile_id' => $profile->id,
                'institution' => 'Université Paris-Saclay',
                'degree' => 'Master en Informatique',
                'field_of_study' => 'Développement Web et Mobile',
                'start_date' => '2015-09-01',
                'end_date' => '2017-06-30',
                'description' => 'Spécialisation en développement d\'applications web et mobiles. Projets réalisés avec diverses technologies modernes.',
            ],
            [
                'profile_id' => $profile->id,
                'institution' => 'IUT de Villetaneuse',
                'degree' => 'DUT Informatique',
                'field_of_study' => 'Programmation et Systèmes d\'Information',
                'start_date' => '2013-09-01',
                'end_date' => '2015-06-30',
                'description' => 'Formation généraliste en informatique avec une forte composante pratique et de nombreux projets en équipe.',
            ],
        ];

        foreach ($educations as $education) {
            Education::create($education);
        }

        // Création des expériences professionnelles
        $experiences = [
            [
                'profile_id' => $profile->id,
                'company' => 'TechInnovate',
                'position' => 'Développeur Full Stack Senior',
                'location' => 'Paris',
                'start_date' => '2020-03-01',
                'end_date' => null,
                'is_current' => true,
                'description' => 'Développement d\'applications web avec Laravel et Vue.js. Mise en place de CI/CD avec GitHub Actions. Optimisation des performances et de la sécurité.',
            ],
            [
                'profile_id' => $profile->id,
                'company' => 'WebSolutions',
                'position' => 'Développeur Back-end',
                'location' => 'Lyon',
                'start_date' => '2017-09-01',
                'end_date' => '2020-02-28',
                'is_current' => false,
                'description' => 'Développement d\'APIs RESTful avec Laravel. Intégration de systèmes de paiement. Mise en place de tests automatisés.',
            ],
            [
                'profile_id' => $profile->id,
                'company' => 'StartupVision',
                'position' => 'Développeur Web (Stage)',
                'location' => 'Paris',
                'start_date' => '2017-01-15',
                'end_date' => '2017-06-30',
                'is_current' => false,
                'description' => 'Développement front-end avec React. Intégration de maquettes. Optimisation pour mobile.',
            ],
        ];

        foreach ($experiences as $experience) {
            Experience::create($experience);
        }

        // Création des catégories
        $categories = [
            ['name' => 'Web', 'slug' => 'web'],
            ['name' => 'Mobile', 'slug' => 'mobile'],
            ['name' => 'API', 'slug' => 'api'],
            ['name' => 'E-commerce', 'slug' => 'e-commerce'],
            ['name' => 'UI/UX', 'slug' => 'ui-ux'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Création des projets
        $projects = [
            [
                'title' => 'E-commerce Responsive',
                'slug' => 'e-commerce-responsive',
                'description' => 'Plateforme e-commerce complète avec gestion des produits, panier, paiement et suivi de commandes.',
                'content' => "# E-commerce Responsive\n\nCe projet est une plateforme e-commerce complète développée avec Laravel et Vue.js. Elle offre une expérience utilisateur fluide sur tous les appareils.\n\n## Fonctionnalités\n\n- Catalogue de produits avec filtres avancés\n- Système de panier d'achat\n- Intégration de passerelles de paiement\n- Gestion des commandes et des livraisons\n- Espace client personnalisé\n- Tableau de bord administrateur\n\n## Technologies utilisées\n\n- Laravel 10\n- Vue.js 3\n- Tailwind CSS\n- MySQL\n- Stripe pour les paiements",
                'featured_image' => null,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'github_url' => 'https://github.com/jeandupont/ecommerce',
                'live_url' => 'https://ecommerce-demo.jeandupont.fr',
                'is_published' => true,
                'views' => 245,
            ],
            [
                'title' => 'Application Mobile de Fitness',
                'slug' => 'application-mobile-fitness',
                'description' => 'Application mobile pour suivre ses entraînements, sa nutrition et ses progrès fitness.',
                'content' => "# Application Mobile de Fitness\n\nCette application mobile permet aux utilisateurs de suivre leurs entraînements, leur nutrition et leurs progrès fitness.\n\n## Fonctionnalités\n\n- Suivi des entraînements avec plus de 100 exercices\n- Planification de programmes personnalisés\n- Suivi nutritionnel et calcul des macronutriments\n- Graphiques de progression\n- Synchronisation avec les appareils connectés\n\n## Technologies utilisées\n\n- React Native\n- Firebase\n- Redux\n- Node.js pour l'API backend\n- MongoDB",
                'featured_image' => null,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'github_url' => 'https://github.com/jeandupont/fitness-app',
                'live_url' => 'https://play.google.com/store/apps/details?id=com.jeandupont.fitnessapp',
                'is_published' => true,
                'views' => 187,
            ],
            [
                'title' => 'API RESTful pour Gestion de Tâches',
                'slug' => 'api-restful-gestion-taches',
                'description' => 'API RESTful complète pour une application de gestion de tâches avec authentification JWT.',
                'content' => "# API RESTful pour Gestion de Tâches\n\nCette API RESTful permet de gérer des tâches, des projets et des équipes avec une authentification sécurisée par JWT.\n\n## Fonctionnalités\n\n- Authentification et autorisation avec JWT\n- Gestion des utilisateurs et des rôles\n- CRUD complet pour les tâches, projets et équipes\n- Filtrage, tri et pagination des résultats\n- Documentation complète avec Swagger\n\n## Technologies utilisées\n\n- Laravel 10\n- MySQL\n- JWT pour l'authentification\n- PHPUnit pour les tests\n- Docker pour le déploiement",
                'featured_image' => null,
                'video_url' => null,
                'github_url' => 'https://github.com/jeandupont/task-api',
                'live_url' => 'https://api-docs.jeandupont.fr',
                'is_published' => true,
                'views' => 132,
            ],
            [
                'title' => 'Dashboard Analytics',
                'slug' => 'dashboard-analytics',
                'description' => 'Dashboard d\'analyse de données avec visualisations interactives et rapports personnalisables.',
                'content' => "# Dashboard Analytics\n\nCe dashboard d'analyse de données offre des visualisations interactives et des rapports personnalisables pour aider à la prise de décision.\n\n## Fonctionnalités\n\n- Visualisations de données interactives\n- Rapports personnalisables\n- Intégration de sources de données multiples\n- Export en PDF, CSV et Excel\n- Alertes et notifications\n\n## Technologies utilisées\n\n- Vue.js 3\n- D3.js pour les visualisations\n- Laravel pour l'API backend\n- PostgreSQL\n- Redis pour le cache",
                'featured_image' => null,
                'video_url' => null,
                'github_url' => 'https://github.com/jeandupont/analytics-dashboard',
                'live_url' => 'https://analytics-demo.jeandupont.fr',
                'is_published' => false,
                'views' => 0,
            ],
        ];

        foreach ($projects as $projectData) {
            $project = Project::create($projectData);
            
            // Associer des catégories aléatoires à chaque projet
            $categoryIds = Category::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();
            $project->categories()->attach($categoryIds);
        }

        // Création des commentaires
        $comments = [
            [
                'project_id' => 1,
                'name' => 'Sophie Martin',
                'email' => 'sophie.martin@example.com',
                'content' => 'Très beau projet ! J\'aime particulièrement l\'interface utilisateur qui est très intuitive.',
                'is_approved' => true,
            ],
            [
                'project_id' => 1,
                'name' => 'Thomas Bernard',
                'email' => 'thomas.bernard@example.com',
                'content' => 'Comment avez-vous géré les performances avec autant de produits ? Je suis impressionné par la rapidité du site.',
                'is_approved' => true,
            ],
            [
                'project_id' => 2,
                'name' => 'Julie Dubois',
                'email' => 'julie.dubois@example.com',
                'content' => 'J\'utilise votre application tous les jours, elle m\'a vraiment aidé à rester motivée dans mon parcours fitness !',
                'is_approved' => true,
            ],
            [
                'project_id' => 3,
                'name' => 'Alexandre Petit',
                'email' => 'alexandre.petit@example.com',
                'content' => 'La documentation de l\'API est très claire. J\'ai pu l\'intégrer facilement dans mon projet.',
                'is_approved' => true,
            ],
            [
                'project_id' => 1,
                'name' => 'Spammer',
                'email' => 'spam@example.com',
                'content' => 'Visitez mon site pour des offres incroyables ! www.spam-site.com',
                'is_approved' => false,
            ],
        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }

        // Création des messages de contact
        $contacts = [
            [
                'name' => 'Marie Leroy',
                'email' => 'marie.leroy@example.com',
                'subject' => 'Demande de collaboration',
                'message' => "Bonjour,\n\nJe suis directrice marketing chez TechSolutions et nous recherchons un développeur pour notre nouveau projet. Votre profil m'intéresse beaucoup.\n\nPourrions-nous discuter de cette opportunité ?\n\nCordialement,\nMarie Leroy",
                'is_read' => true,
                'replied_at' => now()->subDays(2),
            ],
            [
                'name' => 'Pierre Durand',
                'email' => 'pierre.durand@example.com',
                'subject' => 'Question sur votre projet E-commerce',
                'message' => "Bonjour Jean,\n\nJ'ai vu votre projet E-commerce et je suis très impressionné. J'aimerais savoir quelle solution de paiement vous avez utilisée et si vous recommanderiez cette approche pour un site de taille moyenne.\n\nMerci d'avance pour votre réponse,\nPierre",
                'is_read' => true,
                'replied_at' => now()->subDay(),
            ],
            [
                'name' => 'Emma Blanc',
                'email' => 'emma.blanc@example.com',
                'subject' => 'Demande de devis pour site web',
                'message' => "Bonjour,\n\nJe suis à la recherche d'un développeur pour créer un site web pour mon entreprise de décoration d'intérieur. Pourriez-vous me faire parvenir un devis ?\n\nVoici mes besoins :\n- Présentation de l'entreprise\n- Portfolio de réalisations\n- Formulaire de contact\n- Blog\n\nMerci,\nEmma Blanc",
                'is_read' => false,
                'replied_at' => null,
            ],
            [
                'name' => 'Lucas Moreau',
                'email' => 'lucas.moreau@example.com',
                'subject' => 'Conseils pour débutant en développement',
                'message' => "Bonjour Jean,\n\nJe suis étudiant en informatique et j'aimerais me spécialiser dans le développement web. Auriez-vous des conseils ou des ressources à me recommander pour bien débuter ?\n\nJ'hésite entre plusieurs technologies et votre parcours m'inspire beaucoup.\n\nMerci d'avance,\nLucas",
                'is_read' => false,
                'replied_at' => null,
            ],
        ];

        foreach ($contacts as $contactData) {
            $contact = Contact::create($contactData);
            
            // Ajouter des réponses pour les messages déjà répondus
            if ($contactData['replied_at']) {
                ContactReply::create([
                    'contact_id' => $contact->id,
                    'user_id' => $user->id,
                    'message' => "Bonjour " . explode(' ', $contactData['name'])[0] . ",\n\nMerci pour votre message. Je vous réponds dans les plus brefs délais après avoir étudié votre demande.\n\nCordialement,\nJean Dupont",
                ]);
            }
        }

        // Création des visiteurs
        $visitors = [
            [
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'page' => '/',
                'visited_at' => now()->subDays(5),
                'country' => 'France',
            ],
            [
                'ip_address' => '192.168.1.2',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15',
                'page' => '/projects',
                'visited_at' => now()->subDays(4),
                'country' => 'Belgium',
            ],
            [
                'ip_address' => '192.168.1.3',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
                'page' => '/projects/e-commerce-responsive',
                'visited_at' => now()->subDays(3),
                'country' => 'Switzerland',
            ],
            [
                'ip_address' => '192.168.1.4',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'page' => '/contact',
                'visited_at' => now()->subDays(2),
                'country' => 'Canada',
            ],
            [
                'ip_address' => '192.168.1.5',
                'user_agent' => 'Mozilla/5.0 (Linux; Android 11; SM-G991B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.120 Mobile Safari/537.36',
                'page' => '/',
                'visited_at' => now()->subDay(),
                'country' => 'United States',
            ],
            [
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'page' => '/projects/application-mobile-fitness',
                'visited_at' => now()->subHours(12),
                'country' => 'France',
            ],
            [
                'ip_address' => '192.168.1.6',
                'user_agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0',
                'page' => '/projects/api-restful-gestion-taches',
                'visited_at' => now()->subHours(6),
                'country' => 'Germany',
            ],
            [
                'ip_address' => '192.168.1.7',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'page' => '/contact',
                'visited_at' => now()->subHours(3),
                'country' => 'Spain',
            ],
            [
                'ip_address' => '192.168.1.8',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15',
                'page' => '/',
                'visited_at' => now()->subHour(),
                'country' => 'Italy',
            ],
            [
                'ip_address' => '192.168.1.9',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
                'page' => '/projects',
                'visited_at' => now()->subMinutes(30),
                'country' => 'United Kingdom',
            ],
        ];

        foreach ($visitors as $visitor) {
            Visitor::create($visitor);
        }*/
    }
}

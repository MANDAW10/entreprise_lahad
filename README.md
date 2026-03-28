# Lahad Enterprise — Site e-commerce

Site vitrine et boutique en ligne : viandes locales (poulet, caille, agneau), lait, yaourt, fromage, aliments bétail, poussins Goliath.

## Fonctionnalités

- **Site public** : Accueil, Produits, Contact, Panier (sauvegardé en localStorage), Compte client
- **Admin** : Dashboard, gestion produits (CRUD), catégories, commandes, statistiques et graphiques
- **Paiements** : Choix Stripe (Visa/Mastercard), PayPal, Wave, Orange Money (à configurer avec vos clés)
- **Comptes clients** : Inscription, connexion, historique et suivi des commandes
- **Stock** : Gestion automatique du stock à chaque commande

## Prérequis

- PHP 8.2+
- Composer
- SQLite (par défaut) ou PostgreSQL (pgAdmin)

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
```

### Base de données

**SQLite (par défaut)**  
Aucune config : le fichier `database/database.sqlite` est utilisé.

**PostgreSQL**  
Dans `.env` :

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=lahad_enterprise
DB_USERNAME=postgres
DB_PASSWORD=votre_mot_de_passe
```

Puis :

```bash
php artisan migrate --force
php artisan db:seed --force
```

## Lancer le site

```bash
php artisan serve
```

Ouvrir http://localhost:8000

- **Admin** : http://localhost:8000/admin  
  Compte par défaut après `db:seed` : **admin@lahad.com** / **password**

## Ajouter des produits ou catégories

- **Interface** : Connexion admin → Produits ou Catégories → Créer / Modifier.
- **Données** : Modifier `database/seeders/CategorySeeder.php` et `ProductSeeder.php`, puis `php artisan db:seed --force` (ou créer les enregistrements à la main dans l’admin).

## Paiements (production)

1. **Stripe** : Créer un compte Stripe, récupérer les clés et renseigner dans `.env` :  
   `STRIPE_KEY`, `STRIPE_SECRET`, `STRIPE_WEBHOOK_SECRET`
2. **PayPal** : Idem avec `PAYPAL_CLIENT_ID`, `PAYPAL_SECRET`, `PAYPAL_MODE`
3. **Wave / Orange Money** : Configurer selon les APIs officielles et activer dans `config/payments.php` / `.env`

Les moyens de paiement sont déjà proposés au checkout ; l’intégration réelle (redirections, webhooks) est à brancher avec les SDK respectifs.

## Stack

- Laravel 11, HTML/CSS/JS, PostgreSQL ou SQLite
- Stockage : produits, catégories, commandes, clients (users), lignes de commande (order_items)

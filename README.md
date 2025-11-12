# 🎬 Netflix Clone - TALL Stack + Filament

Aplikasi streaming video modern yang dibangun dengan **TALL Stack** (Tailwind CSS, Alpine.js, Laravel, Livewire) dan **Filament Admin Panel**, terintegrasi dengan **Midtrans** untuk sistem pembayaran.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel)
![Livewire](https://img.shields.io/badge/Livewire-3-4E56E6?style=flat-square&logo=livewire)
![Filament](https://img.shields.io/badge/Filament-3-0055CC?style=flat-square)
![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat-square&logo=php)
![Node.js](https://img.shields.io/badge/Node.js-22+-339933?style=flat-square&logo=node.js)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

---

## 📋 Daftar Isi

-   [Fitur Utama](#fitur-utama)
-   [Tech Stack](#tech-stack)
-   [Requirement](#requirement)
-   [Instalasi](#instalasi)
-   [Konfigurasi](#konfigurasi)
-   [Struktur Database](#struktur-database)
-   [Model & Relasi](#model--relasi)
-   [API & Usage](#api--usage)
-   [Development Roadmap](#development-roadmap)
-   [Contributing](#contributing)
-   [License](#license)

---

## 🎯 Fitur Utama

### 👥 User Management

-   ✅ Registrasi & Login dengan Email Verification
-   ✅ Two-Factor Authentication (2FA)
-   ✅ User Profile Management
-   ✅ Password Reset
-   ✅ Social Login Ready (Structure)

### 🎥 Content Management

-   ✅ Movie CRUD dengan Category/Genre
-   ✅ Multiple Video Quality (SD, HD, 4K)
-   ✅ Movie Rating & Reviews
-   ✅ Thumbnail & Poster Management
-   ✅ Video URL Management (S3 Ready)
-   ✅ Active/Inactive Status

### 💳 Subscription & Payment System

-   ✅ Multi-tier Subscription Plans (Basic, Premium, VIP)
-   ✅ Plan Features:
    -   Pricing & Duration Configuration
    -   Max Users per Plan
    -   Quality Limits (SD/HD/4K)
-   ✅ Midtrans Payment Gateway Integration
-   ✅ Payment Status Tracking (Pending, Settlement, Expire, Cancel)
-   ✅ Order Management
-   ✅ Invoice Generation (Ready)

### 👤 User Features

-   ✅ Watch History Tracking
-   ✅ Progress Saving (Resume Watch)
-   ✅ Favorite Movies Management
-   ✅ Personalized Recommendations (Ready)
-   ✅ Continue Watching Section
-   ✅ Movie Search & Filter

### 📊 Admin Dashboard (Filament)

-   ✅ Dashboard Analytics & Statistics
-   ✅ Movie Management Interface
-   ✅ Category/Genre Management
-   ✅ Subscription Plans Configuration
-   ✅ User Management & Permissions
-   ✅ Payment Orders Tracking
-   ✅ Revenue Reports
-   ✅ Role-Based Access Control (RBAC)
-   ✅ Activity Logs

### 🔍 Advanced Query Features

-   ✅ Spatie Query Builder Integration dengan performance optimization
-   ✅ Advanced Filtering & Sorting dengan type-safe queries
-   ✅ Pagination Ready dengan cursor pagination
-   ✅ API Resource Format dengan caching
-   ✅ Lazy eager loading support

---

## 🛠️ Tech Stack

### Backend

-   **Laravel 12** - Modern Web Framework dengan fitur terbaru (Unified action model, async model caching, view attributes)
-   **Livewire 3** - Full-stack reactive components dengan Volt
-   **Filament 3** - Admin Panel yang powerful & modern dengan table builder
-   **PHP 8.3+** - Latest PHP dengan typed properties, readonly classes, attributes
-   **Laravel Reverb** - Real-time WebSocket support (built-in)
-   **Herd/Laravel Pail** - Development tools terbaru untuk log management

### Frontend

-   **Tailwind CSS 4** - Utility-first CSS framework terbaru dengan performa lebih baik
-   **Alpine.js 3.x** - Lightweight reactive JavaScript dengan plugin system
-   **Blade** - Modern templating engine dengan anonymous components
-   **Vite 6** - Next-gen frontend build tooling dengan HMR lebih cepat

### Database

-   **MySQL 8.0+** - Relational Database dengan JSON support
-   **Laravel Eloquent ORM** - Query Builder modern dengan lazy eager loading
-   **Laravel Migrations** - Schema builder terbaru

### Additional Libraries

-   **Spatie Query Builder** - Advanced filtering & sorting dengan performance
-   **Spatie Permissions** - Role & Permission Management dengan caching
-   **Spatie MediaLibrary** - File Management modern
-   **Laravel Fortify** - Authentication scaffolding modern
-   **Midtrans SDK** - Payment Gateway integration
-   **Pest** - Modern testing framework dengan syntax clean
-   **Laravel Pulse** - Real-time application monitoring (baru di Laravel 12)
-   **PestPHP** - Testing framework modern

---

## 📦 Requirement

-   **PHP** 8.3 atau lebih tinggi (dengan extensions: curl, mbstring, openssl, json)
-   **Composer** 2.8+
-   **Node.js** 22+ & **npm** 11+
-   **MySQL** 8.0+ atau MariaDB 10.8+
-   **Git** terbaru
-   **Midtrans Account** (untuk payment gateway)
-   **Herd** atau **Docker** (optional, recommended untuk development)

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/yourusername/netflix-clone.git
cd netflix-clone
```

### 2. Install Dependencies

```bash
# Install PHP Dependencies
composer install

# Install Node Dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

```bash
# Run migrations
php artisan migrate

# (Optional) Run seeders
php artisan db:seed
```

### 5. Build Assets

```bash
# Development dengan HMR (Hot Module Replacement)
npm run dev

# Production
npm run build

# Production dengan minification
npm run build -- --minify
```

### 6. Symlink Storage (jika diperlukan)

```bash
php artisan storage:link
```

### 7. Run Development Server

```bash
# Using Laravel Herd (recommended)
herd open

# Or traditional way
php artisan serve

# With Reverb (untuk WebSocket real-time)
php artisan reverb:start
```

Server akan berjalan di `http://localhost:8000` atau sesuai Herd configuration

---

## ⚙️ Konfigurasi

### .env Configuration

```env
# Application
APP_NAME="Netflix Clone"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=netflix_clone
DB_USERNAME=root
DB_PASSWORD=

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password

# Midtrans Payment Gateway
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false

# Storage (S3 untuk production)
FILESYSTEM_DISK=local
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_URL=
AWS_ENDPOINT=
AWS_USE_PATH_STYLE_ENDPOINT=false

# Laravel Reverb (WebSocket real-time)
REVERB_APP_ID=your_app_id
REVERB_APP_KEY=your_app_key
REVERB_APP_SECRET=your_app_secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
```

### Laravel 12 Fitur Terbaru

```env
# Laravel Pulse (Monitoring real-time)
PULSE_ENABLED=true
PULSE_INGEST_ROUTE_MIDDLEWARE=
PULSE_STORAGE_DRIVER=database

# Unified action model
ACTION_MIDDLEWARE=throttle:60,1

# Async model caching
MODEL_CACHE_ENABLED=true
MODEL_CACHE_DRIVER=redis
```

### Konfigurasi Database

Buat database baru di MySQL:

```sql
CREATE DATABASE netflix_clone CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Midtrans Setup

1. Login ke [Midtrans Dashboard](https://dashboard.midtrans.com)
2. Ambil **Server Key** dan **Client Key**
3. Masukkan ke `.env` file

---

## 📊 Struktur Database

### Entity Relationship Diagram

```
┌─────────────┐
│    users    │
└──────┬──────┘
       │
       ├──→ user_subscriptions
       ├──→ watch_histories
       ├──→ favorites
       └──→ payment_orders

┌──────────────────┐
│ subscription_plans│
└──────┬───────────┘
       │
       ├──→ user_subscriptions
       └──→ payment_orders

┌──────────────┐
│  categories  │
└──────┬───────┘
       │
       └──→ movies

┌────────────┐
│   movies   │
└──────┬─────┘
       │
       ├──→ watch_histories
       └──→ favorites
```

### Tables Overview

| Table                | Purpose              | Key Fields                                           |
| -------------------- | -------------------- | ---------------------------------------------------- |
| `users`              | User accounts        | id, name, email, password                            |
| `categories`         | Movie categories     | id, name, slug, description                          |
| `movies`             | Movie content        | id, title, slug, category_id, rating, is_premium     |
| `subscription_plans` | Subscription tiers   | id, name, price, duration_days, quality              |
| `user_subscriptions` | User subscriptions   | user_id, subscription_plan_id, start_date, end_date  |
| `watch_histories`    | Watch tracking       | user_id, movie_id, progress_percent, last_watched_at |
| `favorites`          | Favorite movies      | user_id, movie_id                                    |
| `payment_orders`     | Payment transactions | order_id, user_id, amount, status, transaction_id    |

---

## 🧩 Model & Relasi

### User Model

```php
// Relationships
$user->subscriptions()           // HasMany UserSubscription
$user->activeSubscriptions()     // HasMany (Valid only)
$user->watchHistories()          // HasMany WatchHistory
$user->watchedMovies()           // BelongsToMany Movie
$user->favoriteMovies()          // BelongsToMany Movie
$user->favorites()               // HasMany Favorite
$user->paymentOrders()           // HasMany PaymentOrder

// Methods
$user->currentSubscription()     // Get active subscription
$user->hasActiveSubscription()   // Check subscription status
$user->canAccessPremiumMovies()  // Check premium access
```

### Movie Model

```php
// Relationships
$movie->category()               // BelongsTo Category
$movie->watchHistories()         // HasMany WatchHistory
$movie->favorites()              // HasMany Favorite
$movie->favoritedBy()            // BelongsToMany User
$movie->watchedBy()              // BelongsToMany User

// Query Builder Scopes
Movie::active()                  // Filter active movies
Movie::premium()                 // Filter premium movies
Movie::free()                    // Filter free movies
Movie::mostWatched()             // Order by watch count
Movie::mostFavorited()           // Order by favorite count
Movie::minimumRating(8.0)        // Filter by minimum rating
```

### UserSubscription Model

```php
// Relationships
$subscription->user()            // BelongsTo User
$subscription->subscriptionPlan() // BelongsTo SubscriptionPlan
$subscription->paymentOrder()    // BelongsTo PaymentOrder

// Methods
$subscription->isExpired()       // Check if expired
$subscription->isValid()         // Check if active & not expired
$subscription->daysRemaining()   // Get days left

// Query Scopes
UserSubscription::valid()        // Active & not expired
UserSubscription::expired()      // Expired only
UserSubscription::expiringWithinDays(7) // Expiring soon
```

### Other Models

-   **Category** - Movie categories with active movie filter
-   **SubscriptionPlan** - Subscription configuration
-   **WatchHistory** - User watch tracking
-   **Favorite** - User favorites
-   **PaymentOrder** - Payment transactions

---

## 📡 API & Usage

### Query Builder Examples

#### Movies

```php
// Get all active movies with filters
use Spatie\QueryBuilder\QueryBuilder;

$movies = Movie::applyQueryBuilder()
    ->get();

// Using filters & sorts
$movies = Movie::applyQueryBuilder()
    ->filter([
        'title' => 'Action',
        'min_rating' => 8.0,
        'is_premium' => true,
        'sort' => '-rating'
    ])
    ->paginate(15);
```

#### Subscriptions

```php
// Get user's valid subscriptions
$subscriptions = UserSubscription::applyQueryBuilder()
    ->filter([
        'user_id' => auth()->id(),
        'status' => 'valid'
    ])
    ->get();

// Get expired subscriptions
$expired = UserSubscription::query()
    ->expired()
    ->get();
```

#### Users

```php
// Get active users with subscriptions
$activeUsers = User::applyQueryBuilder()
    ->filter([
        'has_subscription' => true,
        'email_verified' => true
    ])
    ->paginate(50);
```

### Scope Examples

```php
// Watch History
$user->watchHistories()->continueWatching()->get();
$movie->watchHistories()->finished()->count();

// Favorites
$user->favorites()->orderByCreated('desc')->get();

// Payment Orders
PaymentOrder::settled()->recent(30)->sum('amount');
PaymentOrder::pending()->where('user_id', $userId)->get();

// Subscriptions
$user->subscriptions()->expiringWithinDays(7)->get();
```

### Filament Resource Examples

```php
// Access admin panel
// URL: /admin
// Login dengan user yang memiliki role admin

// Resources Available:
- Movies Management
- Categories Management
- Subscription Plans
- Users Management
- Payment Orders
- Subscription Tracking
```

---

## 🗂️ Struktur Folder

```
netflix-clone/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Movie.php
│   │   ├── Category.php
│   │   ├── SubscriptionPlan.php
│   │   ├── UserSubscription.php
│   │   ├── WatchHistory.php
│   │   ├── Favorite.php
│   │   └── PaymentOrder.php
│   ├── Http/
│   │   └── Controllers/
│   ├── Livewire/
│   │   └── [Livewire Components]
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   ├── FortifyServiceProvider.php
│   │   └── VoltServiceProvider.php
│   └── Services/
│       └── MidtransService.php
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
│   ├── web.php
│   └── console.php
├── tests/
│   ├── Feature/
│   └── Unit/
├── .env.example
├── composer.json
├── package.json
├── phpunit.xml
├── vite.config.js
└── README.md
```

---

## 🚀 Laravel 12 Fitur Terbaru yang Digunakan

### Unified Action Model

```php
// Action dirancang untuk menangani business logic
// app/Actions/ProcessMovieUpload.php
use Illuminate\Foundation\Attributes\AsAction;

#[AsAction]
class ProcessMovieUpload
{
    public function handle(Movie $movie, UploadedFile $file): void
    {
        // Logic implementation
    }
}
```

### Async Model Caching

```php
// Automatic caching untuk model queries
// Diaktifkan di config/cache.php
$movie = Movie::find(1); // Cache otomatis
```

### Lazy Eager Loading

```php
// Load relations secara lazy untuk performance
$users = User::all();
$favorites = $users->lazy()->loadMissing('favorites');
```

### Type-safe Eloquent

```php
// Automatic type inference
$user = User::find(1); // return User|null (type-safe)
$movies = Movie::where('rating', '>', 8)->get(); // return Collection<Movie>
```

### Built-in Reverb WebSocket

```php
// Real-time features tanpa library tambahan
// Broadcasting built-in
class MovieRating implements ShouldBroadcast
{
    public function broadcastOn(): array
    {
        return [new Channel('movies')];
    }
}
```

### Laravel Pulse

```php
// Real-time application monitoring
// Akses di /pulse
// Monitoring: requests, slow queries, exceptions, queue jobs
```

---

## 📈 Development Roadmap

### Phase 1: Foundation ✅ (Current)

-   [x] Project Setup (TALL Stack + Filament)
-   [x] Database Design & Migrations
-   [x] Model Creation with Relations
-   [x] Basic Admin Panel
-   [x] User Authentication

### Phase 2: Core Features (Next)

-   [ ] **Frontend UI Components**

    -   [ ] Movie Listing Page
    -   [ ] Movie Detail & Player
    -   [ ] User Dashboard
    -   [ ] Profile Page
    -   [ ] Search & Filter UI

-   [ ] **Livewire Components**

    -   [ ] MovieCard Component
    -   [ ] WatchPlayer Component
    -   [ ] FavoriteToggle Component
    -   [ ] ContinueWatchingList Component
    -   [ ] SearchFilter Component

-   [ ] **API Endpoints (REST/GraphQL)**
    -   [ ] Movie API (List, Detail, Search, Filter)
    -   [ ] User Profile API
    -   [ ] Watch History API
    -   [ ] Favorite API
    -   [ ] Subscription API

### Phase 3: Payment Integration

-   [ ] **Midtrans Integration**

    -   [ ] Payment Page UI
    -   [ ] Order Processing
    -   [ ] Webhook Handling
    -   [ ] Invoice Generation
    -   [ ] Payment Receipt Email

-   [ ] **Subscription Management**

    -   [ ] Auto-renewal Configuration
    -   [ ] Subscription Upgrade/Downgrade
    -   [ ] Plan Comparison
    -   [ ] Cancellation Request

-   [ ] **Premium Features**
    -   [ ] Quality Selection (SD/HD/4K)
    -   [ ] Multi-device Streaming
    -   [ ] Offline Download (Optional)
    -   [ ] Ad-free Streaming

### Phase 4: Advanced Features

-   [ ] **Recommendations Engine**

    -   [ ] ML-based Recommendations
    -   [ ] Trending Movies
    -   [ ] Similar Movies
    -   [ ] Personalized Homepage

-   [ ] **Social Features**

    -   [ ] Movie Reviews & Ratings
    -   [ ] Comment System
    -   [ ] Share Movies
    -   [ ] Watchlist

-   [ ] **Analytics**

    -   [ ] User Activity Analytics
    -   [ ] Revenue Analytics
    -   [ ] Content Performance Metrics
    -   [ ] User Retention Metrics

-   [ ] **Admin Enhancements**
    -   [ ] Advanced Analytics Dashboard
    -   [ ] Bulk Operations
    -   [ ] Custom Reports
    -   [ ] User Support Ticket System

### Phase 5: Performance & Optimization

-   [ ] **Caching Strategy**

    -   [ ] Redis Integration
    -   [ ] Query Caching
    -   [ ] View Caching
    -   [ ] API Response Caching

-   [ ] **Optimization**

    -   [ ] Database Indexing
    -   [ ] Query Optimization
    -   [ ] Image Optimization
    -   [ ] Lazy Loading

-   [ ] **CDN Integration**
    -   [ ] CloudFlare Integration
    -   [ ] Media CDN (for videos)
    -   [ ] Static Asset CDN

### Phase 6: Deployment & DevOps

-   [ ] **Infrastructure**

    -   [ ] Docker Configuration
    -   [ ] CI/CD Pipeline (GitHub Actions)
    -   [ ] Environment Configuration
    -   [ ] Database Backup Strategy

-   [ ] **Monitoring**

    -   [ ] Error Tracking (Sentry)
    -   [ ] Performance Monitoring
    -   [ ] Uptime Monitoring
    -   [ ] Log Management

-   [ ] **Security**
    -   [ ] HTTPS/SSL
    -   [ ] Rate Limiting
    -   [ ] DDoS Protection
    -   [ ] Security Headers

---

## ⚡ Performance & Optimization Tips (Laravel 12)

### Query Optimization

```php
// ❌ Avoid N+1 queries
$users = User::all();
foreach ($users as $user) {
    echo $user->subscriptions; // N queries
}

// ✅ Use eager loading
$users = User::with('subscriptions')->get();
foreach ($users as $user) {
    echo $user->subscriptions; // 1 query
}

// ✅ Use lazy eager loading
$users = User::all();
$subscriptions = $users->lazy()->loadMissing('subscriptions');
```

### Caching Strategy

```php
// Laravel 12 automatic model caching
$movie = cache()->remember("movie.{$id}", 3600, function () {
    return Movie::find($id);
});

// Atau gunakan model caching otomatis
$movie = Movie::find($id); // cached automatically
```

### Database Indexing

```php
// Migrations dengan index optimal
Schema::create('movies', function (Blueprint $table) {
    $table->id();
    $table->string('title')->index();
    $table->unsignedBigInteger('category_id')->index();
    $table->decimal('rating', 3, 1)->index();
    $table->boolean('is_active')->index();
    // Compound index untuk query sering
    $table->index(['category_id', 'is_active']);
});
```

### Async Processing dengan Queue

```php
// Heavy operations dijalankan async
class ProcessVideoUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Video processing logic
    }
}

// Dispatch async
ProcessVideoUpload::dispatch($video);
```

---

## 🔧 Development Commands

### Database

```bash
# Create migrations
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh migration (wipe & migrate)
php artisan migrate:fresh --seed
```

### Models & Resources

```bash
# Create model with migration
php artisan make:model ModelName -m

# Create Filament resource
php artisan make:filament-resource ResourceName

# Create Livewire component (Volt)
php artisan make:volt pages/ComponentName
```

### Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/MovieTest.php

# Run tests with coverage
php artisan test --coverage
```

### Code Quality

```bash
# Run static analysis (if configured)
./vendor/bin/phpstan analyze

# Format code
./vendor/bin/pint

# Fix Laravel insights issues
php artisan insights --fix
```

### Cache & Queue

```bash
# Clear all cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# View queue jobs
php artisan queue:work
```

---

## 🔐 Security Features (Laravel 12 Enhanced)

-   ✅ **Authentication**: Email verification, Password hashing, 2FA dengan rate limiting
-   ✅ **Authorization**: Role-based access control (RBAC) dengan caching
-   ✅ **API Protection**: CSRF protection, Rate limiting dengan sliding window
-   ✅ **Payment Security**: Midtrans secure integration dengan webhook validation
-   ✅ **Data Protection**: SQL injection prevention, XSS protection, CSRF tokens
-   ✅ **Session Management**: Secure session handling dengan encryption
-   ✅ **Laravel Pulse**: Real-time security monitoring
-   ✅ **Type Safety**: Type-safe queries mencegah injection attacks

---

## 📝 Testing (Pest Framework)

### Test Coverage

```bash
# Feature Tests
tests/Feature/
├── MovieTest.php
├── SubscriptionTest.php
├── UserSubscriptionTest.php
├── PaymentTest.php
└── AuthenticationTest.php

# Unit Tests
tests/Unit/
├── Models/
├── Services/
└── Helpers/
```

### Run Tests

```bash
# Run all tests dengan Pest
php artisan test

# Run tests dengan coverage report
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/MovieTest.php

# Watch mode (auto-run tests)
php artisan test --watch

# Parallel testing (lebih cepat)
php artisan test --parallel
```

### Example Pest Test

```php
// tests/Feature/MovieTest.php
test('can filter active movies', function () {
    Movie::factory()->create(['is_active' => true]);
    Movie::factory()->create(['is_active' => false]);

    $movies = Movie::active()->get();

    expect($movies)->toHaveCount(1)
        ->first()->is_active->toBeTrue();
});
```

---

## 🐛 Troubleshooting

### Common Issues

**Issue: Database connection error**

```bash
# Solusi: Pastikan .env sudah dikonfigurasi benar
php artisan config:clear
php artisan cache:clear
```

**Issue: Livewire component tidak update**

```bash
# Solusi: Clear semua cache
php artisan livewire:publish --assets
npm run build
```

**Issue: Storage not writable**

```bash
# Solusi: Set permissions
chmod -R 775 storage bootstrap/cache
```

**Issue: Midtrans payment error**

```bash
# Solusi: Pastikan Server Key & Client Key benar di .env
# Check Midtrans mode (sandbox/production)
```

---

## 📞 Support & Contribution

### Reporting Issues

Please create an issue di GitHub dengan detail:

-   Description masalah
-   Steps to reproduce
-   Expected vs actual behavior
-   Screenshot/Error log

### Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## 👨‍💻 Author

**Your Name**

-   GitHub: [@yourusername](https://github.com/yourusername)
-   Email: your.email@example.com

---

## 🙏 Acknowledgments

-   [Laravel](https://laravel.com)
-   [Livewire](https://livewire.laravel.com)
-   [Filament](https://filamentphp.com)
-   [Tailwind CSS](https://tailwindcss.com)
-   [Midtrans](https://midtrans.com)
-   [Spatie](https://spatie.be)

---

## 📚 Useful Resources

### Documentation

-   [Laravel Documentation](https://laravel.com/docs)
-   [Livewire Documentation](https://livewire.laravel.com/docs)
-   [Filament Documentation](https://filamentphp.com/docs)
-   [Tailwind CSS Docs](https://tailwindcss.com/docs)

### Tutorials

-   [Laravel by Taylor Otwell](https://laracasts.com)
-   [Filament Admin](https://filamentphp.com)
-   [TALL Stack Guide](https://tallstack.dev)

### Community

-   [Laravel Discussions](https://laravel.com/community)
-   [Livewire Discord](https://discord.gg/livewire)
-   [Laravel Reddit](https://reddit.com/r/laravel)

---

**Last Updated**: November 12, 2025  
**Version**: 1.0.0 (In Development)  
**Laravel Version**: 12 (Latest)  
**PHP Version**: 8.3+  
**Node.js Version**: 22+

---

## 🎯 Tech Stack Status

| Technology   | Version | Status            |
| ------------ | ------- | ----------------- |
| Laravel      | 12      | ✅ Latest         |
| Livewire     | 3       | ✅ Latest         |
| Filament     | 3       | ✅ Latest         |
| Tailwind CSS | 4       | ✅ Latest         |
| Alpine.js    | 3.x     | ✅ Latest         |
| PHP          | 8.3+    | ✅ Latest         |
| Node.js      | 22+     | ✅ Latest         |
| Vite         | 6       | ✅ Latest         |
| Pest         | Latest  | ✅ Modern Testing |

---

## 🚀 Getting Started Checklist

-   [ ] Clone repository
-   [ ] Copy `.env.example` to `.env`
-   [ ] Run `composer install`
-   [ ] Run `npm install`
-   [ ] Generate app key: `php artisan key:generate`
-   [ ] Create database
-   [ ] Run migrations: `php artisan migrate`
-   [ ] Configure Midtrans keys in `.env`
-   [ ] Run `npm run dev`
-   [ ] Run `php artisan serve` atau `herd open`
-   [ ] Visit http://localhost:8000
-   [ ] Access admin panel at http://localhost:8000/admin
-   [ ] Login dengan credentials dari seeder
-   [ ] Explore Laravel Pulse di http://localhost:8000/pulse
-   [ ] Start building awesome features! 🚀

---

## 📚 Laravel 12 Learning Resources

### Official Documentation

-   [Laravel 12 Docs](https://laravel.com/docs/12.x)
-   [Laravel Reverb Docs](https://laravel.com/docs/12.x/reverb)
-   [Laravel Pulse Docs](https://laravel.com/docs/12.x/pulse)

### Video Tutorials

-   [Laravel 12 Course - Laracasts](https://laracasts.com)
-   [TALL Stack Guide](https://tallstack.dev)
-   [Filament v3 Series](https://filamentphp.com)

### Community Resources

-   [Laravel News](https://laravel-news.com)
-   [Spatie Blog](https://spatie.be/blog)
-   [Laravel Discord](https://discord.gg/laravel)

---

## 🌟 Highlights - Why Laravel 12?

1. **Type Safety** - Reduce bugs dengan type hints
2. **Performance** - Model caching otomatis & lazy loading
3. **Developer Experience** - Syntax bersih dan readable
4. **Built-in WebSocket** - Reverb untuk real-time features
5. **Monitoring** - Laravel Pulse untuk production insights
6. **Security** - Enterprise-grade security features
7. **Scalability** - Siap untuk aplikasi dengan jutaan users
8. **Community** - Ekosistem terbesar di PHP

---

Happy Coding! 🎉

Stay updated dengan perkembangan terbaru di [Laravel Blog](https://blog.laravel.com)

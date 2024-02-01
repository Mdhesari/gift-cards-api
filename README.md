# Gift Card Management System

A scalable and efficient system for managing gift cards, allowing users to check their wallet balance, view transactions, and submit gift cards.

## Installation

Follow these steps to set up the Gift Card Management System:

```zsh
# Clone the repository
git clone https://github.com/mdhesari/gift-cards-api.git
cd gift-card-system

# Configure environment variables
cp .env.example .env
php artisan key:generate

# Packages
composer install

# Docker
./vendor/bin/sail up -d

# Tests
php artisan test

# Migrations
php artisan migrate
```

# Laravel Project Setup Guide

This guide will help you set up this Laravel project from GitHub to your local development environment.

## Prerequisites

Make sure you have the following installed:

- PHP >= 8.1
- Composer
- Laravel CLI (optional)
- MySQL or any other database supported by Laravel
- Node.js & NPM (for frontend assets, if applicable)

## Steps to Setup

### 1. Clone the Repository

```bash
git clone https://github.com/BhargavKhandar/interview-task.git
cd interview-task

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate
# Optional
php artisan db:seed

npm install
npm run dev
# or for production build
npm run build

php artisan serve

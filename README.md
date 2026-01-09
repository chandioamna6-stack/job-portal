<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/chandioamna6-stack/job-portal/actions"><img src="https://github.com/chandioamna6-stack/job-portal/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/license-MIT-brightgreen" alt="License"></a>
</p>

# Job Portal

A **Laravel-based Job Portal** web application allowing job seekers to find jobs and employers to post them. Includes full user authentication, job applications, admin panel, messaging, notifications, payments, and resume uploads.

---

## Project Phases & Features

### Phase 1: User Authentication
- Job Seeker Registration/Login (separate role from Employer)  
- Employer Registration/Login  
- Dashboard redirects based on role  
- Profile management page  

### Phase 2: Job Listings
- Job model, migration, and controller  
- Employer “Post Job” form  
- Job listing page (search & filter)  
- Featured jobs display on homepage  

### Phase 3: Job Applications
- Application model and migration  
- Job seeker “Apply Now” functionality (resume upload)  
- Application status tracking for job seekers  
- Employer view of applicants  

### Phase 4: Admin Panel
- Admin dashboard  
- Approve/reject job posts  
- User management (view/edit/delete users)  
- Analytics overview  

### Phase 5: Messaging & Notifications
- Messaging system (job seeker ↔ employer)  
- Notifications for job applications, responses, and updates  

### Phase 6: Payments & Premium Jobs
- Payment integration (Stripe/PayPal)  
- Premium job posting feature  

### Phase 7: Resume Uploads
- File upload functionality (PDF, DOCX)  
- Link resumes to user profiles and applications  

---

## Tech Stack

- **Backend:** Laravel PHP Framework  
- **Database:** MySQL  
- **Frontend:** Blade Templates, HTML, CSS, JS  
- **Tools:** XAMPP / Apache, Composer, npm  

---

## Installation & Setup

```bash
# Clone the repository
git clone https://github.com/chandioamna6-stack/job-portal.git

# Navigate to the project folder
cd JobPortal



composer install

# Install Node dependencies (for frontend assets)
npm install

# Copy .env.example to .env and configure your database
cp .env.example .env

# Generate Laravel application key
php artisan key:generate

# Run migrations
php artisan migrate

# Compile frontend assets (optional)
npm run dev

# Start the local server
php artisan serve
Open http://localhost:8000 in your browser

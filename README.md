<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/chandioamna6-stack/job-portal/actions">
    <img src="https://github.com/chandioamna6-stack/job-portal/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://opensource.org/licenses/MIT">
    <img src="https://img.shields.io/badge/license-MIT-brightgreen" alt="License">
  </a>
</p>

# Job Portal

A **Laravel-based Job Portal** web application allowing job seekers to find jobs and employers to post them. Includes full user authentication, job applications, admin panel, messaging, notifications, payments, and resume uploads.

<p align="center">
  <a href="https://github.com/user-attachments/assets/fc50da27-7fec-4df0-a2cc-f55ba58503d7" target="_blank">
    <strong>🎥 Watch Video Demo</strong>
  </a>
</p>

---

## 📸 Application Preview

<img width="1343" height="896" alt="Screenshot 2026-01-09 215326" src="https://github.com/user-attachments/assets/1e635b48-289b-451f-9365-9228127b3722" />

<img width="1343" height="870" alt="Screenshot 2026-01-09 215725" src="https://github.com/user-attachments/assets/485d52ee-e045-404b-bbaf-65985aa7dcd0" />

<img width="1343" height="888" alt="Screenshot 2026-01-09 215411" src="https://github.com/user-attachments/assets/6ed02116-9c2b-48f0-aae5-787a887bd770" />

<img width="1347" height="876" alt="Screenshot 2026-01-09 215532" src="https://github.com/user-attachments/assets/bb1b9e47-4bf6-4d0f-969a-6cdf6acd0c17" />

<img width="1353" height="487" alt="Screenshot 2026-01-09 215628" src="https://github.com/user-attachments/assets/d01bb147-ced5-4c8d-97ea-7b2a91bcddd3" />

<img width="1321" height="871" alt="Screenshot 2026-01-09 215801" src="https://github.com/user-attachments/assets/86e1f199-54f2-4cc5-8d6c-dacfae6d5dd6" />


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
- Application status tracking
- Employer view of applicants

### Phase 4: Admin Panel
- Admin dashboard
- Approve/reject job posts
- User management (view/edit/delete users)
- Analytics overview

### Phase 5: Messaging & Notifications
- Messaging system (job seeker ↔ employer)
- Notifications for job applications and responses

### Phase 6: Payments & Premium Jobs
- Payment integration (Stripe/PayPal)
- Premium job postings

### Phase 7: Resume Uploads
- Resume upload (PDF, DOCX)
- Resume linked to profile and applications

---

## Tech Stack

- **Backend:** Laravel
- **Database:** MySQL
- **Frontend:** Blade, HTML, CSS, JavaScript
- **Tools:** XAMPP, Composer, npm

---

## Installation & Setup

```bash
git clone https://github.com/chandioamna6-stack/job-portal.git
cd JobPortal

composer install
npm install

cp .env.example .env
php artisan key:generate
php artisan migrate

npm run dev
php artisan serve
Open http://localhost:8000 in your browser.

# Task Manager Application

This is a simple Task Manager application built with Laravel (backend) and Vue.js (frontend). It allows users to create projects and tasks, manage their status, and assign tasks to team members.

---

## Requirements

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL or SQLite (or any database supported by Laravel)

---

## Installation

1. **Clone the repository:**

```bash
git clone https://github.com/yourusername/Task-Management-Application
cd Task-Management-Application

cp .env.example .env

2. **Update your database credentials and other necessary environment variables in**
.env


3. **Run database migrations:**
php artisan migrate

4.**Install frontend dependencies:**
npm install

5. **Run the development server:**
php artisan serve
npm run dev

Notes:
Make sure to configure your API base URL in the .env file.

Example:

VITE_API_BASE_URL=http://127.0.0.1:8000/api


⚠️ If endpoints are not working, update VITE_API_BASE_URL to match your backend server address.
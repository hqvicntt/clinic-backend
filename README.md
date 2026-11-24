# 🏥 MedCare Hospital - Clinic Management Backend & Web Admin

A comprehensive RESTful API backend and Web Administration Dashboard built with **Laravel 12** and **MySQL** for the **MedCare Hospital** mobile healthcare application (CT484 - Mobile Application Development Project).

---

## ✨ Key Features

### 🔐 Authentication & Account Management (Laravel Sanctum)

- **Patient Registration & Login:** Token-based authentication (`Bearer Token`).
- **Forgot Password via OTP:** Secure 6-digit OTP generation with a 5-minute expiration window (`password_otps`) and password reset workflow.
- **Profile & Security:** View/update personal profile information and change password with automatic token revocation.

### 📅 Appointment & Medical Records System

- **Doctor & Specialty Directory:** Public endpoints to browse doctors filtered by medical specialties.
- **Appointment Booking & Cancellation:** Patients can book appointments by date/time slot and cancel pending/approved bookings with ownership verification.
- **Nested Eager Loading:** Single-query retrieval of patient appointments bundled with doctor details, medical diagnosis (`medical_records`), and prescribed medications (`medicines` via pivot table).

### 🖥️ Web Administration Dashboard (Blade + Bootstrap 5)

- **Role-Based Access Control:** Dedicated admin login portal protected by middleware (`role === 'admin'`).
- **Appointment Workflow:** Real-time dashboard statistics, approve or cancel incoming patient requests, and complete examinations with a diagnosis & prescription modal.

---

## 🛠️ Tech Stack

- **Framework:** Laravel 12 (PHP 8.2+)
- **Database:** MySQL 8.0
- **Authentication:** Laravel Sanctum (API Tokens) & Session Guard (Web Admin)
- **Frontend (Admin):** Blade Templates, Bootstrap 5.3
- **Deployment:** Railway Cloud Platform (Auto-deploy via GitHub & `Procfile`)

---

## 🗄️ Database Schema Overview

- `users`: Stores patient and admin accounts (`id`, `name`, `email`, `password`, `phone`, `role`).
- `specialties`: Medical departments (`id`, `name`, `description`).
- `doctors`: Doctor profiles linked to specialties (`id`, `specialty_id`, `name`, `avatar`, `schedule`, `is_active`).
- `appointments`: Booking records (`id`, `user_id`, `doctor_id`, `appointment_date`, `appointment_time`, `symptoms`, `status`, `cancellation_reason`).
- `medical_records`: Examination diagnosis and doctor notes (`id`, `appointment_id`, `diagnosis`, `doctor_notes`).
- `medicines`: Medication catalog (`id`, `name`, `brand`, `description`, `dosage_form`).
- `appointment_medicine`: Pivot table linking prescriptions and dosages (`appointment_id`, `medicine_id`, `dosage`).
- `password_otps`: Temporary 6-digit OTP codes for password recovery (`email`, `otp`, `expires_at`).

---

## 🔌 API Endpoints Reference

### Public Routes

| Method | Endpoint               | Description                              |
| :----- | :--------------------- | :--------------------------------------- |
| `POST` | `/api/register`        | Register a new patient account           |
| `POST` | `/api/login`           | Authenticate user and issue Bearer token |
| `POST` | `/api/forgot-password` | Generate 6-digit OTP for password reset  |
| `POST` | `/api/reset-password`  | Verify OTP and set a new password        |
| `GET`  | `/api/doctors`         | Get all active doctors with specialties  |

### Protected Routes (`Authorization: Bearer <token>`)

| Method | Endpoint                        | Description                                                             |
| :----- | :------------------------------ | :---------------------------------------------------------------------- |
| `GET`  | `/api/profile`                  | Retrieve current user profile                                           |
| `PUT`  | `/api/profile`                  | Update name, email, or phone number                                     |
| `PUT`  | `/api/change-password`          | Update password and revoke old tokens                                   |
| `POST` | `/api/appointments`             | Create a new appointment booking                                        |
| `GET`  | `/api/patient/appointments`     | List patient's appointments with nested medical records & prescriptions |
| `PUT`  | `/api/appointments/{id}/cancel` | Cancel a pending or approved appointment                                |

---

## 🚀 Local Setup & Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/hqvicntt/clinic-backend
    cd clinic-backend
    ```

2. **Install PHP dependencies:**

    ```bash
    composer install
    ```

3. **Configure environment variables:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    Update `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env` to match your MySQL 8.0 configuration.

4. **Run database migrations and seeders:**

    ```bash
    php artisan migrate --seed
    ```

5. **Start the local development server (LAN accessible):**

    ```bash
    php artisan serve --host=0.0.0.0 --port=8000
    ```

    - **API Base URL:** `http://<your-local-ip>:8000/api`
    - **Web Admin Login URL:** `http://<your-local-ip>:8000/api/admin/login`

---

## 👨‍💻 Author

- **Huynh Quang Vi** — Backend Architecture, Database Design, RESTful API, Web Admin & Cloud Deployment.

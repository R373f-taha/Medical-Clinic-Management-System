# 🏥 Medical Clinic Management System

> A robust backend system for managing medical clinics, providing dashboards for clinic staff (admin, doctor, employee) via Blade templates and API access for patients.

---

## 👤 Team & Logo

<div align="center">

![Project Logo](screenshots/X2-Team.png)

**Team Members:**

* Rahaf Taha
* Kheder Alkhateeb
* Rama Yousfan
* Yara Sleten
* Kinda Ghanem

</div>

---

## 📸 Screenshots

<div align="center">

![Admin Dashboard](screenshots/admin-dashboard.png)
![Doctor Dashboard](screenshots/doctor-dashboard.png)
![Employee Dashboard](screenshots/employee-dashboard.png)
![Patient API](screenshots/patient-api.png)
![Before Login](screenshots/beforeLogin.png)
![Login](screenshots/Login.png)

</div>

---

## 📚 Table of Contents

* [Project Overview](#-project-overview)
* [Team & Logo](#-team--logo)
* [Screenshots](#-screenshots)
* [Requirements](#-requirements)
* [Installation & Setup](#-installation--setup)
* [System Roles](#-system-roles)
* [Database Structure](#-database-structure)
* [Interfaces & Routes](#-interfaces--routes)
* [API Documentation](#-api-documentation)
* [Sample Credentials](#-sample-credentials)
* [Support & Contributions](#-support--contributions)
* [Acknowledgments](#-acknowledgments)

---

## 🚀 Project Overview

The **Medical Clinic Management System** is a backend Laravel application that provides:

* ✅ Clinic staff dashboards using Blade templates
* 🏥 API access for patients
* 📊 Role-based access control for Admin, Doctor, Employee, and Patient
* 🔐 Secure authentication and data management

---

## ⚙️ Requirements

| Component | Version |
| --------- | ------- |
| PHP       | ≥ 8.2   |
| Composer  | Latest  |
| Laravel   | 12.x    |
| Database  | MySQL   |


---

## 🛠 Installation & Setup

### 1. Clone the Repository

```bash
git clone <https://github.com/R373f-taha/Medical-Clinic-Management-System.git>
cd medical_clinic_management
```

### 2. Install Dependencies

```bash
composer install    # PHP dependencies
npm install         # JS dependencies (for Blade assets)
```

### 3. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Run the Application

```bash
php artisan serve    # Start Laravel server
npm run dev          # Compile frontend assets
```

---

## 👥 System Roles

| Role         | Access & Permissions                              |
| ------------ | ------------------------------------------------- |
| Clinic Admin | Full control over the system, manage users & data |
| Doctor       | Manage appointments, view patients                |
| Employee     | Assist admin, manage schedules & records          |
| Patient      | Access personal data via API, view appointments   |

---

## 🗄 Database Structure

> The system contains 10+ tables. Below are the major ones with columns:

### `users`

* `id` (PK)
* `name`
* `email`
* `password`
* `email_verified_at` 
* `remember_token` 
* `created_at`, `updated_at`

### `patients`

* `id` (PK)
* `user_id` (FK → users.id)
* `blood_type`
* `	height`
* `	weight`
* `	gender`
* `	allergies`
* `created_at`, `updated_at`

### `doctors`

* `id` (PK)
* `user_id` (FK → users.id)
* `specialization`
* `qualifications`
* `available_hours`
* `experience_years`
* `services`
* `created_at`, `updated_at`

### `employees`

* `id` (PK)
* `user_id` (FK → users.id)
* `name`
* `qualifications`
* `age`
* `phone`
* `email`
* `date_of_birth`
* `created_at`, `updated_at`

### `appointments`

* `id` (PK)
* `patient_id` (FK → patients.id)
* `doctor_id` (FK → doctors.id)
* `appointment_date`
* `hold_expires_at`
* `reason`
* `notes`
* `status` (scheduled, completed, canceled)
* `created_at`, `updated_at`

### `medical_records`

* `id` (PK)
* `patient_id` (FK → patients.id)
* `doctor_id` (FK → doctors.id)
* `notes`
* `diagnosis`
* `treatment_plan`
* `follow_up_date`
* `date`
* `created_at`, `updated_at`

### `ratings`

* `id` (PK)
* `patient_id` (FK → patients.id)
* `doctor_id` (FK → doctors.id)
* `rating`
* `date`
* `notes`
* `created_at`, `updated_at`

---

## 🔗 Interfaces & Routes

| Page / API         | Route                       | Description                            |
| ------------------ | -----------                 | ------------------------------         |
| Admin Dashboard    | `/admin`                    | Full system management                 |
| Doctor Dashboard   | `/doctor`                   | Manage appointments & patients         |
| Employee Dashboard | `/employee`                 | Assist with admin tasks                |


---

## 📚 API Documentation

### Authentication

| Method | Endpoint                                   | Description                         |
| ------ | ---------------                            | --------------------------          |
| POST   | `/api/patient/register`                    | Register a new patient              |
| POST   | `/api/patient/login`                       | Patient login                       |
| GET    | `/api/patient/logout`                      | Logout (token-based)                |
| POST   | `/api/patient/refresh`                     |  Token Refresh (token-based)        |

### Appointments

| Method | Endpoint                                   | Description                          |
| ------ | ------------------------                   | ----------------------               |
| GET    | `/api/patient/take/appointment`            | Get patient details                  |
| GET    |`/api/patient/cancel/{id}/appointment`      | Cancel appointments(token based)     |
| POST   | `/api/patient/cancel/appointments`         | Cancel all appointments(token-based) |
| GET    |`/api/patient/cancel/{id}/appointment`      | Cancel appointments(token based)     |
| GET    |`/api/patient/show/appointments      `      | Show appointments  (token based)     |
| GET    | `/api/patient/invoice/for/{id}/appointment`| invoice (token based)                |

### other procedures

| Method | Endpoint                                   | Description                          |
| ------ | ------------------------                   | ----------------------               |
| GET    | `/api/patient/me`                          | show patient info   (token based)    |
| POST   | `/api/patient/medicalRecord`               | show medical record  (token-based)   |
| GET    |`/api/patient/cancel/{id}/appointment`      | Cancel appointments(token based)     |
| GET    |`/api/patient/add/rating             `      | Add Rating         (token based)     |

### api collection

https://documenter.getpostman.com/view/50321677/2sBXVigUyL
---

## 🔑 Sample Credentials

### Clinic Admin

```
Email: admin@example.com
Password: password123
```

### Doctor

```
Email:Test Email from the seeder
Password: password

```

### Employee


```
Email:Test Email from the seeder
Password: password

```

### To activate the email responsible for sending appointment-related emails to patients (for new bookings or cancellations):

Prerequisites💛:

The email must have two-factor authentication enabled.

Access Gmail settings and navigate to "App Passwords" under security settings.

Generate a new app password by specifying the app name and copying the generated password.

Email Configuration Settings:

env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=[Your Email]
MAIL_PASSWORD=[Generated App Password Here]
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=[Your Email]
MAIL_FROM_NAME=[App Name]



## 📞 Support & Contributions

* Open an issue on the [GitHub repository](https://github.com/R373f-taha/Medical-Clinic-Management-System.git)

* Fork the repository and submit a pull request
* Contact the team for questions or collaboration

---

## 🏆 Acknowledgments

*                     💛💛🎉 Special Thanks  
                          Focal X Agency
        For their commitment to student growth and learning opportunities.

                    

*                        💛development team :
                             Rahaf Taha, 
                            Kheder Alkhateeb,
                             Rama Yousfan   
                             Yara Sleten, 
                             Kinda Ghanem

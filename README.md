# Pharmacy Management System

A modern Pharmacy Management System built with Laravel, designed to simplify medicine inventory management, sales tracking, authentication, and pharmacy operations.

---

## Features

### Authentication System

* User registration and login
* Role-based authentication
* Secure password handling
* Session management

### Medicine Management

* Add new medicines
* Edit and update medicine details
* Delete medicines
* Medicine stock tracking
* Expiry date monitoring

### Inventory Management

* Real-time stock updates
* Low-stock alerts
* Medicine categorization
* Supplier management

### Dashboard

* Overview statistics
* Total medicines count
* Stock availability tracking
* Recent activity monitoring

### Additional Functionalities

* Search and filter medicines
* Responsive admin dashboard
* Validation and error handling
* Clean and modern UI

---

## Technologies Used

* Laravel
* PHP
* MySQL
* Blade Template Engine
* Bootstrap / Tailwind CSS
* JavaScript
* Git & GitHub

---

## Project Structure

```bash
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
tests/
```

---

## Installation Guide

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/pharmacy.git
```

### 2. Navigate to the Project Folder

```bash
cd pharmacy
```

### 3. Install Dependencies

```bash
composer install
```

### 4. Create Environment File

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Configure Database

Update the `.env` file with your database credentials.

```env
DB_DATABASE=pharmacy
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run Migrations

```bash
php artisan migrate
```

### 8. Start the Development Server

```bash
php artisan serve
```

---

## Git Workflow

### Branches Used

* `develop`
* `feature/authentication-system`
* `feature/medicine-management`

---

## Future Improvements

* Sales and billing system
* Prescription management
* Supplier reports
* Barcode scanning
* Invoice generation
* Notifications and alerts
* API integration

---

## Screenshots

Add your project screenshots here.

---

## Contributing

Contributions are welcome. Fork the repository and create a pull request.

---

## License

This project is licensed under the MIT License.

---

## Developer

Developed by Ange Uwimpuhwe

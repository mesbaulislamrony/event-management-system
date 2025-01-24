# Event Management System

A simple event management system built with PHP that allows users to create and manage events, and attendees to join events.

## Features

### User Management
- User registration with mobile number validation (minimum 11 digits)
- Secure login with password protection
- Session management for authenticated users

### Event Management
- Create, edit, and delete events
- Events include title, description, host, datetime, and capacity
- Users can only manage their own events
- View list of all events with pagination
- Search events by title, description, or host
- Download attendee list as CSV for each event

### Event Joining
- AJAX-based event joining system
- Real-time form validation
- Seat availability checking
- Prevent duplicate registrations
- Mobile number validation
- Success/error notifications

### Security Features
- Password hashing using PHP's password_hash
- SQL injection prevention with prepared statements
- XSS prevention with input sanitization
- CSRF protection
- Session-based authentication
- User-specific data access control

## Setup Instructions

1. Clone the repository
2. Create a MySQL database
3. Import the database schema from `database.sql`
4. Configure database connection in `config/database.php`
5. Ensure PHP 7.4+ and MySQL 5.7+ are installed
6. Point your web server to the project directory

## Database Configuration

Update the database configuration in `config/database.php`:

```php
private $host = "localhost";
private $database = "your_database_name";
private $username = "your_username";
private $password = "your_password";
```

## Default Login Credentials

```
Mobile No: 01717171717
Password: password
```

## Technologies Used

- PHP 7.4+
- MySQL 5.7+
- Bootstrap 5
- JavaScript (ES6)
- PDO for database operations
- Carbon for date handling

## Directory Structure

```
event-management-system/
├── app/
│   ├── Config/
│   ├── Controllers/
│   │   └── Api/
│   └── Models/
├── auth/
├── events/
├── layouts/
├── vendor/
├── config/
├── api/
└── public/
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is licensed under the MIT License.

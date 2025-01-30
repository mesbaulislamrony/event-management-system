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

## Run Locally

1. Clone the repository
2. Create a MySQL database `eventshub`
3. Import the database schema from `database.sql`
4. Configure database connection in `config/database.php`
5. Ensure PHP 7.4+ and MySQL 5.7+ are installed
6. Point your web server to the project directory
7. Go to the project directory `cd event-management-system`
8. Open terminal and update composer `composer update`

## Live Project

To visit live project on [Click Here](https://mesbaul.binfosys.solutions)

## Default Login Credentials

```
Mobile No: 01738120411
Password: 12345678
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
├── api/
├── app/
│   ├── Controllers/
│   │   └── Api/
│   └── Middleware/
│   └── Models/
├── assets/
├── auth/
├── config/
├── error/
├── events/
├── layouts/
├── vendor/
├── index.php
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is licensed under the MIT License.

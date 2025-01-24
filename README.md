# Event Management System

A comprehensive web application for managing events, registrations, and attendees. Built with PHP, MySQL, and Bootstrap.

## Project Overview

The Event Management System is a robust platform that allows users to create, manage, and track events. Users can register for events, manage attendee lists, and download attendee information in CSV format.

## Features

- **User Authentication**
  - Secure login and registration system
  - Password validation (minimum 6 characters)
  - Mobile number validation (minimum 11 digits)

- **Event Management**
  - Create and edit events
  - Set event capacity and date/time
  - View event details and available seats
  - Delete events with confirmation
  - Pagination for event listings (5 events per page)

- **Attendee Management**
  - Register attendees for events
  - Track number of seats booked
  - Prevent overbooking with capacity validation

- **Data Validation**
  - Client-side JavaScript validation
  - Server-side PHP validation
  - Form validation with error messages

## Technical Stack

- PHP 7.4+
- MySQL 5.7+
- Bootstrap 5
- JavaScript (ES6)
- HTML5/CSS3

## Installation Instructions

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer (for dependency management)

### Application Setup

1. Clone the repository:
```bash
git clone https://github.com/mesbaulislamrony/event-management-system.git
cd event-management-system
```

2. Configure database connection:
   - Open `config/database.php`
   - Update database credentials:
     ```php
     $host = 'your_host_name';
     $dbname = 'your_database_name';
     $username = 'your_username';
     $password = 'your_password';
     ```

### Database Setup

1. Create a new MySQL database:
```sql
CREATE DATABASE your_database_name;
```

2. Import the database schema:
```bash
mysql -u your_username -p your_database_name < database.sql
```

## Login Credentials

### Default Admin User
- Mobile: 01700000000
- Password: password

## Security Considerations

1. Always change default credentials after installation
2. Keep PHP and MySQL updated to latest stable versions
3. Use HTTPS in production environment
4. Regularly backup your database
5. Monitor error logs for suspicious activity

## Support

For any issues or questions, please create an issue in the repository for timeless support.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

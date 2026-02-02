# Event Management System

A full-stack Event Management System developed using core PHP and MySQL, allowing users to browse, search, and register for events, while administrators manage events and view registration logs.

This application is built without frameworks or template engines, demonstrating a strong understanding of backend logic, session management, database interaction, and frontend integration using AJAX.

# Key Features

# User Features
- User registration and login
- Secure session-based authentication
- View all events
- Live event search (AJAX)
- Filter events by category
- Register for events
- View registration status

# Admin Features
- Add new events
- Edit existing events
- Delete events
- View registration log sheet
- Role-based access control (Admin / User)

# General Features
- Fixed header with navigation
- Footer sticks to the bottom of the page
- Responsive event grid layout
- AJAX-powered search & filter
- Secure password handling
- Clean UI using custom CSS


# Tech Stack
|_______________________________|
| Layer        | Technology     |
|--------------|----------------|
|Backend       | PHP (Core PHP) |
|Database      | MySQL          |
|Frontend      | HTML5, CSS3    |
|Interactivity | JavaScript     | 
|AJAX          | Fetch API      |
|Server        | Apache (XAMPP) |
|-------------------------------|

#  Project Structure
Assessment_FullStack/
│
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── script.js
│
├── config/
│   └── db.php
│
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── functions.php
│
├── public/
│   ├── index.php
│   ├── login.php
│   ├── register.php
│   ├── add_event.php
│   ├── edit_event.php
│   ├── logout.php
│   ├── log_sheet.php
│   └── ajax_count.php
│
└── README.md

- Authentication & Security
- Sessions prevent unauthorized access
- Protected pages require login
- Browser back button does not bypass authentication
- Passwords are validated before storage
- Inputs are sanitized to prevent XSS
- Admin routes are role-restricted

Events load dynamically without refreshing the page:
	Keyword search
	Category filtering
	Live updates while typing
	AJAX handled in ajax_count.php

UI & Layout Design:
	Fixed header using position: fixed
	Footer stays at bottom using Flexbox layout
	Event cards arranged in responsive grid
	Horizontal scrolling prevented
	Clean spacing and alignment using CSS

Edge Cases Tested:
	Page refresh after logout
	Browser back navigation
	Empty search results
	Duplicate event registration



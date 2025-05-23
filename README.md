# ENSA-GESTION: Scientific Equipment Management System

## Overview

This web application, developed for ENSA Fès, digitizes the management of scientific equipment. Built with PHP, MySQL, HTML, and CSS, it replaces a manual Excel-based process with features like adding, modifying, deleting, searching, and viewing statistics (by year/category) of equipment. It includes secure user authentication and an intuitive interface.

## Setup Instructions

1. **Prerequisites**: Ensure XAMPP is installed.
2. **Clone the Repository**: Place the project in `C:\xampp\htdocs\ensa-gestion`.
3. **Database Setup**: Import the database schema using phpMyAdmin or MySQL Workbench from the provided SQL scripts (not included in repo, local sql service).
4. **Start Server**: Launch Apache and MySQL via XAMPP.
5. **Access**: Open `http://localhost/ensa-gestion/login.php` in your browser.

## Usage

- Register using an authorized name (listed in `noms_autorises` table).
- Log in to access the homepage (`accueil.php`).
- Navigate via the sidebar to manage equipment, search by criteria (date, category, designation), or view statistics.
- Log out when done (`logout.php`).

## Project Structure

- `/styles`: Contains CSS files (`layoutStyles.css`, `loginStyles.css`) and logo (`ENSAFES_Logo.png`).
- PHP files: Handle core functionalities (e.g., `ajouter_materiel.php`, `rechercher_par_annee.php`, `cout_par_categorie.php`).
- `materiel.csv`: Sample data for equipment (import via phpMyAdmin).

## Contributing

This project was developed by Aazi Ikram as part of the Web Development module at ENSA Fès. 

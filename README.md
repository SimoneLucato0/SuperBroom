# SuperBroom

This project was conducted as the final assignment for the 2021/2022 Web Technologies course, led by Prof. Ombretta Gaggi at the University of Padova.

## Authors

Simone Lucato, University of Padua, Italy

Marta Greggio, University of Padua, Italy

Elia Scandaletti, University of Padua, Italy

Giulia Zorzet, University of Padua, Italy

## Purpose

The primary goal was to create a website for a company that allows customers to rent supercars for driving on company-affiliated circuits. Customers can browse available cars and circuits to book them or contact the company through a contact form. Upon signup, users can view and edit their personal data, as well as browse their reservation history. Administrators can access a reserved area where they can add, edit, or remove circuits and cars, as well as view customers' reservations.
The core idea of the project was to create an accessible user experience, regardless of visual impairments, while using the latest technologies and building an "interesting" site.

## Key features

- **Modern design**: The application uses the most up-to-date UX features, for example carousels and tab panels, which are notoriously complex to be made accessible. They were built following WAI-ARIA practices by W3C, as well as documentation on `aria-live` regions.
- **Screen Reader Compatibility**: Optimized content structure and semantic HTML to ensure smooth navigation and comprehension for users relying on screen readers.
- **Keyboard Navigation**: Full functionality accessible through keyboard controls, enabling users who can't use a mouse to easily navigate the site.

## Getting started

### Prerequisites

It is assumed that the application is hosted on a server.

### Installation

1. **Create Database**:

   ```bash
   ./scripts/create_db.sh
   ```

2. **Populate Database**:
   ```bash
   ./scripts/populate_db.sh
   ```

# DevTracker - AI Coding Guidelines

## Architecture Overview
DevTracker is a simple PHP/MySQL web application for tracking coding projects. It consists of static HTML pages (home, about, contact) and dynamic PHP pages (project listing, add project) connected to a MySQL database.

**Key Components:**
- `db.php`: Database connection (mysqli, localhost/root/no-password/"azhaan")
- `index.php`: Displays projects from "projects" table in a styled table
- `create.php`: Form to add new projects with validation and auto-generated IDs
- Static HTML files with consistent navbar navigation

## Database Schema
```sql
CREATE TABLE projects (
    proj_id VARCHAR(50) PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT NOT NULL
);
```

## Coding Patterns
- **Database Access**: Always `require_once('db.php')` for connection. Use prepared statements for INSERT/UPDATE operations.
- **Form Handling**: POST forms to the same page. Validate inputs server-side, display errors in `.notice.error` divs.
- **Project ID**: Auto-generate numeric IDs if empty (max existing + 1). Supports manual string/int IDs.
- **Output Sanitization**: Use `htmlspecialchars()` for all user data output in HTML.
- **Navigation**: Include navbar in all pages linking to home.html, index.php, about.html, contact.html, create.php.

## Development Workflow
- Run on XAMPP (htdocs folder) - access via http://localhost/Coding-Project-Website/
- No build process required - direct PHP execution
- Database setup: Create "azhaan" database and projects table manually

## Styling Conventions
- Use `style.css` for all styling
- Navbar: teal background (#009879), white text
- Forms: Centered container with rounded corners, focus effects
- Tables: Alternating rows, hover effects, responsive word-wrap

## File Structure
- PHP files handle both logic and HTML output
- CSS linked via `<link rel="stylesheet" href="style.css">`
- No JavaScript or frameworks - vanilla PHP/HTML/CSS

## Common Tasks
- Adding features: Follow create.php pattern (validation → prepared insert → success message)
- Modifying display: Update index.php query and table structure
- Styling changes: Edit style.css, test across all pages</content>
<parameter name="filePath">c:\xampp\htdocs\Coding-Project-Website\.github\copilot-instructions.md
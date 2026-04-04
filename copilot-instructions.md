# DevTracker - AI Coding Agent Instructions

## Project Overview
**DevTracker** is a PHP/MySQL web application for managing project listings. It provides a web interface to browse projects and add new ones to a MySQL database. The app uses a simple MVC-like structure with separate presentation (HTML), business logic (PHP), and data access (db.php) layers.

## Architecture & Data Flow

### Key Components
- **[db.php](db.php)**: Central database connection file connecting to MySQL "azhaan" database on localhost (root/no-password)
- **[index.php](index.php)**: Main page displaying projects in a table; queries projects table and embeds PHP in HTML
- **[create.php](create.php)**: Form for adding new projects with validation and auto-ID generation
- **HTML pages** (home.html, about.html, contact.html): Static content pages with shared navbar
- **[style.css](style.css)**: Centralized styling for navbar, tables, and forms

### Database Schema
Projects table structure (inferred from code):
```
CREATE TABLE projects (
  proj_id INT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  category VARCHAR(100),
  description TEXT
)
```

### Data Flow Pattern
1. HTML pages → navbar links navigate between pages
2. index.php → includes db.php → queries projects → loops results into HTML table rows
3. create.php → form submission → validates input → auto-generates ID if empty → prepared statement INSERT

## Critical Conventions

### Database Patterns
- **Connection**: Use `require_once('db.php')` to include db connection in all PHP files needing database access
- **Query safety**: Prepared statements with `mysqli_prepare()` for INSERT (see create.php L37) to prevent SQL injection
- **Simple queries**: Direct `mysqli_query()` acceptable for SELECT statements (index.php), but error handling required
- **Auto-ID generation**: When proj_id empty, query MAX(CAST(proj_id AS UNSIGNED)) and increment (create.php L26-34)

### Form Handling Pattern
- POST validation occurs before database operations
- Input sanitization: `trim()` on all POST values, `htmlspecialchars()` when echoing to prevent XSS
- Error array accumulation: collect all validation errors before attempting insert (create.php L4-21)
- Success state tracked via boolean flag for UI conditionals

### HTML/PHP Integration
- PHP blocks embedded within HTML for data population (index.php lines 30-37)
- Navbar is duplicated across pages—consider extracting to included file for DRY principle
- Form values repopulated on POST using ternary with `htmlspecialchars()` (create.php L93)

### Styling
- Single global stylesheet; navbar uses teal background (#009879)
- Table styling: alternating rows, box-shadow, responsive max-width (1200px)
- Form styling in [style.css](style.css)—use `.form-container`, `.form-group` classes

## Common Development Tasks

### Adding a New Project Field
1. Modify projects table schema
2. Update create.php validation array (L15-21)
3. Update create.php form inputs (around L93+)
4. Update index.php SELECT and table row echoing (L30-37)
5. Update HTML form POST parameter capture (L7-10)

### Adding a New Page
1. Create HTML file with navbar copy from home.html
2. Add link to navbar in ALL HTML/PHP files manually (no navbar include yet)
3. Link to new page in [style.css](style.css) if styling needed

### Database Issues
- Test connection: Check [db.php](db.php) localhost/root credentials match XAMPP setup
- If "Connection failed" appears, verify MySQL is running and "azhaan" database exists
- For query errors, check mysqli_error($con) output

## Development Environment
- Local setup: XAMPP (Apache + MySQL on localhost)
- Database: MySQL server, database "azhaan"
- Root access no password (db.php L1)
- Files served from: `c:\xampp\htdocs\Coding-Project-Website`

## Navigation & Structure
All pages include same navbar with links:
- Home → home.html
- Projects → index.php (dynamic)
- About → about.html
- Contact → contact.html
- Add Project → create.php (form)

The "brand" link doesn't navigate (href="#")—update if needed.

## Anti-Patterns to Avoid
- ❌ Don't use direct `mysqli_query()` for user input (use prepared statements)
- ❌ Don't echo POST/GET data without `htmlspecialchars()`
- ❌ Don't add new navbar items without updating all pages
- ❌ Don't assume proj_id will always be numeric—handle both numeric and string types (see create.php L35)

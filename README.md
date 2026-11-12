# DS Construction - Luxury PHP Construction Website & Admin CMS

A full-stack, responsive website built with PHP, SQLite, and vanilla CSS/JavaScript for **DS Construction**, featuring dynamic **Day & Night theme switching**, modern architectural styling, and a **comprehensive Admin Control Panel** where all site content, images, and settings can be modified.

---

## 🌟 Key Features

### 1. ☀️ / 🌙 Smart Day & Night Theme System
- **Automatic Solar Sync (Default)**: Automatically detects daytime (6:00 AM – 6:30 PM) and nightfall (6:30 PM – 6:00 AM) and shifts themes accordingly.
- **Manual Mode Toggle**: Visitors can freely toggle between **Day**, **Night**, or **Auto** mode via the interactive pill switcher in the navigation bar.
- **Persistence**: User preference is saved in both `localStorage` and `cookies` (`ds_theme_pref`), enabling instantaneous server-side rendering in PHP without UI flickering.
- **Custom Aesthetic Themes**:
  - **Night Mode (Dark Luxury & Gold)**: Sleek obsidian backdrop (`#090c12`) with metallic gold accents (`#d4af37`), designed to match the uploaded **DS Construction** emblem logo.
  - **Day Mode (Architectural White & Gold)**: Clean, high-end white & slate palette with warm gold trims, crisp typography, and light shadows.

## 🗄️ Standard MySQL / MariaDB Database

The application now uses **standard MySQL / MariaDB** (compatible with XAMPP, phpMyAdmin, and live web hosts):
- **Database Name**: `ds_construction`
- **Host**: `localhost`
- **Username**: `root`
- **Password**: *(blank / empty by default in XAMPP)*
- **SQL Dump File**: [database/ds_construction.sql](file:///C:/Users/Service%20PC/.gemini/antigravity/scratch/ds-construction/database/ds_construction.sql)

### How Database Setup Works:
1. **Automatic**: If the database doesn't exist yet, `config/db.php` automatically creates `ds_construction` and imports all tables and seed data upon opening the site.
2. **Manual (Optional via phpMyAdmin)**:
   - Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
   - Click **Import** and select `database/ds_construction.sql`.
   - Click **Go** to import.
- **Site Identity & Brand Settings**:
  - Update Company Name, Slogan/Tagline, and Contact Information (Phone, Email, Headquarters Address, Operating Hours).
  - **Logo Uploader**: Upload new brand emblem or update existing logo anytime.
  - **Hero Section Customization**: Modify headline text, subtitle, call-to-action button label and URL.
  - **Live Counter Metrics**: Modify live statistics (Years of Mastery, Completed Builds, Client Retention, Industry Awards).
  - **About Story & Core Mission**: Update company history and mission statements.
  - **Theme Behavior**: Select default theme behavior (Auto, Day, or Night).
  - **Social Links**: Update Facebook, Instagram, LinkedIn, and Twitter/X profiles.
- **Portfolio Projects Management (CRUD)**:
  - Add, edit, and delete developments.
  - Set project title, category (Commercial, Luxury Residential, Renovation, Infrastructure), client, location, year, image upload or URL, and completion status.
  - Toggle "Featured on Homepage" badge.
- **Services Management (CRUD)**:
  - Add, edit, and delete construction services.
  - Custom FontAwesome icons, short summary cards, detailed technical descriptions, and images.
- **Client Testimonials Management (CRUD)**:
  - Add, edit, and delete client reviews with star ratings, avatars, client name, and company title.
- **Executive Leadership Team (CRUD)**:
  - Manage executive profiles, headshot photos, role descriptions, and LinkedIn links.
- **Inquiries & Quotes Inbox**:
  - Review all client proposal requests submitted through the quote form.
  - Filter by Unread, Read, or Contacted.
  - Single-click reply via pre-filled email client.
- **Admin Credentials Security**:
  - Change username and secure bcrypt-hashed password.

---

## 🔐 Default Admin Credentials

- **URL**: `http://localhost:8000/admin/login.php` (or `http://localhost/ds-construction/admin/login.php`)
- **Username**: `admin`
- **Password**: `admin123`

*(You can change these anytime in the Admin Panel under **Admin Credentials**)*.

---

## 🚀 How to Run the Website

### Option A: 1-Click Launch (Recommended)
Double-click `start-server.bat` in the project root:
```cmd
start-server.bat
```
This automatically starts PHP's built-in web server and opens `http://localhost:8000` in your default browser.

### Option B: Via Terminal / PowerShell
```powershell
& "C:\xampp\php\php.exe" -S localhost:8000
```
Then visit:
- Public Website: [http://localhost:8000](http://localhost:8000)
- Admin Panel: [http://localhost:8000/admin/login.php](http://localhost:8000/admin/login.php)

### Option C: Via XAMPP Apache
Start Apache from your **XAMPP Control Panel**, and navigate to:
- Public Website: [http://localhost/ds-construction](http://localhost/ds-construction)
- Admin Panel: [http://localhost/ds-construction/admin/login.php](http://localhost/ds-construction/admin/login.php)

---

## 📁 Project Structure

```
ds-construction/
├── assets/
│   ├── css/
│   │   ├── style.css           # Public styling with Day/Night CSS variables & transitions
│   │   └── admin.css           # Modern dark luxury Admin Dashboard stylesheet
│   ├── js/
│   │   └── main.js             # Theme controller (Auto/Day/Night), counters, mobile menu, filters
│   └── images/
│       ├── logo.jpg            # DS Construction gold emblem logo (from user upload)
│       └── uploads/            # Admin uploads directory (photos, logos, avatars)
├── config/
│   ├── db.php                  # PDO SQLite connection, schema auto-migration & data seeder
│   ├── auth.php                # Authentication, session security & flash notifications
│   └── helpers.php             # Day/Night resolution & secure image uploader
├── database/
│   └── construction.db         # Self-contained SQLite database
├── includes/
│   ├── header.php              # Global navigation bar with Day/Night switcher & brand logo
│   └── footer.php              # Global footer with contact info & quick links
├── admin/
│   ├── index.php               # Admin overview with metrics & recent leads
│   ├── login.php               # Secure admin login
│   ├── logout.php              # Session sign-out
│   ├── settings.php            # Edit company info, logo, hero, stats & theme defaults
│   ├── services.php            # Services management table
│   ├── service-edit.php        # Add / Edit service
│   ├── projects.php            # Portfolio management table
│   ├── project-edit.php        # Add / Edit project
│   ├── testimonials.php        # Client reviews management
│   ├── testimonial-edit.php    # Add / Edit review
│   ├── team.php                # Team members management
│   ├── team-edit.php           # Add / Edit team member
│   ├── messages.php            # Lead / quote requests inbox
│   ├── profile.php             # Change admin username & password
│   └── includes/
│       ├── admin_header.php
│       └── admin_footer.php
├── index.php                   # Homepage with hero, services, portfolio, stats, quote form
├── services.php                # Detailed services breakdown
├── projects.php                # Interactive portfolio gallery with category filters
├── about.php                   # Company history, values, and leadership team
├── contact.php                 # Contact details, consultation form, and office hours
├── submit-contact.php          # Contact form processor with DB storage & spam protection
└── start-server.bat            # 1-click local server launcher
```

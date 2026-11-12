-- ========================================================
-- DS CONSTRUCTION - MySQL / MariaDB Database Dump
-- Compatible with XAMPP phpMyAdmin & standard MySQL
-- ========================================================

CREATE DATABASE IF NOT EXISTS `ds_construction` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ds_construction`;

-- --------------------------------------------------------
-- Table structure for table `settings`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `setting_key` VARCHAR(100) NOT NULL,
  `setting_value` TEXT DEFAULT NULL,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `services`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `icon` VARCHAR(100) DEFAULT 'fa-building',
  `short_desc` TEXT DEFAULT NULL,
  `full_desc` TEXT DEFAULT NULL,
  `image` VARCHAR(500) DEFAULT NULL,
  `order_num` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `projects`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `category` VARCHAR(100) NOT NULL,
  `client` VARCHAR(255) DEFAULT NULL,
  `location` VARCHAR(255) DEFAULT NULL,
  `year` VARCHAR(50) DEFAULT NULL,
  `image` VARCHAR(500) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `featured` TINYINT(1) DEFAULT 0,
  `status` VARCHAR(50) DEFAULT 'Completed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `testimonials`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `client_name` VARCHAR(255) NOT NULL,
  `client_role` VARCHAR(255) DEFAULT NULL,
  `company` VARCHAR(255) DEFAULT NULL,
  `rating` INT DEFAULT 5,
  `content` TEXT NOT NULL,
  `avatar` VARCHAR(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `team`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `team`;
CREATE TABLE `team` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `role` VARCHAR(255) NOT NULL,
  `bio` TEXT DEFAULT NULL,
  `photo` VARCHAR(500) DEFAULT NULL,
  `linkedin` VARCHAR(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `messages`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(100) DEFAULT NULL,
  `service` VARCHAR(150) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(50) DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping initial data for table `settings`
-- --------------------------------------------------------
INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('site_name', 'DS Construction'),
('tagline', 'Building Excellence with Gold Standard Craftsmanship'),
('phone', '+1 (800) 555-0199'),
('email', 'contact@dsconstruction.com'),
('address', '742 Park Avenue, 18th Floor, New York, NY 10021'),
('working_hours', 'Mon - Sat: 8:00 AM - 7:00 PM'),
('hero_title', 'Building Landmarks with Gold Standard Precision'),
('hero_subtitle', 'From luxury residential estates to state-of-the-art commercial developments, DS Construction delivers engineering excellence, structural innovation, and timeless architectural beauty.'),
('hero_cta_text', 'View Our Projects'),
('hero_cta_link', 'projects.php'),
('stat_experience', '18+'),
('stat_projects', '350+'),
('stat_clients', '99%'),
('stat_awards', '25'),
('about_story', 'Established with a vision for uncompromising quality, DS Construction has emerged as an industry benchmark for luxury residential, high-scale commercial builds, and structural engineering. We combine state-of-the-art heavy machinery, modern BIM modeling, and master craftsmanship to turn ambitious blueprints into enduring landmarks.'),
('about_mission', 'To deliver world-class infrastructure and architectural masterpieces with unyielding structural integrity, sustainability, and complete client transparency.'),
('default_theme_mode', 'auto'),
('logo_path', 'assets/images/logo.jpg'),
('facebook_url', 'https://facebook.com'),
('instagram_url', 'https://instagram.com'),
('linkedin_url', 'https://linkedin.com'),
('twitter_url', 'https://twitter.com')
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);

-- --------------------------------------------------------
-- Dumping initial data for table `users` (admin / admin123)
-- --------------------------------------------------------
INSERT INTO `users` (`id`, `username`, `password_hash`, `email`) VALUES
(1, 'admin', '$2y$10$wE7i79KjGj1Hh.7eY6W7Z.hW3qfGzW5M3lGvN3gH4rZ7tZ6h4K5X2', 'admin@dsconstruction.com')
ON DUPLICATE KEY UPDATE `username` = VALUES(`username`);

-- --------------------------------------------------------
-- Dumping initial data for table `services`
-- --------------------------------------------------------
INSERT INTO `services` (`id`, `title`, `slug`, `icon`, `short_desc`, `full_desc`, `image`, `order_num`) VALUES
(1, 'Commercial Construction', 'commercial-construction', 'fa-building', 'Turnkey commercial hubs, high-rise office towers, and retail plazas built for durability and corporate prestige.', 'We engineer cutting-edge commercial spaces built to code, optimized for maximum operational flow, energy conservation, and aesthetic grandeur. Our commercial team orchestrates every phase from zoning and permits to final tenant improvements.', 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80', 1),
(2, 'Luxury Residential Estates', 'luxury-residential', 'fa-house-chimney', 'Bespoke architectural villas, high-end private homes, and custom living spaces engineered with meticulous detail.', 'From modern minimalist beachfront villas to opulent traditional estates, we bring your dream residence to life with fine materials, custom millwork, smart home automation, and gold-standard construction precision.', 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80', 2),
(3, 'Civil Engineering & Structural Design', 'civil-engineering', 'fa-helmet-safety', 'Advanced seismic structural frameworks, foundational piling, and rigorous engineering calculations.', 'Our certified structural engineers utilize advanced 3D finite element analysis and Building Information Modeling (BIM) to ensure safety factors exceed industry thresholds across all soils and environments.', 'https://images.unsplash.com/photo-1541888946425-d0fbb1861563?auto=format&fit=crop&w=800&q=80', 3),
(4, 'Renovation & Architectural Remodeling', 'renovation-remodeling', 'fa-hammer', 'Revitalizing historic landmarks, modernizing commercial interiors, and luxury residential expansions.', 'Whether retrofitting older buildings with contemporary sustainable materials or overhauling luxury penthouses, we preserve character while dramatically upgrading aesthetics and structural stamina.', 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=800&q=80', 4),
(5, 'Project Management & Turnkey Contracting', 'project-management', 'fa-diagram-project', 'Comprehensive project planning, rigorous budget controls, and seamless scheduling from groundbreaking to handover.', 'With transparent reporting, on-site safety officers, and strict supply chain logistics, DS Construction guarantees timely delivery without budget surprises.', 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?auto=format&fit=crop&w=800&q=80', 5),
(6, 'Industrial & Infrastructure Development', 'industrial-infrastructure', 'fa-industry', 'Heavy industrial plants, logistics warehouses, and foundational civil infrastructure.', 'Built to withstand intense operational stress, our industrial builds feature reinforced slabs, automated loading dock engineering, and sustainable energy integration.', 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?auto=format&fit=crop&w=800&q=80', 6);

-- --------------------------------------------------------
-- Dumping initial data for table `projects`
-- --------------------------------------------------------
INSERT INTO `projects` (`id`, `title`, `category`, `client`, `location`, `year`, `image`, `description`, `featured`, `status`) VALUES
(1, 'Aura Grand Luxury Tower', 'Commercial', 'Skyline Ventures Group', 'Financial District, NY', '2025', 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80', 'A 42-story LEED Gold certified commercial landmark combining double-glazed reflective curtain walls, high-efficiency geothermal heating, and luxury corporate penthouses.', 1, 'Completed'),
(2, 'The Golden Crest Modern Villa', 'Luxury Residential', 'Private Client', 'Hamptons, NY', '2026', 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=800&q=80', 'An 8,500 sq ft modern architectural villa featuring cantilevered infinity pools, imported travertine facades, floor-to-ceiling panoramic glass, and custom gold-finished hardware.', 1, 'Completed'),
(3, 'Horizon Heights Corporate Center', 'Commercial', 'Horizon Global', 'Midtown, NY', '2026', 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80', 'State-of-the-art multi-tenant corporate headquarters with acoustic sound-baffles, smart elevator controls, and an interconnected sky garden.', 1, 'In Progress'),
(4, 'The Royal Oak Heritage Renovation', 'Renovation', 'Heritage Preservation Trust', 'Beacon Hill, MA', '2024', 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80', 'Historic preservation and luxury modernization of an 1890 brick masonry estate, incorporating modern seismic reinforcement and geothermal energy retrofits.', 0, 'Completed'),
(5, 'Nexus Logistics Hub & Freight Terminal', 'Infrastructure', 'Nexus Global Logistics', 'Newark Logistics Zone, NJ', '2025', 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80', '450,000 sq ft industrial logistics complex engineered with laser-leveled superflat slabs, solar roof array, and 64 automated truck docking stations.', 0, 'Completed'),
(6, 'The Sovereign Hilltop Residence', 'Luxury Residential', 'Private Client', 'Greenwich, CT', '2026', 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=800&q=80', 'Bespoke estate nestled in 5 rolling acres with subterranean 8-car gallery garage, private screening room, and titanium zinc roofing.', 1, 'Completed');

-- --------------------------------------------------------
-- Dumping initial data for table `testimonials`
-- --------------------------------------------------------
INSERT INTO `testimonials` (`id`, `client_name`, `client_role`, `company`, `rating`, `content`, `avatar`) VALUES
(1, 'Marcus Vance', 'Managing Director', 'Vance Capital Partners', 5, 'DS Construction handled our corporate headquarters development flawlessly. Their attention to structural perfection, strict adherence to milestones, and gold-standard finishings exceeded every expectation.', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80'),
(2, 'Elena Rostova', 'Principal Architect', 'Rostova Design Atelier', 5, 'As an architect, finding a general contractor that honors every nuanced curve and detail of your blueprints is rare. DS Construction executed our vision with surgical accuracy and unmatched luxury.', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80'),
(3, 'David Sterling', 'Real Estate Investor', 'Sterling Luxury Assets', 5, 'From the groundbreaking ceremony to the final handover inspection, DS Construction was consummate professionals. Our modern villa was finished 3 weeks ahead of schedule and the craftsmanship is simply peerless.', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80');

-- --------------------------------------------------------
-- Dumping initial data for table `team`
-- --------------------------------------------------------
INSERT INTO `team` (`id`, `name`, `role`, `bio`, `photo`, `linkedin`) VALUES
(1, 'David Sullivan', 'Founder & Chief Executive Officer', '25+ years commanding luxury residential and high-rise commercial developments across North America.', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&q=80', 'https://linkedin.com'),
(2, 'Sarah Chen, PE', 'Head of Structural Engineering', 'Licensed Professional Engineer specializing in seismic resilience, reinforced post-tension concrete, and sustainable building systems.', 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&q=80', 'https://linkedin.com'),
(3, 'Robert Hernandez', 'VP of Project Operations', 'Oversees site logistics, contractor safety management, and rigorous procurement timelines for multi-million dollar portfolios.', 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=400&q=80', 'https://linkedin.com');

-- --------------------------------------------------------
-- Dumping initial data for table `messages`
-- --------------------------------------------------------
INSERT INTO `messages` (`id`, `name`, `email`, `phone`, `service`, `message`, `status`) VALUES
(1, 'Alexander Wright', 'alex.wright@horizonventures.com', '+1 555-839-2041', 'Commercial Construction', 'We are initiating architectural planning for an 8-story commercial tech hub in Manhattan. We would love to discuss feasibility, budget modeling, and timeline with DS Construction.', 'unread'),
(2, 'Sophia Morales', 'morales.sophia@gmail.com', '+1 555-492-1100', 'Luxury Residential Estates', 'Looking to commission a modern custom 6,000 sq ft residence on our private hillside lot. Please provide availability for an initial site consultation.', 'read');

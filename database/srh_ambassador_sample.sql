CREATE TABLE IF NOT EXISTS srh_programs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  program_name VARCHAR(255) NOT NULL,
  degree_level VARCHAR(100) NOT NULL,
  department VARCHAR(255) NOT NULL,
  description TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS srh_countries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL
);

CREATE TABLE IF NOT EXISTS srh_languages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  iso_code VARCHAR(12) NULL
);

CREATE TABLE IF NOT EXISTS srh_ambassadors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  photo VARCHAR(255) NULL,
  degree_program VARCHAR(255) NOT NULL,
  bio TEXT NOT NULL,
  contact_preference VARCHAR(120) NOT NULL,
  availability VARCHAR(120) NOT NULL,
  status ENUM('draft','active','inactive') NOT NULL DEFAULT 'draft'
);

CREATE TABLE IF NOT EXISTS srh_ambassador_programs (
  ambassador_id INT NOT NULL,
  program_id INT NOT NULL,
  PRIMARY KEY (ambassador_id, program_id)
);

CREATE TABLE IF NOT EXISTS srh_ambassador_countries (
  ambassador_id INT NOT NULL,
  country_id INT NOT NULL,
  PRIMARY KEY (ambassador_id, country_id)
);

CREATE TABLE IF NOT EXISTS srh_ambassador_languages (
  ambassador_id INT NOT NULL,
  language_id INT NOT NULL,
  PRIMARY KEY (ambassador_id, language_id)
);

CREATE TABLE IF NOT EXISTS srh_events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  starts_at DATETIME NOT NULL,
  location_or_link VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  event_type VARCHAR(120) NOT NULL,
  club_id INT NULL,
  interested_count INT NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS srh_event_ambassadors (
  event_id INT NOT NULL,
  ambassador_id INT NOT NULL,
  PRIMARY KEY (event_id, ambassador_id)
);

CREATE TABLE IF NOT EXISTS srh_club_polls (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  club_idea VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  interest_count INT NOT NULL DEFAULT 0,
  popularity_threshold INT NOT NULL DEFAULT 20,
  status ENUM('open','popular','converted','closed') NOT NULL DEFAULT 'open',
  created_by_ambassador_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS srh_clubs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  category VARCHAR(150) NOT NULL,
  status ENUM('proposed','active','paused') NOT NULL DEFAULT 'active',
  member_count INT NOT NULL DEFAULT 0,
  created_from_poll_id INT NULL,
  created_by_ambassador_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS srh_club_members (
  club_id INT NOT NULL,
  user_id INT NOT NULL,
  role ENUM('member','lead') NOT NULL DEFAULT 'member',
  joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (club_id, user_id)
);

CREATE TABLE IF NOT EXISTS srh_student_inquiries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  country VARCHAR(150) NOT NULL,
  interested_program_id INT NULL,
  question_message TEXT NOT NULL,
  preferred_language_id INT NULL,
  assigned_ambassador_id INT NULL,
  status ENUM('new','assigned','answered','closed') NOT NULL DEFAULT 'new',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS srh_faq_categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  description TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS srh_faqs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  category_id INT NOT NULL,
  body TEXT NOT NULL,
  language_id INT NOT NULL,
  published TINYINT(1) NOT NULL DEFAULT 1
);

INSERT INTO srh_programs (id, program_name, degree_level, department, description) VALUES
  (1, 'International Business Administration', 'Bachelor', 'Business', 'Business studies with international and practical focus.'),
  (2, 'Computer Science', 'Master', 'Technology', 'Advanced software engineering, data, and digital systems.'),
  (3, 'Hospitality Management', 'Bachelor', 'Management', 'Service, tourism, and hospitality management in an international context.');

INSERT INTO srh_countries (id, name) VALUES
  (1, 'Germany'),
  (2, 'India'),
  (3, 'Georgia');

INSERT INTO srh_languages (id, name, iso_code) VALUES
  (1, 'English', 'en'),
  (2, 'German', 'de'),
  (3, 'Hindi', 'hi');

INSERT INTO srh_ambassadors (id, name, photo, degree_program, bio, contact_preference, availability, status) VALUES
  (1, 'Maya Singh', 'images/ambassadors/maya.jpg', 'International Business Administration', 'Maya helps prospective students understand business studies and campus life in Berlin.', 'Email', 'Weekdays', 'active'),
  (2, 'Luka Beridze', 'images/ambassadors/luka.jpg', 'Computer Science', 'Luka supports students interested in technology programs and moving to Berlin.', 'Video call', 'Evenings', 'active'),
  (3, 'Anna Keller', 'images/ambassadors/anna.jpg', 'Hospitality Management', 'Anna shares experience from hospitality projects and student events.', 'Email', 'Weekends', 'active'),
  (4, 'Samir Patel', 'images/ambassadors/samir.jpg', 'Computer Science', 'Samir answers questions about labs, projects, and student jobs.', 'Chat', 'Flexible', 'active'),
  (5, 'Nino Chkheidze', 'images/ambassadors/nino.jpg', 'International Business Administration', 'Nino helps with questions about international student onboarding.', 'Email', 'Weekdays', 'active');

INSERT INTO srh_ambassador_programs VALUES
  (1,1), (2,2), (3,3), (4,2), (5,1);

INSERT INTO srh_ambassador_countries VALUES
  (1,2), (2,3), (3,1), (4,2), (5,3);

INSERT INTO srh_ambassador_languages VALUES
  (1,1), (1,3), (2,1), (3,1), (3,2), (4,1), (4,3), (5,1);

INSERT INTO srh_club_polls (id, title, club_idea, description, interest_count, popularity_threshold, status, created_by_ambassador_id) VALUES
  (1, 'Should SRH start a Film Club?', 'Film Club', 'Weekly screenings and student discussion nights.', 31, 25, 'popular', 1),
  (2, 'Interest check: Robotics Club', 'Robotics Club', 'Build small robots and prepare showcase demos.', 18, 25, 'open', 2);

INSERT INTO srh_clubs (id, name, description, category, status, member_count, created_from_poll_id, created_by_ambassador_id) VALUES
  (1, 'Data & AI Club', 'Student-led projects, talks, and study circles around data science and applied AI.', 'Technology', 'active', 38, NULL, 2),
  (2, 'Founders Club', 'A place to test ideas, meet co-founders, and prepare pitch nights.', 'Entrepreneurship', 'active', 24, NULL, 1),
  (3, 'Hospitality Culture Club', 'Pop-up tastings, venue visits, and service design conversations.', 'Campus Life', 'active', 19, NULL, 3);

INSERT INTO srh_club_members (club_id, user_id, role) VALUES
  (1,1,'lead'), (1,2,'member'), (2,3,'lead'), (3,4,'member');

INSERT INTO srh_events (id, title, starts_at, location_or_link, description, event_type, club_id, interested_count) VALUES
  (1, 'Online Ambassador Q&A', '2026-07-08 16:00:00', 'https://meet.example/srh-qa', 'Open question session with current SRH students.', 'Online Q&A', NULL, 34),
  (2, 'Berlin Campus Tour', '2026-07-15 11:00:00', 'SRH Berlin Campus', 'Guided tour for prospective students and families.', 'Campus', NULL, 51),
  (3, 'International Student Welcome Talk', '2026-08-03 14:00:00', 'Auditorium A', 'Ambassadors explain first-week essentials.', 'Welcome', NULL, 27),
  (4, 'Data Club Project Night', '2026-08-14 17:00:00', 'Lab 2.04', 'Bring a dataset and build a tiny dashboard with other students.', 'Club Meetup', 1, 42);

INSERT INTO srh_event_ambassadors VALUES
  (1,1), (1,2), (2,3), (2,5), (3,1), (3,4);

INSERT INTO srh_student_inquiries (id, student_name, email, country, interested_program_id, question_message, preferred_language_id, assigned_ambassador_id, status) VALUES
  (1, 'Elena Rossi', 'elena@example.com', 'Italy', 1, 'How international is the business program?', 1, 1, 'assigned'),
  (2, 'Arjun Mehta', 'arjun@example.com', 'India', 2, 'Can I work part time during the Computer Science master?', 1, 4, 'answered'),
  (3, 'Mariam Dolidze', 'mariam@example.com', 'Georgia', 3, 'Are there practical hospitality projects?', 1, NULL, 'new');

INSERT INTO srh_faq_categories (id, name, description) VALUES
  (1, 'Admissions', 'Questions about applying and documents.'),
  (2, 'Campus Life', 'Questions about living and studying in Berlin.'),
  (3, 'Programs', 'Questions about academic programs.');

INSERT INTO srh_faqs (id, title, category_id, body, language_id, published) VALUES
  (1, 'How do I contact an ambassador?', 2, 'Use the inquiry form and select your program and preferred language.', 1, 1),
  (2, 'Can I ask in German?', 1, 'Yes. Choose German as preferred language if an ambassador is available.', 2, 1),
  (3, 'Are campus tours available?', 2, 'Campus tours are listed on the events page.', 1, 1),
  (4, 'Which program should I choose?', 3, 'Start with the program overview and ask an ambassador for personal experience.', 1, 1),
  (5, 'What happens after I submit an inquiry?', 1, 'A coordinator reviews it and assigns a suitable ambassador.', 1, 1);

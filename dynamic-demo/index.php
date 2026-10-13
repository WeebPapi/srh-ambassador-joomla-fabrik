<?php
session_start();

$lang = $_GET['lang'] ?? $_POST['lang'] ?? 'en';
$lang = $lang === 'de' ? 'de' : 'en';

$copy = [
  'en' => [
    'app' => 'SRH Ambassador Platform',
    'ambassadors' => 'Ambassadors',
    'programs' => 'Programs',
    'clubs' => 'Clubs',
    'events' => 'Events',
    'dashboard' => 'Ambassador Dashboard',
    'faq' => 'FAQ',
    'contact' => 'Contact',
    'language' => 'Language',
    'introTitle' => 'Joomla/Fabrik Dynamic Demo',
    'introBody' => 'This page reads and writes the same MariaDB tables planned for the Fabrik implementation.',
    'studentClubs' => 'Student Clubs',
    'members' => 'members',
    'joinClub' => 'Join club',
    'joined' => 'Joined',
    'clubPolls' => 'Club Interest Polls',
    'interested' => 'interested',
    'needed' => 'needed',
    'imInterested' => "I'm interested",
    'marked' => 'Marked',
    'createPoll' => 'Create interest poll',
    'createClub' => 'Create club',
    'createEvent' => 'Create club event',
    'clubIdea' => 'Club idea',
    'description' => 'Description',
    'threshold' => 'Popularity threshold',
    'name' => 'Name',
    'category' => 'Category',
    'title' => 'Title',
    'club' => 'Club',
    'date' => 'Date',
    'savePoll' => 'Create poll',
    'saveClub' => 'Create club',
    'saveEvent' => 'Create event',
    'saved' => 'Saved to MariaDB through the Joomla/Fabrik demo endpoint.',
  ],
  'de' => [
    'app' => 'SRH Ambassador Plattform',
    'ambassadors' => 'Botschafter',
    'programs' => 'Studiengänge',
    'clubs' => 'Clubs',
    'events' => 'Events',
    'dashboard' => 'Botschafter-Dashboard',
    'faq' => 'FAQ',
    'contact' => 'Kontakt',
    'language' => 'Sprache',
    'introTitle' => 'Dynamische Joomla/Fabrik-Demo',
    'introBody' => 'Diese Seite liest und schreibt dieselben MariaDB-Tabellen, die für die Fabrik-Implementierung geplant sind.',
    'studentClubs' => 'Studentische Clubs',
    'members' => 'Mitglieder',
    'joinClub' => 'Club beitreten',
    'joined' => 'Beigetreten',
    'clubPolls' => 'Club-Interessensumfragen',
    'interested' => 'interessiert',
    'needed' => 'benötigt',
    'imInterested' => 'Ich bin interessiert',
    'marked' => 'Markiert',
    'createPoll' => 'Interessensumfrage erstellen',
    'createClub' => 'Club erstellen',
    'createEvent' => 'Club-Event erstellen',
    'clubIdea' => 'Club-Idee',
    'description' => 'Beschreibung',
    'threshold' => 'Beliebtheitsschwelle',
    'name' => 'Name',
    'category' => 'Kategorie',
    'title' => 'Titel',
    'club' => 'Club',
    'date' => 'Datum',
    'savePoll' => 'Umfrage erstellen',
    'saveClub' => 'Club erstellen',
    'saveEvent' => 'Event erstellen',
    'saved' => 'In MariaDB über den Joomla/Fabrik-Demo-Endpunkt gespeichert.',
  ],
][$lang];

function db(): PDO {
  $host = getenv('JOOMLA_DB_HOST') ?: 'db';
  $name = getenv('JOOMLA_DB_NAME') ?: 'joomla';
  $user = getenv('JOOMLA_DB_USER') ?: 'joomla';
  $password = getenv('JOOMLA_DB_PASSWORD') ?: 'joomla';
  return new PDO("mysql:host=$host;dbname=$name;charset=utf8mb4", $user, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
}

function setup(PDO $pdo): void {
  $pdo->exec("CREATE TABLE IF NOT EXISTS srh_club_polls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    club_idea VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    interest_count INT NOT NULL DEFAULT 0,
    popularity_threshold INT NOT NULL DEFAULT 20,
    status ENUM('open','popular','converted','closed') NOT NULL DEFAULT 'open',
    created_by_ambassador_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  )");
  $pdo->exec("CREATE TABLE IF NOT EXISTS srh_clubs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(150) NOT NULL,
    status ENUM('proposed','active','paused') NOT NULL DEFAULT 'active',
    member_count INT NOT NULL DEFAULT 0,
    created_from_poll_id INT NULL,
    created_by_ambassador_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  )");
  $pdo->exec("CREATE TABLE IF NOT EXISTS srh_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    starts_at DATETIME NOT NULL,
    location_or_link VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    event_type VARCHAR(120) NOT NULL,
    club_id INT NULL,
    interested_count INT NOT NULL DEFAULT 0
  )");
  ensureColumn($pdo, 'srh_events', 'club_id', 'INT NULL');
  ensureColumn($pdo, 'srh_events', 'interested_count', 'INT NOT NULL DEFAULT 0');

  if ((int) $pdo->query("SELECT COUNT(*) FROM srh_clubs")->fetchColumn() === 0) {
    $stmt = $pdo->prepare("INSERT INTO srh_clubs (name, description, category, status, member_count) VALUES (?, ?, ?, 'active', ?)");
    $stmt->execute(['Data & AI Club', 'Student-led projects, talks, and study circles around data science and applied AI.', 'Technology', 38]);
    $stmt->execute(['Founders Club', 'A place to test ideas, meet co-founders, and prepare pitch nights.', 'Entrepreneurship', 24]);
    $stmt->execute(['Hospitality Culture Club', 'Pop-up tastings, venue visits, and service design conversations.', 'Campus Life', 19]);
  }
  if ((int) $pdo->query("SELECT COUNT(*) FROM srh_club_polls")->fetchColumn() === 0) {
    $stmt = $pdo->prepare("INSERT INTO srh_club_polls (title, club_idea, description, interest_count, popularity_threshold, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute(['Should SRH start a Film Club?', 'Film Club', 'Weekly screenings and student discussion nights.', 31, 25, 'popular']);
    $stmt->execute(['Interest check: Robotics Club', 'Robotics Club', 'Build small robots and prepare showcase demos.', 18, 25, 'open']);
  }
  if ((int) $pdo->query("SELECT COUNT(*) FROM srh_events")->fetchColumn() === 0) {
    $clubId = (int) $pdo->query("SELECT id FROM srh_clubs WHERE name = 'Data & AI Club' LIMIT 1")->fetchColumn();
    $stmt = $pdo->prepare("INSERT INTO srh_events (title, starts_at, location_or_link, description, event_type, club_id, interested_count) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(['Online Ambassador Q&A', '2026-07-08 16:00:00', 'https://meet.example/srh-qa', 'Open question session with current SRH students.', 'Online Q&A', null, 34]);
    $stmt->execute(['Berlin Campus Tour', '2026-07-15 11:00:00', 'SRH Berlin Campus', 'Guided tour for prospective students and families.', 'Campus', null, 51]);
    $stmt->execute(['Data Club Project Night', '2026-08-14 17:00:00', 'Lab 2.04', 'Bring a dataset and build a tiny dashboard with other students.', 'Club Meetup', $clubId, 42]);
  }
}

function ensureColumn(PDO $pdo, string $table, string $column, string $definition): void {
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?");
  $stmt->execute([$table, $column]);
  if ((int) $stmt->fetchColumn() === 0) {
    $pdo->exec("ALTER TABLE $table ADD COLUMN $column $definition");
  }
}

function h($value): string {
  return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$pdo = db();
setup($pdo);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  if ($action === 'join_club') {
    $stmt = $pdo->prepare('UPDATE srh_clubs SET member_count = member_count + 1 WHERE id = ?');
    $stmt->execute([(int) $_POST['id']]);
    $_SESSION['srh_actions']['club:' . (int) $_POST['id']] = true;
  } elseif ($action === 'poll_interest') {
    $stmt = $pdo->prepare('UPDATE srh_club_polls SET interest_count = interest_count + 1 WHERE id = ?');
    $stmt->execute([(int) $_POST['id']]);
    $_SESSION['srh_actions']['poll:' . (int) $_POST['id']] = true;
  } elseif ($action === 'event_interest') {
    $stmt = $pdo->prepare('UPDATE srh_events SET interested_count = interested_count + 1 WHERE id = ?');
    $stmt->execute([(int) $_POST['id']]);
    $_SESSION['srh_actions']['event:' . (int) $_POST['id']] = true;
  } elseif ($action === 'create_poll') {
    $stmt = $pdo->prepare("INSERT INTO srh_club_polls (title, club_idea, description, popularity_threshold, status) VALUES (?, ?, ?, ?, 'open')");
    $stmt->execute([$_POST['title'] ?: $_POST['club_idea'], $_POST['club_idea'], $_POST['description'], (int) $_POST['threshold']]);
    $message = $copy['saved'];
  } elseif ($action === 'create_club') {
    $stmt = $pdo->prepare("INSERT INTO srh_clubs (name, category, description, status, member_count) VALUES (?, ?, ?, 'active', 0)");
    $stmt->execute([$_POST['name'], $_POST['category'], $_POST['description']]);
    $message = $copy['saved'];
  } elseif ($action === 'create_event') {
    $stmt = $pdo->prepare("INSERT INTO srh_events (title, starts_at, location_or_link, description, event_type, club_id, interested_count) VALUES (?, ?, ?, ?, 'Club Meetup', ?, 0)");
    $stmt->execute([$_POST['title'], $_POST['starts_at'], $_POST['location'], $_POST['description'], (int) $_POST['club_id'] ?: null]);
    $message = $copy['saved'];
  }
}

$clubs = $pdo->query("SELECT * FROM srh_clubs WHERE status = 'active' ORDER BY id")->fetchAll();
$polls = $pdo->query("SELECT * FROM srh_club_polls ORDER BY FIELD(status, 'popular', 'open', 'converted', 'closed'), id")->fetchAll();
$events = $pdo->query("SELECT e.*, c.name AS club_name FROM srh_events e LEFT JOIN srh_clubs c ON c.id = e.club_id ORDER BY e.starts_at")->fetchAll();
$actions = $_SESSION['srh_actions'] ?? [];
?>
<!doctype html>
<html lang="<?= h($lang) ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($copy['app']) ?></title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <header class="site-header">
      <h1><?= h($copy['app']) ?></h1>
      <nav>
        <a href="#clubs"><?= h($copy['clubs']) ?></a>
        <a href="#events"><?= h($copy['events']) ?></a>
        <a href="#ambassador-dashboard"><?= h($copy['dashboard']) ?></a>
      </nav>
      <form class="language-switch" method="get">
        <label><?= h($copy['language']) ?>
          <select name="lang" onchange="this.form.submit()">
            <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>EN</option>
            <option value="de" <?= $lang === 'de' ? 'selected' : '' ?>>DE</option>
          </select>
        </label>
      </form>
    </header>
    <main>
      <section class="intro">
        <h2><?= h($copy['introTitle']) ?></h2>
        <p><?= h($copy['introBody']) ?></p>
      </section>

      <?php if ($message): ?><p class="status"><?= h($message) ?></p><?php endif; ?>

      <section id="clubs">
        <h2><?= h($copy['studentClubs']) ?></h2>
        <div class="grid">
          <?php foreach ($clubs as $club): ?>
            <article>
              <h3><?= h($club['name']) ?></h3>
              <p><?= h($club['category']) ?> - <?= h($club['member_count']) ?> <?= h($copy['members']) ?></p>
              <p><?= h($club['description']) ?></p>
              <form method="post">
                <input type="hidden" name="lang" value="<?= h($lang) ?>">
                <input type="hidden" name="action" value="join_club">
                <input type="hidden" name="id" value="<?= h($club['id']) ?>">
                <?php $key = 'club:' . $club['id']; ?>
                <button type="submit" <?= !empty($actions[$key]) ? 'disabled' : '' ?>><?= h(!empty($actions[$key]) ? $copy['joined'] : $copy['joinClub']) ?></button>
              </form>
            </article>
          <?php endforeach; ?>
        </div>

        <h3><?= h($copy['clubPolls']) ?></h3>
        <div class="list">
          <?php foreach ($polls as $poll): ?>
            <article>
              <h3><?= h($poll['title']) ?></h3>
              <p><?= h($poll['description']) ?></p>
              <p><?= h($poll['interest_count']) ?> <?= h($copy['interested']) ?> / <?= h($poll['popularity_threshold']) ?> <?= h($copy['needed']) ?> - <?= h($poll['status']) ?></p>
              <form method="post">
                <input type="hidden" name="lang" value="<?= h($lang) ?>">
                <input type="hidden" name="action" value="poll_interest">
                <input type="hidden" name="id" value="<?= h($poll['id']) ?>">
                <?php $key = 'poll:' . $poll['id']; ?>
                <button type="submit" <?= !empty($actions[$key]) ? 'disabled' : '' ?>><?= h(!empty($actions[$key]) ? $copy['marked'] : $copy['imInterested']) ?></button>
              </form>
            </article>
          <?php endforeach; ?>
        </div>
      </section>

      <section id="events">
        <h2><?= h($copy['events']) ?></h2>
        <div class="list">
          <?php foreach ($events as $event): ?>
            <article>
              <h3><?= h($event['title']) ?></h3>
              <p><?= h($event['starts_at']) ?> - <?= h($event['event_type']) ?><?= $event['club_name'] ? ' - ' . h($event['club_name']) : '' ?></p>
              <p><?= h($event['interested_count']) ?> <?= h($copy['interested']) ?></p>
              <p><?= h($event['description']) ?></p>
              <form method="post">
                <input type="hidden" name="lang" value="<?= h($lang) ?>">
                <input type="hidden" name="action" value="event_interest">
                <input type="hidden" name="id" value="<?= h($event['id']) ?>">
                <?php $key = 'event:' . $event['id']; ?>
                <button type="submit" <?= !empty($actions[$key]) ? 'disabled' : '' ?>><?= h(!empty($actions[$key]) ? $copy['marked'] : $copy['interested']) ?></button>
              </form>
            </article>
          <?php endforeach; ?>
        </div>
      </section>

      <section id="ambassador-dashboard">
        <h2><?= h($copy['dashboard']) ?></h2>
        <div class="dashboard-grid">
          <form method="post">
            <h3><?= h($copy['createPoll']) ?></h3>
            <input type="hidden" name="lang" value="<?= h($lang) ?>">
            <input type="hidden" name="action" value="create_poll">
            <label><?= h($copy['title']) ?> <input name="title" required></label>
            <label><?= h($copy['clubIdea']) ?> <input name="club_idea" required></label>
            <label><?= h($copy['description']) ?> <textarea name="description" required></textarea></label>
            <label><?= h($copy['threshold']) ?> <input type="number" name="threshold" value="20" min="1"></label>
            <button type="submit"><?= h($copy['savePoll']) ?></button>
          </form>

          <form method="post">
            <h3><?= h($copy['createClub']) ?></h3>
            <input type="hidden" name="lang" value="<?= h($lang) ?>">
            <input type="hidden" name="action" value="create_club">
            <label><?= h($copy['name']) ?> <input name="name" required></label>
            <label><?= h($copy['category']) ?> <input name="category" required></label>
            <label><?= h($copy['description']) ?> <textarea name="description" required></textarea></label>
            <button type="submit"><?= h($copy['saveClub']) ?></button>
          </form>

          <form method="post">
            <h3><?= h($copy['createEvent']) ?></h3>
            <input type="hidden" name="lang" value="<?= h($lang) ?>">
            <input type="hidden" name="action" value="create_event">
            <label><?= h($copy['title']) ?> <input name="title" required></label>
            <label><?= h($copy['club']) ?>
              <select name="club_id">
                <option value="0">-</option>
                <?php foreach ($clubs as $club): ?><option value="<?= h($club['id']) ?>"><?= h($club['name']) ?></option><?php endforeach; ?>
              </select>
            </label>
            <label><?= h($copy['date']) ?> <input type="datetime-local" name="starts_at" required></label>
            <label>Location <input name="location" required></label>
            <label><?= h($copy['description']) ?> <textarea name="description" required></textarea></label>
            <button type="submit"><?= h($copy['saveEvent']) ?></button>
          </form>
        </div>
      </section>
    </main>
  </body>
</html>

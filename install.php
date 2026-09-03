<?php
require __DIR__.'/config.php';

$db->exec('CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT NOT NULL UNIQUE, password TEXT NOT NULL, role TEXT NOT NULL DEFAULT "partner", slug TEXT NOT NULL UNIQUE, phone TEXT, whatsapp TEXT, company TEXT, bio TEXT, created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP)');
$db->exec('CREATE TABLE IF NOT EXISTS services (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT NOT NULL, slug TEXT NOT NULL UNIQUE, short_description TEXT, description TEXT NOT NULL, price REAL NOT NULL DEFAULT 0, commission_rate REAL NOT NULL DEFAULT 40, active INTEGER NOT NULL DEFAULT 1, created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP)');
$db->exec('CREATE TABLE IF NOT EXISTS landing_pages (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER NOT NULL, service_id INTEGER NOT NULL, slug TEXT NOT NULL UNIQUE, headline TEXT, subheadline TEXT, cta_text TEXT DEFAULT "Richiedi una consulenza", published INTEGER NOT NULL DEFAULT 1, created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE, FOREIGN KEY(service_id) REFERENCES services(id) ON DELETE CASCADE)');
$db->exec('CREATE TABLE IF NOT EXISTS leads (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER NOT NULL, service_id INTEGER NOT NULL, landing_page_id INTEGER, name TEXT NOT NULL, email TEXT, phone TEXT, message TEXT, status TEXT NOT NULL DEFAULT "new", created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(user_id) REFERENCES users(id), FOREIGN KEY(service_id) REFERENCES services(id), FOREIGN KEY(landing_page_id) REFERENCES landing_pages(id))');
$db->exec('CREATE TABLE IF NOT EXISTS sales (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER NOT NULL, service_id INTEGER NOT NULL, lead_id INTEGER, amount REAL NOT NULL, status TEXT NOT NULL DEFAULT "pending", created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(user_id) REFERENCES users(id), FOREIGN KEY(service_id) REFERENCES services(id), FOREIGN KEY(lead_id) REFERENCES leads(id))');
$db->exec('CREATE TABLE IF NOT EXISTS sales_guides (id INTEGER PRIMARY KEY AUTOINCREMENT, service_id INTEGER NOT NULL UNIQUE, opening TEXT, questions TEXT, objections TEXT, whatsapp_script TEXT, phone_script TEXT, FOREIGN KEY(service_id) REFERENCES services(id) ON DELETE CASCADE)');

$count = (int)$db->query("SELECT COUNT(*) FROM users WHERE role='admin'")->fetchColumn();
if ($count === 0) {
    $stmt=$db->prepare('INSERT INTO users(name,email,password,role,slug) VALUES(?,?,?,?,?)');
    $stmt->execute(['Administrator','admin@example.com',password_hash('ChangeMe123!', PASSWORD_DEFAULT),'admin','admin']);
}
$serviceCount=(int)$db->query('SELECT COUNT(*) FROM services')->fetchColumn();
if ($serviceCount===0) {
    $stmt=$db->prepare('INSERT INTO services(title,slug,short_description,description,price,commission_rate) VALUES(?,?,?,?,?,?)');
    $stmt->execute(['Automatizzazione Social Media','automatizzazione-social-media','Automatizza la gestione dei tuoi canali social.','Piattaforma personalizzabile per automatizzare pubblicazione, gestione contenuti e flussi social.',2500,40]);
}
layout_start('Installazione');
?>
<div class="container"><div class="card"><h1>Partner Sales Hub installato</h1><p>Database creato correttamente.</p><p><strong>Admin:</strong> admin@example.com<br><strong>Password iniziale:</strong> ChangeMe123!</p><p class="muted">Accedi e cambia subito la password. Poi elimina questo file install.php dal server.</p><a class="btn" href="index.php">Vai al login</a></div></div>
<?php layout_end(); ?>

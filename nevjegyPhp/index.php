<?php
  $status = "";
  $errors = [];

  $servername = "localhost"; 
  $username = "startupc_vv-diak"; 
  $password = "OYi!La@41bhI3Fdw"; 
  $dbname = "startupc_vv"; 
  $tablename = "nmate";



  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      if (empty($_POST['user_name'])) $errors[] = "A név megadása kötelező!";
      else $name = $_POST['user_name'];

      if (empty($_POST['user_email']) || !filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
          $errors[] = "Érvénytelen email cím!";
      }
      else $email = $_POST['user_email'];

      if (empty($_POST['message']) || strlen($_POST['message']) < 5) {
          $errors[] = "Az üzenet túl rövid!";
      }
      else $message = $_POST['message'];

      if (!empty($errors)) {
          $status = "<div class='alert alert-danger'>" . implode("<br>", $errors) . "</div>";
      } 
      else {
          $headers  = "MIME-Version: 1.0\r\n";
          $headers .= "Content-type: text/plain; charset=UTF-8\r\n";
          $headers .= "From: noreply@startupcovasna.ro\r\n";
          $headers .= "Reply-To: ".$email."\r\n";

          try {
            $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $db->exec("
                CREATE TABLE IF NOT EXISTS $tablename (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    message TEXT NOT NULL,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB CHARSET=utf8mb4;
            ");
          } catch (PDOException $e) {
              die("Database connection failed: " . $e->getMessage());
          }


          if (mail("morsakk.mate@gmail.com", "Contact: $email Name: $name", $message, $headers)) {

              $stmt = $db->prepare("INSERT INTO $tablename (name, email, message) VALUES (?, ?, ?)");
              $stmt->execute([$name, $email, $message]);

              header("Location: ?success=1");
              exit;
          } else {
              $status = "<div class='alert alert-danger'>Hiba történt az üzenet küldése közben.</div>";
          }
      }
  }

  if (isset($_GET['success'])) {
      $status = "<div class='alert alert-success'>Üzenet sikeresen elküldve!</div>";
  }
?>

<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="style.css" />

    <title>Nagy Máté</title>
  </head>
  <body>
    <main>
      <div class="lux-card">
        <div id="form-status">
          <?php if (!empty($status)) echo $status; ?>
        </div>

        <div class="profile">
          <img src="./img/profile.jpg" alt="Nagy Máté" class="avatar" />
          <h1>Nagy Máté</h1>
          <p class="subtitle">Erasmus+</p>

          <a href="MateNagy.vcf" download="Nagy_Mate.vcf" class="save-btn">
            <i class="bi bi-person-plus"></i> Save Contact
          </a>
        </div>

        <div class="line"></div>

        <section>
          <h3 class="section-title">Kapcsolat</h3>
          <div class="contact-grid">
            <a href="tel:+36501111713" class="icon"
              ><i class="bi bi-telephone"></i
            ></a>
            <a href="sms:+36501111713" class="icon"
              ><i class="bi bi-chat-text"></i
            ></a>
            <a href="mailto:morsakk.mate@gmail.com" class="icon"
              ><i class="bi bi-envelope"></i
            ></a>
          </div>
        </section>

        <div class="line"></div>

        <section>
          <h3 class="section-title">Közösségi Média</h3>
          <div class="social-grid">
            <a
              href="https://m.me/100061482573856"
              target="_blank"
              ><i class="bi bi-messenger"></i
            ></a>
            <a
              href="https://www.facebook.com/profile.php?id=100061482573856"
              target="_blank"
              ><i class="bi bi-facebook"></i
            ></a>
            <a href="https://t.me/mate_284" target="_blank"
              ><i class="bi bi-telegram"></i
            ></a>
            <a href="https://www.instagram.com/mate_284/" target="_blank"
              ><i class="bi bi-instagram"></i
            ></a>
            <a href="https://www.snapchat.com/add/mate.284/" target="_blank"
              ><i class="bi bi-snapchat"></i
            ></a>
          </div>
        </section>

        <div class="line"></div>

        <section class="school">
          <img
            src="https://szg-vasvari.cms.intezmeny.edir.hu/uploads/logo_cea7af9c46.svg"
            alt="VP-logo"
          />
          <p>
            Szegedi SZC Vasvári Pál<br />Gazdasági és Informatikai Technikum
          </p>
          <div class="contact-grid">
            <a href="https://shorturl.at/sbb3W" target="_blank"
              ><i class="bi bi-geo-alt-fill"></i
            ></a>
            <a href="mailto:b1nagmat@vasvari.org"
              ><i class="bi bi-envelope"></i
            ></a>
            <a href="https://www.vasvari.hu/" target="_blank"
              ><i class="bi bi-globe2"></i
            ></a>
            <a href="https://www.facebook.com/szeged.vasvaripal" target="_blank"
              ><i class="bi bi-facebook"></i
            ></a>
          </div>
        </section>

        <div class="line"></div>

        <section class="contact-form">
          <h3 class="section-title">Get in Touch</h3>
          <form id="contact-form" method="POST">
            <div class="form-group">
              <input
                type="text"
                name="user_name"
                id="user_name"
                placeholder="Neved"
                required
              />
            </div>
            <div class="form-group">
              <input
                type="email"
                name="user_email"
                id="user_email"
                placeholder="Email címed"
                required
              />
            </div>
            <div class="form-group">
              <textarea
                name="message"
                id="message"
                rows="4"
                placeholder="Üzenet..."
                required
              ></textarea>
            </div>
            <button type="submit" class="send-btn">
              <i class="bi bi-send"></i> Üzenet küldése
            </button>
          </form>
        </section>
      </div>
    </main>
  </body>
</html>

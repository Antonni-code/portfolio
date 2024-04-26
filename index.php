<?php
include("includes/conn.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ANTONNI | PORTFOLIO</title>

  <link href="external/css/styles.css" rel="stylesheet">

  <link href="vendor/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="vendor/bootstrap-icons-1.11.3/">
  <link href="vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">




</head>

<nav class="navbar navbar-expand-lg navbar-container">
  <div class="container-fluid">
    <a class="navbar-brand header-name" href="#">ANTONNI.</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto d-flex ">
        <li class="nav-item">
          <a class="nav-link encircler active" aria-current="page" href="#home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link encircler" href="#about_me">About Me</a>
        </li>
        <li class="nav-item">
          <a class="nav-link encircler" href="#works">Works</a>
        </li>
        <li class="nav-item">
          <a class="nav-link encircler" href="#contact">Contact</a>
        </li>
      </ul>
    </div>
    <ul class="navbar-nav d-flex navbar-text ">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#">
          <h5><i class="bi bi-list"></i></h5>
        </a>
      </li>
    </ul>

  </div>
</nav>

<body>
  <div class="container-fluid hero-section" id='home'>
    <div class="row center-row">
      <div class="col-md-5 lefty">

        <h1 class="namer">
          <p class="small-its"><span data-bs-toggle="modal" data-bs-target="#loginModal">IT'S</span></p>ANTONNI DELOS REYES.
        </h1>
        <br>
        <h1>FULL-STACK DEVELOPER FROM <span class="country">ZAMBOANGA CITY</span></h1>
      </div>
      <div class="col-md-2 righty">
        <img class="img-fluid img-bg" src="external/img/421056068_313791077872437_7589182820387536794_n.jpg">

      </div>
    </div>


  </div>

  <div class="container-fluid about-me-section">
    <div class="content-about" id='about_me'>
      <h1 class="about-me-header">About Me</h1>
      <br> <br>
      <h3>Hi, I'm Jude Antonni Delos Reyes, a fullstack programmer hailing from Zamboanga City.
        My interest for programming started way beyond my college years where I recently graduated at
        Western Mindano State University with roles such as full-stack programmer, lead programmer and others.
        <br><br>
        In my free time, I love to dabble on using different technological stacks to create my programs, skate
        and even hit the gym.
      </h3>
    </div>
  </div>

  <div class="container-fluid programming-languages">
    <div class="row gx-5 content-lang" id="works">
      <?php
      function displayWorks($conn)
      {
        $query = "SELECT * FROM works";
        try {
          $stmt = $conn->query($query);

          // Check if there are rows returned
          if ($stmt->rowCount() > 0) {
            // Iterate through each row
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo '<div class="container-work">';
              echo '<img src="admin/external/uploads/' . $row['image'] . '" class="img-fluid">';
              echo '<hr>';
              echo '<P>' . $row['description'] . '</P>';
              echo '</div>';
              echo '<br>';
            }
          } else {
            echo 'No data found in the works table.';
          }
        } catch (PDOException $e) {
          echo 'Error: ' . $e->getMessage();
        }
      }

      ?>
      <div class="col left-content ">
        <h1>Works</h1>
        <p>are both of my front-end and back-end forte which helps me design with ease.</p>
        <?php displayWorks($conn); ?>
      </div>
      <?php
      unset($conn);
      ?>

    </div>
  </div>
  <div class="container-fluid contact-section" id="contact">
    <div class="row">
      <div class="col">
        <h1>You've got any ideas? </h1>
        <h3>Send your inquiries for future projects and make that dream come true
          at my email <a class="email" href="mailto:antonnidelosreyes@gmail.com">here!</a>
      </div>
    </div>
  </div>
</body>

<footer>
  <div class="container-fluid footer-section">
    <div class="row">
      <div class="col-md-3">
        <h1 class="footer-name">ANTONNI.</h1>
      </div>
      <div class="col-sm-4">
        <p class="footer-name"><b>Additional Links</b></p>
        <p class="footer-link"> <a href="#about_me" class="link">About</a> </p>
        <p class="footer-link"><a href="#contact" class="link">Contact Me</a> </p>
        <p class="footer-link"><a href="#works" class="link">My Works</a> </p>
        </div>
      <div class="col-sm-4">
        <p class="footer-name"><b>Follow Me</b> </p>
        <p class="footer-link"><a href="https://www.facebook.com/Antonni101" class="link">Facebook</a> </p>
      </div>

    </div>

  </div>
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center login-body ">
          <h1 class="modal-title fs-5 login-header" id="loginModalLabel">Admin Login</h1>
          <form action="processes/login.php" method="POST">
            <label for="username"> Username <br></label>
            <br>
            <Input type="text" name="email" class='input-form'>
            <br>
            <label for="password"> Password <br> </label>
            <br>
            <Input type="password" name="password" class='input-form'>
            <br>
            <input type="submit" name="Login" value="Login" class="login-btn">
          </form>
        </div>
      </div>
    </div>
  </div>

</footer>
<script src="vendor/bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
<script src="vendor/splide-4.1.3/dist/js/splide.min.js"></script>
<script src="vendor/aos-master/dist/aos.js"></script>
<script src="vendor/sweetalert2/dist/sweetalert2.js"></script>


</body>
<?php
if (isset($_SESSION['STATUS'])) {
  if ($_SESSION['STATUS'] == "LOGGED_OUT") {
    echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'You have been succesfully logged out!',
                    icon: 'success'
                });
              </script>";
  }
}
unset($_SESSION['STATUS']);
?>


</html>
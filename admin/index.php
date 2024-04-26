<?php
include('includes/conn.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <link href="vendor/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/bootstrap-icons-1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<style>

  

.fixed-bottom {
  position: fixed;
  bottom: 0;
  width: 100%;
  background-color: #0d6efd;
  color: white;
  padding: 10px 0; 
  box-sizing: border-box;
}


  .nav-link:hover{
    background-color: #007bff;
    color: white !important;
  }

  .admin-panel {
   height: 100%;
  }

  .admin-sidebar {
    background-color: #f8f9fa;
  }

  .admin-content {
    padding-top: 50px;
  }

  .admin-card-header {
    background-color: #007bff;
    color: #fff;
  }
</style>

<div class="container-fluid admin-panel">
  <div class="row">
    <!-- Sidebar -->
    <nav class="col-md-2 col-sm-4 admin-sidebar d-flex flex-column justify-content-between py-4">
      <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <span class="fs-4">Admin Panel</span>
      </a>
      <br>
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#"><i class="fas fa-tachometer-alt me-2"></i><i class="bi bi-speedometer"></i> Dashboard</a>
        </li>
      </ul>
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
       
        <li class="nav-item">
          <a href="processes/logout.php" class="nav-link text-muted"><i class="bi bi-door-open"></i><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
        </li>
      </ul>
    </nav>
    <!-- Content -->
    <main class="col-md-10 col-sm-8 admin-content">
      <div class="d-flex align-items-center">
  <strong role="status">    <h1><i class="bi bi-balloon-heart-fill"></i> Welcome, Antonni!</h1></strong>
  <div class=" ms-auto" aria-hidden="true">
  <p><i class="bi bi-calendar"></i> The date today is currently: <?php echo date('Y-m-d'); ?></p>

  </div>
</div>
      <p><i class="bi bi-arrow-clockwise"></i> Looking to refresh your portfolio? <a href="" data-bs-toggle="modal" data-bs-target="#workModal"> Add work here</a></p>

      <div class="card mb-3">
        <div class="card-header admin-card-header">
          Works
        </div>
        <div class="card-body">
          <table class="table table-hover text-center">
            <thead>
              <tr>
                <th scope="col">Name of Work</th>
                <th scope="col">Picture of Work</th>
                <th scope="col">Description of Work</th>
                <th scope="col">Manage</th>
              </tr>
            </thead>
            <tbody>
              <?php

              try {
                $stmt = $conn->prepare("SELECT * FROM works ORDER by id DESC");
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";

                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td><br><a href='#' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#pictureModal" . $row['id'] . "'>View Picture</a></td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>";
                    echo "<br>";
                    echo "<button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editWorkModal" . $row['id'] . "'>Edit</button> <br> <br>";
                    echo "<button type='button' class='btn btn-danger' onclick='deleteWork(" . $row['id'] . ")'>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                    echo "<div class='modal fade' id='editWorkModal" . $row['id'] . "' tabindex='-1' aria-labelledby='pictureModalLabel" . $row['id'] . "' aria-hidden='true'>";
                    echo "<div class='modal-dialog modal-dialog-centered modal-xl'>";
                    echo "<div class='modal-content'>";
                    echo "<div class='modal-header'>";
                    echo "<h5 class='modal-title' id='pictureModalLabel" . $row['id'] . "'>Edit Work</h5>";
                    echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                    echo "</div>";
                    echo "<div class='modal-body'>";
                    echo "<form action='processes/edit_work.php' method='POST' enctype='multipart/form-data'>";
                    echo "<div class='form-group' style='margin-bottom:20px'>";
                    echo "<label for='workName'>Name of Work:</label>";
                    echo "<input type='text' class='form-control' name='workName' placeholder='Enter name of work' required value='" . $row['name'] . "'>";
                    echo "</div>";
                    echo "<div class='form-group' style='margin-bottom:20px'>";
                    echo "<label for='workPicture'>Picture of Work:</label>";
                    echo "<input type='file' class='form-control-file' name='workPicture' accept='image/*' value='" . $row['image'] . "'>";
                    echo "</div>";
                    echo "<div class='form-group' style='margin-bottom:20px'>";
                    echo "<label for='workDescription'>Description of Work:</label>";
                    echo "<textarea class='form-control' name='workDescription' rows='5' placeholder='Enter description of work' required>'" . $row['description'] . "'</textarea>";
                    echo "</div>";
                    echo "<input type='hidden' name='workId' value='" . $row['id'] . "'>"; // Hidden input to store the work ID
                    echo "<button type='submit' name='submit' class='btn btn-primary'>Save Changes</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";

                    
                    echo "<div class='modal fade' id='pictureModal" . $row['id'] . "' tabindex='-1' aria-labelledby='pictureModalLabel" . $row['id'] . "' aria-hidden='true'>";
                      echo "<div class='modal-dialog modal-dialog-centered modal-xl'>";
                      echo "<div class='modal-content'>";
                      echo "<div class='modal-header'>";
                      echo "<h5 class='modal-title' id='pictureModalLabel" . $row['id'] . "'>Picture of Work</h5>";
                      echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                      echo "</div>";
                      echo "<div class='modal-body'>";
                      echo "<img src='external/uploads/" . $row['image'] . "' class='img-fluid' alt='Picture of Work'>";
                      echo "</div>";
                      echo "</div>";
                      echo "</div>";
                      echo "</div>";
                  }
                } else {
                  echo "<tr><td colspan='5'>No works found.</td></tr>";
                }
              } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
              }

              $conn = null;
              ?>

            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</div>

<footer class="fixed-bottom">
  <div class="bg-primary container-fluid text-center">
    <h5>Antonni | All Rights Reserved | <?php echo date('Y'); ?></h5>
  </div>
</footer>




<script>
  function deleteWork(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'processes/delete_work.php?id=' + id;
      }
    });
  }
</script>



<div class="modal fade" id="workModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add work</h1>
      </div>
      <div class="modal-body">
        <form action="processes/add_work.php" method="POST" enctype="multipart/form-data">
          <div class="form-group" style='margin-bottom:20px'>
            <label for="workName">Name of Work:</label>
            <input type="text" class="form-control" name="workName" placeholder="Enter name of work" required>
          </div>
          <div class="form-group" style='margin-bottom:20px'>
            <label for="workPicture">Picture of Work:</label>
            <input type="file" class="form-control-file" name="workPicture" accept="image/*" required>
          </div>
          <div class="form-group" style='margin-bottom:20px'>
            <label for="workDescription">Description of Work:</label>
            <textarea class="form-control" name="workDescription" rows="5" placeholder="Enter description of work" required></textarea>
          </div>
          <input type="submit" name="submit" class="btn btn-primary"></button>
        </form>
      </div>

    
    </div>
  </div>
</div>


<script src="vendor/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="vendor/sweetalert2/dist/sweetalert2.js"></script>


</body>
<?php
if (isset($_SESSION['STATUS'])) {
  if ($_SESSION['STATUS'] == "DEL_SUCCESS") {
    echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'The deletion was successful!',
                    icon: 'success'
                });
              </script>";
  } elseif ($_SESSION['STATUS'] == "UPLOAD_SUCCESS") {
    echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'The upload was successful!',
                    icon: 'success'
                });
              </script>";
            } elseif ($_SESSION['STATUS'] == "EDIT_SUCCESS") {
              echo "<script>
                          Swal.fire({
                              title: 'Success!',
                              text: 'The edit was successful!',
                              icon: 'success'
                          });
                        </script>";
  } elseif ($_SESSION['STATUS'] == "LOGIN_SUCCESS") {
    echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Welcome admin!',
                    icon: 'success'
                });
              </script>";
  }
  unset($_SESSION['STATUS']);
}
?>


</html>
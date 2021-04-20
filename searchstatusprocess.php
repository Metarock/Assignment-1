<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c6df42253a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
    <title></title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="container-fluid">
          <div class="navbar-nav">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="./index.html">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./about.html">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./poststatusform.php">Post a Status</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./searchstatusform.html">Search Status</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <?php
      require_once('conf/sqlinfo.inc.php');

      $conn = mysqli_connect($host, $user, $password, $db);

      function findStatus($conn, $table, $statusText){
        $status = "SELECT * FROM $table WHERE status LIKE '%$statusText%'";

        return $status;
      }

      if(!$conn){
        echo "<h1>Connection to SQL has failed</h1>";
        echo "<div class='form-row d-flex justify-content-center text-center'>";
        echo '<div class="form-group col-md-2">';
        echo '<input class ="form-button" type="button" name="" value="Back" onClick="location.href=`searchstatusform.html`">';
        echo "</div></div>";
        die();
      }else{

        //check if table exists
        if(!preg_match('/^[\w.,!?]+$/', $_GET['statustext']) && is_null( $_GET['statustext'])){
          die("<p>The status you are searching for is invalid</p>");
          echo "<div class='form-row d-flex justify-content-center text-center'>";
          echo '<div class="form-group col-md-2">';
          echo '<input class ="form-button" type="button" name="" value="Back" onClick="location.href=`searchstatusform.html`">';
          echo "</div></div>";
        }
        else{
          $statusText = $_GET['statustext'];
        }

        $query = findStatus($conn, $table, $statusText);

        $result = mysqli_query($conn, $query);

        if(!$result || $result->num_rows == 0){
          echo "<div class = 'container py-5'>";
          echo "<h6>FAILED TO READ TABLE</h6>";
          echo "<div class = 'alert alert-danger' role='alert'>";
          echo "<strong>Status Text: ", $query, "</strong>";
          echo "Unable to find text OR does not exist! Please try again.";
          echo "</div></div>";
          echo "<div class='form-row d-flex justify-content-center text-center'>";
          echo '<div class="form-group col-md-2">';
          echo '<input class ="form-button" type="button" name="" value="Search status" onClick="location.href=`searchstatusform.html`">';
          echo '<div class="form-group col-md-2">';
          echo '<input class ="form-button" type="button" name="" value="Home" onClick="location.href=`index.html`">';
          echo "</div></div></div>";
        } else {
          while($row = mysqli_fetch_assoc($result)){
            echo'<div class="container">';
            echo'<h2>Status Code: ', $row["code"], '</h2>';
            echo '<div class="content">';
            echo'<p>Status: ', $row["status"], '</p>';
            echo'<p>Share: ', $row["share"], '</p>';
            echo'<p>Date: ', date('F jS \, Y', strtotime( $row["date"])), '</p>';
            echo'<p>Like: ', $row["likeBoolean"] ? "Allowed" : "Not Allowed", '</p>';
            echo'<p>Comment: ', $row["shareBoolean"]? "Allowed" : "Not Allowed", '</p>';
            echo'<p>Share: ', $row["commentBoolean"]? "Allowed" : "Not Allowed", '</p>';
            echo'</div></div>';
          }
          echo "<div class='form-row d-flex justify-content-center text-center'>";
          echo '<div class="form-group col-md-2">';
          echo '<input class ="form-button" type="button" name="" value="Search" onClick="location.href=`searchstatusform.html`">';
          echo '<div class="form-group col-md-2">';
          echo '<input class ="form-button" type="button" name="" value="Home" onClick="location.href=`index.html`">';
          echo "</div></div></div>";
          //Free up memory, after using the result pointer
          mysqli_free_result($result);
        }
        //close database
        mysqli_close($result)
      }

     ?>

  </body>
</html>

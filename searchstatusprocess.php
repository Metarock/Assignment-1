<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c6df42253a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <title></title>
  </head>
  <body>
    <nav class="navbar navbar-light">
      <a class="nav-link"href="./index.html">Home</a>
      <a class="nav-link"href="./about.html">About</a>
      <a class="nav-link"href="./poststatusform.php">Post a Status</a>
      <a class="nav-link"href="./searchstatusform.html">Search Status</a>
    </nav>
    <?php
      require_once('conf/sqlinfo.inc.php');

      $conn = mysqli_connect($host, $user, $password, $db);

      function findStatus($conn, $table, $statusText){
        $status = "SELECT * FROM $table WHERE status LIKE '%$statusText%'";

        return $status;
      }
      $statusText = $_GET['statustext'];

      if(!$conn){
        echo "<h1>Connection to SQL has failed</h1>";
        die();
      }else{

        //check if table exists
        if(!preg_match('/^[\w.,!?]+$/', $statusText) && is_null($statusText)){
          die("<p>The status you are searching for is invalid</p>");
        }

        $query = findStatus($conn, $table, $statusText);

        $result = mysqli_query($conn, $query);

        if(!$result){
          echo "<p>Failed to read the table, something is wrong with ", $query,"</p>";
        } else {
          while($row = mysqli_fetch_assoc($result)){
            echo'<div class="container">';
            echo'<h2>Status Code: ', $row["code"], '</h2>';
            echo '<div class="content">';
            echo'<p>Status ', $row["status"], '</p>';
            echo'<p>Share: ', $row["share"], '</p>';
            echo'<p>Date: ', date('F jS \, Y', strtotime( $row["date"])), '</p>';
            echo'<p>Like: ', $row["likeBoolean"] ? "Allowed" : "Not Allowed", '</p>';
            echo'<p>Comment: ', $row["shareBoolean"]? "Allowed" : "Not Allowed", '</p>';
            echo'<p>Share: ', $row["commentBoolean"]? "Allowed" : "Not Allowed", '</p>';
            echo'</div></div>';
          }
        }
      }

     ?>

  </body>
</html>

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


    <h1 class = "text-center text-uppercase">Status Processing </h1>
    <?php
    require_once('conf/sqlinfo.inc.php');

    //// TODO:
    // 1. Status (done), Status text (done), share (done)
    $conn = mysqli_connect($host, $user, $password, $db);


    //Create the table of into the server IF IT DOES NOT EXIST YET
    function createTable($conn, $table){
      $createTable = "CREATE TABLE IF NOT EXISTS $table(
        code VARCHAR(5) PRIMARY KEY,
        status VARCHAR(500) NOT NULL,
        share VARCHAR(50) NOT NULL,
        date DATE NOT NULL,
        likeBoolean tinyint(1) NOT NULL,
        commentBoolean tinyint(1) NOT NULL,
        shareBoolean tinyint(1) NOT NULL

      ) ";

    }

    function insertTable($conn, $table,$statusCode, $statusText, $share, $date, $likeable, $commentable, $shareable){
      $insert = "INSERT INTO $table"
                . "(code, status, share, date, likeBoolean, commentBoolean, shareBoolean)"
                . "VALUES"
                ."('$statusCode', '$statusText', '$share', '$date', '$likeable', '$commentable', '$shareable')";
      return $insert;
    }

    function codeExists($conn, $table){
      $code = "SELECT code FROM $table";

      return $code;
    }

    function tableExists($conn, $table){
      $checkTable = "SELECT * FROM $table";

      return $checkTable;
    }

    if(!$conn){
      echo "<p>Connection failed</p>";
      die();

    }else{
      echo "<p>Connection successful</p>";
      //get data from the form and check it is printing out
      $statusCode = $_POST['statuscode'];
      $statusText = $_POST['statustext'];
      $share= $_POST['share'];
      $date = $_POST['date'];
      $permission = $_POST['permission'];

      //validate the input and upon error provide links to return to the Home page and Post Status
      $tableExist = tableExists($conn, $table);

      $exists = mysqli_query($conn, $tableExist);

      if($exists){
        echo "<p>Table exists</p>";
      }
      else{
        echo "<p>Table does not exists. Creating one</p>";

        createTable($conn, $table);
      }


      if(!preg_match('/^S\d{4}$/', $statusCode)){
        //do something here\
        echo "<div class = 'container py-5'>";
        echo "<h4 class = 'text-center text-uppercase'>Invalid Input</h4>";
        echo "<h6>Status Code Invalid</h6>";
        echo "<div class = 'alert alert-danger' role='alert'>";
        echo "<strong>Invalid</strong>";
        echo " The status code is not according to format, please follow the example (S1234)";
        echo "</div></div>";
        die();

      }
      else if(!preg_match('/^[\w.,!?]+$/', $statusText)){

        echo "<div class = 'container py-5'>";
        echo "<h4 class = 'text-center text-uppercase'>Invalid Input</h4>";
        echo "<h6>Status Text is invalid</h6>";
        echo "<div class = 'alert alert-danger' role='alert'>";
        echo "<strong>Invalid</strong>";
        echo " The inputs are empty and needs to be occupied. Please ensure they are filled.";
        echo "</div></div>";
        die();
      }
      else if(empty($share) || empty($date)){
        // echo "<p>The inputs are empty and needs to occupied. Please ensure that they are filled.</p>";
        // echo "<p> Please click go back on home page or post status page to input again</p>";
        echo "<div class = 'container py-5'>";
        echo "<h4 class = 'text-center text-uppercase'>Invalid Input</h4>";
        echo "<h6>Share or Date is not occupied</h6>";
        echo "<div class = 'alert alert-danger' role='alert'>";
        echo "<strong>Invalid</strong>";
        echo " The inputs are empty and needs to be occupied. Please ensure they are filled.";
        echo "</div></div>";
        die();
      }

      $codeQuery = codeExists($conn, $table);


      $result = mysqli_query($conn, $codeQuery);

      //if there are no data in the table, code can ignore this.
      if(mysqli_num_rows($result) != 0){
        while($row = mysqli_fetch_assoc($result)){
          if($row['code'] == $statusCode){
            echo "<div class = 'container py-5'>";
            echo "<h4 class = 'text-center text-uppercase'>Invalid Input</h4>";
            echo "<h6>Status Code ERROR</h6>";
            echo "<div class = 'alert alert-danger' role='alert'>";
            echo "<strong>Invalid</strong>";
            echo "Status Code: ", $statusCode, " already exists!!";
            echo "</div></div>";
            die();
          }
        }
      }

      $date = date('d/m/Y', strtotime($date));

      //check if date is valid
      $testDate = explode('/', $date);
      $validDate = checkdate($testDate[0], $testDate[1], $testDate[2]);

      if(!validDate){
        die("<p>Invalid date, please input again</p>");
      }

      //permission, setting it to false first;
      $likeable = 0;
      $commentable = 0;
      $shareable = 0;
      if(empty($permission)){
        die("<p>Permissions are not set, please return and enter your input.</p>");
      }else{
        foreach($permission as $value){
          if($value === "like"){
            $likeable = 1;
          }
          if($value === "comment"){
            $commentable = 1;
          }
          if($value === "share"){
            $shareable = 1;
          }
        }
      }


      //format date for sql
      $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

      //insert table
      $insert = insertTable($conn, $table, $statusCode, $statusText, $share, $date, $likeable, $commentable, $shareable);

      echo $insert;

      $result = mysqli_query($conn, $insert);

      if(!$result){
        echo "<p>Oops something went wrong</p>";
        //If status code exists
      } else{
        echo "<p>Successfully posted and stored into $table database</p>";
      }

    } //if connection is successful





    ?>

  </body>
</html>

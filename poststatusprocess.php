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
  <!-- Used navbar for easier navigation for users -->
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
    $conn = mysqli_connect($host, $user, $password, $db);

    //--------------------------FUNCTIONS----------------------------------------//

    //Create the table of into the server IF IT DOES NOT EXIST YET
    function createTable($table){
      $createTable = "CREATE TABLE $table(
        code VARCHAR(5),
        status VARCHAR(500) NOT NULL,
        share VARCHAR(50) NOT NULL,
        date DATE NOT NULL,
        likeBoolean tinyint(1) NOT NULL,
        commentBoolean tinyint(1) NOT NULL,
        shareBoolean tinyint(1) NOT NULL,
        PRIMARY KEY (code)
      ) ";

      return $createTable;
    }

    function insertTable($table,$statusCode, $statusText, $share, $date, $likeable, $commentable, $shareable){
      $insert = "INSERT INTO $table"
                . "(code, status, share, date, likeBoolean, commentBoolean, shareBoolean)"
                . "VALUES"
                ."('$statusCode', '$statusText', '$share', '$date', '$likeable', '$commentable', '$shareable')";
      return $insert;
    }

    function codeExists($table){
      $code = "SELECT code FROM $table";

      return $code;
    }

    function tableExists($table){
      $checkTable = "SELECT * FROM $table";

      return $checkTable;
    }

    //------------------------------------------------------------------//

    //Check if connection is working 
    if(!$conn){
      echo "<p>Connection failed</p>";
      die();

    }else{
      //get data from the form and check it is printing out
      $statusCode = $_POST['statuscode'];
      $statusText = $_POST['statustext'];
      $share= $_POST['share'];
      $date = $_POST['date'];
      $permission = $_POST['permission'];

      //validate table exists
      $tableExist = tableExists($table);


      
      $result = mysqli_query($conn, $tableExist);

      if(empty($result)){ //if table does not exist, create a new one
        echo "<div class = 'container py-5'>";
        echo "<h4 class = 'text-center text-uppercase'>Table does not exists. Creating one</h4>";
        echo "</div>";

        $createTable = createTable($table);

        $result = mysqli_query($conn, $createTable);
      }
      else{ //if data succeeds, proceed forward
        echo "<div class = 'container py-5'>";
        echo "<h4 class = 'text-center text-uppercase'>Connected</h4>";
        echo "</div>";
      }

      //if user does not input a letter followed by 4 digit numbers then print an error message
      if(!preg_match('/^S\d{4}$/', $statusCode)){
        echo "<div class = 'container py-5'>";
        echo "<h4 class = 'text-center text-uppercase'>Invalid Input</h4>";
        echo "<h6>Status Code Invalid</h6>";
        echo "<div class = 'alert alert-danger' role='alert'>";
        echo "<strong>Invalid Code</strong>";
        echo " The status code is not according to format, please follow the example (S1234)";
        echo "</div></div>";
        echo "<div class='form-row d-flex justify-content-center text-center'>";
        echo '<div class="form-group col-md-2">';
        echo '<input class ="form-button" type="button" name="" value="Post Status" onClick="location.href=`poststatusform.php`">';
        echo "</div></div>";
        echo "<div class='form-row d-flex justify-content-center text-center'>";
        echo '<div class="form-group col-md-2">';
        echo '<input class ="form-button" type="button" name="" value="Back Home" onClick="location.href=`index.html`">';
        echo '</div></div>';
        die();

      } //if user inputs symbols and other special characters print an error message
      else if(!preg_match('/^[\w.,!?]+$/', $statusText)){

        echo "<div class = 'container py-5'>";
        echo "<h4 class = 'text-center text-uppercase'>Invalid Input</h4>";
        echo "<h6>Status Text is invalid</h6>";
        echo "<div class = 'alert alert-danger' role='alert'>";
        echo "<strong>Invalid</strong>";
        echo " The inputs are empty and needs to be occupied OR it's not valid. Please ensure they are filled AND valid.";
        echo "</div></div>";
        echo "<div class='form-row d-flex justify-content-center text-center'>";
        echo '<div class="form-group col-md-2">';
        echo '<input class ="form-button" type="button" name="" value="Post Status" onClick="location.href=`poststatusform.php`">';
        echo "</div></div>";
        echo "<div class='form-row d-flex justify-content-center text-center'>";
        echo '<div class="form-group col-md-2">';
        echo '<input class ="form-button" type="button" name="" value="Back Home" onClick="location.href=`index.html`">';
        echo '</div></div>';
        die();
      }
      else if(empty($share) || empty($date)){
        echo "<div class = 'container py-5'>";
        echo "<h4 class = 'text-center text-uppercase'>Invalid Input</h4>";
        echo "<h6>Share or Date is not occupied</h6>";
        echo "<div class = 'alert alert-danger' role='alert'>";
        echo "<strong>Invalid share or date</strong>";
        echo " The inputs are empty and needs to be occupied. Please ensure they are selected.";
        echo "</div></div>";
        echo "<div class='form-row d-flex justify-content-center text-center'>";
        echo '<div class="form-group col-md-2">';
        echo '<input class ="form-button" type="button" name="" value="Post Status" onClick="location.href=`poststatusform.php`">';
        echo "</div></div>";
        echo "<div class='form-row d-flex justify-content-center text-center'>";
        echo '<div class="form-group col-md-2">';
        echo '<input class ="form-button" type="button" name="" value="Back Home" onClick="location.href=`index.html`">';
        echo '</div></div>';
        die();
      }

      $codeQuery = codeExists($table);


      $result = mysqli_query($conn, $codeQuery);

      //if there are no data in the table, code can ignore this.
      if(mysqli_num_rows($result) != 0){
        //this is to validate the status code exists 
        while($row = mysqli_fetch_assoc($result)){
          if($row['code'] == $statusCode){
            echo "<div class = 'container py-5'>";
            echo "<h4 class = 'text-center text-uppercase'>Invalid Input</h4>";
            echo "<h6>Status Code ERROR</h6>";
            echo "<div class = 'alert alert-danger' role='alert'>";
            echo "<strong>Invalid</strong>";
            echo "Status Code: ", $statusCode, " already exists!!";
            echo "</div></div>";
            echo "<div class='form-row d-flex justify-content-center text-center'>";
            echo '<div class="form-group col-md-2">';
            echo '<input class ="form-button" type="button" name="" value="Post Status" onClick="location.href=`poststatusform.php`">';
            echo "</div></div>";
            echo "<div class='form-row d-flex justify-content-center text-center'>";
            echo '<div class="form-group col-md-2">';
            echo '<input class ="form-button" type="button" name="" value="Back Home" onClick="location.href=`index.html`">';
            echo '</div></div>';
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
        //loop through the array of permissions and set their values to true
        //if user has it selected
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
      $insert = insertTable($table, $statusCode, $statusText, $share, $date, $likeable, $commentable, $shareable);

      $result = mysqli_query($conn, $insert);

      //If return value of result is null or false
      if(!$result){
        echo "<div class = 'container py-5'>";
        echo "<h6>ERROR</h6>";
        echo "<div class = 'alert alert-danger' role='alert'>";
        echo "<strong>Invalid</strong>";
        echo "Inserting failed!!";
        echo "</div></div>";
        echo "<div class='form-row d-flex justify-content-center text-center'>";
        echo '<div class="form-group col-md-2">';
        echo '<input class ="form-button" type="button" name="" value="Post status" onClick="location.href=`poststatusform.php`">';
        echo "</div></div>";
        echo "<div class='form-row d-flex justify-content-center text-center'>";
        echo '<div class="form-group col-md-2">';
        echo '<input class ="form-button" type="button" name="" value="Back Home" onClick="location.href=`index.html`">';
        echo '</div></div>';
        //If status code exists
      } else{ //if connection is successful
        echo "<div class = 'container py-5'>";
        echo "<h4 class = 'text-center text-uppercase'>SUCCESS</h4>";
        echo "<h6>Inserting table success!</h6>";
        echo "</div>";
        echo "<div class='form-row d-flex justify-content-center text-center'>";
        echo '<div class="form-group col-md-2">';
        echo '<input class ="form-button" type="button" name="" value="Create a new post" onClick="location.href=`poststatusform.php`">';
        echo "</div></div>";
        echo "<div class='form-row d-flex justify-content-center text-center'>";
        echo '<div class="form-group col-md-2">';
        echo '<input class ="form-button" type="button" name="" value="Back Home" onClick="location.href=`index.html`">';
        echo '</div></div>';
      }

    } 
    //close database
    mysqli_close($result)
    ?>
  </body>
</html>

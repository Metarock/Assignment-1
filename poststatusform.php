<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c6df42253a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
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
    <h1 class="heading">Status Posting System</h1>

    <form class="" action="./poststatusprocess.php" method="post">
      <div class="form-row d-flex justify-content-center text-center">
        <div class="form-group">
          <label for="">Status Code</label>
          <input class="form-control" type="text" name="statuscode" maxlength="5" required/>
        </div>
        <div class="form-group">
          <label for="">Status</label>
          <input class="form-control" type="text" name="statustext" value="" required/><br>
        </div>
      </div>

      <label class="" for="">Share</label>
      <div class="form-row d-flex justify-content-center text-center">
        <div class="form-group col-md-1">
          <input type="radio" class="form-control" name="share" value="public">
          <label for="public">Public</label>
        </div>

        <div class="form-group col-md-1">
          <input type="radio"class="form-control" name="share" value="friends">
          <label for="friends">Friends</label>
        </div>
        <div class="form-group col-md-1">
          <input type="radio" class="form-control"name="share" value="self">
          <label for="self">Only Me</label> <br>
        </div>
      </div>

      <div class="form-group">
        <label for="">Date: </label><input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" /><br>
      </div>

      <div class="form-group">
        <label for="">Permission Type: </label>
        <label><input type ="checkbox" name="permission[]" value="like"/>Allow like</label>
        <label><input type ="checkbox" name="permission[]" value="comment"/>Allow comment</label>
        <label><input type ="checkbox" name="permission[]" value="share"/>Allow share</label> <br>
      </div>



      <div class="form-row d-flex justify-content-center text-center">
        <div class="form-group col-md-1">
          <input class ="btn btn-primary active" type="submit" name="" value="Submit">
        </div>
        <div class="form-group col-md-1">
          <input class ="btn btn-warning active" type="reset" name="" value="Reset"> <br>
        </div>

      </div>

      <a class=""href="./index.html">Return to Home Page</a>
    </form>
  </body>
</html>

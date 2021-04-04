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
    <nav class="navbar navbar-light">
      <a class="nav-link"href="./index.html">Home</a>
      <a class="nav-link"href="./about.html">About</a>
      <a class="nav-link"href="./poststatusform.php">Post a Status</a>
      <a class="nav-link"href="./searchstatusform.html">Search Status</a>
    </nav>
    <h1 class="heading">Status Posting System</h1>

    <form class="" action="./poststatusprocess.php" method="post">
      <label for="">Status Code(Required)</label><input type="text" name="statuscode" maxlength="5" required/><br>
      <label for="">Status (required)</label><input type="text" name="statustext" value="" required/><br>

      <label for="">Share</label>
      <input type="radio" name="share" value="public">
      <label for="public">Public</label>
      <input type="radio" name="share" value="friends">
      <label for="friends">Friends</label>
      <input type="radio" name="share" value="self">
      <label for="self">Only Me</label> <br>

      <label for="">Date: </label><input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" /><br>

      <label for="">Permission Type: </label>
      <label><input type ="checkbox" name="permission[]" value="like"/>Allow like</label>
      <label><input type ="checkbox" name="permission[]" value="comment"/>Allow comment</label>
      <label><input type ="checkbox" name="permission[]" value="share"/>Allow share</label> <br>

      <input class ="btn btn-primary active" type="submit" name="" value="Submit">
      <input class ="btn btn-warning active" type="reset" name="" value="Reset"> <br>

      <a class=""href="./index.html">Return to Home Page</a>
    </form>
  </body>
</html>


 <!-- <div class="row">
  <div class="mx-auto col-sm-6">
    <div class="card">
      <div class="card-header">
        <h4>Status Form Information</h4>
      </div>
      <div class="class-body">
        <form class="form" action="./poststatusprocess.php" method="post">
          <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Status Code(Required)</label>
              <div class="col-lg-9">
                <input class="form-control" type="text" name="statuscode" maxlength="5" required/>
              </div>
          </div>
          <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Status (Required)</label>
              <div class="col-lg-9">
                  <input class = "form-control" type="text" name="statustext" value="" required/>
              </div>
          </div>
          <div class="form-group row">
            <label class ="col-lg-3 col-form-label form-control-label">Share</label>
            <div class="col-lg-9">
              <input class = "form-control" type="radio" name="share" value="public">
              <label for="public">Public</label>
              <input class = "form-control" type="radio" name="share" value="friends">
              <label for="friends">Friends</label>
              <input class = "form-control" type="radio" name="share" value="self">
              <label for="self">Only Me</label>
            </div>
          </div>
          <div class="form-group rpw">
            <label class = "col-lg-3 col-form-label form-control-label">Date: </label>
            <div class="col-lg-9">
              <input class = "form-control" type="date" name="date" value="<?php echo date('Y-m-d'); ?>" />
            </div>
          </div>
          <div class="form-group rpw">
            <label class = "col-lg-3 col-form-label form-control-label">Permission Type: </label>
            <div class="col-lg-9">
              <label><input class = "form-control" type ="checkbox" name="permission[]" value="like"/>Allow like</label>
              <label><input class = "form-control" type ="checkbox" name="permission[]" value="comment"/>Allow comment</label>
              <label><input class = "form-control" type ="checkbox" name="permission[]" value="share"/>Allow share</label>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label"></label>
            <div class="col-lg-9">
              <input class ="btn btn-primary" type="submit" name="" value="Submit">
              <input class ="btn btn-secondary" type="reset" name="" value="Reset">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div> -->

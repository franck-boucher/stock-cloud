<?php
  include("core.php");

  if (isset($_POST['pwd']))
  {
    if(check_password($_POST['pwd']))
    {
      $_SESSION['pwd'] = 'connected';
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Stock Cloud- fboucher</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/docs.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="navbar-static-top.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Static navbar -->
    <div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Stock Cloud</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php" title="Download"><span class="glyphicon glyphicon-cloud-download"></span></a></li>
            <li class="active" title="Upload"><a href="upload.php"><span class="glyphicon glyphicon-cloud-upload"></span></a></li>
            <li>
              <?php
              if($_SESSION['pwd'] == 'connected')
                {
                  echo '<a href="logout.php" title="Sign out"><span class="glyphicon glyphicon-star-empty"></span></a>';
                } else {
                  echo '<a href="#" title="Sign in" data-toggle="modal" data-target=".bs-example-modal-sm"><span class="glyphicon glyphicon-star"></span></a>';
                }
              ?>

            </li>
              
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li><a href="./" title="About Stock Cloud">About</a></li>
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <!-- Modal Prompt-->
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <form role="form" method="post" action="upload.php">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title" id="myModalLabel">Admin password</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <input id="pwd" name="pwd" type="password" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Sign in</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron" style="text-align: center;">

        <form method="POST" action="index.php" enctype="multipart/form-data">
        <!-- On limite le fichier à 700Mo -->
        <input type="hidden" name="MAX_FILE_SIZE" value="700000000">
        <legend>Upload</legend>
        <input type="file" name="avatar" class="form-control"><br/>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>

      </div>

    </div> <!-- /container -->

<footer class="bs-docs-footer" role="contentinfo">
  <div class="container">

    <p>Designed and built by <a href="https://github.com/franck-boucher/">Franck Boucher</a>.</p>
    <p>Powered by the <a href="http://getbootstrap.com">Bootstrap</a> and <a href="http://glyphicons.com">Glyphicons</a>.</p>
  </div>
</footer>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  

</body>

</html>
<?php
  include("core.php");
  
  if (isset($_POST['pwd']))
  {
    if(check_password($_POST['pwd']))
    {
      $_SESSION['pwd'] = 'connected';
    } else {
    }
  }

  if (!empty($_FILES['avatar']['name']))
  {
    $dossier = '../downloads/';
    $fichier = basename($_FILES['avatar']['name']);
    $taille_maxi = 800000000;
    $taille = filesize($_FILES['avatar']['tmp_name']);
    $extensions = array('.html', '.htm', '.xhtml', '.css', '.js', '.php');
    $extension = strrchr($_FILES['avatar']['name'], '.'); 
    //Début des vérifications de sécurité...
    if(in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
    {
         $erreur = 'Stock Cloud does not host script files';
    }
    if($taille>$taille_maxi)
    {
         $erreur = 'This file is too big';
    }

    if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
    {
         //On formate le nom du fichier ici...
         $fichier = strtr($fichier, 
              'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
              'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
         $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
         if(!move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
         {
          echo 'Failed to upload !';
         }
    }
    else
    {
         echo $erreur;
    }
  }

  if (isset($_POST['del']) && isset($_POST['chemin']))
  {
    $dir = opendir($_POST['chemin']);
    if (file_exists($_POST['chemin'].DIRECTORY_SEPARATOR.$_POST["del"]))
    {
      unlink($_POST['chemin'].DIRECTORY_SEPARATOR.$_POST["del"]);
    }
    closedir($dir);
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

    <?php
      function explorer($chemin){
          $lstat    = lstat($chemin);
          $mtime    = date('d/m/Y H:i:s', $lstat['mtime']);
          $filetype = filetype($chemin);
           
          // Affichage des infos sur le fichier $chemin
          //echo "type: $filetype size: $lstat[size]  mtime: $mtime <br/>";
           
          // Si $chemin est un dossier => on appelle la fonction explorer() pour chaque élément (fichier ou dossier) du dossier$chemin
          if( is_dir($chemin) ){
              $me = opendir($chemin);
              while( $child = readdir($me) ){
                  if( $child != '.' && $child != '..' ){
                      if(filetype($chemin.DIRECTORY_SEPARATOR.$child) == "dir") {
                        explorer( $chemin.DIRECTORY_SEPARATOR.$child );
                      } else {
                          $icon = icon($file);
                        echo '<tr>
                                <td><span class="'. icon($child) .'"></span></td>
                                <td><a href="' . $chemin.DIRECTORY_SEPARATOR.$child . '">' . $child . '</a></td>
                                <td>'. taille_fichier($chemin.DIRECTORY_SEPARATOR.$child) .'</td>';

                        if($_SESSION['pwd'] == 'connected')
                          {
                      ?>
                            <td>
                              <a href="javascript:void(0)" onclick="document.getElementById('form1').elements['chemin'].value='<?php echo $chemin; ?>'; document.getElementById('form1').elements['del'].value='<?php echo $child; ?>'; document.getElementById('form1').submit(); return false;">
                                <span class="glyphicon glyphicon-remove"></span>
                              </a>
                            </td>
                      <?php
                          }

                        echo '  </tr>';
                      }
                  }
              }
          }
      }
    ?>

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
            <li class="active"><a href="index.php" title="Download"><span class="glyphicon glyphicon-cloud-download"></span></a></li>
            <li><a href="upload.php" title="Upload"><span class="glyphicon glyphicon-cloud-upload"></span></a></li>
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
          <form role="form" method="post" action="index.php" name="modal">
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
      <div class="jumbotron">

      <?php

        if($dossier = opendir('../downloads'))
        {
          if($_SESSION['pwd'] == 'connected') {
      ?>
            <form action="index.php" method="post" id="form1" style="display:none" >
              <input type="hidden" name="chemin" value="" />
              <input type="hidden" name="del" value="" />
            </form>
      <?php 
          }
      ?>

      <table class="table table-striped">
          <thead>
            <tr>
              <th></th>
              <th>File Name</th>
              <th>Size</th>
              <?php
                if($_SESSION['pwd'] == 'connected') {
                  echo '<th></th>';
                }
              ?>
            </tr>
          </thead>
          <tbody>

      <?php
         explorer("../downloads");
      ?>
          </tbody>
        </table>

        <?php
          } else {
            echo "Erreur de dossier !";
          }
        ?>

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
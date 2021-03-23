<?php
session_start();
$connection = mysqli_connect("localhost","root", "","espace_membre");
$query = "SELECT * FROM membres WHERE NOT(mail = 'admin') "; // Liste des joueurs
$query2 = "SELECT mail, pseudo , score_max FROM parties NATURAL JOIN membres "; // historique joueurs (chaque joueur avec son score_max dans le jeu)
$result = mysqli_query($connection, $query);
$result2 = mysqli_query($connection,$query2);

?>
<!doctype html>
  <head>
    <title>Trips &mdash; Website Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="fonts/icomoon/style.css"> <!-- ICON DE LA VIDEO -->
    <link rel="stylesheet" href="css/bootstrap.min.css"> <!-- STYLE CSS-->
    <link rel="stylesheet" href="css/jquery.fancybox.min.css"> <!-- VIDEO -->
    <link rel="stylesheet" href="css/aos.css">  <!-- ANIMATION PREMIER PARAGRAPHE-->
    
    <script src="http://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="css/style.css">  

  </head>

  <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
      
    
    <div class="site-wrap" id="home-section">

      <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
          <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
          </div>
        </div>
        <div class="site-mobile-menu-body"></div>
      </div>



      <header class="site-navbar site-navbar-target" role="banner">

        <div class="container">
          <div class="row align-items-center position-relative">

            <div class="col-3 ">
              <div class="site-logo">
                <a href="admin.php?id=<?php echo $_SESSION['id']?>" class="font-weight-bold">
                  <img src="images/logo3.png" alt="Image" class="img-fluid">
                </a>
              </div>
            </div>

            <div class="col-9  text-right">
              

              <?php
              $bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', ''); // recupération de l'identifiant de l'admin
              if(isset($_GET['id']) AND $_GET['id'] >0 )
                 {
                     $getid = intval($_GET['id']);
                     $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
                     $requser-> execute(array($getid));
                     $userinfo = $requser->fetch(); 
              ?>

              <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                <ul class="site-menu main-menu js-clone-nav ml-auto ">
                  <li class="active"><a href="admin.php?id=<?php echo $_SESSION['id']?>" class="nav-link">Accueil</a></li>
                  <li class="nav-link"><?php echo $userinfo['pseudo']; ?></li>
                <?php
                 if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
                    {
                 ?>
                       <li class="nav-link"><a href="deconnexion.php">Se déconnecter</a></li>
                 <?php  
                    }
                 ?>
                </ul>
              </nav>
            </div>
            <?php
              }
              ?>
             
            
          </div>
        </div>

      </header>
    
    <footer class="site-footer bg-light">
      <h3 style="text-align:center; background-color:#ffa110 ; horizontal-align:center">Liste des joueurs </h3>
    <div>
    <?php // event handler pour supprimer un utilisateur quand le bouton Supprimer est cliqué
       if(array_key_exists('supprimer',$_POST)) { 
        $getid = strval($_POST['id_sup']);
        $bdd1 = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $query1 =$bdd1->prepare('DELETE FROM membres where mail= ?') ; 
        $query1-> execute(array($getid));
        header("refresh:0");

    } 
    ?> 
    <table  class="table-memebres"  style="border: 1px solid #1C6EA4; background-color: #EEEEEE;width: 100%;text-align: left;border-collapse: collapse;  border-bottom: 2px solid #444444;border-top: 2px solid #444444;">
      <tr> <!-- une table qui contient la liste des joueurs-->
      <th style="border: 1px solid #AAAAAA;padding: 3px 2px;" >pseudo</th>
      <th style="border: 1px solid #AAAAAA;padding: 3px 2px;"  >mail</th>
      <th style="border: 1px solid #AAAAAA;padding: 3px 2px;"  >Action</th>
  </tr>
    <?php
    while ($rows=mysqli_fetch_assoc($result)) // boucle qui construit la table (affichage)
          {
            ?>
            <tr>
            <td value=<?php echo $rows['pseudo']; ?> style="border: 1px solid #AAAAAA;padding: 3px 2px;"  ><?php echo " ".$rows['pseudo']." "; ?></td>
            <td value=<?php echo $rows['mail']; ?> style="border: 1px solid #AAAAAA;padding: 3px 2px;"  ><?php echo " ".$rows['mail']." "; ?></td>
            <td  style="border: 1px solid #AAAAAA;padding: 3px 2px;"  >
            <form method="post" >
            <input type="hidden" name="id_sup" value=<?php echo $rows['mail']; ?> />
            <button type="submit"  name="supprimer"  style="color:  #ffa110 ; background-color : #fff"value=<?php echo " ".$rows['mail']." "; ?>>Supprimer </button>
            </form>
          </td>
            <tr>
           
         <?php
          }
          ?>
    </table>
        </br>
        <h3 style="text-align:center; background-color:#ffa110 ; horizontal-align:center">Historique joueurs </h3>

    </div>
    <div> 
    <table  class="table-scores"  style="border: 1px solid #1C6EA4; background-color: #EEEEEE;width: 100%;text-align: left;border-collapse: collapse;  border-bottom: 2px solid #444444;border-top: 2px solid #444444;">
      <tr> <!-- une table qui contient l'historique des joueurs-->
      <th style="border: 1px solid #AAAAAA;padding: 3px 2px;" >pseudo</th>
      <th style="border: 1px solid #AAAAAA;padding: 3px 2px;"  >mail</th>
      <th style="border: 1px solid #AAAAAA;padding: 3px 2px;"  >Score</th>
  </tr>
    <?php
    while ($rows2=mysqli_fetch_assoc($result2)) // boucle qui construit la table (affichage)
          {
            ?>
            <tr>
            <td value=<?php echo $rows2['pseudo']; ?> style="border: 1px solid #AAAAAA;padding: 3px 2px;"  ><?php echo " ".$rows2['pseudo']." "; ?></td>
            <td value=<?php echo $rows2['mail']; ?> style="border: 1px solid #AAAAAA;padding: 3px 2px;"  ><?php echo " ".$rows2['mail']." "; ?></td>
            <td style="border: 1px solid #AAAAAA;padding: 3px 2px;"><?php echo $rows2['score_max']; ?> </td>
            <tr>
           
         <?php
          }
          ?>
    </table>
    </div>
        </div>
        <div class="row pt-5 mt-5 text-center"> <!-- FIN PARTIE CONTACT-->
          <div class="col-md-12">
            <div class="border-top pt-5">
              <p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This project is made with <i class="icon-heart text-danger" aria-hidden="true"></i> 
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
            </div>
          </div>

        </div>
      </div>  
    </footer>

    </div>
    
    <script src="js/insc.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>  
    <script src="js/owl.carousel.min.js"></script>  <!-- SLIDER --> 
    <script src="js/jquery.fancybox.min.js"></script>   <!-- VIDEO -->
    <script src="js/aos.js"></script>  <!-- LES ECRITURES -->
    <script src="js/main.js"></script>  <!-- LES ECRITURES -->

  </body>
  <?php
  ob_end_flush();?>
</html>

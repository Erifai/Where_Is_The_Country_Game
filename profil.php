<?php
session_start();
?>
<!doctype html>
  <head>
    <title>Trips &mdash; Website Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="fonts/icomoon/style.css"> <!-- ICON DE LA VIDEO -->
    <link rel="stylesheet" href="css/profil.css">
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
                <a href="profil.php?id=<?php echo $_SESSION['id']?>" class="font-weight-bold">
                  <img src="images/logo3.png" alt="Image" class="img-fluid">
                </a>
              </div>
            </div>

            <div class="col-9  text-right">
              

              <?php
              $bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', ''); // recupération de l'identifiant de l'utilisateur connecté
              if(isset($_GET['id']) AND $_GET['id'] >0 )
                 {
                     $getid = intval($_GET['id']);
                     $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
                     $requser-> execute(array($getid));
                     $userinfo = $requser->fetch(); 
              ?>

              <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                <ul class="site-menu main-menu js-clone-nav ml-auto ">
                  <li class="active"><a href="profil.php?id=<?php echo $_SESSION['id']?>" class="nav-link">Accueil</a></li>
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

    <div class="ftco-blocks-cover-1">
      <div class="site-section-cover overlay" style="background-image: url('images/travel2.jpg')">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-5" data-aos="fade-right">
              <h1 class="mb-3 text-white">Aimez-vous voyager ?</h1>
              <p>Venez apprendre la localisation des pays du monde par un simple Quiz et choisissez votre destination  </p>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="site-section py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="heading-39101 mb-5">
              <span class="backdrop">Quiz</span>
              <span class="subtitle-39191">A quoi sert !</span> <!--description du site-->
              <h3>Notre Quiz</h3>
            </div>
            <p>Notre site propose un quiz qui vous fait apprendre la localisation des pays du monde, c'est un jeu interactif (à connotation culturelle). Leprincipe général  est  de  proposer  des questionnaires constituésde  5 questions (Drapeau?  =>c’est où sur la carte du monde?).  Le  «plateau»  du  jeu  sera  tout simplement la carte du monde. Chaque question consiste à localiser à l’aide d’un clic  de  souris,  l’emplacement du  pays représenté  par  son  drapeau dans  la question.</p>
            <p>Commencer en choisissant <a href="#continent">un continent</a>.</p>
            <p>Pour jouer en mode planète ou avoir plus de pays <a href="#inscription">inscrivez vous</a>.</p>
          </div>
          <div class="col-md-6" data-aos="fade-right">
            <img src="images/traveler.jpg" alt="Image" class="img-fluid">
          </div>
        </div>
      </div>  
    </div>
   
    <div class="site-section">

      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-7">
            <div  id="continent" class="heading-39101 mb-5">
              <span class="backdrop text-center">Continent</span> <!-- mode continent -->
              <span class="subtitle-39191">Jouer en mode Continent</span>
              <h3>Choisissez un pour commencer</h3>
            </div>
          </div>
        </div>
      <form method="post" section="donnee.php">  
        <div class="row">
          <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
            <div class="listing-item">
              <div class="listing-image">
                <img src="images/asie.jpg" alt="Image" class="img-fluid">
              </div>
              <div class="listing-item-content">
                <!--   <a class="px-3 mb-3 category bg-primary" href="#">$200.00</a> -->
                <h2 class="mb-1"><a href="monJeux/asie/StamenTileLayer.php?id=<?php echo ($_SESSION['id']); ?>">L'ASIE</a></h2>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
           <div class="listing-item">
              <div class="listing-image">
                <img src="images/america2.jpg" alt="Image" class="img-fluid">
              </div>
              <div class="listing-item-content">
                <h2 class="mb-1"><a href="monJeux/amerique/StamenTileLayer.php?id=<?php echo ($_SESSION['id']); ?>">L'AMÉRIQUE</a></h2>
              </div>                                                             <!--Pour stocker l'id de l'utilisateur-->
              </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
            <div class="listing-item">
              <div class="listing-image">
                <img src="images/africa.jpg" alt="Image" class="img-fluid">
              </div>
              <div class="listing-item-content">
                <h2 class="mb-1"><a href="monJeux/afrique/StamenTileLayer.php?id=<?php echo ($_SESSION['id']); ?>">L'AFRIQUE</a></h2>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
            <div class="listing-item">
              <div class="listing-image"> 
               <a href="modeinvite.php"> <img src="images/europe.jpg" alt="Image" class="img-fluid"/></a>
              </div>
              <div class="listing-item-content">
                <h2 class="mb-1"><a href="monJeux/europe/StamenTileLayer.php?id=<?php echo ($_SESSION['id']); ?>">L'EUROPE</a></h2>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
            <div class="listing-item">
              <div class="listing-image">
                <img src="images/oceania.jpg" alt="Image" class="img-fluid">
              </div>
              <div class="listing-item-content">
                <h2 class="mb-1"><a href="monJeux/oceanie/StamenTileLayer.php?id=<?php echo ($_SESSION['id']); ?>">L'OCÉANIE</a></h2>
              </div>
            </div>
          </div>

          
        </div>
      </form>  
      </div>
    </div>


    <div class="site-section">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-7">
            <div  id="continent" class="heading-39101 mb-5">
              <span class="backdrop text-center">Planète</span> <!-- partie planete -->
              <span class="subtitle-39191">Jouer en mode Planète</span>
             
            </div>
          </div>
        </div>
        <div class="row">
          <div class="world" data-aos="fade-up">
            <div class="listing-item">
             <div class="listing-image">
             <a  href="modeinvite.php"><img src="images/world3.jpg" alt="Image" class="img-fluid"></a>
             <div class="listing-item-content">
                <h2 class="mb-1"><a href="monJeux/planete/StamenTileLayer.php">Planète</a></h2>
              </div>
             </div>
            </div> 
          </div>
         
        </div>
      </div>  
    </div>

    <div class="site-section">

   
    <body> 
    </body>
      
    <div class="site-section bg-image overlay" style="background-image: url('images/travel2.jpg')">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 text-center">
            <p id="myBtn" class="mb-0"><a  class="btn btn-primary text-white py-3 px-4">Commencer le Quiz</a></p> 
          </div>
        </div>
      </div>
    </div>

    <div id="myModal" class="modal"> 
    <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p><a href="#continent">Veuillez choisir le mode pour commencer</a></p>
  </div>
  </div>

    <footer class="site-footer bg-light"> <!-- FIN PARTIE CONTACT-->

        
        </div>
        <div class="row pt-5 mt-5 text-center">
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

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

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

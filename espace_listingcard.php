<?php 
require_once("lib/functions.php");
require_once("ini.php");

if(SRequest::getInstance()->get('del') !==null) {
    SRequest::getInstance()->unset('session',APP_TAG);
    header('Location:index.php?del');
    exit;
}

try {
    
    $card_model =new CardModel( SPDO::getInstance( DB_HOST, DB_NAME, DB_LOGIN, DB_PWD )->getPDO());
    
    if(isset($_SESSION[APP_TAG]['user'])) {
        $user =  unserialize($_SESSION[APP_TAG]['user']);
    }

    if(SRequest::getInstance()->post('delete')){
        $target = $user_model->ReadOne(SRequest::getInstance()->post('delete'));

        if ( ($error = $user->ValidDel($target)) === true){
                $delete = $user_model->DeleteUser(SRequest::getInstance()->post('delete'));
                unset($error);
        }
    }

    $listing_card = $card_model->ReadAll();
} catch (Exception $e) {
        // header('Location: 404.php');
        // exit;
}

?><!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>espace_cartes</title>

        <!-- Fontfaces CSS-->
        <link href="./assets/css/font-face.css" rel="stylesheet" media="all">
        <link href="./assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
        <link href="./assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
        <link href="./assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

        <!-- Bootstrap CSS-->
        <link href="./assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

        <!-- Vendor CSS-->
        <link href="./assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
        <link href="./assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
        <link href="./assets/vendor/wow/animate.css" rel="stylesheet" media="all">
        <link href="./assets/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
        <link href="./assets/vendor/slick/slick.css" rel="stylesheet" media="all">
        <link href="./assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
        <link href="./assets/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

        <!-- Main CSS-->
        <link href="https://fonts.googleapis.com/css?family=Barlow" rel="stylesheet"> 
        <link href="./assets/css/font.css" rel="stylesheet" media="all">
        <link href="./assets/css/cardAdmin.css" rel="stylesheet" media="all">
        <link href="./assets/css/theme.css" rel="stylesheet" media="all">
    </head>

        <?php include('nav.php'); ?>

    <body class="animsition" style="animation-duration: 900ms; opacity: 1;">
    <main class="page-content--bge5" style="" >  
     <!--il y a un height 100vs a viré dans bootstrap pour aggrandir le gris  -->
        <section class="p-t-20">
          
             <div class="container">
                <div class="row">
                <h3 class="title-5 m-b-35">Listing des Cartes</Canvas></h3>
                    <div class="col-md-12" style="display:flex; flex-wrap:inherit; flex-direction:row;">
                        
                           
                        <?php 
                        foreach ($listing_card as $key => $card) {
                            echo $card->ShowCard();
                        }
                        ?>    

                    </div>
                </div>
            </div>
            </section>

             <?php if(isset($delete)) echo'<div class="alert alert-success" role="alert"> '.$delete.' </div>'; ?> 
        </main>



     <!-- Jquery JS-->
  <script src="./assets/vendor/jquery-3.2.1.min.js"></script>
  <!-- Bootstrap JS-->
  <script src="./assets/bootstrap-4.1/popper.min.js"></script>
  <script src="./assets/bootstrap-4.1/bootstrap.min.js"></script>
  <!-- Vendor JS       -->
  <script src="./assets/slick/slick.min.js">
  </script>
  <script src="./assets/wow/wow.min.js"></script>
  <script src="./assets/animsition/animsition.min.js"></script>
  <script src="./assets/bootstrap-progressbar/bootstrap-progressbar.min.js">
  </script>
  <script src="./assets/vendor/counter-up/jquery.waypoints.min.js"></script>
  <script src="./assets/vendor/counter-up/jquery.counterup.min.js">
  </script>
  <script src="./assets/vendor/circle-progress/circle-progress.min.js"></script>
  <script src="./assets/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="./assets/vendor/chartjs/Chart.bundle.min.js"></script>
  <script src="./assets/vendor/select2/select2.min.js">
  </script>

  <!-- Main JS-->
  <script src="./assets/js/main.js"></script>
        
    </body>
</html>
<?php 
require_once("lib/functions.php");
require_once("ini.php");

if(SRequest::getInstance()->get('del') !==null) {
    SRequest::getInstance()->unset('session',APP_TAG);
    header('Location:index.php?del');
    exit;
}

try {
    $user_model =new UserModel( SPDO::getInstance( DB_HOST, DB_NAME, DB_LOGIN, DB_PWD )->getPDO());
    $player_model = new PlayerModel( SPDO::getInstance( DB_HOST, DB_NAME, DB_LOGIN, DB_PWD )->getPDO());
    
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

    $player = $player_model->ReadOneByUser($user->get_id()); 
        if ($player !== false) {
            header('Location:player_waiting.php');
            exit;
        }

    $listing_user = $user_model->ReadAll($user->get_power());
} catch (Exception $e) {
        header('Location: 404.php');
        // exit;
}

?><!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>espace_admin</title>

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
        <link href="./assets/css/theme.css" rel="stylesheet" media="all">
    </head>

        <?php include('nav.php'); ?>

    <body class="animsition" style="animation-duration: 900ms; opacity: 1;">
    <main class="page-content--bge5" style="padding-top:40px;">   
        <section class="p-t-20">
            <?php if (isset($error)) {
            echo'<div class="alert alert-danger" role="alert"> '. Error($error).' </div>';
            }
            if($user->get_power()>=100){ ?>
            <div class="col-lg-6 mx-auto" >
                <div class="card">
                    <div class="card-header">Profil</div>
                    <div class="card-body card-block">
                        <form action="" method="post" class="">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Nom</div>
                                    <input type="text" id="username3" name="username3" class="form-control" value="<?php echo $user->get_name() ?> ">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Prénom</div>
                                    <input type="text" id="username3" name="username3" class="form-control" value="<?php echo $user->get_firstname() ?>">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">pseudo</div>
                                    <input type="text" id="username3" name="username3" class="form-control"value="<?php echo $user->get_pseudo() ?> ">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Email</div>
                                    <input type="email" id="email3" name="email3" class="form-control" value="<?php echo $user->get_email() ?>">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Nombres de Games jouées</div>
                                    <p type="text" id="username3" name="username3" class="form-control"> <?php echo $user->get_NumGamePlayed_player(); ?> </p>
                                    <div class="input-group-addon">
                                        <i class="fa fa-asterisk"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Nombres de Games gagnés</div>
                                    <p type="text" id="username3" name="username3" class="form-control"> <?php echo $user->get_NumGameWin_player() ?></p>
                                    <div class="input-group-addon">
                                        <i class="fa fa-asterisk"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions form-group">
                                <button  href="espace_game.php" type="submit" class="btn btn-primary btn-sm">Modifer</button>
                                <a  href="espace_game.php" type="submit" class="btn btn-danger btn-sm">Jouer</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php } else {?>
             <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="title-5 m-b-35">Listing des Users</h3>
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Pseudo</th>
                                            <th>Email</th>
                                            <th>Validation Email</th>
                                            <th>Parties Jouées</th>
                                            <th>Parties Gagnées</th>
                                            <th>Rang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        if(!empty($listing_user)) {
                                            foreach ($listing_user as $value) {
                                               $value->ShowTr();
                                            }
                                        }
                                    ?>
                                    </tbody>
                                </table>
                                <br>
                                <div class="form-actions form-group">
                                <a href="create_user.php" class="btn btn-info btn-sm"> Créer un User  </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
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
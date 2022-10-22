<?php $time = time(); ?>
<!doctype html>
<html lang="en" self="messages">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel = "icon" href = "Title_Icon_PNG.png" type = "image/x-icon"/>
    <link rel = "icon" href = "Title_Icon_PNG.png" type = "image/png"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Style/Modules.css?time=<?=$time?>" media="screen">
    <link rel="stylesheet" type="text/css" href="Style/Style.css?time=<?=$time?>" media="screen">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <script type="text/javascript" src="Script/Modules.js?time=<?=$time?>"></script>
    <script type="text/javascript" src="Script/MainFunctions.js?time=<?=$time?>"></script>
    <?php
    session_start(); 
    if(!isset($_SESSION["first_name"]) && !isset($_SESSION["last_name"]) && !isset($_SESSION["username"]) && !isset($_SESSION["password"])){
      echo "<script>window.location = locationTeleport;</script>";
    }
    ?>
    <title>Arso nameštaj - Poruke</title>
  </head>
    <body>
      <nav class="navbar navbar-expand-* navbar-light form-row">
        <a class="navbar-brand ml-4" href="index.php"><img src="Media/Images/Arso_Logo_BLACK_PNG.png"/></a>
        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse rounded" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto my-4">
            <li class="nav-item mx-2">
              <a class="nav-link nav-link_b color-custom2 menu_link_hover2 px-4" href="index.php">Naslovna</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link nav-link_b color-custom2 menu_link_hover2 px-4" href="materials.php">Materijali</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link nav-link_b color-custom2 menu_link_hover2 px-4" href="services.php">Usluge</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link nav-link_b color-custom2 menu_link_hover2 px-4" href="aboutus.php">O nama</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link nav-link_b color-custom2 menu_link_hover2 px-4" href="contact.php">Kontakt</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link nav-link_b color-custom2 menu_link_hover2 px-4" href="gallery.php">Galerija</a>
            </li>
            <li class="nav-item mx-2 desktop_panel" style="position: relative;">
              <a class="nav-link nav-link_b color-custom2 menu_link_hover2 px-4" 
              <?php
              if(!isset($_SESSION["first_name"]) && !isset($_SESSION["last_name"]) && !isset($_SESSION["username"]) && !isset($_SESSION["password"])){
                echo 
              'href="login.php" ';}?>
              for="submenu01"><img src="Media/Images/LOG_IN_PNG_ICON_BLACK.png" style="max-height: 2rem !important;"/>
              <?php
              if(isset($_SESSION["first_name"]) && isset($_SESSION["last_name"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])){
                echo 
              '<span style="margin-left: 1rem;">' . $_SESSION["first_name"] . " " . $_SESSION["last_name"] . '</span>';
              }?></a>
              <?php
              if(isset($_SESSION["first_name"]) && isset($_SESSION["last_name"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])){
                echo 
                '<div class="desktop_panel"><div class="submenu_custom2" style="position: absolute; top: -0.5rem; left: 0; width: 100%; padding-top: 3.5rem !important; display: none; z-index: 999999;" id="submenu01">
                <a class="nav-link nav-link_b color-custom2 menu_link_hover2 px-4" href="updategallery.php">Ažuriraj galeriju</a>
                <a class="nav-link nav-link_b color-custom2 menu_link_hover2 px-4 current_page2" href="messages.php">Ažuriraj poruke</a>
                <a class="nav-link nav-link_b color-custom2 menu_link_hover2 px-4" onclick="logout();">Odjavi se</a>
                </div></div>';
              }
              ?>
            </li>
            <?php
              if(isset($_SESSION["first_name"]) && isset($_SESSION["last_name"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])){
                echo
                '<li class="mobile_panel nav-item mx-2" style="display: none;">
                <a class="nav-link nav-link_b color-custom2 menu_link_hover2 px-4" href="updategallery.php">Ažuriraj galeriju</a>
              </li>
              <li class="mobile_panel nav-item mx-2" style="display: none;">
                <a class="nav-link nav-link_b color-custom2 menu_link_hover2 px-4 current_page2" href="messages.php">Ažuriraj poruke</a>
              </li>
              <li class="mobile_panel nav-item mx-2" style="display: none;">
                <a class="nav-link nav-link_b color-custom2 menu_link_hover2 px-4" onclick="logout();">Odjavi se</a>
              </li>';
              }
              else{
                echo
                '<li class="mobile_panel nav-item mx-2" style="display: none;">
                <a class="nav-link nav-link_b color-custom2 menu_link_hover2 px-4" href="login.php">Prijavi se</a>
              </li>';
              }?>
          </ul>
        </div>
      </nav> 
    <div class="container p-4">
      <h2 class="color-custom4" style="text-align: center;">Message preview</h2>
      <div id="messagecontainer">

      </div>
    </div>
    
    <div class="container mb-5 py-2">
      <div class="row">
        <div class="col-md-3 p-2"></div>
        <div class="col-md-6 p-2"><button type="button" class="btn custom-btn2 w-100 mt-2 py-2" id="removeallmessages">Delete all</button></div>
        <div class="col-md-3 p-2"></div>
      </div>
    </div>
    
    
    <footer class="u-clearfix u-footer u-grey-80" id="sec-a20a"><div class="py-4 md-px-5 md-mx-5 u-clearfix u-sheet u-valign-middle-lg u-valign-middle-md u-valign-middle-xl">
      <div class="u-clearfix u-expanded-width u-layout-wrap u-layout-wrap-1">
        <div class="u-layout">
          <div class="u-layout-row">
            <div class="u-container-style u-layout-cell u-size-15 u-layout-cell-1">
              <div class="u-container-layout u-valign-middle-lg u-valign-middle-md u-valign-middle-xl u-valign-middle u-container-layout-7">
                <img class="u-align-center-sm u-align-center-xs u-align-left-lg u-align-left-md u-align-left-xl u-image u-image-contain u-image-default u-image-1" src="Media/Images/Arso_Logo_PNG.png" alt="">
              </div>
            </div>
            <div class="u-container-style u-layout-cell u-size-30 u-layout-cell-2">
              <div class="u-container-layout u-container-layout-2">
                <div class="u-expanded-width u-list u-list-1">
                  <div class="u-repeater u-repeater-1">
                    <div class="row">
                  <div class="col-xl-6">
                    <div class="u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-3">
                      <div class="form-row"><p class="u-align-left u-text u-text-1"><span class="u-file-icon u-icon u-text-grey-50 u-icon-1"><div class="col"><span class="non_separation"><b>Srbija</b></span></div>
                      </span></p></div>
                      </div>
                    </div>
                    <div class="u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-3">
                      <div class="form-row"><p class="u-align-left u-text u-text-1"><span class="u-file-icon u-icon u-text-grey-50 u-icon-1"><img src="Media/Images/12.png" alt=""><div class="col"><span class="non_separation">Radiše Zatežića 10, 32000 Čačak</span></div>
                      </span></p></div>
                      </div>
                    </div>
                    <div class="u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-4">
                      <div class="form-row"><p class="u-align-left u-text u-text-1"><span class="u-file-icon u-icon u-text-grey-50 u-icon-2"><img src="Media/Images/14.png" alt=""><div class="col"><span class="non_separation">+381 60 0538437</span></div>
                      </span></p></div>
                      </div>
                    </div>
                    <div class="u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-4">
                      <div class="form-row"><p class="u-align-left u-text u-text-1"><span class="u-file-icon u-icon u-text-grey-50 u-icon-2"><img src="Media/Images/15.png" alt=""><div class="col"><span class="non_separation">arso.cacak@gmail.com </span></div>
                      </span></p></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-6">
                    <div class="u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-3">
                      <div class="form-row"><p class="u-align-left u-text u-text-1"><span class="u-file-icon u-icon u-text-grey-50 u-icon-1"><div class="col"><span class="non_separation"><b>Slovenija</b></span></div>
                      </span></p></div>
                      </div>
                    </div>
                    <div class="u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-3">
                      <div class="form-row"><p class="u-align-left u-text u-text-1"><span class="u-file-icon u-icon u-text-grey-50 u-icon-1"><img src="Media/Images/12.png" alt=""><div class="col"><span class="non_separation">Kardeljev trg 10, 3320 Velenje</span></div>
                      </span></p></div>
                      </div>
                    </div>
                    <div class="u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-4">
                      <div class="form-row"><p class="u-align-left u-text u-text-1"><span class="u-file-icon u-icon u-text-grey-50 u-icon-2"><img src="Media/Images/14.png" alt=""><div class="col"><span class="non_separation">+386 51 735 311</span></div>
                      </span></p></div>
                      </div>
                    </div>
                    <div class="u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-4">
                      <div class="form-row"><p class="u-align-left u-text u-text-1"><span class="u-file-icon u-icon u-text-grey-50 u-icon-2"><img src="Media/Images/15.png" alt=""><div class="col"><span class="non_separation">arso.velenje@gmail.com</span></div>
                      </span></p></div>
                      </div>
                    </div>
                  </div>
                  </div>

                  <div class="row">
                  <div class="col">
                  <div class="u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-5">
                      <div class="form-row"><p class="u-align-left u-text u-text-1"><span class="u-file-icon u-icon u-text-grey-50 u-icon-3 text-center"><img src="Media/Images/13.png" alt=""><div class="col text-center"><span>Radnim danima od 7h do 15h</span></div>
                        </p></span></div>
                      </div>
                    </div>
                  </div>
                  </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="u-align-center-sm u-align-center-xs u-align-right-lg u-align-right-md u-align-right-xl u-container-style u-layout-cell u-size-15 u-layout-cell-3">
              <div class="u-container-layout u-valign-middle-lg u-valign-middle-md u-valign-middle-xl u-valign-middle u-container-layout-7">
                <div class="u-align-center-sm u-align-center-xs u-align-right-lg u-align-right-md u-align-right-xl u-list u-list-2">
                  <div class="u-repeater u-repeater-2">
                    <div class="u-align-right u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-8">
                        <h5 class="u-align-center-md u-align-center-sm u-align-center-xs u-text u-text-5">Kontaktirajte nas</h5>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="u-align-center-sm u-align-center-xs u-align-right-lg u-align-right-md u-align-right-xl u-list u-list-2">
                  <div class="u-repeater u-repeater-3">
                    <!--<div class="u-align-center u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-9"><span class="u-file-icon u-icon u-text-grey-50 u-icon-5" data-href="https://nicepage.com" data-target="_blank"><img src="Media/Images/16.png" alt=""></span>
                      </div>
                    </div>
                    <div class="u-align-center u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-10"><span class="u-file-icon u-icon u-text-grey-50 u-icon-6" data-href="https://nicepage.com"><img src="Media/Images/17.png" alt=""></span>
                      </div>
                    </div>-->
                    <div class="u-align-center u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-11"><span class="u-file-icon u-icon u-text-grey-50 u-icon-8"><a title="Facebook" target="_blank" href="https://www.facebook.com/goran.arsenijevic.37"><img src="Media/Images/16.png" alt=""></a></span>
                      </div>
                    </div>
                    <div class="u-align-center u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-12"><span class="u-file-icon u-icon u-text-grey-50 u-icon-8"><a title="Instagram" target="_blank" href="https://www.instagram.com/pohistvo_arso/"><img src="Media/Images/18.png" alt=""></a></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <h6 class="u-align-center-xs u-text u-text-6">© ​HG Software Group. All rights reserved.</h6>
    </div></footer>

    </body>
</html>
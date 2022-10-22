<?php session_start(); $time = time(); ?>
<!doctype html>
<html lang="en">
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
    <title>Arso nameštaj - Početna</title>
  </head>
    <body>
        
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <nav class="navbar navbar-expand-* navbar-dark form-row" style="position: absolute; top: 0; left: 0; z-index: 99999; width: 100%;">
        <a class="navbar-brand ml-4" href="index.php"><img src="Media/Images/Arso_Logo_PNG.png"/></a>
        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse rounded" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto my-4 collapse-bg1">
            <li class="nav-item mx-2">
              <a class="nav-link color-custom1 menu_link_hover1 current_page1 px-4" href="index.php">Naslovna</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link nav-link_b color-custom1 menu_link_hover1 px-4" href="materials.php">Materijali</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link nav-link_b color-custom1 menu_link_hover1 px-4" href="services.php">Usluge</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link nav-link_b color-custom1 menu_link_hover1 px-4" href="aboutus.php">O nama</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link nav-link_b color-custom1 menu_link_hover1 px-4" href="contact.php">Kontakt</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link nav-link_b color-custom1 menu_link_hover1 px-4" href="gallery.php">Galerija</a>
            </li>
            <li class="nav-item mx-2 desktop_panel" style="position: relative;">
              <a class="nav-link nav-link_b color-custom1 menu_link_hover1 px-4" 
              <?php
              if(!isset($_SESSION["first_name"]) && !isset($_SESSION["last_name"]) && !isset($_SESSION["username"]) && !isset($_SESSION["password"])){
                echo 
              'href="login.php" ';}?>
              for="submenu01"><img src="Media/Images/LOG_IN_PNG_ICON_WHITE.png" style="max-height: 2rem !important;"/>
              <?php
              if(isset($_SESSION["first_name"]) && isset($_SESSION["last_name"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])){
                echo 
              '<span style="margin-left: 1rem;">' . $_SESSION["first_name"] . " " . $_SESSION["last_name"] . '</span>';
              }?></a>
              <?php
              if(isset($_SESSION["first_name"]) && isset($_SESSION["last_name"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])){
                echo 
                '<div class="desktop_panel"><div class="submenu_custom1" style="position: absolute; top: -0.5rem; left: 0; width: 100%; padding-top: 3.5rem !important; display: none; z-index: 999999;" id="submenu01">
                <a class="nav-link nav-link_b color-custom1 menu_link_hover1 px-4" href="updategallery.php">Ažuriraj galeriju</a>
                <a class="nav-link nav-link_b color-custom1 menu_link_hover1 px-4" href="messages.php">Ažuriraj poruke</a>
                <a class="nav-link nav-link_b color-custom1 menu_link_hover1 px-4" onclick="logout();">Odjavi se</a>
                </div></div>';
              }
              ?>
            </li>
            <?php
              if(isset($_SESSION["first_name"]) && isset($_SESSION["last_name"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])){
                echo
            '<li class="mobile_panel nav-item mx-2" style="display: none;">
              <a class="nav-link nav-link_b color-custom1 menu_link_hover1 px-4" href="updategallery.php">Ažuriraj galeriju</a>
            </li>
            <li class="mobile_panel nav-item mx-2" style="display: none;">
              <a class="nav-link nav-link_b color-custom1 menu_link_hover1 px-4" href="messages.php">Ažuriraj poruke</a>
            </li>
            <li class="mobile_panel nav-item mx-2" style="display: none;">
              <a class="nav-link nav-link_b color-custom1 menu_link_hover1 px-4" onclick="logout();">Odjavi se</a>
            </li>';
              }
              else{
                echo
                '<li class="mobile_panel nav-item mx-2" style="display: none;">
                <a class="nav-link nav-link_b color-custom1 menu_link_hover1 px-4" href="login.php">Prijavi se</a>
              </li>';
              }?>
          </ul>
        </div>
      </nav>
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="form-row" style="height: 100vh; background-image: url('Media/Images/Slider/4.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">
              <div style="position: absolute; top: 0; left:0; width: 100%; height: 100%; background-color: rgba(1, 1, 1, 0.4);"></div>
              <div class="col-3"></div>
                <div class="col-6">
                    <div class="text-white d-block slider_text">
                        <h1>Predsoblja</h1>
                        <h3 style="text-align: justify;">Pre&shy;dso&shy;blje je prvo me&shy;sto ko&shy;je vas po&shy;zdra&shy;vlja pri&shy;li&shy;kom ula&shy;ska u vaš dom. Obi&shy;čno ni&shy;je pro&shy;stra&shy;no, pa je još va&shy;žni&shy;je da bu&shy;de le&shy;po i do&shy;bro osmi&shy;šlje&shy;no. To ni&shy;je te&shy;ško ostva&shy;ri&shy;ti oda&shy;bi&shy;rom odgo&shy;va&shy;ra&shy;ju&shy;ćeg na&shy;me&shy;šta&shy;ja. Vi&shy;se&shy;ći orma&shy;ri&shy;ći i orma&shy;ri za ka&shy;pu&shy;te, či&shy;zme i ci&shy;pe&shy;le, me&shy;sto gde mo&shy;že&shy;te se&shy;de&shy;ti ka&shy;ko bi&shy;ste se kre&shy;ta&shy;li, su osno&shy;vni ele&shy;me&shy;nti pre&shy;dso&shy;blja.</h3>
                        <a class="button_type1 color-custom1 px-3 py-1 d-inline-block mt-4" href="gallery.php?type=predsoblja">Pogledaj galeriju</a>
                    </div>
                </div>
              <div class="col-3"></div>
            </div>
          </div>
          <div class="carousel-item">
              <div class="form-row" style="height: 100vh; background-image: url('Media/Images/Slider/1.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">
                <div style="position: absolute; top: 0; left:0; width: 100%; height: 100%; background-color: rgba(1, 1, 1, 0.4);"></div>
                <div class="col-3"></div>
                    <div class="col-6">
                        <div class="text-white d-block slider_text">
                            <h1>Kuhinje</h1>
                            <h3 style="text-align: justify; text-justify: auto;">Ku&shy;hi&shy;nja je ce&shy;ntra&shy;lno me&shy;sto u ku&shy;ći. Bez obzi&shy;ra da li že&shy;li&shy;te mo&shy;de&shy;rnu ku&shy;hi&shy;nju ili kla&shy;si&shy;čnu ku&shy;hi&shy;nju, odli&shy;čna po&shy;nu&shy;da bo&shy;ja omo&shy;gu&shy;ća&shy;va vam da iza&shy;be&shy;re&shy;te ku&shy;hi&shy;nju svo&shy;jih sno&shy;va. Iz ši&shy;ro&shy;kog spe&shy;ktra ele&shy;me&shy;na&shy;ta do&shy;bi&shy;će&shy;te fu&shy;nkci&shy;o&shy;na&shy;lnu ku&shy;hi&shy;nju . Kva&shy;li&shy;te&shy;tni ma&shy;te&shy;ri&shy;ja&shy;li, ugra&shy;đe&shy;ni pri&shy;klju&shy;čci, si&shy;ste&shy;mi za pri&shy;gu&shy;ši&shy;va&shy;nje i kva&shy;li&shy;te&shy;tna pro&shy;i&shy;zvo&shy;dnja su ga&shy;ra&shy;nci&shy;ja du&shy;go&shy;tra&shy;jnih pe&shy;rfo&shy;rma&shy;nsi.</h3>
                            <a class="button_type1 color-custom1 px-3 py-1 d-inline-block mt-4" href="gallery.php?type=kuhinje">Pogledaj galeriju</a>
                        </div>
                    </div>
                  <div class="col-3"></div>
              </div>
          </div>
          <div class="carousel-item">
            <div class="form-row" style="height: 100vh; background-image: url('Media/Images/Slider/2.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">
              <div style="position: absolute; top: 0; left:0; width: 100%; height: 100%; background-color: rgba(1, 1, 1, 0.4);"></div>
              <div class="col-3"></div>
                <div class="col-6">
                    <div class="text-white d-block slider_text">
                        <h1>Dnevne sobe</h1>
                        <h3 style="text-align: justify; text-justify: auto;">Dne&shy;vna so&shy;ba je po&shy;red ku&shy;hi&shy;nje ce&shy;ntra&shy;lno po&shy;dru&shy;čje va&shy;šeg do&shy;ma. Osta&shy;ni&shy;te tu sa po&shy;ro&shy;di&shy;com i pri&shy;ja&shy;te&shy;lji&shy;ma, opu&shy;sti&shy;te se ka&shy;da pri&shy;ča&shy;te, či&shy;ta&shy;te ili gle&shy;da&shy;te TV, pa se uve&shy;ri&shy;te da je ovo stva&shy;rno le&shy;po me&shy;sto u ko&shy;me pro&shy;ve&shy;de&shy;te na&shy;jvi&shy;še vre&shy;me&shy;na. Ra&shy;zmi&shy;sli&shy;te o sti&shy;lu ko&shy;ji vo&shy;li&shy;te. Da li će bi&shy;ti mo&shy;de&shy;rna dne&shy;vna so&shy;ba sa či&shy;stim pra&shy;vim li&shy;ni&shy;ja&shy;ma sa sa&shy;mo ne&shy;ko&shy;li&shy;ko ko&shy;ma&shy;da na&shy;me&shy;šta&shy;ja, ili mo&shy;ra&shy;ju ima&shy;ti sve što pri&shy;pa&shy;da opre&shy;mi sa&shy;vre&shy;me&shy;nog mu&shy;lti&shy;me&shy;di&shy;ja&shy;lnog ugla.</h3>
                        <a class="button_type1 color-custom1 px-3 py-1 d-inline-block mt-4" href="gallery.php?type=dnevne sobe">Pogledaj galeriju</a>
                    </div>
                </div>
              <div class="col-3"></div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="form-row" style="min-height: 100vh; background-image: url('Media/Images/Slider/3.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">
              <div style="position: absolute; top: 0; left:0; width: 100%; height: 100%; background-color: rgba(1, 1, 1, 0.4);"></div>
              <div class="col-3"></div>
                <div class="col-6">
                    <div class="text-white d-block slider_text">
                        <h1>Ormari</h1>
                        <h3 style="text-align: justify; text-justify: auto;">Mo&shy;de&shy;ran ugra&shy;dni ormar je da&shy;nas ne&shy;o&shy;pho&shy;dan deo go&shy;to&shy;vo sva&shy;kog do&shy;ma, jer nam po&shy;ma&shy;že da re&shy;ši&shy;mo mno&shy;ge pro&shy;sto&shy;rne pro&shy;ble&shy;me. Sa ugra&shy;dnim orma&shy;rom će&shy;te po&shy;sti&shy;ći po&shy;tpu&shy;nu isko&shy;ri&shy;šće&shy;no&shy;st pro&shy;sto&shy;ra čak i ka&shy;da je za&shy;hte&shy;van. Ugra&shy;dnii orma&shy;ri ili sa&shy;mo kli&shy;zna vra&shy;ta po&shy;ma&shy;žu pri&shy;kri&shy;va&shy;nju ne&shy;pra&shy;vi&shy;lno&shy;sti u pro&shy;sto&shy;ri&shy;ma i ti&shy;me pru&shy;ža&shy;ju odli&shy;čno re&shy;še&shy;nje za pre&shy;la&shy;zak izme&shy;đu pro&shy;sto&shy;ra&shy;.Pre&shy;dno&shy;st na&shy;ših ugra&shy;dnih orma&shy;ra je uskla&shy;đe&shy;no&shy;st sa osta&shy;lim na&shy;me&shy;šta&shy;jem.</h3>
                        <a class="button_type1 color-custom1 px-3 py-1 d-inline-block mt-4" href="gallery.php?type=ormari">Pogledaj galeriju</a>
                    </div>
                </div>
              <div class="col-3"></div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="form-row" style="min-height: 100vh; background-image: url('Media/Images/Slider/5.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">
              <div style="position: absolute; top: 0; left:0; width: 100%; height: 100%; background-color: rgba(1, 1, 1, 0.4);"></div>
              <div class="col-3"></div>
                <div class="col-6">
                    <div class="text-white d-block slider_text">
                        <h1>Dečije/Spavaće sobe</h1>
                        <h3 style="text-align: justify; text-justify: auto;">Za ve&shy;ći&shy;nu lju&shy;di va&shy;žno je da spa&shy;va&shy;ća so&shy;ba zra&shy;či smi&shy;re&shy;no&shy;šću, pri&shy;ja&shy;tno&shy;šću i vi&shy;so&shy;kim ose&shy;ća&shy;jem to&shy;pli&shy;ne. Ta&shy;mo pro&shy;vo&shy;di&shy;mo svo&shy;je vre&shy;me ka&shy;da se že&shy;li&shy;mo opu&shy;sti&shy;ti na&shy;kon na&shy;po&shy;rnog da&shy;na na po&shy;slu, ka&shy;da že&shy;li&shy;mo da se na&shy;spa&shy;va&shy;mo ili odmo&shy;ri&shy;mo.<br>Opre&shy;ma&shy;nje pro&shy;sto&shy;ra u ko&shy;me će se de&shy;te igra&shy;ti i ra&shy;sti je za&shy;ba&shy;vno i  iza&shy;zo&shy;vno isku&shy;stvo jer so&shy;bu tre&shy;ba ure&shy;di&shy;ti le&shy;po i fu&shy;nkci&shy;o&shy;na&shy;lno ta&shy;ko da je de&shy;ca vo&shy;le tre&shy;nu&shy;tno ali i to&shy;kom go&shy;di&shy;na.</h3>
                        <a class="button_type1 color-custom1 px-3 py-1 d-inline-block mt-4" href="gallery.php?type=spavaće sobe">Pogledaj galeriju</a>
                    </div>
                </div>
              <div class="col-3"></div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="form-row" style="min-height: 100vh; background-image: url('Media/Images/Slider/6.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">
              <div style="position: absolute; top: 0; left:0; width: 100%; height: 100%; background-color: rgba(1, 1, 1, 0.4);"></div>
              <div class="col-3"></div>
                <div class="col-6">
                    <div class="text-white d-block slider_text">
                        <h1>Kupatila</h1>
                        <h3 style="text-align: justify; text-justify: auto;">Ku&shy;pa&shy;ti&shy;lski na&shy;me&shy;štaj je ono što da&shy;je gla&shy;vnu no&shy;tu izgle&shy;du ku&shy;pa&shy;ti&shy;la. Oda&shy;bir ele&shy;me&shy;na&shy;ta na&shy;me&shy;šta&shy;ja za ku&shy;pa&shy;ti&shy;lo, sti&shy;la i bo&shy;je je od klju&shy;čnog zna&shy;ča&shy;ja za ce&shy;lo&shy;ku&shy;pnu este&shy;ti&shy;ku ove pro&shy;sto&shy;ri&shy;je. Ku&shy;pa&shy;ti&shy;lo bi tre&shy;ba&shy;lo da bu&shy;de li&shy;čna oa&shy;za za pri&shy;va&shy;tno&shy;st i opu&shy;šta&shy;nje, pa je za&shy;to bi&shy;tno da ga opre&shy;mi&shy;mo sa uku&shy;som i sti&shy;lom.</h3>
                        <a class="button_type1 color-custom1 px-3 py-1 d-inline-block mt-4" href="gallery.php?type=kupatila">Pogledaj galeriju</a>
                    </div>
                </div>
              <div class="col-3"></div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="form-row" style="min-height: 100vh; background-image: url('Media/Images/Slider/7.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">
              <div style="position: absolute; top: 0; left:0; width: 100%; height: 100%; background-color: rgba(1, 1, 1, 0.4);"></div>
              <div class="col-3"></div>
                <div class="col-6">
                    <div class="text-white d-block slider_text">
                        <h1>Ostalo</h1>
                        <h3 style="text-align: justify; text-justify: auto;">Uve&shy;k po&shy;sto&shy;ji pro&shy;stor ili zid ko&shy;ji za&shy;hte&shy;va po&shy;se&shy;bnu pa&shy;žnju i vaš dom či&shy;ne uni&shy;ka&shy;tnim i pri&shy;la&shy;go&shy;đe&shy;nim sa&shy;mo va&shy;šim po&shy;tre&shy;ba&shy;ma i že&shy;lja&shy;ma. Za&shy;to uvek ima&shy;mo odli&shy;čna re&shy;še&shy;nja bi&shy;lo da se ra&shy;di o ka&shy;nce&shy;la&shy;ri&shy;ji, bi&shy;bli&shy;ote&shy;ci, ko&shy;mo&shy;di, po&shy;li&shy;ca&shy;ma...</h3>
                        <a class="button_type1 color-custom1 px-3 py-1 d-inline-block mt-4" href="gallery.php?type=ostalo">Pogledaj galeriju</a>
                    </div>
                </div>
              <div class="col-3"></div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
        <div class="arrow" id="arrow1"></div>
      </div>

      <div class="container my-5" id="scrollContent1">
        <section class="u-section-1">
        <div class="u-container-layout u-valign-middle u-container-layout-1">
          <h2 class="u-align-center-sm u-align-center-xs u-custom-font u-font-oswald u-text u-text-1">Ko smo mi
          </h2>
          <p class="u-text u-text-2" style="text-align: justify; text-justify: auto;">
          Na&shy;ša fi&shy;rma se ba&shy;vi pro&shy;da&shy;jom ma&shy;te&shy;ri&shy;ja&shy;la i pro&shy;i&shy;zvo&shy;dnjom na&shy;me&shy;šta&shy;ja po že&shy;lji ku&shy;pa&shy;ca od plo&shy;ča&shy;stih ma&shy;te&shy;ri&shy;ja&shy;la kao i ma&shy;si&shy;vnog drve&shy;ta uz ko&shy;ri&shy;šće&shy;nje na&shy;jsa&shy;vre&shy;me&shy;ni&shy;jih oko&shy;va. 
          <br><br> Ci&shy;lj nam je da obli&shy;ku&shy;je&shy;mo bre&shy;nd ko&shy;ji će ku&shy;pci vo&shy;le&shy;ti i po&shy;što&shy;va&shy;ti a sa svo&shy;jim na&shy;či&shy;nom po&shy;slo&shy;va&shy;nja i ra&shy;zmi&shy;šlja&shy;nja že&shy;li&shy;mo da omo&shy;gu&shy;ći&shy;mo po&shy;u&shy;zdan i si&shy;gu&shy;ran izbor kva&shy;li&shy;te&shy;tnog na&shy;me&shy;šta&shy;ja za dom.</p>
          <a href="aboutus.php" id="about_btn" class="u-border-2 u-border-grey-dark-1 u-btn u-btn-rectangle u-button-style u-custom-font u-font-oswald u-none u-btn-11">Pročitaj više</a>
        </div>
      </section>
      </div>

    <div class="container my-5">
      <hr/>
      <section class="u-align-center-md u-align-center-sm u-align-center-xs u-clearfix u-section-1" id="sec-f71a">
        <div class="u-clearfix u-sheet u-sheet-1">
          <div class="u-clearfix u-expanded-width u-gutter-0 u-layout-wrap u-layout-wrap-1">
            <div class="u-gutter-0 u-layout">
              <div class="u-layout-row">
                <div class="u-size-30">
                  <div class="u-layout-col">
                    <div class="u-align-left u-container-style u-layout-cell u-size-60 u-layout-cell-1">
                      <div class="u-container-layout u-valign-middle u-container-layout-1">
                        <h2 class="u-align-center-sm u-align-center-xs u-custom-font u-font-oswald u-text u-text-1">Radimo sa najboljim<br>partnerima
                        </h2>
                        <p class="u-text u-text-2">Da bi ispu&shy;ni&shy;li sva&shy;ki za&shy;htev kli&shy;je&shy;nta bi&shy;ra&shy;mo sa&shy;mo na&shy;jbo&shy;lje pro&shy;i&shy;zvo&shy;đa&shy;če i do&shy;ba&shy;vlja&shy;če ko&shy;ji su tu da za&shy;je&shy;dno sa na&shy;ma uči&shy;ne čak i ono što ni&shy;je mo&shy;gu&shy;će.</p>
                        <a href="aboutus.php" id="supplier_btn" class="u-border-2 u-border-grey-dark-1 u-btn u-btn-rectangle u-button-style u-custom-font u-font-oswald u-none u-btn-11">Pogledaj sve</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="u-size-30">
                  <div class="u-layout-col">
                    <div class="u-align-center-sm u-align-center-xs u-align-left-lg u-align-left-md u-align-left-xl u-container-style u-layout-cell u-size-60 u-layout-cell-2">
                      <div class="u-container-layout u-container-layout-2">
                        <div class="u-list u-list-1">
                          <div class="u-repeater u-repeater-1">
                            <div class="u-align-center-sm u-align-center-xs u-container-style u-image u-image-contain u-list-item u-repeater-item u-image-1">
                              <div class="u-container-layout u-similar-container u-container-layout-3"></div>
                            </div>
                            <div class="u-align-center-sm u-align-center-xs u-container-style u-image u-image-contain u-list-item u-repeater-item u-image-2">
                              <div class="u-container-layout u-similar-container u-container-layout-4"></div>
                            </div>
                            <div class="u-align-center-sm u-align-center-xs u-container-style u-image u-image-contain u-list-item u-repeater-item u-image-3">
                              <div class="u-container-layout u-similar-container u-container-layout-5"></div>
                            </div>
                            <div class="u-align-center-sm u-align-center-xs u-container-style u-image u-image-contain u-list-item u-repeater-item u-image-4">
                              <div class="u-container-layout u-similar-container u-container-layout-6"></div>
                            </div>
                            <div class="u-align-center-sm u-align-center-xs u-container-style u-image u-image-contain u-list-item u-repeater-item u-image-5">
                              <div class="u-container-layout u-similar-container u-container-layout-7"></div>
                            </div>
                            <div class="u-align-center-sm u-align-center-xs u-container-style u-image u-image-contain u-list-item u-repeater-item u-image-6">
                              <div class="u-container-layout u-similar-container u-container-layout-8"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section></div>

    
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
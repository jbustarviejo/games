
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="utf-8" /> 
        <meta name="robots" content="noindex"/>
        <link type="image/x-icon" href="images/favicon.ico" rel="shortcut icon"/>
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="/css/style.css"/>
        <script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="/js/login.js"></script>
        <script type="text/javascript" src="/js/shop.js"></script>
        <?php echo $includes; ?>
    </head>

    <body id="body"> 
        <!--Header de la página fake-->
        <header>
            <nav id="user-pannel">
                <?php echo $user_pannel;?>
            </nav>
            <nav class="menu">
                <div class="cont-menu">
                    <a href="/" class="bot_home" ondragstart="return false;"></a>
                    <a href="/juegos" class="bot_desc" ondragstart="return false;">Juegos</a>
                    <a href="/tienda" class="bot_desc" ondragstart="return false;">Tienda</a>
                    <a href="/mis-puntos" class="bot_desc" ondragstart="return false;">Mi panel</a>
                </div>
                <div class="logo">
                    <img alt="movistar" src="/images/movistar/movistar-logo.png" ondragstart="return false;">
                </div>
            </nav>
        </header>

        <!--Script de inicio de juegos-->
        <?php if($_SERVER['REQUEST_URI']=="/juegos"){ ?>
        <script type="text/javascript">
            //Una vez se haya cargado la página, inicar los juegos
            $(document).ready(function () {
                games.initGames(<?php echo "'".$userName."','".$userPoints."','". $userToken ."'";?>);
            });
        </script>
        <?php } else if($_SERVER['REQUEST_URI']=="/tienda"){ ?>
        <!--Script de inicio de la tienda-->
        <script type="text/javascript">
            //Una vez se haya cargado la página, inicar la tienda
            $(document).ready(function () {
                shop.initShop(<?php echo "'".$userName."','". $userToken ."'";?>);
            });
        </script>
        <?php } ?>

        <div class="fake-container" id="fake-container">
            <?php echo $content; ?>
        </div>

        <!--Diálogo de login de usuario-->
        <?php if($login){ ?>
        <div id="login-menu-container">
            <div>
                <h1>¡Bienvenido al Movijuego!</h1>
                <p>Para poder participar es necesario estar logado. Introduce tus datos de acceso</p>
                <input class="input-login login-username" id="login-username" type="text" onkeypress="login.keypressed(event);" placeholder="Introduce tu id de usuario" disabled="disabled" /><br/>
                <input class="input-login login-password" id="login-password" type="password" onkeypress="login.keypressed(event);" placeholder="Introduce tu contraseña" disabled="disabled" /><br>
                <button class="login-button" onclick="login.start();">Acceder</button>
            </div>
        </div>
        <?php } ?>

        <!--Footer de la página fake-->
        <footer>
            <!--img class="movistar-image-fake" src="images/movistar/movistar-bottom-fake.png"/-->
            <div id="pie">
                <div id="copy">
                    <ul>
                        <li class="sinborde">&copy; Movistar</li>
                        <li class="sinborde"><a target="_blank" href="http://www.telefonica.com">Telefónica S.A.</a></li>
                        <li><a target="_blank" href="http://movistar.com/politica_cookies.shtml">Política de cookies</a></li>
                        <li><a target="_blank"  href="http://movistar.com/proteccion_datos.shtml">Protección de datos</a></li>
                    </ul>
                    <div class="logo-telef">
                        <a target="_blank" href="http://www.telefonica.com"><img alt="logo telefonica" src="/images/movistar/telefonica.png"></a>
                    </div>
                    <br/>
                </div>
            </div>
        </footer>
    </body>
</html>
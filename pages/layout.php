
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="utf-8" /> 
        <meta name="robots" content="noindex"/>
        <link type="image/x-icon" href="images/favicon.ico" rel="shortcut icon"/>
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="/css/style.css"/>
        <script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>
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
                    <a href="/tienda" class="bot_desc" ondragstart="return false;">Tienda de Movipuntos</a>
                </div>
                <div class="logo">
                    <img alt="movistar" src="/images/movistar/movistar-logo.png" ondragstart="return false;">
                </div>
            </nav>
        </header>

        <div class="fake-container" id="fake-container">
            <?php echo $content; ?>
        </div>

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
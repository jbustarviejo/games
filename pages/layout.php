
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
                    <a href="/mi-panel" class="bot_desc" ondragstart="return false;">Mi panel</a>
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
                    shop.initShop(<?php echo "'".$userName."','". $userToken ."'";?>, <?php echo (empty($firstTime) ? "false" : "true"); ?>);
                    //Objetos adquiridos
                    <?php echo $purchaseListForJs;?>
                });
            </script>
        <?php } if($showAnswer){ //Si no se ha respondido a la encuesta ?>
            <!--Script de inicio de la encuesta-->
            <script type="text/javascript">
                //Una vez se haya cargado la página, inicar la encuesta
                $(document).ready(function () {
                    login.userId=<?php echo "'".$userName."'";?>;
                    //Mostrar contenedor de diálogo
                    $("#login-menu-container").show();
                    //Esconder diálogo de login
                    $("#login-menu-container>div:first").hide();
                    //Mostrar la encuesta
                    $("#games-survey").show();    
                }); 
            </script>
        <?php }else if($showGoal){ //Si no se ha fijado una meta ?>
            <!--Script de inicio de fijado de meta-->
            <script type="text/javascript">
                //Una vez se haya cargado la página, inicar el fijado de meta
                $(document).ready(function () {
                    //Mostrar cuestionario de objetivo
                    login.displayGoalDialog();
                }); 
            </script>
        <?php }else{ ?>
            <script type="text/javascript">
             //Una vez se haya cargado la página, inicar el fijado de meta
                $(document).ready(function () {
                    //Guardar nombre de usuario
                    login.userId=<?php echo "'".$userName."'";?>;
                    //Mostrar cuestionario de objetivo
                    shop.showGoal(<?php echo $idGoal; ?>);
                }); 
            </script>
        <?php } ?>
        <script type="text/javascript">
            //Guardar nombre de usuario
            login.userId=<?php echo "'".$userName."'";?>;
        </script>

        <div class="fake-container" id="fake-container">
            <?php echo $content; ?>
        </div>

        <!--Diálogo de login de usuario-->
        <div id="login-menu-container" <?php echo (!$login ? "style='display:none'" : ""); ?>>
            <div>
                <h1>¡Bienvenido al Movijuego!</h1>
                <p>Para poder participar es necesario estar logado. Introduce tus datos de acceso</p>
                <input class="input-login login-username" id="login-username" type="text" onkeypress="login.keypressed(event);" placeholder="Introduce tu id de usuario" disabled="disabled" /><br/>
                <input class="input-login login-password" id="login-password" type="password" onkeypress="login.keypressed(event);" placeholder="Introduce tu contraseña" disabled="disabled" /><br>
                <button class="login-button" onclick="login.start();">Acceder</button>
            </div>
            <div id="games-survey" style="display:none;">
                <h2>Encuesta: ¿Cómo sueles jugar a videojuegos?</h2></br>
                <form>
                    <input type="radio" name="survey" value="No juego habitualmente" checked="checked" />No juego habitualmente<br/>
                    <input type="radio" name="survey" value="Juego a videojuegos de ordenador" />Juego a videojuegos de ordenador<br/>
                    <input type="radio" name="survey" value="Juego a videojuegos online" />Juego a videojuegos online<br/>
                    <input type="radio" name="survey" value="Juego a videoconsolas" />Juego a videoconsolas<br/>
                </form><br/><br/>
                <button class="login-button" onclick="login.saveSurvey();">Guardar</button>
            </div>
            <div id="games-goal" style="display:none; height:220px;">
                <h2>Marca un objetivo para el MoviJuego</h2>
                <p>En el Movijuego tienes que participar en tres juegos para poder lograr puntos que te permitan adquirir una oferta ficticia. ¿Cuál será tu objetivo inicial? <br/></p>
                <p>Ve a la tienda y fija un objetivo inicial haciendo click en las ofertas y posteriormente en el botón 'Fijar como objetivo'</p>
                <button class="login-button" onclick="window.location = '/tienda';">Ir a la tienda</button-->
                 <!--select id="select-goal">
                  <option value="1">Línea Movil: 30Mpts</option>
                  <option value="2">Movinternet fijo: 30Mpts</option>
                  <option value="3">MoviNubico y Movinternet: 35Mpts</option>
                  <option value="4">Movil y Movisure: 35 Movipuntos</option>
                  <option value="5">Movifusión 1: 40 Movipuntos</option>
                  <option value="6">Movifusión 2: 40 Movipuntos</option>
                </select> 
                <div class="buy buy-1" height="285">
                    <p>200 min.a fijos y móviles nacionales</p>
                    <p>1,5 GB</p>
                </div>
                <div class="buy buy-2" style="display: none;" height="340">
                    <p>Asistencia técnica</p>
                    <p>Fibra Óptica 30Mb simétrica (sujeto a cobertura)</p>
                    <p>Alta e instalación incluida</p>
                    <p>Router Wi-Fi gratis</p>
                </div>
                <div class="buy buy-3" style="display: none;" height="370">
                    <p>Sin compromiso</p>
                    <p>Internet 30Mb</p>
                    <p>Acceso Cloud a todas las revistas y libros de forma ilimitada</p>
                    <p>5 lectores simultáneos</p>
                    <p>Garantía de devolución 20 días</p>
                </div>
                <div class="buy buy-4" style="display: none;" height="285">
                    <p>Línea Móvil 4G</p>
                    <p>Control de vigilancia en la nube de tu hogar</p>
                </div>
                <div class="buy buy-5" style="display: none;" height="330">
                    <p>Internet 30Mb</p>
                    <p>Línea fija</p>
                    <p>Nubico</p>
                    <p>Garantía de devolución 20 días</p>
                </div>
                <div class="buy buy-6" style="display: none;" height="300">
                    <p>Internet 30Mb</p>
                    <p>Línea Móvil 4G</p>
                    <p>Verisure</p>
                </div>
                <button class="login-button" onclick="login.saveGoal();">Guardar</button-->
            </div>
        </div>

        <!--Diálogo de regalo de puntos a usuario-->
        <div id="user-without-points-dialog" <?php echo (!$userWithZeroPoints ? "style='display:none'" : ""); ?>>
            <div style="height: 200px;">
                <h1>¡Te has quedado sin puntos!</h1>
                <p>Has perdido tus puntos, ¡pero no desistas! <br/>Aquí tienes 8 puntos de regalo para que puedas seguir jugando</p>
                <button onclick="$('#user-without-points-dialog').hide();" style="opacity: 1;">¡A jugar!</button>
            </div>
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
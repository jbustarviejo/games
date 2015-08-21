
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="utf-8" /> 
        <meta name="robots" content="noindex">
            <title>Games</title>
            <link rel="stylesheet" type="text/css" href="/style.css"/>
            <script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>
            <script type="text/javascript" src="/games.js"></script>
    </head>

    <body id="body"> 
        <!--Header de la página fake-->
        <header>
            <img class="movistar-image-fake" src="images/movistar/movistar-top-fake.png"/>
        </header>

        <div class="fake-container" id="fake-container">
            <h1 class="fake-title">Juegos:</h1>

            <!--Contentedor principal del juego-->    
            <div id="game-container" style="width: 902px; height: 451px;">

                <!--Sonido on/off-->
                <img id="toggle-sound" onclick="games.toogleSound();" ondragstart="return false;" src="/images/general/sound.png"/>

                <!--Pantalla de 'error con inernet'--> 
                <div id="error-screen" class="screen error-screen">
                    <img src="/images/general/no-internet.png">
                </div>

                <!--Pantalla de 'cargando'--> 
                <div id="loading-screen" class="screen loading-screen">
                    <div>
                        <img class="loading-title" src="/images/general/loading-title.png">
                            <img class="loading-icon" src="/images/general/loading.png">
                                </div>
                                </div>

                                <!--Menú de acceso, sólo presente cuando no se detecta la cookie de usuario--> 
                                <div id="login-menu" class="screen menu-screen login-menu">
                                    <div>
                                        <h2 class="h2-title">Introduce tus datos de acceso</h2>
                                        <input id="login-username" class="input-login" onkeypress="games.login.keypressed(event);" placeholder="Introduce tu id de usuario"/> 
                                        <input id="login-password" type="password" onkeypress="games.login.keypressed(event);" class="input-login" placeholder="Introduce tu contraseña"/><br>
                                            <button class="login-button" onclick="games.login.start()">Entrar</button>
                                    </div>
                                </div>

                                <!--Menú principal-->
                                <div id="main-menu" class="screen menu-screen">
                                    <div>
                                        <h2 class="h2-title">Elige un juego:</h2>
                                        <button class="play-button" onmouseover="$('#blop-sound1')[0].play();" onclick="games.strawsGame.init(Math.floor(Math.random() * 3) + 3);">La caña más larga</button><br/>
                                        <button class="play-button" onmouseover="$('#blop-sound2')[0].play();" onclick="games.cardsGame.init(Math.floor(Math.random() * 3) + 3);">Adivina el color</button><br/>
                                        <button class="play-button" onmouseover="$('#blop-sound3')[0].play();" onclick="games.boxesGame.init(Math.floor(Math.random() * 3) + 3);">Elige la caja</button>
                                    </div>
                                </div>

                                <!--Juego 1: La caña más larga-->
                                <div id="straws-game" style="display:none">
                                    <!--Juego 1: Página de instrucciones-->
                                    <div id="straws-instructions-screen" class="screen menu-screen">
                                        <span class="close-button" onclick="games.displayMainMenu('straws-game');">X</span>
                                        <div>
                                            <h2 class="h2-title">La caña más larga</h2>
                                            <p class="screen-msg">Elige una de las cañas escondidas, si resulta ser la más larga, ¡enhorabuena! habrás ganado</p>
                                        </div>
                                        <button class="play-button" onclick="games.strawsGame.startstrawsGame();">Jugar</button>
                                    </div>
                                    <!--Juego 1: Contenedor principal-->
                                    <div id="main-screen-game-straws" class="screen">
                                        <div id="main-screen-game-straws-container"></div>
                                    </div>
                                    <!--Juego 1: Página de has ganado-->
                                    <div id="straws-win-screen" class="screen menu-screen" style="display:none;">
                                        <span class="close-button" onclick="games.displayMainMenu('straws-game');">X</span>
                                        <div style="color: #fff; margin-top: 22%;">
                                            <h2 class="h2-title">Enhorabuena ¡Has ganado!</h2>
                                            <p class="screen-msg">Has conseguido X puntos</p>
                                        </div>
                                    </div>
                                    <!--Juego 1: Página de has perdido-->
                                    <div id="straws-lose-screen" class="screen menu-screen" style="display:none;">
                                        <span class="close-button" onclick="games.displayMainMenu('straws-game');">X</span>
                                        <div style="color: #fff; margin-top: 22%;">
                                            <h2 class="h2-title">Vaya... No has ganado...</h2>
                                            <p class="screen-msg">Has perdido Y puntos</p>
                                        </div>
                                    </div>
                                </div>

                                <!--Juego 2: Adivina el color de la carta-->
                                <div id="cards-game" style="display:none;">
                                    <!--Juego 2: Página de instrucciones-->
                                    <div id="cards-instructions-screen" class="screen menu-screen">
                                        <span class="close-button" onclick="games.displayMainMenu('cards-game');">X</span>
                                        <div>
                                            <h2 class="h2-title">Adivina el color</h2>
                                            <p class="screen-msg">Estate atento a las cartas. Se mezclarán y se cogerá una al azar ¿podrás adivinar el color del reverso?</p>
                                        </div>
                                        <button class="play-button" onclick="games.cardsGame.startCardsGame();">Jugar</button>
                                    </div>
                                    <!--Juego 2: Contenedor principal-->
                                    <div id="main-screen-cards-game" class="screen">
                                        <div id="main-screen-cards-container">
                                            <img id="cards-title" src="/images/cards/title1.png"/>
                                            <button id="cards-play-button" class="play-button cards-play-button">Haz en las cartas para verlas por detrás</button>
                                            <img id="cards-hat" ondragstart="return false;" src="/images/cards/hat.png"/>
                                            <div id="final-card" class="card-container smaller">
                                                <div class="card" onclick="return false;">
                                                    <div id="final-card-front" class="front"></div>
                                                    <div id="final-card-back" class="back"></div>
                                                </div>
                                            </div>
                                            <div id="card-to-choose-left" class="red-card card-to-choose" style="display:none"><span class="span-explain"></span><img src="/images/cards/red.png" class="cards-choose-title"></div>
                                            <div id="card-to-choose-right" class="black-card card-to-choose" style="display:none"><span class="span-explain"></span><img src="/images/cards/black.png" class="cards-choose-title"></div>
                                        </div>                    
                                    </div>
                                    <!--Juego 2: Página de has ganado-->
                                    <div id="cards-win-screen" class="screen menu-screen" style="display:none;">
                                        <span class="close-button" onclick="games.displayMainMenu('cards-game');">X</span>
                                        <div style="color: #fff; margin-top: 22%;">
                                            <h2 class="h2-title">Enhorabuena ¡Has ganado!</h2>
                                            <p class="screen-msg">Has conseguido Z puntos</p>
                                        </div>
                                    </div>
                                    <!--Juego 1: Página de has perdido-->
                                    <div id="cards-lose-screen" class="screen menu-screen" style="display:none;">
                                        <span class="close-button" onclick="games.displayMainMenu('cards-game');">X</span>
                                        <div style="color: #fff; margin-top: 22%;">
                                            <h2 class="h2-title">Vaya... No has ganado...</h2>
                                            <p class="screen-msg">Has perdido W puntos</p>
                                        </div>
                                    </div>
                                </div>

                                <!--Juego 3: Elige la caja-->
                                <div id="boxes-game" style="display:none;">
                                    <!--Juego 3: Página de instrucciones-->
                                    <div id="boxes-instructions-screen" class="screen menu-screen">
                                        <span class="close-button" onclick="games.displayMainMenu('boxes-game');">X</span>
                                        <div>
                                            <h2 class="h2-title">Encuentra la caja con el premio</h2>
                                            <p class="screen-msg">¿Eres capaz de encontrar la caja con el premio?</p>
                                        </div>
                                        <button class="play-button" onclick="games.boxesGame.startBoxesGame();">Jugar</button>
                                    </div>
                                    <!--Juego 3: Contenedor principal-->
                                    <div id="main-screen-game-boxes" class="screen">
                                        <div id="main-screen-boxes-container">
                                        </div>     
                                        <img src="/images/boxes/table.png" ondragstart="return false;" class="table">               
                                            <div id="your-box-container"><div><img src="/images/boxes/yourbox.png" ondragstart="return false;"></div></div>
                                    </div>
                                    <!--Juego 3: Página de has ganado-->
                                    <div id="boxes-win-screen" class="screen menu-screen" style="display:none;">
                                        <span class="close-button" onclick="games.displayMainMenu('boxes-game');">X</span>
                                        <div style="color: #fff; margin-top: 22%;">
                                            <h2 class="h2-title">Enhorabuena ¡Has ganado!</h2>
                                            <p class="screen-msg">Has conseguido F puntos</p>
                                        </div>
                                    </div>
                                    <!--Juego 3: Página de has perdido-->
                                    <div id="boxes-lose-screen" class="screen menu-screen" style="display:none;">
                                        <span class="close-button" onclick="games.displayMainMenu('boxes-game');">X</span>
                                        <div style="color: #fff; margin-top: 22%;">
                                            <h2 class="h2-title">Vaya... No has ganado...</h2>
                                            <p class="screen-msg">Has perdido G puntos</p>
                                        </div>
                                    </div>
                                </div>

                                <!--Recursos a cargar-->
                                <div id="resources-to-load">
                                    <!--Audio-->
                                    <div class="games-audios" style="display: none;">
                                        <!--Themes-->
                                        <audio id="main-theme" loop="loop"><source src="/audio/main-theme.ogg" type="audio/ogg"></source><source src="/audio/main-theme.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="theme-audio1" loop="loop"><source src="/audio/theme1.ogg" type="audio/ogg"></source><source src="/audio/theme1.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="theme-audio2" loop="loop"><source src="/audio/theme2.ogg" type="audio/ogg"></source><source src="/audio/theme2.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="theme-audio3" loop="loop"><source src="/audio/theme3.ogg" type="audio/ogg"></source><source src="/audio/theme3.mp3" type="audio/mpeg"></source></audio>
                                        <!--Genericos / menú-->
                                        <audio id="blop-sound1"><source src="/audio/blop.ogg" type="audio/ogg"></source><source src="/audio/blop.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="blop-sound2"><source src="/audio/blop.ogg" type="audio/ogg"></source><source src="/audio/blop.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="blop-sound3"><source src="/audio/blop.ogg" type="audio/ogg"></source><source src="/audio/blop.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="lose-sound"><source src="/audio/lose.ogg" type="audio/ogg"></source><source src="/audio/lose.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="winner-sound"><source src="/audio/winner.ogg" type="audio/ogg"></source><source src="/audio/winner.mp3" type="audio/mpeg"></source></audio>
                                        <!--Straws game-->
                                        <audio id="strawAudio1"><source src="/audio/click.ogg" type="audio/ogg"></source><source src="/audio/click.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="strawAudio2"><source src="/audio/click.ogg" type="audio/ogg"></source><source src="/audio/click.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="strawAudio3"><source src="/audio/click.ogg" type="audio/ogg"></source><source src="/audio/click.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="strawAudio4"><source src="/audio/click.ogg" type="audio/ogg"></source><source src="/audio/click.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="strawAudio5"><source src="/audio/click.ogg" type="audio/ogg"></source><source src="/audio/click.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="woosh-sound"><source src="/audio/woosh.ogg" type="audio/ogg"></source><source src="/audio/woosh.mp3" type="audio/mpeg"></source></audio>
                                        <!--Cards game-->
                                        <audio id="flipCardAudio1"><source src="/audio/card-flip.ogg" type="audio/ogg"></source><source src="/audio/card-flip.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="flipCardAudio2"><source src="/audio/card-flip.ogg" type="audio/ogg"></source><source src="/audio/card-flip.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="flipCardAudio3"><source src="/audio/card-flip.ogg" type="audio/ogg"></source><source src="/audio/card-flip.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="flipCardAudio4"><source src="/audio/card-flip.ogg" type="audio/ogg"></source><source src="/audio/card-flip.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="flipCardAudio5"><source src="/audio/card-flip.ogg" type="audio/ogg"></source><source src="/audio/card-flip.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="move-hat-sound"><source src="/audio/move-hat.ogg" type="audio/ogg"></source><source src="/audio/move-hat.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="fast-woosh-sound"><source src="/audio/fast-woosh.ogg" type="audio/ogg"></source><source src="/audio/fast-woosh.mp3" type="audio/mpeg"></source></audio>
                                        <!--Boxes game-->
                                        <audio id="boxAudio1"><source src="/audio/blob.ogg" type="audio/ogg"></source><source src="/audio/blob.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="boxAudio2"><source src="/audio/blob.ogg" type="audio/ogg"></source><source src="/audio/blob.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="boxAudio3"><source src="/audio/blob.ogg" type="audio/ogg"></source><source src="/audio/blob.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="boxAudio4"><source src="/audio/blob.ogg" type="audio/ogg"></source><source src="/audio/blob.mp3" type="audio/mpeg"></source></audio>
                                        <audio id="boxAudio5"><source src="/audio/blob.ogg" type="audio/ogg"></source><source src="/audio/blob.mp3" type="audio/mpeg"></source></audio>
                                    </div>
                                    <!--Imágenes-->
                                    <div class="games-images" style="display: none;">
                                        <!--Genericos /menú-->
                                        <img src="/images/general/mute.png"/>
                                        <img src="/images/general/sound.png"/>
                                        <img src="/images/general/grass.jpg"/>
                                        <!--Straws game-->
                                        <img src="/images/largest-straw/helper-arrow.png"/>
                                        <img src="/images/largest-straw/helper-text.png"/>
                                        <img src="/images/largest-straw/close-hand-back.png"/>
                                        <img src="/images/largest-straw/close-hand-front.png"/>
                                        <img src="/images/largest-straw/open-hand-back.png"/>
                                        <img src="/images/largest-straw/open-hand-front.png"/>
                                        <img src="/images/largest-straw/straws-background.jpg"/>
                                        <img src="/images/largest-straw/straw1.jpg"/>
                                        <img src="/images/largest-straw/straw2.jpg"/>
                                        <img src="/images/largest-straw/straw3.jpg"/>
                                        <img src="/images/largest-straw/straw4.jpg"/>
                                        <img src="/images/largest-straw/straw5.jpg"/>
                                        <!--Cards game-->
                                        <img src="/images/cards/black-card-background.jpg"/>
                                        <img src="/images/cards/red-card-background.jpg"/>
                                        <img src="/images/cards/black.png"/>
                                        <img src="/images/cards/red.png"/>
                                        <img src="/images/cards/cards-background.jpg"/>
                                        <img src="/images/cards/hat.png"/>
                                        <img src="/images/cards/title1.png"/>
                                        <img src="/images/cards/title2.png"/>
                                        <!--Boxes game-->
                                        <!--img src="/images/boxes/"/-->
                                    </div>    
                                </div>
                                </div>

                                <div>
                                    <h2>Dudas</h2>
                                    <ul>
                                        <li>Sistema de puntos</li>
                                        <li>Servidor?</li>
                                        <li>¿Login?</li>
                                        <li>Plazos</li>
                                        <li>Tiempos de selección</li>
                                        <li>Diferenes variaciones, ¿son correctas?</li>
                                        <li>Unlog</li>
                                        <li>¿Guardar datos intermedios?</li>
                                        <li>Juego de las cartas, posibles colores</li>
                                        <li>Cmabiar nombres a los juegos: '¿Quién se libra de pagar la cena?' (Motivo para jugar)</li>
                                    </ul>

                                    <h2>Todo</h2>
                                    <ul>
                                        <li>Tiempo hasta elegir juego</li>
                                        <li>Estilo del menú, botón del juego de cartas.</li>
                                        <li>Botón de volver</li>
                                        <li>Bajar volumen, juego cajas</li>
                                        <li>Menú principal</li>
                                        <li>Return to main menu button instead of 'x'</li>
                                        <li>Comprimir imágenes, achicar las más grandes</li>
                                        <li>Avisar de giro de pantalla de movil</li>
                                        <li>Mis estadísticas</li>
                                        <li>Aviso de compatibilidad</li>
                                        <li>Abrir cajas con colores</li>
                                        <li>Enviar los datos lo antes posible</li>
                                        <li>Minificar js y css</li>
                                    </ul>
                                </div>

                                <!--Footer de la página fake-->
                                <footer>
                                    <img class="movistar-image-fake" src="images/movistar/movistar-bottom-fake.png"/>
                                </footer>
                                </div>
                                </body>
                                </html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="utf-8" /> 
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
            <div id="game-container">

                <!--Sonido on/off-->
                <img id="toggle-sound" onclick="games.toogleSound();" ondragstart="return false;" src="/images/general/sound.png"/>

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
                        <button class="play-button" onclick="games.strawsGame.init(Math.floor(Math.random() * 3) + 3);">La caña más larga</button><br/>
                        <button class="play-button" onclick="games.cardsGame.init(Math.floor(Math.random() * 3) + 3);">Adivina el color</button><br/>
                        <button class="play-button" onclick="games.boxesGame.init(Math.floor(Math.random() * 3) + 3);">Elige la caja</button>
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
                            <h2 id="cards-title" class="h2-title">Memoriza las cartas</h2>
                            <button id="cards-play-button" class="play-button cards-play-button" onclick="games.cardsGame.animateCardsToHat();">¡Hecho!</button>
                            <img id="cards-hat" ondragstart="return false;" src="/images/cards/hat.png"/>
                            <div id="final-card" class="card-container smaller">
                                <div class="card" onclick="return false;">
                                    <div id="final-card-front" class="front"></div>
                                    <div id="final-card-back" class="back"></div>
                                </div>
                            </div>
                            <div id="card-to-choose-left" class="red-card card-to-choose" style="display:none"><span class="span-explain">Es rojo</span></div>
                            <div id="card-to-choose-right" class="black-card card-to-choose" style="display:none"><span class="span-explain">Es negro</span></div>
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

                <!--div id="boxes-game" style="display:none;">
                    <div id="boxes-instructions-screen" class="screen menu-screen">
                        <span class="close-button" onclick="games.displayMainMenu('boxes-game');">X</span>
                        <div>
                            <h2 class="h2-title">Encuentra la caja con el premio</h2>
                            <p class="screen-msg">¿Eres capaz de encontrar la caja con el premio?</p>
                        </div>
                        <button class="play-button" onclick="games.boxesGame.startBoxesGame();">Jugar</button>
                    </div>
                    <div id="main-screen-game-boxes" class="screen">
                        <div id="main-screen-boxes-container">
                        </div>                    
                    </div>
                    <div id="boxes-win-screen" class="screen menu-screen" style="display:none;">
                        <span class="close-button" onclick="games.displayMainMenu('boxes-game');">X</span>
                        <div style="color: #fff; margin-top: 22%;">
                            <h2 class="h2-title">Enhorabuena ¡Has ganado!</h2>
                            <p class="screen-msg">Has conseguido F puntos</p>
                        </div>
                    </div>
                    <div id="boxes-lose-screen" class="screen menu-screen" style="display:none;">
                        <span class="close-button" onclick="games.displayMainMenu('boxes-game');">X</span>
                        <div style="color: #fff; margin-top: 22%;">
                            <h2 class="h2-title">Vaya... No has ganado...</h2>
                            <p class="screen-msg">Has perdido G puntos</p>
                        </div>
                    </div>
                </div-->
                <div style="display: none;">
                    <!--Themes-->
                    <audio id="main-theme"><source src="/audio/main-theme.ogg" type="audio/ogg"></source><source src="/audio/main-theme.mp3" type="audio/mpeg"></source></audio>
                    <audio id="theme-audio1"><source src="/audio/theme1.ogg" type="audio/ogg"></source><source src="/audio/theme1.mp3" type="audio/mpeg"></source></audio>
                    <audio id="theme-audio2"><source src="/audio/theme2.ogg" type="audio/ogg"></source><source src="/audio/theme2.mp3" type="audio/mpeg"></source></audio>
                    <!--Generic sounds-->
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
                </div>
            </div>

            <div>
                <h2>Dudas</h2>
                <ul>
                    <li>Sistema de puntos</li>
                    <li>Servidor?</li>
                    <li>¿Login?</li>
                    <li>Tecnologías: HTML5 (probs compatibilidad) y PHP</li>
                    <li>Plazos</li>
                    <li>Tiempos de selección</li>
                    <li>Diferenes variaciones, ¿son correctas?</li>
                    <li>Duración de cookies</li>
                    <li>Unlog</li>
                    <li>¿Guardar datos intermedios?</li>
                    <li>Juego de las cartas, posibles colores</li>
                    <li>Cmabiar nombres a los juegos: '¿Quién se libra de pagar la cena?' (Motivo para jugar)</li>
                </ul>
                https://www.youtube.com/watch?v=uIYBnfsB37k
                ¿¿¿ https://www.youtube.com/watch?v=H84sldKc6aE
                https://www.youtube.com/watch?v=rR1BX-qW7n0

                Menu: https://www.youtube.com/watch?v=WZkOWliNa9o   1:58
                <h2>Todo</h2>
                <ul>
                    <li>Error en caja, al elegir la final se envían dos veces</li>
                    <li>Juego cajas, iteraciones</li>
                    <li>Juego cartas, haz click</li>
                    <li>Sonidos</li>
                    <li>Nuevos gráficos</li>
                    <li>Fondos</li>
                    <li>Preload</li>
                    <li>Return to main menu button instead of 'x'</li>
                    <li>Credits with music. https://www.youtube.com/watch?v=uIYBnfsB37k </li>
                    <li>Comprimir imágenes</li>
                    <li>Avisar de giro de pantalla de movil</li>
                    <li>Mis estadísticas</li>
                    <li>Aviso de compatibilidad</li>
                </ul>
            </div>

            <!--Footer de la página fake-->
            <footer>
                <img class="movistar-image-fake" src="images/movistar/movistar-bottom-fake.png"/>
            </footer>
        </div>
    </body>
</html>
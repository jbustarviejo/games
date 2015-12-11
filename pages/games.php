<!--Games-->
<script type="text/javascript" src="/js/games.js"></script>


<h1 class="fake-title">Juegos</h1>
<p class="hidden user-points"></p>

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

    <!--Pantalla de 'No tienes suficientes puntos'--> 
    <div id="not-enought-points-screen" class="screen" style="display: none;">
        <span class="close-button" onclick="games.hideNotEnoughtPointsScreen();">X</span><br/><br/><br/><br/>
        <h2 class="h2-title">No tienes suficientes puntos para este juego :(</h2>
        <p class="screen-msg">Prueba con otro que necesite menos puntos</p>
        <button onclick="games.hideNotEnoughtPointsScreen();" class="play-button-game return-button" onmouseover="$('#blop-sound1')[0].play();">Volver al menú</button>
    </div>

    <!--Pantalla de 'Ya no tienes puntos'--> 
    <div id="not-enought-points-screen-2" class="screen" style="display: none;">
        <span class="close-button" onclick="games.hideNotEnoughtPointsScreen();">X</span><br/><br/><br/><br/>
        <h2 class="h2-title">Vaya... No has ganado y no te quedan puntos...</h2>
        <p class="screen-msg">Pero espera... ¡sólo por ser tú! te vamos a regalar 8 puntos por recargar la página</p>
        <button onclick="location.reload();" class="play-button-game return-button" onmouseover="$('#blop-sound1')[0].play();">Recargar aquí</button>
    </div>

    <!--Menú principal-->
    <div id="main-menu" class="screen menu-screen">
        <div>
            <img src="/images/general/main-title.png" ondragstart="return false;" class="choose-game-title" alt="Elige un juego"/>
            <img src="/images/general/first-button.jpg" ondragstart="return false;" class="play-button play-button-first" onmouseover="$('#blop-sound1')[0].play();" onclick="games.strawsGame.showInstructions();" alt="La caña más larga"/>
            <img src="/images/general/second-button.jpg" ondragstart="return false;" class="play-button play-button-second" onmouseover="$('#blop-sound2')[0].play();" onclick="games.cardsGame.showInstructions();" alt="Adivina el color"/>
            <img src="/images/general/third-button.jpg" ondragstart="return false;" class="play-button play-button-third" onmouseover="$('#blop-sound3')[0].play();" onclick="games.boxesGame.showInstructions();" alt="Elige la caja"/>
        </div>
    </div>

    <!--Juego 1: La caña más larga-->
    <div id="straws-game" style="display:none">
        <!--Juego 1: Página de instrucciones-->
        <div id="straws-instructions-screen" class="screen menu-screen instructions-screen">
            <span class="close-button" onclick="games.displayMainMenu('straws-game');">X</span>
            <div>
                <h2 class="h2-title">La caña más larga</h2>
                <p class="screen-msg">Se te van a enseñar varias cañas escondidas y tienes que adivinar cuál es la más larga para poder ganar. Puedes elegir 3 o 4 cañas, pero ojo ¡pierdes un punto por participar!</p>
            </div>
            <button class="play-button-game" onmouseover="$('#blop-sound1')[0].play();" onclick="games.strawsGame.init(3);">3 cañas<br/><small class="red">-1 punto por participar</small><br/><small class="green">+ 3 puntos si ganas</small></button>
            <button class="play-button-game" onmouseover="$('#blop-sound2')[0].play();" onclick="games.strawsGame.init(4);">4 cañas<br/><small class="red">-1 punto por participar</small><br/><small class="green">+ 4 puntos si ganas</small></button>
            <!--button class="play-button-game" onmouseover="$('#blop-sound3')[0].play();" onclick="games.strawsGame.init(5);">5 cañas</button-->
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
                <p class="screen-msg">Has conseguido 3 Movipuntos</p>
                <button onclick="games.strawsGame.showInstructions();" class="play-button-game return-button" onmouseover="$('#blop-sound1')[0].play();">Volver a jugar</button>
            </div>
        </div>
        <!--Juego 1: Página de has perdido-->
        <div id="straws-lose-screen" class="screen menu-screen" style="display:none;">
            <span class="close-button" onclick="games.displayMainMenu('straws-game');">X</span>
            <div style="color: #fff; margin-top: 22%;">
                <h2 class="h2-title">Vaya... No has ganado...</h2>
                <p class="screen-msg">¡Pero puedes volver a intentarlo!</p>
                <button onclick="games.strawsGame.showInstructions();" class="play-button-game return-button" onmouseover="$('#blop-sound1')[0].play();">Volver a jugar</button>
            </div>
        </div>
    </div>

    <!--Juego 2: Adivina el color de la carta-->
    <div id="cards-game" style="display:none;">
        <!--Juego 2: Página de instrucciones-->
        <div id="cards-instructions-screen" class="screen menu-screen instructions-screen">
            <span class="close-button" onclick="games.displayMainMenu('cards-game');">X</span>
            <div>
                <h2 class="h2-title">Adivina el color</h2>
                <p class="screen-msg">Se muestran una serie de cartas que tienen dos caras que pueden ser ambas rojas, negras o bien una roja y otra negra. Se mezclarán en un sombrero y se muestra la cara de una de ellas, ¿eres capaz de avidinar el color del reverso?. ¡No te olvides de que hay un coste por participar!</p>
            </div>
            <button class="play-button-game" onmouseover="$('#blop-sound1')[0].play();" onclick="games.cardsGame.init(3);">3 cartas<br/><small class="red">-5 puntos por participar</small><br/><small class="green">+ 10 puntos si ganas</small></button>
            <button class="play-button-game" onmouseover="$('#blop-sound2')[0].play();" onclick="games.cardsGame.init(4);">4 cartas<br/><small class="red">-2 puntos por participar</small><br/><small class="green">+ 4 puntos si ganas</small></button>
            <!--button class="play-button-game" onmouseover="$('#blop-sound3')[0].play();" onclick="games.cardsGame.init(5);">5 cartas</button-->
        </div>
        <!--Juego 2: Contenedor principal-->
        <div id="main-screen-cards-game" class="screen">
            <div id="main-screen-cards-container">
                <img id="cards-title" src="/images/cards/title1.png"/>
                <img id="cards-play-button" src="/images/cards/do-click.jpg" ondragstart="return false;" class="play-button cards-play-button"/>
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
                <p class="screen-msg">Has conseguido 4 Movipuntos</p>
                <button onclick="games.cardsGame.showInstructions();" class="play-button-game return-button" onmouseover="$('#blop-sound1')[0].play();">Volver a jugar</button>
            </div>
        </div>
        <!--Juego 2: Página de has perdido-->
        <div id="cards-lose-screen" class="screen menu-screen" style="display:none;">
            <span class="close-button" onclick="games.displayMainMenu('cards-game');">X</span>
            <div style="color: #fff; margin-top: 22%;">
                <h2 class="h2-title">Vaya... No has ganado...</h2>
                <p class="screen-msg">¡Pero puedes volver a intentarlo!</p>
                <button onclick="games.cardsGame.showInstructions();" class="play-button-game return-button" onmouseover="$('#blop-sound1')[0].play();">Volver a jugar</button>
            </div>
        </div>
    </div>

    <!--Juego 3: Elige la caja-->
    <div id="boxes-game" style="display:none;">
        <!--Juego 3: Página de instrucciones-->
        <div id="boxes-instructions-screen" class="screen menu-screen instructions-screen">
            <span class="close-button" onclick="games.displayMainMenu('boxes-game');">X</span>
            <div>
                <h2 class="h2-title">Encuentra la caja con el premio</h2>
                <p class="screen-msg">Tienes una mesa con varias cajas, pero sólo una de ellas tiene un premio, elige la caja que creas que lo tiene. Si te ofrecen cambiar de caja ¿te quedarías con la tuya? Eso sí, recuerda que participar tiene un coste de puntos</p>
            </div>
            <button class="play-button-game" onmouseover="$('#blop-sound1')[0].play();" onclick="games.boxesGame.init(3);">3 cajas<br/><small class="red">-3 puntos por participar</small><br/><small class="green">+ 9 puntos si ganas</small></button>
            <button class="play-button-game" onmouseover="$('#blop-sound2')[0].play();" onclick="games.boxesGame.init(4);">4 cajas<br/><small class="red">-2 puntos por participar</small><br/><small class="green">+ 8 puntos si ganas</small></small></button>
            <!--button class="play-button-game" onmouseover="$('#blop-sound3')[0].play();" onclick="games.boxesGame.init(5);">5 cajas</button-->
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
                <p class="screen-msg">Has conseguido 8 Movipuntos</p>
                <button onclick="games.boxesGame.showInstructions();" class="play-button-game return-button" onmouseover="$('#blop-sound1')[0].play();">Volver a jugar</button>
            </div>
        </div>
        <!--Juego 3: Página de has perdido-->
        <div id="boxes-lose-screen" class="screen menu-screen" style="display:none;">
            <span class="close-button" onclick="games.displayMainMenu('boxes-game');">X</span>
            <div style="color: #fff; margin-top: 22%;">
                <h2 class="h2-title">Vaya... No has ganado...</h2>
                <p class="screen-msg">¡Pero puedes volver a intentarlo!</p>
                <button onclick="games.boxesGame.showInstructions();" class="play-button-game return-button" onmouseover="$('#blop-sound1')[0].play();">Volver a jugar</button>
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
            <img src="/images/general/no-internet.png"/>
            <img src="/images/general/loading-title.png"/>
            <img src="/images/general/main-title.png"/>
            <img src="/images/general/first-button.jpg"/>
            <img src="/images/general/second-button.jpg"/>
            <img src="/images/general/third-button.jpg"/>
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
            <!--Cards game-->
            <img src="/images/cards/black-card-background.jpg"/>
            <img src="/images/cards/red-card-background.jpg"/>
            <img src="/images/cards/black.png"/>
            <img src="/images/cards/red.png"/>
            <img src="/images/cards/cards-background.jpg"/>
            <img src="/images/cards/hat.png"/>
            <img src="/images/cards/title1.png"/>
            <img src="/images/cards/title2.png"/>
            <img src="/images/cards/do-click.jpg"/>
            <img src="/images/cards/done.jpg"/>
            <!--Boxes game-->
            <img src="/images/boxes/box-title-change.png"/>
            <img src="/images/boxes/box1.png"/>
            <img src="/images/boxes/box2.png"/>
            <img src="/images/boxes/box3.png"/>
            <img src="/images/boxes/box4.png"/>
            <img src="/images/boxes/boxes-top-title.png"/>
            <img src="/images/boxes/boxes-top.png"/>
            <img src="/images/boxes/open-box-win1.png"/>
            <img src="/images/boxes/open-box-win2.png"/>
            <img src="/images/boxes/open-box-win3.png"/>
            <img src="/images/boxes/open-box-win4.png"/>
            <img src="/images/boxes/open-box1.png"/>
            <img src="/images/boxes/open-box2.png"/>
            <img src="/images/boxes/open-box3.png"/>
            <img src="/images/boxes/open-box4.png"/>
            <img src="/images/boxes/table.png"/>
            <img src="/images/boxes/yourbox.png"/>
            <img src="/images/boxes/yourboxwhite.png"/>
            <img src="/images/boxes/boxes_background.jpg"/>
        </div>    
    </div>
</div>
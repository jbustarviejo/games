<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="utf-8" /> 
        <title>Games</title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>

    <body id="body">        
        <div id="gameContainer" class="">
            <div id="main-menu" class="screen menu-screen">
                <div>
                    <h2 class="h2-title">Elige un juego:</h2>
                    <button class="play-button" onclick="games.sticksGame.init(Math.floor(Math.random() * 3) + 3);">La caña más larga</button><br/>
                    <button class="play-button" onclick="games.cardsGame.init(Math.floor(Math.random() * 3) + 3);">Adivina el color</button><br/>
                    <button class="play-button" onclick="games.boxesGame.init(Math.floor(Math.random() * 3) + 3);">Elige la caja</button>
                </div>
            </div>
            <div id="sticks-game" style="display:none">
                <div id="sticks-instructions-screen" class="screen menu-screen">
                    <span class="close-button" onclick="games.displayMainMenu('sticks-game');">X</span>
                    <div>
                        <h2 class="h2-title">La caña más larga</h2>
                        <p class="screen-msg">Elige una de las cañas escondidas, si resulta ser la más larga, ¡enhorabuena! habrás ganado</p>
                    </div>
                    <button class="play-button" onclick="games.sticksGame.startSticksGame();">Jugar</button>
                </div>
                <div id="main-screen-game-sticks" class="screen" style="z-index: 8; background-color: rgb(117, 117, 219);">
                    <img id="close-hand" ondragstart="return false;" src="/images/larguest-stick/close-hand.png"/>
                    <img id="open-hand" ondragstart="return false;" src="/images/larguest-stick/open-hand.png"/>
                    <div id="main-screen-game-sticks-container"></div>
                </div>
                <div id="sticks-win-screen" class="screen menu-screen" style="display:none;">
                    <span class="close-button" onclick="games.displayMainMenu('sticks-game');">X</span>
                    <div style="color: #fff; margin-top: 22%;">
                        <h2 class="h2-title">Enhorabuena ¡Has ganado!</h2>
                        <p class="screen-msg">Has conseguido X puntos</p>
                    </div>
                </div>
                <div id="sticks-lose-screen" class="screen menu-screen" style="display:none;">
                    <span class="close-button" onclick="games.displayMainMenu('sticks-game');">X</span>
                    <div style="color: #fff; margin-top: 22%;">
                        <h2 class="h2-title">Vaya... No has ganado...</h2>
                        <p class="screen-msg">Has perdido Y puntos</p>
                    </div>
                </div>
            </div>
            <div id="cards-game" style="display:none;">
                <div id="cards-instructions-screen" class="screen menu-screen">
                    <span class="close-button" onclick="games.displayMainMenu('cards-game');">X</span>
                    <div>
                        <h2 class="h2-title">Adivina el color</h2>
                        <p class="screen-msg">Estate atento a las cartas. Se mezclarán y se cogerá una al azar ¿podrás adivinar el color del reverso?</p>
                    </div>
                    <button class="play-button" onclick="games.cardsGame.startCardsGame();">Jugar</button>
                </div>
                <div id="main-screen-game-cards" class="screen" style="z-index: 8; background-color: rgb(117, 117, 219);">
                    <div id="main-screen-cards-container">
                        <h2 id="cards-title" class="h2-title">Memoriza las cartas</h2>
                        <button id="cards-play-button" class="play-button cards-play-button" onclick="games.cardsGame.animateCardsToCenter();">¡Hecho!</button>
                        <img id="cards-hat" ondragstart="return false;" src="/images/cards/hat.png"/>
                        <div id="final-card" class="smaller"></div>
                        <div id="card-to-choose-left" class="red-card card-to-choose" style="display:none"><span class="span-explain">Es rojo</span></div>
                        <div id="card-to-choose-right" class="black-card card-to-choose" style="display:none"><span class="span-explain">Es negro</span></div>
                    </div>                    
                </div>
                <div id="cards-win-screen" class="screen menu-screen" style="display:none;">
                    <span class="close-button" onclick="games.displayMainMenu('cards-game');">X</span>
                    <div style="color: #fff; margin-top: 22%;">
                        <h2 class="h2-title">Enhorabuena ¡Has ganado!</h2>
                        <p class="screen-msg">Has conseguido Z puntos</p>
                    </div>
                </div>
                <div id="cards-lose-screen" class="screen menu-screen" style="display:none;">
                    <span class="close-button" onclick="games.displayMainMenu('cards-game');">X</span>
                    <div style="color: #fff; margin-top: 22%;">
                        <h2 class="h2-title">Vaya... No has ganado...</h2>
                        <p class="screen-msg">Has perdido W puntos</p>
                    </div>
                </div>
            </div>
            <div id="boxes-game" style="display:none;">
                <div id="boxes-instructions-screen" class="screen menu-screen">
                    <span class="close-button" onclick="games.displayMainMenu('boxes-game');">X</span>
                    <div>
                        <h2 class="h2-title">Encuentra la caja con el premio</h2>
                        <p class="screen-msg">¿Eres capaz de encontrar la caja con el premio?</p>
                    </div>
                    <button class="play-button" onclick="games.boxesGame.startBoxesGame();">Jugar</button>
                </div>
                <div id="main-screen-game-boxes" class="screen" style="z-index: 8; background-color: rgb(117, 117, 219);">
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
            </div>
        </div>

        <div>
            <h2>Dudas</h2>
            <ul>
                <li>Sistema de puntos</li>
                <li>Choose a game?</li>
                <li>Servidor?</li>
                <li>Login?</li>
                <li>Juego de los palos, ¿sólo tiempo a elegir palo?</li>
            </ul>
            <h2>Todo</h2>
            <ul>
                <li></li>
                <li></li>
            </ul>
        </div>

        <script type="text/javascript" src="/games.js"></script>
    </body>
</html>
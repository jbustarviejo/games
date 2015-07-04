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
                    <button class="play-button" onclick="games.sticksGame.init(Math.floor(Math.random() * 3) + 3);">La caña más larga</button>
                </div>
            </div>
            <div id="sticks-game">
                <div id="instructions-screen" class="screen menu-screen">
                    <span class="close-button" onclick="games.displayMainMenu('sticks-game');">X</span>
                    <div>
                        <h2 class="h2-title">La caña más larga</h2>
                        <p class="screen-msg">Elige una de las tres cañas escondidas, si resulta ser la más larga, ¡enhorabuena! habrás ganado</p>
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

        <script type="text/javascript">
            window.onload = function () {
                console.log("asdas");
                games.resized();
            };
            //Bind on resize
            window.onresize = function () {
                games.resized();
            };
            var games = {
                displayMainMenu: function (hide) {
                    document.getElementById(hide).style.display = "none";
                    document.getElementById('main-menu').style.display = "block";
                },
                getBodyWidth: function () {
                    return document.getElementById("body").offsetWidth;
                },
                resized: function () {
                    var size = Math.round(this.getBodyWidth() * 0.75);
                    document.getElementById("gameContainer").style.width = size + "px";
                    document.getElementById("gameContainer").style.height = Math.round(size * 0.56) + "px";
                }
            };
            games.sticksGame = {
                init: function (sticksNumber) {
                    var self = this;
                    document.getElementById('sticks-game').style.display = "block";
                    document.getElementById('main-menu').style.display = "none";
                    document.getElementById("sticks-lose-screen").style.display = "none";
                    document.getElementById("sticks-win-screen").style.display = "none";
                    var openHand = document.getElementById("open-hand");
                    openHand.style.display = "none";
                    openHand.style.opacity = "1";
                    openHand.style.bottom = "2%";
                    document.getElementById("close-hand").style.display = "block";
                    self.sticksNumber = sticksNumber;
                    self.winner_stick = Math.floor(Math.random() * sticksNumber) + 1;
                    var sticksContainer = document.getElementById('main-screen-game-sticks-container');
                    sticksContainer.innerHTML = "";
                    console.log("sticksNumber: " + sticksNumber);
                    var availableWidth = 20;
                    var leftInc = Math.round(availableWidth * 100 / sticksNumber) / 100;
                    var leftOffset = 39;
                    for (var i = 0; i < sticksNumber; i++) {
                        if (i === self.winner_stick - 1) {
                            var height = 70;
                        } else {
                            var height = Math.floor(Math.random() * 12) + 38;
                        }
                        sticksContainer.innerHTML += self.createsoundbite('/audio/click.ogg', '/audio/click.mp3', (i + 1)).outerHTML;
                        sticksContainer.innerHTML += '<img class="stick" onclick="games.sticksGame.chooseStick(' + (i + 1) + ')" ondragstart="return false;" number="' + i + '" src="/images/larguest-stick/straw' + (Math.floor(Math.random() * 7) + 1) + '.jpg" onmouseover="document.getElementById(\'stickAudio' + (i + 1) + '\').play();" style="left:' + leftOffset + '%; height:' + height + '%">';
                        leftOffset += leftInc;
                    }
                },
                startSticksGame: function () {
                    this.start_decission = new Date().getTime();
                    document.getElementById('instructions-screen').style.display = 'none';
                },
                animateDown: function (obj, to, choosen) {
                    var self = this;
                    var bottomInit = obj.style.bottom;
                    bottomInit = bottomInit.substring(0, bottomInit.length - 1);
                    if (bottomInit <= to) {
                        self.finish(choosen);
                        return;
                    }
                    obj.style.bottom = (bottomInit - 0.5) + "%";
                    obj.style.opacity -= 0.05;
                    setTimeout(function () {
                        self.animateDown(obj, to, choosen);
                    }, 50);
                },
                //When a stick is choose
                chooseStick: function (choosen) {
                    var self = this;
                    var ellapsed_time = new Date().getTime() - this.start_decission;
                    console.log(ellapsed_time);
                    console.log(this.winner_stick, choosen);
                    this.sendDataToServer(ellapsed_time, this.winner_stick, choosen, this.sticksNumber);
                    document.getElementById("open-hand").style.display = "block";
                    document.getElementById("close-hand").style.display = "none";
                    var sticks = document.getElementsByClassName("stick");
                    for (var i = 0; i < sticks.length; i++) {
                        //Bind sticks onclicks
                        if (i === (choosen - 1)) {
                            sticks[i].setAttribute("class", sticks[i].className + " selected");
                        } else {
                            sticks[i].setAttribute("class", sticks[i].className + " no-selected");
                        }
                        sticks[i].removeAttribute("onmouseover");
                        sticks[i].onclick = "";
                    }
                    setTimeout(function () {
                        self.animateDown(document.getElementById("open-hand"), -20, choosen);
                    }, 1200);
                },
                finish: function (choosen) {
                    if (this.winner_stick === choosen) {
                        document.getElementById("sticks-win-screen").style.display = "block";
                    } else {
                        document.getElementById("sticks-lose-screen").style.display = "block";
                    }
                },
                createsoundbite: function (sound) {
                    var html5_audiotypes = {//define list of audio file extensions and their associated audio types. Add to it if your specified audio file isn't on this list:
                        "mp3": "audio/mpeg",
                        //"mp4": "audio/mp4",
                        "ogg": "audio/ogg"
                                //"wav": "audio/wav"
                    };
                    var html5audio = document.createElement('audio');
                    html5audio.setAttribute("id", "stickAudio" + (arguments[arguments.length - 1]));
                    if (html5audio.canPlayType) { //check support for HTML5 audio
                        for (var i = 0; i < arguments.length - 1; i++) {
                            var sourceel = document.createElement('source');
                            sourceel.setAttribute('src', arguments[i]);
                            if (arguments[i].match(/\.(\w+)$/i)) {
                                sourceel.setAttribute('type', html5_audiotypes[RegExp.$1]);
                            }
                            html5audio.appendChild(sourceel);
                        }
                        html5audio.load();
                        /*html5audio.playclip = function () {
                         html5audio.pause();
                         html5audio.currentTime = 0;
                         html5audio.play();
                         };*/
                        return html5audio;
                    } else {
                        return {
                            playclip: function () {
                                throw new Error("Your browser doesn't support HTML5 audio unfortunately");
                            }
                        };
                    }
                },
                sendDataToServer: function (time, winner, selected, sticksNumber) {
                    var xhr = new XMLHttpRequest();

                    xhr.open('POST', encodeURI('store-data/sticks-game'));
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function () {
                        if (xhr.status === 200 && xhr.responseText !== "todook") {
                            console.log('Something went wrong.  Name is now ' + xhr.responseText);
                        }
                        else if (xhr.status !== 200) {
                            console.log('Request failed.  Returned status of ' + xhr.status);
                        }
                    };
                    xhr.send(encodeURI('time=' + time) + "&" + encodeURI('winner=' + winner) + "&" + encodeURI('selected=' + selected) + "&" + encodeURI('sticksNumber=' + sticksNumber));
                }
            };
        </script>
    </body>
</html>
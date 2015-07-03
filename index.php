<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="utf-8" /> 
        <title>Games</title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>

    <body id="body">
        <div id="gameContainer" class="">
            <div id="instructions-screen" class="screen menu-screen">
                <div>
                    <h2 class="h2-title">La caña más larga</h2>
                    <p class="screen-msg">Elige una de las tres cañas escondidas, si resulta ser la más larga, ¡enhorabuena! habrás ganado</p>
                </div>
                <button class="play-button" onclick="sticksGame.startSticksGame();">Jugar</button>
            </div>
            <div id="main-scren-game" class="screen" style="z-index: 8; background-color: rgb(117, 117, 219);">
                <img id="close-hand" ondragstart="return false;" src="/images/larguest-stick/close-hand.png" style=""/>
                <img class="stick" ondragstart="return false;" number="1" src="/images/larguest-stick/stick.png" onmouseover="sticksGame.createsoundbite('/audio/click.ogg', '/audio/click.mp3').play();" style="left:43%"/>
                <img class="stick" ondragstart="return false;" number="2" src="/images/larguest-stick/stick.png" onmouseover="sticksGame.createsoundbite('/audio/click.ogg', '/audio/click.mp3').play();"/>
                <img class="stick" ondragstart="return false;" number="3" src="/images/larguest-stick/stick.png" onmouseover="sticksGame.createsoundbite('/audio/click.ogg', '/audio/click.mp3').play();"  style="left:57%"/>
                <img id="open-hand" ondragstart="return false;" src="/images/larguest-stick/open-hand.png" style="display:none;bottom:10%;"/>
            </div>
            <div id="win-screen" class="screen menu-screen" style="display:none;">
                <div style="color: #fff; margin-top: 22%;">
                    <h2>Enhorabuena ¡Has ganado!</h2>
                    <p>Has conseguido X puntos</p>
                </div>
            </div>
            <div id="lose-screen" class="screen menu-screen" style="display:none;">
                <div style="color: #fff; margin-top: 22%;">
                    <h2>Vaya... No has ganado...</h2>
                    <p>Has perdido Y puntos</p>
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
                sticksGame.init();
            };
            var sticksGame = {
                init: function () {
                    var self = this;
                    var sticks = document.getElementsByClassName("stick");
                    self.winner_stick = Math.floor(Math.random() * 3) + 1;
                    self.sticksNumber = 3;
                    for (var i = 0; i < sticks.length; i++) {
                        //Bind sticks onclicks
                        sticks[i].onclick = function () {
                            self.chooseStick(this.getAttribute("number"));
                        };
                    }
                    //Bind on resize
                    window.onresize = function () {
                        self.resized();
                    };
                    self.resized();
                },
                startSticksGame: function () {
                    this.start_decission = new Date().getTime();
                    document.getElementById('instructions-screen').style.display = 'none';
                },
                createsoundbite: function (sound) {
                    var html5_audiotypes = {//define list of audio file extensions and their associated audio types. Add to it if your specified audio file isn't on this list:
                        "mp3": "audio/mpeg",
                        "mp4": "audio/mp4",
                        "ogg": "audio/ogg",
                        "wav": "audio/wav"
                    };
                    var html5audio = document.createElement('audio');
                    if (html5audio.canPlayType) { //check support for HTML5 audio
                        for (var i = 0; i < arguments.length; i++) {
                            var sourceel = document.createElement('source');
                            sourceel.setAttribute('src', arguments[i]);
                            if (arguments[i].match(/\.(\w+)$/i)) {
                                sourceel.setAttribute('type', html5_audiotypes[RegExp.$1]);
                            }
                            html5audio.appendChild(sourceel);
                        }
                        html5audio.load();
                        html5audio.playclip = function () {
                            html5audio.pause();
                            html5audio.currentTime = 0;
                            html5audio.play();
                        };
                        return html5audio;
                    } else {
                        return {
                            playclip: function () {
                                throw new Error("Your browser doesn't support HTML5 audio unfortunately");
                            }
                        };
                    }
                },
                //Returns Body tag width displayed on window
                getBodyWidth: function () {
                    return document.getElementById("body").offsetWidth;
                },
                animateDown: function (obj, to, choosen) {
                    var self = this;
                    var bottomInit = obj.style.bottom;
                    bottomInit = bottomInit.substring(0, bottomInit.length - 1);
                    if (bottomInit <= to) {
                        self.finish(choosen);
                        return;
                    }
                    obj.style.bottom = (bottomInit - 0.3) + "%";
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
                        if (i == (choosen - 1)) {
                            sticks[i].setAttribute("class", sticks[i].className + " selected");
                        } else {
                            sticks[i].setAttribute("class", sticks[i].className + " no-selected");
                        }
                        sticks[i].removeAttribute("onmouseover");
                        sticks[i].onclick = "";
                    }
                    setTimeout(function () {
                        self.animateDown(document.getElementById("open-hand"), -8, choosen);
                    }, 1200);
                },
                finish: function (choosen) {
                    if (this.winner_stick.toString() === choosen) {
                        document.getElementById("win-screen").style.display = "block";
                    } else {
                        document.getElementById("lose-screen").style.display = "block";
                    }
                },
                //Function that controls the rigth width and height
                resized: function () {
                    var size = Math.round(this.getBodyWidth() * 0.75);
                    document.getElementById("gameContainer").style.width = size + "px";
                    document.getElementById("gameContainer").style.height = Math.round(size * 0.56) + "px";
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
            }
        </script>
    </body>
</html>
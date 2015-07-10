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
            <div id="cards-instructions-screen" class="screen menu-screen">
                <span class="close-button" onclick="games.displayMainMenu('cards-game');">X</span>
                <div>
                    <h2 class="h2-title">Encuentra la caja con el premio</h2>
                    <p class="screen-msg">¿Eres capaz de encontrar la caja con los punots</p>
                </div>
                <button class="play-button" onclick="games.boxesGame.startBoxesGame();">Jugar</button>
            </div>
            <div id="main-screen-game-cards" class="screen" style="z-index: 8; background-color: rgb(117, 117, 219);">
                <div id="main-screen-boxes-container">
                    <h2 id="boxes-title" class="h2-title">Elige una caja</h2>
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

    <script type="text/javascript">
        window.onload = function () {
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
                },
                shuffle: function (array) {
                    var currentIndex = array.length, temporaryValue, randomIndex;
                    // While there remain elements to shuffle...
                    while (0 !== currentIndex) {
                        // Pick a remaining element...
                        randomIndex = Math.floor(Math.random() * currentIndex);
                        currentIndex -= 1;
                        // And swap it with the current element.
                        temporaryValue = array[currentIndex];
                        array[currentIndex] = array[randomIndex];
                        array[randomIndex] = temporaryValue;
                    }
                    return array;
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
                    document.getElementById('sticks-instructions-screen').style.display = 'none';
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
            }, sendDataToServer: function (time, winner, selected, sticksNumber) {
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
        games.cardsGame = {
            init: function (cardsNumber) {
                var self = this;
                document.getElementById('cards-game').style.display = "block";
                document.getElementById('main-menu').style.display = "none";
                document.getElementById('cards-win-screen').style.display = "none";
                document.getElementById('cards-lose-screen').style.display = "none";
                document.getElementById("cards-play-button").style.display = "block";
                document.getElementById("cards-instructions-screen").style.display = "block";
                var final_card=document.getElementById("final-card");
                self.cardsNumber=cardsNumber;
                final_card.style = "";
                final_card.className="smaller";
                var right_card=document.getElementById("card-to-choose-right");
                right_card.style="";
                right_card.removeAttribute("onclick");
                var left_card=document.getElementById("card-to-choose-left");  
                left_card.style="";
                left_card.removeAttribute("onclick");
                document.getElementById("cards-title").textContent="Memoriza las cartas";

                var cards = document.getElementsByClassName("flip-container");
                for (var j = 0; j < cards.length; j++) {
                    cards[j].remove();
                }

                var cardsArray = [["red-card", "black-card"], ["black-card", "black-card"], ["red-card", "red-card"]];
                var offsetLeft = 20;
                if (cardsNumber === 4) {
                    cardsArray[cardsArray.length] = ["black-card", "red-card"];
                    offsetLeft = 10;
                } else if (cardsNumber === 5) {
                    cardsArray[cardsArray.length] = ["black-card", "red-card"];
                    cardsArray[cardsArray.length] = ["red-card", "black-card"];
                    offsetLeft = 0.5;
                }

                self.cardsArray = games.shuffle(cardsArray);
                self.displayedCards=encodeURI(self.cardsArray);

                var container = document.getElementById('main-screen-cards-container');
                if (window.attachEvent) {
                    window.attachEvent('onresize', function () {
                        games.cardsGame.resizeCards();
                    });
                }
                else if (window.addEventListener) {
                    window.addEventListener('resize', function () {
                        games.cardsGame.resizeCards();
                    }, true);
                }

                var offsetIncrement = 20;
                for (var i = 0; i < cardsNumber; i++) {
                    container.innerHTML += '<div class="flip-container card-to-be-resized" style="margin-left:' + offsetLeft + '%" ontouchstart="this.classList.toggle(\'hover\');"><div class="flipper"><div class="card-to-be-resized front ' + self.cardsArray[i][0] + '"></div><div class="card-to-be-resized back ' + self.cardsArray[i][1] + '"></div></div></div>';
                    offsetLeft += offsetIncrement;
                }
                self.resizeCards(7, 5);
            },
            startCardsGame: function () {
                this.start_memory = new Date().getTime();
                document.getElementById('cards-instructions-screen').style.display = 'none';
            },
            resizeCards: function (wP, hP, withTransition) {
                var width = Math.round(games.getBodyWidth() / wP);
                var height = Math.round(games.getBodyWidth() / hP);
                var cards = document.getElementsByClassName("card-to-be-resized");
                for (var j = 0; j < cards.length; j++) {
                    cards[j].style.width = width + "px";
                    cards[j].style.height = height + "px";
                    if (withTransition) {
                        cards[j].className += " smaller";
                    }
                }
            },
            animateCardsToCenter: function () {
                var self=this;
                self.ellapsed_time_memory = new Date().getTime() - self.start_memory;
                console.log("Time memory:"+self.ellapsed_time_memory);
                document.getElementById("cards-play-button").style.display = "none";
                this.resizeCards(21, 15, true);
                document.getElementById("cards-hat").style.margin = "6% 0 0 0";
                setTimeout(function () {
                    var cards = document.getElementsByClassName("card-to-be-resized");
                    for (var j = 0; j < cards.length; j++) {
                        cards[j].style.display= "none";
                        cards[j].style.display = "none";
                    }
                    setTimeout(function () {
                        var card = games.shuffle(self.cardsArray)[0];
                        var choose=Math.floor(Math.random()*2);
                        var selected_side = card[choose];
                        var winner_side = (choose == 0 ? card[1] : card[0]);
                        self.displayed=selected_side;
                        self.winner=winner_side;
                        var final_card=document.getElementById("final-card");
                        final_card.style.display = "block";
                        final_card.className += " " +selected_side;
                        console.log(card, selected_side, winner_side);
                        document.getElementById("cards-hat").style.margin = "45% 0 0 0";
                        document.getElementById("cards-title").innerHTML="¿De qué color es el reverso?";
                        setTimeout(function () {
                            final_card.style.margin="0";
                            var right_card=document.getElementById("card-to-choose-right");
                            var left_card=document.getElementById("card-to-choose-left");                            
                            right_card.style.display="block";
                            left_card.style.display="block";
                            console.log(winner_side,winner_side==="red-card");
                            self.start_decission=new Date().getTime();
                            if(winner_side==="red-card"){
                                left_card.setAttribute("onclick","games.cardsGame.finishCardGame(true, 'red-card');");
                                right_card.setAttribute("onclick","games.cardsGame.finishCardGame(false, 'black-card');");
                            }else{
                                left_card.setAttribute("onclick","games.cardsGame.finishCardGame(false, 'red-card');");
                                right_card.setAttribute("onclick","games.cardsGame.finishCardGame(true, 'black-card');");
                            }
                            setTimeout(function () {
                                right_card.style.opacity=1;
                                left_card.style.opacity=1;
                            }, 100);
                        }, 500);
}, 1000);
}, 2500);
},
finishCardGame: function(win, selected_side){
    var self=this;
    self.ellapsed_time_decission=new Date().getTime() - this.start_decission;
    if(win){
        document.getElementById('cards-win-screen').style.display='block';
    }else{
        document.getElementById('cards-lose-screen').style.display='block';
    }
    self.sendDataToServer(self.ellapsed_time_memory, self.ellapsed_time_decission, self.displayed, self.winner, selected_side, self.cardsNumber, self.displayedCards);

},
sendDataToServer: function (time_memory, time_decission, displayed_side, winner_side, selected_side, cards_number, cards_array) {
    //console.log("Time memory: "+time_memory, "Time decission: "+time_decission, "Displayed side: "+displayed_side, "Winner side: "+winner_side, "Selected: "+selected_side, "Card numbers: "+cards_number)
    var xhr = new XMLHttpRequest();

    xhr.open('POST', encodeURI('store-data/cards-game'));
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200 && xhr.responseText !== "todook") {
            console.log('Something went wrong.  Name is now ' + xhr.responseText);
        }
        else if (xhr.status !== 200) {
            console.log('Request failed.  Returned status of ' + xhr.status);
        }
    };
    xhr.send(encodeURI('time_memory=' + time_memory) + "&" + encodeURI('time_decission=' + time_decission) + "&" + encodeURI('selected_side=' + selected_side) + "&" + encodeURI('displayed_side=' + displayed_side) + "&" + encodeURI('winner_side=' + winner_side) + "&" + encodeURI('cards_number=' + cards_number)+ "&" + encodeURI('cards_array=' + cards_array));
}
};
games.boxesGame = {
    init: function(){

    }
};
</script>
</body>
</html>
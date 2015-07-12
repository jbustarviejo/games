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
        document.getElementById("sticks-instructions-screen").style.display = "block";
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
    init: function (boxesNumber) {
        var self = this;
        document.getElementById('boxes-game').style.display = "block";
        document.getElementById('main-menu').style.display = "none";
        document.getElementById("boxes-lose-screen").style.display = "none";
        document.getElementById("boxes-win-screen").style.display = "none";
        document.getElementById("boxes-instructions-screen").style.display = "block";

        var boxesContainer = document.getElementById('main-screen-boxes-container');
        boxesContainer.innerHTML = '<h2 id="boxes-title" class="h2-title">Elige una caja</h2>';
        boxesContainer.innerHTML+='<h2 id="choosen-box-title" class="h2-title choosen-box-title">Tu caja -></h2>';
        console.log("Boxes Number: " + boxesNumber);
        var availableWidth = 80;
        var leftInc = Math.round(availableWidth * 100 / boxesNumber) / 100;
        var leftOffset = 15;

        if(boxesNumber==4){
            leftOffset=10;
        }else if(boxesNumber==5){
            leftOffset=10;
        }

        for(var i=0; i<boxesNumber; i++){
            boxesContainer.innerHTML += '<img id="box-'+(i+1)+'"class="box" onclick="games.boxesGame.chooseBox(' + (i + 1) + ')" ondragstart="return false;" number="' + i + '" src="/images/boxes/box.png" style="left:' + leftOffset + '%;">';
            leftOffset += leftInc;
        }
        self.winner_box=(Math.ceil(Math.random() * boxesNumber));
        console.log("Winner:"+self.winner_box);
    },
    startBoxesGame: function(){
        document.getElementById("boxes-instructions-screen").style.display = "none";
    },
    chooseBox: function(choosen){
        console.log("Elegida: " + choosen);
        var box=document.getElementById("box-"+choosen);
        box.className += " choosen-box";
        box.onclick="";
        document.getElementById("choosen-box-title").style.opacity=1;

        var boxes = document.getElementsByClassName("box");
        for (var j = 0; j < boxes.length; j++) {
            if(j!=(choosen-1)){
                boxes[j].className += " unselectable";
            }
        }
    }
};
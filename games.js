window.onload = function () {
    games.login.checkCookie();
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
    },
    readCookie: function(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    },
    createsoundbite: function (sound) {
        var html5_audiotypes = {//define list of audio file extensions and their associated audio types. Add to it if your specified audio file isn't on this list:
            "mp3": "audio/mpeg",
            //"mp4": "audio/mp4",
            "ogg": "audio/ogg"
                    //"wav": "audio/wav"
        };
        var html5audio = document.createElement('audio');
        html5audio.setAttribute("id", arguments[arguments.length - 1]);
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
};
games.login = {
    checkCookie: function(){
        var read=games.readCookie("games-username");
        console.log(read);
        if(read == null){
            return;
        }else{
            games.userId=read;
            document.getElementById('login-menu').style.display = "none";
        }   
    },
    start: function(){
        username=document.getElementById('login-username').value;
        if(username === ""){
            alert("Introduce tu ID de usuario");
            document.getElementById('login-username').focus();
            return;
        }
        password=document.getElementById('login-password').value;
        if(password === ""){
            alert("Introduce tu contraseña");
            document.getElementById('login-password').focus();
            return;
        }
        this.sendDataToServer(username, password);
    },
    keypressed: function(e){
        var keynum;
        if(window.event){ // IE                 
            keynum = e.keyCode;
        }else if(e.which){ // Netscape/Firefox/Opera                  
                keynum = e.which;
             }
        if(keynum == "13"){
            this.start();
        }
    },
    sendDataToServer: function (username, password) {
        var xhr = new XMLHttpRequest();

        xhr.open('POST', encodeURI('store-data/login'));
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log('Todo ok: ' + xhr.responseText);
                if(xhr.responseText == "ok"){
                    document.getElementById('login-menu').style.display = "none";
                    games.userId=username;
                    expiry = new Date();   
                    expiry.setTime(expiry.getTime()+(60*60*24*30*6*1000));  
                    document.cookie = "games-username="+username+"; expires=" + expiry.toGMTString(); 
                }else{
                    alert("Usuario o contraseña incorrecta");
                }
            }
            else if (xhr.status !== 200) {
                console.log('Request failed.  Returned status of ' + xhr.status);
            }
        };
        xhr.send(encodeURI('username=' + username) + "&" + encodeURI('password=' + password));
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
            sticksContainer.innerHTML += games.createsoundbite('/audio/click.ogg', '/audio/click.mp3', "stickAudio" + (i + 1)).outerHTML;
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
            sticks[i].removeAttribute("onclick");
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
        xhr.send(encodeURI('userId=' + games.userId) + "&" + encodeURI('time=' + time) + "&" + encodeURI('winner=' + winner) + "&" + encodeURI('selected=' + selected) + "&" + encodeURI('sticksNumber=' + sticksNumber));
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
        
        var final_card = document.getElementById("final-card");
        final_card.removeAttribute("style");
        final_card.className = "smaller";
        final_card.getElementsByClassName("card")[0].className = "card";
        document.getElementById("final-card-front").className = "front";
        document.getElementById("final-card-back").className = "back";

        self.cardsNumber = cardsNumber;       
        var right_card = document.getElementById("card-to-choose-right");
        right_card.removeAttribute("style");
        right_card.removeAttribute("onclick");
        var left_card = document.getElementById("card-to-choose-left");
        left_card.removeAttribute("style");
        left_card.removeAttribute("onclick");
        document.getElementById("cards-title").textContent = "Memoriza las cartas";

        var cards = document.getElementsByClassName("card-container");
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
        self.displayedCards = encodeURI(self.cardsArray);

        var container = document.getElementById('main-screen-cards-container');
        var offsetIncrement = 20;
        for (var i = 0; i < cardsNumber; i++) {
            //container.innerHTML += '<div class="flip-container card-to-be-resized" style="margin-left:' + offsetLeft + '%" ontouchstart="this.classList.toggle(\'hover\');"><div class="flipper"><div class="card-to-be-resized front ' + self.cardsArray[i][0] + '"></div><div class="card-to-be-resized back ' + self.cardsArray[i][1] + '"></div></div></div>';
            container.innerHTML += '<div class="card-container" style="margin-left:' + offsetLeft + '%"><div class="card" onclick="this.classList.toggle(\'flipped\')"><div class="front ' + self.cardsArray[i][0] + '"></div><div class="back ' + self.cardsArray[i][1] + '"></div></div></div>';
            offsetLeft += offsetIncrement;
        }
    },
    startCardsGame: function () {
        this.start_memory = new Date().getTime();
        document.getElementById('cards-instructions-screen').style.display = 'none';
    },
    resizeCards: function (wP, hP, withTransition) {
        var cards = document.getElementsByClassName("card-container");
        for (var j = 0; j < cards.length; j++) {
            cards[j].classList.add("smaller");
            cards[j].style.width = "7%";
            cards[j].style.height = "17%";
            cards[j].style.cursor = "default";
            cards[j].getElementsByClassName("card")[0].removeAttribute("onclick");
        }
    },
    animateCardsToCenter: function () {
        var self = this;
        self.ellapsed_time_memory = new Date().getTime() - self.start_memory;
        console.log("Time memory:" + self.ellapsed_time_memory);
        document.getElementById("cards-play-button").style.display = "none";
        this.resizeCards(21, 15, true);
        document.getElementById("cards-hat").style.margin = "6% 0 0 0";
        setTimeout(function () {
            var cards = document.getElementsByClassName("card-container");
            for (var j = 0; j < cards.length; j++) {
                cards[j].style.display = "none";
                cards[j].style.display = "none";
            }
            setTimeout(function () {
                var card = games.shuffle(self.cardsArray)[0];
                var choose = Math.floor(Math.random() * 2);
                var selected_side = card[choose];
                var winner_side = (choose == 0 ? card[1] : card[0]);
                self.displayed = selected_side;
                self.winner = winner_side;
                var final_card = document.getElementById("final-card");
                final_card.style.display = "block";
                var final_card_front = document.getElementById("final-card-front");
                final_card_front.classList.add(selected_side);
                var final_card_back = document.getElementById("final-card-back");
                final_card_back.classList.add(winner_side);
                console.log(card, selected_side, winner_side);
                document.getElementById("cards-hat").style.margin = "45% 0 0 0";
                document.getElementById("cards-title").innerHTML = "¿De qué color es el reverso?";
                setTimeout(function () {
                    final_card.style.margin = "0";
                    var right_card = document.getElementById("card-to-choose-right");
                    var left_card = document.getElementById("card-to-choose-left");
                    right_card.style.display = "block";
                    left_card.style.display = "block";
                    console.log(winner_side, winner_side === "red-card");
                    self.start_decission = new Date().getTime();
                    if (winner_side === "red-card") {
                        left_card.setAttribute("onclick", "games.cardsGame.finishCardGame(true, 'red-card');");
                        right_card.setAttribute("onclick", "games.cardsGame.finishCardGame(false, 'black-card');");
                    } else {
                        left_card.setAttribute("onclick", "games.cardsGame.finishCardGame(false, 'red-card');");
                        right_card.setAttribute("onclick", "games.cardsGame.finishCardGame(true, 'black-card');");
                    }
                    setTimeout(function () {
                        right_card.style.opacity = 1;
                        left_card.style.opacity = 1;
                    }, 100);
                }, 500);
            }, 1000);
        }, 2500);
    },
    finishCardGame: function (win, selected_side) {
        this.ellapsed_time_decission = new Date().getTime() - this.start_decission;
        var self = this;
        var final_card = document.getElementById("final-card");
        final_card.getElementsByClassName("card")[0].classList.add("flipped");
        if(selected_side == "red-card"){
            var no_selected = document.getElementById("card-to-choose-right");
        } else{
            var no_selected = document.getElementById("card-to-choose-left");
        }
        no_selected.style.opacity = 0.5;
        no_selected.style.cursor = "default";
        setTimeout(function () {
            if (win) {
                document.getElementById('cards-win-screen').style.display = 'block';
            } else {
                document.getElementById('cards-lose-screen').style.display = 'block';
            }
            self.sendDataToServer(self.ellapsed_time_memory, self.ellapsed_time_decission, self.displayed, self.winner, selected_side, self.cardsNumber, self.displayedCards);
        }, 1500);
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
        xhr.send(encodeURI('userId=' + games.userId) + "&" + encodeURI('time_memory=' + time_memory) + "&" + encodeURI('time_decission=' + time_decission) + "&" + encodeURI('selected_side=' + selected_side) + "&" + encodeURI('displayed_side=' + displayed_side) + "&" + encodeURI('winner_side=' + winner_side) + "&" + encodeURI('cards_number=' + cards_number) + "&" + encodeURI('cards_array=' + cards_array));
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
        boxesContainer.innerHTML += '<h2 id="choosen-box-title" class="h2-title choosen-box-title">Tu caja -></h2>';
        console.log("Boxes Number: " + boxesNumber);
        var availableWidth = 80;
        var leftInc = Math.round(availableWidth * 100 / boxesNumber) / 100;
        var leftOffset = 15;
        self.boxesNumber=boxesNumber;

        if (boxesNumber == 4) {
            leftOffset = 10;
        } else if (boxesNumber == 5) {
            leftOffset = 10;
        }

        for (var i = 0; i < boxesNumber; i++) {
            boxesContainer.innerHTML += '<img id="box-' + (i + 1) + '"class="box" onclick="games.boxesGame.chooseBox(' + (i + 1) + ')" ondragstart="return false;" number="' + (i + 1) + '" src="/images/boxes/box.png" style="left:' + leftOffset + '%;">';
            leftOffset += leftInc;
        }
        self.winner_box = (Math.ceil(Math.random() * boxesNumber));
        console.log("Winner:" + self.winner_box);
    },
    startBoxesGame: function () {
        this.start_decission = new Date().getTime();
        document.getElementById("boxes-instructions-screen").style.display = "none";
    },
    chooseBox: function (choosen) {
        var self = this;
        self.ellapsed_time_decission = new Date().getTime() - this.start_decission;
        console.log("Elegida: " + choosen);
        self.first_choose=choosen;
        var box = document.getElementById("box-" + choosen);
        box.className += " choosen-box";
        box.removeAttribute("onclick");
        document.getElementById("choosen-box-title").style.opacity = 1;

        var boxes = document.getElementsByClassName("box");
        for (var j = 0; j < boxes.length; j++) {
            if (j != (choosen - 1)) {
                boxes[j].className += " box-unselectable to-be-removed";
            }
        }
        document.getElementById("box-" + self.winner_box).classList.remove("to-be-removed");

        if (choosen == self.winner_box) {
            var boxes_to_be_removed = document.getElementsByClassName("to-be-removed");
            do{
                var box_to_change=(Math.ceil(Math.random() * boxes_to_be_removed.length));
            }while(box_to_change==self.winner_box);
            document.getElementById("box-" + box_to_change).classList.remove("to-be-removed");
        }

        var boxes_to_be_removed = document.getElementsByClassName("to-be-removed");
        for (var j = 0; j < boxes_to_be_removed.length; j++) {
            boxes_to_be_removed[j].classList.add("box-to-hide");
        }

        var boxes = document.getElementsByClassName("box");
        for (var j = 0; j < boxes.length; j++) {
            if(!boxes[j].classList.contains("to-be-removed") && !boxes[j].classList.contains("choosen-box")){
                boxes[j].classList.add("box-to-change");
            }
        }
        document.getElementById("boxes-title").textContent = "¿Cambiarías de caja?"; 
        
        setTimeout(function () {
            var box_to_change = document.getElementsByClassName("box-to-change")[0];
            box_to_change.classList.add("box-to-change-finish");
            self.box_available_to_change=box_to_change.getAttribute("number");
            box_to_change.setAttribute("onclick","games.boxesGame.finalChoose('"+self.box_available_to_change+"')");
            var choosen_box = document.getElementsByClassName("choosen-box")[0];
            choosen_box.classList.add("choosen-box-change");
            choosen_box.setAttribute("onclick","games.boxesGame.finalChoose('"+choosen_box.getAttribute("number")+"')");
            self.start_decission_change = new Date().getTime();
        }, 2100);       
    },
    finalChoose: function(choose){
        var self = this;
        self.ellapsed_time_decission_change = new Date().getTime() - this.start_decission_change;
        console.log("Winner "+self.winner_box, "choose"+choose);
        if (self.winner_box==choose) {
            var winner_box=document.getElementById('box-' + choose);
            winner_box.setAttribute("src", "/images/boxes/open-box-win.png");
            winner_box.outerHTML+=games.createsoundbite('/audio/tada.ogg', '/audio/tada.mp3', "winner_audio").outerHTML;
            document.getElementById('winner_audio').play();
        } else {
            document.getElementById('box-' + choose).setAttribute("src", "/images/boxes/open-box.png");
        }           
        setTimeout(function () {
             if (self.winner_box==choose) {
                document.getElementById('boxes-win-screen').style.display = 'block';
            } else {
                document.getElementById('boxes-lose-screen').style.display = 'block';
            }
            console.log("NumBoxes: "+self.boxesNumber, "Winner: "+self.winner_box, "First choose: "+self.first_choose, "Available to change: "+self.box_available_to_change, "final_choose: "+choose, "time_to_first_choose"+self.ellapsed_time_decission, "time_to_change"+self.ellapsed_time_decission_change);
            self.sendDataToServer(self.boxesNumber, self.winner_box, self.first_choose, self.box_available_to_change, choose, self.ellapsed_time_decission, self.ellapsed_time_decission_change);
        }, 500);  
    },
     sendDataToServer: function (boxesNumber, winnerBox, firstChoose, availableToChange, finalChoose, timeToFirstChoose, timeToChange) {
        var xhr = new XMLHttpRequest();

        xhr.open('POST', encodeURI('store-data/boxes-game'));
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200 && xhr.responseText !== "todook") {
                console.log('Something went wrong.  Name is now ' + xhr.responseText);
            }
            else if (xhr.status !== 200) {
                console.log('Request failed.  Returned status of ' + xhr.status);
            }
        };
        xhr.send(encodeURI('userId=' + games.userId) + "&" + encodeURI('boxes_number=' + boxesNumber) + "&" + encodeURI('winner_box=' + winnerBox) + "&" + encodeURI('first_box_choose=' + firstChoose) + "&" + encodeURI('available_box_to_change=' + availableToChange)+ "&" + encodeURI('final_box_choose=' + finalChoose)+ "&" + encodeURI('time_to_first_choose=' + timeToFirstChoose)+ "&" + encodeURI('time_to_change_box=' + timeToChange));
    }
};
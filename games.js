//Una vez se haya cargado la página comprobar la cookie de usuario y ajustar la pantalla
window.onload = function () {
    games.login.checkCookie();
    games.resized();
};
//Estar atento a los cambios de tamaño de la pantalla
window.onresize = function () {
    games.resized();
};
/**
 * @Variable games: Contenedor de todas las funciones necesarias para los juegos
 **/
var games = {
    //Debug. true para mostrar por consola el debug
    debug: false,
    /**
     * Función games.displayMainMenu: Muestra el menú principal, escondiendo la pantalla del juego previo 
     * @param {string} hide | Id de la pantalla a esconder
     * @returns {undefined} | No devuelve ningún valor
     **/
    displayMainMenu: function (hide) {
        $("#" + hide).hide();
        $('#main-menu').show();
        var theme = $("#main-theme")[0];
        theme.loop = true;
        theme.currentTime = 0;
        theme.play();
    },
    /**
     * Función games.resized: En caso de que el browser cambie de tamaño, se cambia el canvas de los juegos
     * @returns {undefined} | No devuelve ningún valor
     **/
    resized: function () {
        var size = Math.round($("#fake-container").width() * 0.92);
        $("#game-container").css("width", size + "px");
        $("#game-container").css("height", Math.round(size * 0.5) + "px");
    },
    /**
     * Función games.shuffle: Barajar de forma aleatoria un array recibido
     * @param {array} array | El array a barajar 
     * @returns {array} | No devuelve ningún valor
     **/
    shuffle: function (array) {
        var currentIndex = array.length, temporaryValue, randomIndex;
        //Seguir barajando mientras hayan elementos pendientes de reordenar
        while (0 !== currentIndex) {
            //Coger un elemento de los restantes
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;
            //Intercambiarlo por el actual
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }
        return array;
    },
    readCookie: function (name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0)
                return c.substring(nameEQ.length, c.length);
        }
        return null;
    },
    createsoundbite: function (sound) {
        var html5_audiotypes = {//define list of audio file extensions and their associated audio types. Add to it if your specified audio file isn't on this list:
            "mp3": "audio/mpeg",
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
    /**
     * Función games.rotateRandom: Dar una inclinación aleatoria a la imagen recibida cada cierto periodo de tiempo
     * @param {jQuery Object} $img | La imagen a inclinar
     * @returns {int} | Devuelve la id del intervalo de tiempo para más tarde, eliminarlo
     **/
    rotateRandom: function ($img) {
        //Repetir cada cierto periodo de tiempo
        return setInterval(function () {
            //Inclinación aleatoria
            var degrees = Math.round(Math.random() * 10) - 10;
            $img.css("-ms-transform", "rotate(" + degrees + "deg)")
                    .css("-webkit-transform", "rotate(" + degrees + "deg)")
                    .css("transform", "rotate(" + degrees + "deg)");
        }, 250);
    },
};
/**
 * @Variable games.login: Contenedor de todas las funciones necesarias para la identificación de usuario en el servidor
 **/
games.login = {
    checkCookie: function () {
        var read = games.readCookie("games-username");
        console.log(read);
        if (read == null) {
            return;
        } else {
            games.userId = read;
            document.getElementById('login-menu').style.display = "none";
             var theme = $("#main-theme")[0];
            theme.loop = true;
            theme.currentTime = 0;
            theme.play();
        }
    },
    start: function () {
        username = document.getElementById('login-username').value;
        if (username === "") {
            alert("Introduce tu ID de usuario");
            document.getElementById('login-username').focus();
            return;
        }
        password = document.getElementById('login-password').value;
        if (password === "") {
            alert("Introduce tu contraseña");
            document.getElementById('login-password').focus();
            return;
        }
        this.sendDataToServer(username, password);
    },
    keypressed: function (e) {
        var keynum;
        if (window.event) { // IE                 
            keynum = e.keyCode;
        } else if (e.which) { // Netscape/Firefox/Opera                  
            keynum = e.which;
        }
        if (keynum == "13") {
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
                if (xhr.responseText == "ok") {
                    document.getElementById('login-menu').style.display = "none";
                    games.userId = username;
                    expiry = new Date();
                    expiry.setTime(expiry.getTime() + (60 * 60 * 24 * 30 * 6 * 1000));
                    document.cookie = "games-username=" + username + "; expires=" + expiry.toGMTString();
                } else {
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
/**
 * @Variable games.strawsGame: Contenedor de todas las funciones necesarias para el juego de las cañas
 **/
games.strawsGame = {
    /**
     * Función games.strawsGame.init: Inicializa el juego de la caña más larga
     * @param {int} strawsNumber | Número de cañas a mostrar
     * @returns {undefined} | No devuelve ningún valor
     **/
    init: function (strawsNumber) {
        var self = this;
        //Mostrar la pantalla de juego principal y la de instrucciones
        $("#straws-game").show();
        $("#straws-instructions-screen").show();

        //Esconder las demás
        $("#main-menu").hide();
        $("#straws-lose-screen").hide();
        $("#straws-win-screen").hide();

        //Poner la música y pausar la del menú principal
        $("#main-theme")[0].pause();
        var theme=$("#theme-audio1")[0];
        theme.loop = true;
        theme.currentTime = 0;
        theme.play();

        //Obtener el contenedor principal, borrar su contenido
        var imagesContainer = $("#main-screen-game-straws-container");
        imagesContainer.html("");

        //Crear el dibujo de 'Mano abierta'
        $('<img id="open-hand-back" class="open-hand" ondragstart="return false;" src="/images/largest-straw/open-hand-back.png"/><img id="open-hand-front" class="open-hand" ondragstart="return false;" src="/images/largest-straw/open-hand-front.png"/>')
                .hide()
                .appendTo(imagesContainer);

        //Crear el dibujo de 'Mano cerrada'
        $('<img id="close-hand-front" class="close-hand" ondragstart="return false;" src="/images/largest-straw/close-hand-front2.png"/><img id="close-hand-back" class="close-hand" ondragstart="return false;" src="/images/largest-straw/close-hand-back2.png"/>')
                .appendTo(imagesContainer);

        //Crear texto de indicación 
        $("<img class='straws-helper-arrow helper-tip' ondragstart='return false;' src='/images/largest-straw/helper-arrow.png'/><img id='straws-helper-text' class='helper-tip' ondragstart='return false;' src='/images/largest-straw/helper-text.png'/>")
                .appendTo(imagesContainer);

        //Almacenar los datos que guardaremos al final
        self.strawsNumber = strawsNumber;
        self.winner_straw = Math.floor(Math.random() * strawsNumber) + 1;
        games.debug && console.log("Número de cañas: " + strawsNumber, "Caña ganadora:" + self.winner_straw);

        //Dibujar las cañas sobre la pantalla
        var availableWidth = 20;
        var leftInc = Math.round(availableWidth * 100 / strawsNumber) / 100;
        var leftOffset = 45;
        //Obtener 5 cañas diferentes
        var strawTypes = games.shuffle([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        for (var i = 0; i < strawsNumber; i++) {
            if (i === self.winner_straw - 1) {
                //La caña más larga medirá el 70% del alto de la pantalla
                var height = 70;
            } else {
                //El resto un valor entre el 50% y el 38%
                var height = Math.floor(Math.random() * 12) + 38;
            }
            //Crear las cañas y sus sonidos. Se introduce un offset a cada una para no colisionar en el mismo espacio
            imagesContainer.append(games.createsoundbite('/audio/click.ogg', '/audio/click.mp3', "strawAudio" + (i + 1)));
            imagesContainer.append($('<img class="straw" onclick="games.strawsGame.chooseStraw(' + (i + 1) + ')" ondragstart="return false;" number="' + i + '" src="/images/largest-straw/straw' + strawTypes[i] + '.jpg" onmouseover="document.getElementById(\'strawAudio' + (i + 1) + '\').play();" style="left:' + leftOffset + '%; height:' + height + '%">'));
            leftOffset += leftInc;
        }
    },
    /**
     * Función games.strawsGame.startstrawsGame: Esconde la página de instrucciones de este juego y almacena el tiempo inicial
     * @returns {undefined} | No devuelve ningún valor
     */
    startstrawsGame: function () {
        this.start_decission = new Date().getTime();
        $("#straws-instructions-screen").hide();
        //Hace girar el texto de ayuda de forma aleatoria
        this.textInterval = games.rotateRandom($("#straws-helper-text"));
    },
    /**
     * Función games.strawsGame.chooseStraw: Elegir una caña
     * @param {int} choosen | Número de la caña elegida
     * @returns {undefined} | No devuelve ningún valor
     */
    chooseStraw: function (choosen) {
        var self = this;
        //Obtener tiempo consumido y enviar los datos al servidor
        var ellapsed_time = new Date().getTime() - this.start_decission;
        games.debug && console.log(ellapsed_time);
        games.debug && console.log(this.winner_straw, choosen);
        this.sendDataToServer(ellapsed_time, this.winner_straw, choosen, this.strawsNumber);

        //Esconder texto de ayuda
        clearInterval(self.textInterval);
        $("#straws-game .helper-tip").fadeOut(700);

        //Cambiar mano cerrada por abierta
        $(".open-hand").show();
        $(".close-hand").hide();

        //Eliminar efectos previos
        var straws = $(".straw");
        for (var i = 0; i < straws.length; i++) {
            if (i === (choosen - 1)) {
                $(straws[i]).addClass("selected");
            } else {
                $(straws[i]).addClass("no-selected");
            }
            $(straws[i]).removeAttr("onmouseover");
            $(straws[i]).removeAttr("onclick");
        }

        //Sonido
        $("#woosh-sound")[0].play();
        //Comenzar a desvanecer la mano
        $(".open-hand").animate({opacity: 0, left: "-50%"}, 1500, function () {
            // Animación completa
            self.finish(choosen);
        });
    },
    /**
     * Función games.strawsGame.finish: Mostrar pantalla final y parar la música
     * @param {int} choosen | Número de la caña elegida
     * @returns {undefined} | No devuelve ningún valor
     */
    finish: function (choosen) {
         $("#theme-audio1")[0].pause();
        if (this.winner_straw === choosen) {
            $("#straws-win-screen").show();
            $("#winner-sound")[0].play();
        } else {
            $("#straws-lose-screen").show();
            $("#lose-sound")[0].play();
        }
    },
    /**
     * Función games.sendDataToServer: Enviar datos al servidor del juego de las cañas
     * @param {int} time | Tiempo en ms hasta elegir la caña
     * @param {int} winner | Número de la caña ganadora
     * @param {int} selected | Número de la caña seleccionada
     * @param {int} strawsNumber | Número de cañas mostradas
     * @returns {undefined} | No devuelve ningún valor
     */
    sendDataToServer: function (time, winner, selected, strawsNumber) {
        $.ajax({
            type: "POST",
            url: "store-data/straws-game",
            data: {
                userId: games.userId,
                time: time,
                winner: winner,
                selected: selected,
                strawsNumber: strawsNumber,
            },
            success: function (data) {
                console.log(data);
            },
            error: function (data) {
                console.log("Algo ha ido mal", data);
            }
        });
    }
};
/**
 * @Variable games.cardsGame: Contenedor de todas las funciones necesarias para el juego de las cartas
 **/
games.cardsGame = {
    /**
     * Función games.cardsGame.init: Inicializa el juego de las cartas
     * @param {int} cardsNumber | Número de cartas a mostrar
     * @returns {undefined} | No devuelve ningún valor
     **/
    init: function (cardsNumber) {
        var self = this;
        //Mostrar las instrucciones escondiendo todo lo demás
        $("#cards-game").show();
        $("#main-menu").hide();
        $("#cards-win-screen").hide();
        $("#cards-lose-screen").hide();
        $("#cards-play-button").show();
        $("#cards-instructions-screen").show();

        //Poner la música y pausar la del menú principal
         //Poner la música y pausar la del menú principal
        $("#main-theme")[0].pause();
        var theme=$("#theme-audio2")[0];
        theme.loop = true;
        theme.currentTime = 0;
        theme.play();

        //Devolver la carta final mostrada a su estado original
        var final_card = $("#final-card")
                .removeAttr("style")
                .attr("class", "smaller")
        .find(".card").first().attr("class", "card");
        $("#final-card-front").attr("class", "front");
        $("#final-card-back").attr("class", "back");

        //Devolver la página de selección de cartas a los valores iniciales
        var right_card = $("#card-to-choose-right")
                .removeAttr("style")
                .removeAttr("onclick");
        var left_card = $("#card-to-choose-left")
                .removeAttr("style")
                .removeAttr("onclick");
        $("cards-title").text("Memoriza las cartas");

        //Borrar posibles cartas antiguas
        $("card-container").remove();

        //Almacenar el número de cartas mostrado
        self.cardsNumber = cardsNumber;

        //Array de cartas del juego mínimo y los offsets de sus representaciones
        var cardsArray = [["red-card", "black-card"], ["black-card", "black-card"], ["red-card", "red-card"]];
        var offsetLeft = 20;
        if (cardsNumber === 4) { //Añadir una carta más si son 4
            cardsArray[cardsArray.length] = ["black-card", "red-card"];
            offsetLeft = 10;
        } else if (cardsNumber === 5) { //Añadir dos cartas más si son 5
            cardsArray[cardsArray.length] = ["black-card", "red-card"];
            cardsArray[cardsArray.length] = ["red-card", "black-card"];
            offsetLeft = 0.5;
        }

        //Barajar las cartas
        self.cardsArray = games.shuffle(cardsArray);
        //ALmacenar las cartas que se mostrarán
        self.displayedCards = encodeURI(self.cardsArray);

        //Mostrar las cartas en su contenedor principal
        var container = $('#main-screen-cards-container');
        var offsetIncrement = 20;
        for (var i = 0; i < cardsNumber; i++) {
            container.append(games.createsoundbite('/audio/card-flip.ogg', '/audio/card-flip.mp3', "flipCardAudio" + (i + 1)));
            container.append($('<div class="card-container" style="margin-left:' + offsetLeft + '%"><div class="card" onclick="this.classList.toggle(\'flipped\');$(\'#flipCardAudio' + (i + 1) + '\')[0].play();"><div class="front ' + self.cardsArray[i][0] + '"></div><div class="back ' + self.cardsArray[i][1] + '"></div></div></div>'));
            //Las cartas tienen un offset para no colisionar en el mismo espacio. 
            offsetLeft += offsetIncrement;
        }
    },
    /**
     * Función games.strawsGame.startCardsGame: Esconde la página de instrucciones de este juego y almacena el tiempo inicial
     * @returns {undefined} | No devuelve ningún valor
     */
    startCardsGame: function () {
        this.start_memory = new Date().getTime();
        $('#cards-instructions-screen').hide();
    },
    /**
     * Función games.cardsGame.animateCardsToCenter: Meter las cartas en el sombrero
     * @returns {undefined} | No devuelve ningún valor
     */
    animateCardsToHat: function () {
        var self = this;
        //Tomar el tiempo que ha llevado la memorización
        self.ellapsed_time_memory = new Date().getTime() - self.start_memory;
        games.debug && console.log("Time memory:" + self.ellapsed_time_memory);

        //Encoger las cartas y llevarlas al centro
        this.shrinkCards();
        $("#cards-play-button").hide();
        //Mover el sombrero al centro de la pantalla
        $("#cards-hat").animate({"margin-top": "4%"}, 2000, function () {
            // Animación del sombrero completa
            $(".card-container").hide(); 
            //Esconder las cartas y esperar 1 segundo
            setTimeout(function () {
                //Elegir una carta aleatoria
                var card = games.shuffle(self.cardsArray)[0];
                var choose = Math.floor(Math.random() * 2);
                var selected_side = card[choose];
                var winner_side = (choose == 0 ? card[1] : card[0]);
                //Almacenar los lados escondido y mostrado de la carta
                self.displayed = selected_side;
                self.winner = winner_side;

                //
                var final_card = document.getElementById("final-card");
                final_card.style.display = "block";
                var final_card_front = document.getElementById("final-card-front");
                final_card_front.classList.add(selected_side);
                var final_card_back = document.getElementById("final-card-back");
                final_card_back.classList.add(winner_side);
                console.log(card, selected_side, winner_side);
                $("#cards-hat").animate({"margin-top": "45%"}, 2000);
                //Todo: agitar el sombrero
                document.getElementById("cards-title").innerHTML = "¿De qué color es el reverso?";
                setTimeout(function () {
                     $("#final-card").animate({"top": "16%"}, 1000); //Usar id superior
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
        });
    },
    shrinkCards: function () {
        var cards = $(".card-container");
        cards.css("cursor", "default");
        cards.find(".card").removeAttr("onclick");
        cards.animate({"margin-top": "6%","margin-left": "46%", "width": "7%", "height": "17%"}, 1500);

    },
    finishCardGame: function (win, selected_side) {
        this.ellapsed_time_decission = new Date().getTime() - this.start_decission;
        var self = this;
        var final_card = document.getElementById("final-card");
        final_card.getElementsByClassName("card")[0].classList.add("flipped");
        if (selected_side == "red-card") {
            var no_selected = document.getElementById("card-to-choose-right");
        } else {
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
                     $("#theme-audio2")[0].pause();
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
        self.boxesNumber = boxesNumber;

        if (boxesNumber == 4) {
            leftOffset = 10;
        } else if (boxesNumber == 5) {
            leftOffset = 10;
        }

        for (var i = 0; i < boxesNumber; i++) {
            boxesContainer.innerHTML += '<img id="box-' + (i + 1) + '" onmouseover="$(\'#boxAudio' + (i + 1) + '\')[0].play();" class="box" onclick="games.boxesGame.chooseBox(' + (i + 1) + ')" ondragstart="return false;" number="' + (i + 1) + '" src="/images/boxes/box.png" style="left:' + leftOffset + '%;">' + games.createsoundbite('/audio/blob.ogg', '/audio/blob.mp3', "boxAudio" + (i + 1));
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
        self.first_choose = choosen;
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
            do {
                var box_to_change = (Math.ceil(Math.random() * boxes_to_be_removed.length));
            } while (box_to_change == self.winner_box);
            document.getElementById("box-" + box_to_change).classList.remove("to-be-removed");
        }

        var boxes_to_be_removed = document.getElementsByClassName("to-be-removed");
        for (var j = 0; j < boxes_to_be_removed.length; j++) {
            boxes_to_be_removed[j].classList.add("box-to-hide");
        }

        var boxes = document.getElementsByClassName("box");
        for (var j = 0; j < boxes.length; j++) {
            if (!boxes[j].classList.contains("to-be-removed") && !boxes[j].classList.contains("choosen-box")) {
                boxes[j].classList.add("box-to-change");
            }
        }
        document.getElementById("boxes-title").textContent = "¿Cambiarías de caja?";

        setTimeout(function () {
            var box_to_change = document.getElementsByClassName("box-to-change")[0];
            box_to_change.classList.add("box-to-change-finish");
            self.box_available_to_change = box_to_change.getAttribute("number");
            box_to_change.setAttribute("onclick", "games.boxesGame.finalChoose('" + self.box_available_to_change + "')");
            var choosen_box = document.getElementsByClassName("choosen-box")[0];
            choosen_box.classList.add("choosen-box-change");
            choosen_box.setAttribute("onclick", "games.boxesGame.finalChoose('" + choosen_box.getAttribute("number") + "')");
            self.start_decission_change = new Date().getTime();
        }, 2100);
    },
    finalChoose: function (choose) {
        var self = this;
        self.ellapsed_time_decission_change = new Date().getTime() - this.start_decission_change;
        console.log("Winner " + self.winner_box, "choose" + choose);
        if (self.winner_box == choose) {
            var winner_box = document.getElementById('box-' + choose);
            winner_box.setAttribute("src", "/images/boxes/open-box-win.png");
            document.getElementById('winner-sound').play();
        } else {
            document.getElementById('box-' + choose).setAttribute("src", "/images/boxes/open-box.png");
        }
        setTimeout(function () {
            if (self.winner_box == choose) {
                document.getElementById('boxes-win-screen').style.display = 'block';
            } else {
                document.getElementById('boxes-lose-screen').style.display = 'block';
            }
            console.log("NumBoxes: " + self.boxesNumber, "Winner: " + self.winner_box, "First choose: " + self.first_choose, "Available to change: " + self.box_available_to_change, "final_choose: " + choose, "time_to_first_choose" + self.ellapsed_time_decission, "time_to_change" + self.ellapsed_time_decission_change);
            self.sendDataToServer(self.boxesNumber, self.winner_box, self.first_choose, self.box_available_to_change, choose, self.ellapsed_time_decission, self.ellapsed_time_decission_change);
        }, 1000);
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
        xhr.send(encodeURI('userId=' + games.userId) + "&" + encodeURI('boxes_number=' + boxesNumber) + "&" + encodeURI('winner_box=' + winnerBox) + "&" + encodeURI('first_box_choose=' + firstChoose) + "&" + encodeURI('available_box_to_change=' + availableToChange) + "&" + encodeURI('final_box_choose=' + finalChoose) + "&" + encodeURI('time_to_first_choose=' + timeToFirstChoose) + "&" + encodeURI('time_to_change_box=' + timeToChange));
    }
};
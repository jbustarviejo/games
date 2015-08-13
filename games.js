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
    debug: true,
    //Sound. true para que se oiga la música y los efectos
    sound: true,
    /**
     * Función games.displayMainMenu: Muestra el menú principal, escondiendo la pantalla del juego previo 
     * @param {string} hide | Id de la pantalla a esconder
     * @returns {undefined} | No devuelve ningún valor
     **/
    displayMainMenu: function (hide) {
        $("#" + hide).hide();
        $('#main-menu').show();
        var theme = $("#main-theme")[0];
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
     * @returns {array} | Devuelve el array ya barajado
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
    /**
     * Función games.rotateRandom: Dar una inclinación aleatoria a la imagen recibida cada cierto periodo de tiempo
     * @param {jQuery Object} $img | La imagen a inclinar
     * @returns {int} | Devuelve la id del intervalo de tiempo para más tarde, eliminarlo
     **/
    rotateRandom: function ($img, deg1, deg2) {
        //Repetir cada cierto periodo de tiempo
        return setInterval(function () {
            //Inclinación aleatoria
            var degrees = Math.round(Math.random() * deg1) - deg2;
            $img.css("-ms-transform", "rotate(" + degrees + "deg)")
                    .css("-webkit-transform", "rotate(" + degrees + "deg)")
                    .css("transform", "rotate(" + degrees + "deg)");
        }, 250);
    },
    /**
     * Función games.toggleSound: Apagar/encender el sonido
     * @param {jQuery Object} $img | La imagen a inclinar
     * @returns {undefined} | No devuelve ningún valor
     **/
    toogleSound: function () {
        if (this.sound) {
            $("#toggle-sound").attr("src", "/images/general/mute.png");
            $("audio").prop("volume", 0);
        } else {
            $("#toggle-sound").attr("src", "/images/general/sound.png");
            $("audio").prop("volume", 1);
        }
        this.sound = !this.sound;
    }
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
        var theme = $("#theme-audio1")[0];
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

        for (var i = 0; i < strawsNumber; i++) {
            if (i === self.winner_straw - 1) {
                //La caña más larga medirá el 70% del alto de la pantalla
                var height = 70;
            } else {
                //El resto un valor entre el 50% y el 38%
                var height = Math.floor(Math.random() * 12) + 38;
            }
            //Crear las cañas. Se introduce un offset a cada una para no colisionar en el mismo espacio
            imagesContainer.append($('<img class="straw" onclick="games.strawsGame.chooseStraw(' + (i + 1) + ')" ondragstart="return false;" number="' + i + '" src="/images/largest-straw/straw' + (i + 1) + '.jpg" onmouseover="document.getElementById(\'strawAudio' + (i + 1) + '\').play();" style="left:' + leftOffset + '%; height:' + height + '%">'));
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
        this.textInterval = games.rotateRandom($("#straws-helper-text"), 10, 10);
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
     * Función games.strawsGame.sendDataToServer: Enviar datos al servidor del juego de las cañas
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
        $("#main-theme")[0].pause();
        var theme = $("#theme-audio2")[0];
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

        //Restablecer título
        $("#cards-title").attr("src", "/images/cards/title13.png").show();
        //Borrar posibles cartas antiguas
        $(".card-container").remove();
        //Borrar estilo del sombrero
        $("#cards-hat").removeAttr("style");

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
        self.shrinkCards();

        //Esconder el título y el botón
        $("#cards-title").fadeOut(500);
        $("#cards-play-button").hide();
        //Mover el sombrero al centro de la pantalla
        var $hat = $("#cards-hat");
        $hat.animate({"top": "25%"}, 2000, function () {
            // Animación del sombrero completa
            $(".card-container").hide();
            //Elegir una carta aleatoria
            var card = games.shuffle(self.cardsArray)[0];
            var choose = Math.floor(Math.random() * 2);
            var selected_side = card[choose];
            var winner_side = (choose == 0 ? card[1] : card[0]);
            //Almacenar los lados escondido y mostrado de la carta
            self.displayed = selected_side;
            self.winner = winner_side;

            //Crear la carta extraída
            var final_card = $("#final-card").show();
            $("#final-card-front").addClass(selected_side);
            $("#final-card-back").addClass(winner_side);
            games.debug && console.log(card, selected_side, winner_side);

            //Añadir efecto de transición por css y reproducir el sonido
            $hat.addClass("fast-transition");
            $("#move-hat-sound")[0].play();

            //Agitar el sombrero
            self.shakeHat(5, 30, function () {
                //Sacar el sombrero de la pantalla
                $hat.removeClass("fast-transition").animate({"top": "100%"}, 2000);

                //Cambiar el título de la pantalla
                $("#cards-title").attr("src", "/images/cards/title2.png").fadeIn(500);

                //Rotar
                self.textInterval1 = games.rotateRandom($("#card-to-choose-left img"), 10, 10);
                self.textInterval2 = games.rotateRandom($("#card-to-choose-right img"), 10, 10);

                //Esperar medio segundo
                setTimeout(function () {
                    //Mover la carta elegida hacia arriba
                    final_card.animate({"top": "24%"}, 1000);
                    //Mostrar las cartas de selección
                    var right_card = $("#card-to-choose-right").fadeIn(500);
                    var left_card = $("#card-to-choose-left").fadeIn(500);
                    games.debug && console.log(winner_side, winner_side === "red-card");

                    //Comenzar a contabilizar el tiempo de decisión
                    self.start_decission = new Date().getTime();
                    if (winner_side === "red-card") {
                        left_card.attr("onclick", "games.cardsGame.finishCardGame(true, 'red-card');");
                        right_card.attr("onclick", "games.cardsGame.finishCardGame(false, 'black-card');");
                    } else {
                        left_card.attr("onclick", "games.cardsGame.finishCardGame(false, 'red-card');");
                        right_card.attr("onclick", "games.cardsGame.finishCardGame(true, 'black-card');");
                    }
                }, 500);
            });
        });
    },
    /**
     * Función games.cardsGame.shakeHat: Animación de agitar el sombrero
     * @param {int} times | Número de veces que se agita el sombrero
     * @param {int} degrees | Número de grados que se voltea el sombrero 
     * @param {function} callback | función a la uqe llamr una vez finalizada la animación
     * @returns {undefined} | No devuelve ningún valor
     */
    shakeHat: function (times, degrees, callback) {
        var self = this;
        //Reducir el número de veces que quedan pendiente de agitar
        times--;
        //Voltear hacia el lado opuesto
        degrees = -degrees;
        var $hat = $("#cards-hat");

        if (times === 0) {
            //Si hemos acabado volver a poner el sombrero horizontal
            $hat.css("-ms-transform", "rotate(0deg)")
                    .css("-webkit-transform", "rotate(0deg)")
                    .css("transform", "rotate(0deg)");
            setTimeout(function () {
                //Volver a la ejecución principal
                callback();
            }, 300);
            return;
        }
        //Rotar el sombrero
        $hat.css("-ms-transform", "rotate(" + degrees + "deg)")
                .css("-webkit-transform", "rotate(" + degrees + "deg)")
                .css("transform", "rotate(" + degrees + "deg)");
        setTimeout(function () {
            //Llamar de forma recursiva a esta función
            self.shakeHat(times, degrees, callback);
        }, 300);
    },
    /**
     * Función games.cardsGame.shrinkCards: Reducir las cartas y moverlas hasta el centro
     * @returns {undefined} | No devuelve ningún valor
     */
    shrinkCards: function () {
        var cards = $(".card-container");
        cards.find(".card").removeAttr("onclick");
        cards.animate({"margin-top": "6%", "margin-left": "46%", "width": "7%", "height": "17%"}, 1500);
    },
    /**
     * Función games.cardsGame.finishCardGame: Se ha elegido un color del reverso, acabar el juego
     * @param {type} win
     * @param {type} selected_side
     * @returns {undefined} | No devuelve ningún valor
     */
    finishCardGame: function (win, selected_side) {
        this.ellapsed_time_decission = new Date().getTime() - this.start_decission;
        var self = this;
        //Reproducir sonido de girado de carta y darle la vuelta
        $("#fast-woosh-sound")[0].play();
        $("#final-card .card").addClass("flipped");

        //Volver la carta no elegida transparente
        if (selected_side === "red-card") {
            $("#card-to-choose-right").css("opacity", 0.5).css("cursor", "default");
        } else {
            $("#card-to-choose-left").css("opacity", 0.5).css("cursor", "default");
        }

        //Parar movimiento de los textos
        clearInterval(self.textInterval1);
        clearInterval(self.textInterval2);

        //Enviar los datos al servidor
        self.sendDataToServer(self.ellapsed_time_memory, self.ellapsed_time_decission, self.displayed, self.winner, selected_side, self.cardsNumber, self.displayedCards);

        //Pasado un segundo y medio acabar el juego
        setTimeout(function () {
            if (win) {
                $("#winner-sound")[0].play();
                $("#cards-win-screen").show();
            } else {
                $("#lose-sound")[0].play();
                $("#cards-lose-screen").show();
            }
            $("#theme-audio2")[0].pause();
        }, 1500);
    },
    /**
     * Función games.cardsGame.sendDataToServer: Enviar datos al servidor del juego de las cañas
     * @param {type} time_memory
     * @param {type} time_decission
     * @param {type} displayed_side
     * @param {type} winner_side
     * @param {type} selected_side
     * @param {type} cards_number
     * @param {type} cards_array
     * @returns {undefined}
     */
    sendDataToServer: function (time_memory, time_decission, displayed_side, winner_side, selected_side, cards_number, cards_array) {
        games.debug && console.log("Time memory: " + time_memory, "Time decission: " + time_decission, "Displayed side: " + displayed_side, "Winner side: " + winner_side, "Selected: " + selected_side, "Card numbers: " + cards_number)
        $.ajax({
            type: "POST",
            url: "store-data/cards-game",
            data: {
                userId: games.userId,
                time_memory: time_memory,
                time_decission: time_decission,
                selected_side: selected_side,
                displayed_side: displayed_side,
                winner_side: winner_side,
                cards_number: cards_number,
                cards_array: cards_array
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
 * @Variable games.boxesGame: Contenedor de todas las funciones necesarias para el juego de las cajas
 **/
games.boxesGame = {
    /**
     * Función games.boxesGame.init: Inicializa el juego de las cartas
     * @param {int} cardsNumber | Número de cartas a mostrar
     * @returns {undefined} | No devuelve ningún valor
     **/
    init: function (boxesNumber) {
        //Mostrar las instrucciones escondiendo todo lo demás
        var self = this;
        $('#boxes-game').show();
        $('#main-menu').hide();
        $("#boxes-lose-screen").hide();
        $("#boxes-win-screen").hide();
        $("#boxes-instructions-screen").show();
        $("#main-screen-boxes-container").html("");

        //Poner la música y pausar la del menú principal
        $("#main-theme")[0].pause();
        var theme = $("#theme-audio3")[0];
        theme.currentTime = 0;
        theme.play();

        //Restablecer el contenedor de caja
        $("#your-box-container").hide();

        //Inicializar el título
        var boxesContainer = $('#main-screen-boxes-container')
                .append('<img class="boxes-title boxes-title-background" ondragstart="return false;" src="/images/boxes/boxes-top.png">')
                .append('<img class="boxes-title boxes-title-text" ondragstart="return false;" src="/images/boxes/boxes-top-title.png">');

        //Pintar las cajas en el contenedor principal
        for (var i = 0; i < boxesNumber; i++) {
            boxesContainer.append('<img id="box-' + (i + 1) + '" box-number="' + (i + 1) + '" onmouseover="$(\'#boxAudio' + (i + 1) + '\')[0].play();" class="box" onclick="games.boxesGame.chooseBox(' + (i + 1) + ')" ondragstart="return false;" number="' + (i + 1) + '" src="/images/boxes/box'+(i+1)+'.png" style="bottom:36%">' /*+ games.createsoundbite('/audio/blob.ogg', '/audio/blob.mp3', "boxAudio" + (i + 1))*/);

        }

        //Almacenar la caja ganadora, el número de ellas y crear array para guardar las cajas disponibles mostradas
        self.winner_box = (Math.ceil(Math.random() * boxesNumber));
        self.boxesNumber=boxesNumber;
        this.boxesAvailable=[];

        //Centrar las cajas y espaciarlas sobre la mesa
        self.updateBoxes(false);

        games.debug && console.log("Winner:" + self.winner_box);
        games.debug && console.log("Boxes Number: " + boxesNumber);
    },
   /**
     * Función games.boxesGame.startCardsGame: Esconde la página de instrucciones de este juego y almacena el tiempo inicial
     * @returns {undefined} | No devuelve ningún valor
     */
    startBoxesGame: function () {
        this.times=[];
        this.choosenBoxes=[];

        //Rotar el título aleatoriamente
        this.textInterval = games.rotateRandom($(".boxes-title-text"), 20, 10);

        this.start_iteration_time = new Date().getTime();
        $("#boxes-instructions-screen").hide();
    },
   /**
     * Función games.boxesGame.updateBoxes: Atribuye a cada caja un offset para centrarlas sobre la mesa
     * @param {boolean} withAnimation | Si true, no sólo asigna los offsets, si no que también mueve las cajas hasta sus posiciones
     * @returns {undefined} | No devuelve ningún valor
     */
    updateBoxes: function(withAnimation){
        var boxes = $(".box:not(.choosen-box):not(.removing)");
        var boxesNumber=boxes.length;
        
        var availableWidth = 80;
        var leftInc = Math.round(availableWidth * 100 / boxesNumber) / 100;
        var leftOffset = 10;

        if (boxesNumber == 1) {
            leftOffset = 40;
        }if (boxesNumber == 2) {
            leftOffset = 20;
        }else if (boxesNumber == 3) {
            leftOffset = 13;
        }
        
        //Array de las cajas disponibles
        var boxesAvailable="";

        if(withAnimation){
            for (var i = 0; i < boxesNumber; i++) {
                boxesAvailable+=$(boxes[i]).animate({"left": leftOffset + "%"}, 1000, function(){}).attr("number")+",";
                leftOffset += leftInc;
            }
        }else{
            for (var i = 0; i < boxesNumber; i++) {
                boxesAvailable+=$(boxes[i]).css("left", leftOffset + "%").attr("number")+",";
                leftOffset += leftInc;
            }
        }

        this.boxesAvailable[this.boxesAvailable.length]=boxesAvailable.substring(0, boxesAvailable.length-1);  
    },
   /**
     * Función games.boxesGame.chooseBox: EL usuario ha elegido una caja 
     * @param {int} choosen | Número de la caja elegida
     * @returns {undefined} | No devuelve ningún valor
     */
    chooseBox: function (choosen) {
        //Registrar el tiempo tomado en la decisión        
        if(this.animatingBoxes){
            return;
        }
        this.animatingBoxes=true;

        this.times[this.times.length]= new Date().getTime() - this.start_iteration_time;

        console.log("Registrar",this.times);
        var self = this;
        self.choosenBoxes[self.choosenBoxes.length]=choosen;
                
        $(".box").addClass("box-unselectable");                
        //Mostrar el contenedor de caja
        $("#your-box-container").show();
        var previous_choose=$(".choosen-box").removeClass("choosen-box");

        games.debug && console.log("Elegida: " + choosen);

        self.first_choose = choosen;

        //Caja elegida
        var choosen=$("#box-" + choosen)
        .addClass("choosen-box");

        $("#choosen-box-title").hide();

        var boxes_to_remove=$(".box:not(.choosen-box):not(#box-"+self.winner_box+")").addClass("to-be-removed");
        var box_to_delete=(Math.ceil(Math.random() * (boxes_to_remove.length-1)));
        games.debug && console.log("A borrar entre...",boxes_to_remove, "Borrada", box_to_delete);
        $(boxes_to_remove[box_to_delete]).addClass("removing").animate({"height":0, "opacity": 0}, 1000, function(){$(boxes_to_remove[box_to_delete]).remove()});
        boxes_to_remove.removeClass("to-be-removed");

        $(".boxes-title-text").attr("src", "/images/boxes/box-title-change.png");
        self.updateBoxes(true);

        //Mover la elegida al marco de caja elegida
        choosen.animate({"left": "80%", "bottom": "8%"}, 1000, function(){});
        
        if(previous_choose.attr("id") == choosen.attr("id")){
            //Si la caja elegida es la misma, no hacer nada
        } else if(previous_choose){
            previous_choose.animate({"bottom": "36%"}, 1000, function(){});
        } 

        setTimeout(function () {
            var now_boxes=$(".box:not(.removing)").removeClass("box-unselectable"); 
            console.log("quedan",now_boxes.length);
            if(now_boxes.length==2){
                $(now_boxes[0]).attr("onclick", 'games.boxesGame.finalChoose('+$(now_boxes[0]).attr("box-number")+')');
                $(now_boxes[1]).attr("onclick", 'games.boxesGame.finalChoose('+$(now_boxes[1]).attr("box-number")+')');
            }
            self.animatingBoxes=false;
            self.start_iteration_time = new Date().getTime();
        }, 1000);
    },
    finalChoose: function (choosen) {
        this.times[this.times.length]= new Date().getTime() - this.start_iteration_time;
        this.choosenBoxes[this.choosenBoxes.length]=choosen;
        $(".box").removeAttr("onclick").addClass("box-unselectable");
        var self = this;
        
        $("#theme-audio3")[0].pause();

        //Esconder texto de ayuda
        clearInterval(self.textInterval);
        $(".boxes-title").fadeOut(200);

        games.debug && console.log("Winner " + self.winner_box, "choose" + choosen);
        if (self.winner_box == choosen) {
            $('#box-' + choosen).addClass("final-box").attr("src", "/images/boxes/open-box-win.png");
            $('#winner-sound')[0].play();
        } else {
            $('#box-' + choosen).addClass("final-box").attr("src", "/images/boxes/open-box.png");
            $("#lose-sound")[0].play();
        }
        setTimeout(function () {
            if (self.winner_box == choosen) {
                $('#boxes-win-screen').show();
            } else {
                $('#boxes-lose-screen').show();
            }
            games.debug && console.log("NumBoxes: " + self.boxesNumber, "Winner: " + self.winner_box, "First choose: " + self.first_choose, "Available to change: " + self.box_available_to_change, "final_choose: " + choosen, "time_to_first_choose" + self.ellapsed_time_decission, "time_to_change" + self.ellapsed_time_decission_change);
            self.sendDataToServer(self.boxesNumber, self.winner_box, self.boxesAvailable, self.times, self.choosenBoxes);
        }, 1000);
    },
    sendDataToServer: function (boxes_number, winner_box, boxes_available, times, choosen_boxes) {
        var availableBoxes3=boxes_available[2];
        if(availableBoxes3){
            availableBoxes3="'"+availableBoxes3+"'";
        }else{
            availableBoxes3="NULL";
        }
        var availableBoxes4=boxes_available[3];
        if(availableBoxes4){
            availableBoxes4="'"+availableBoxes4+"'";
        }else{
            availableBoxes4="NULL";
        }
        $.ajax({
            type: "POST",
            url: "store-data/boxes-game",
            data: {
                id_user: games.userId,
                boxes_number: boxes_number,
                winner_box: winner_box,
                first_box_choose: choosen_boxes[0],
                first_available_boxes_to_change: boxes_available[0],
                first_time_choosing: times[0],
                second_box_choose: choosen_boxes[1],
                second_available_boxes_to_change: boxes_available[1],
                second_time_choosing: times[1],
                third_box_choose: choosen_boxes[2] || "NULL",
                third_available_boxes_to_change: availableBoxes3,
                third_time_choosing: times[2] || "NULL",
                fourth_box_choose: choosen_boxes[3] || "NULL",
                fourth_available_boxes_to_change: availableBoxes4,
                fourth_time_choosing: times[3] || "NULL",
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
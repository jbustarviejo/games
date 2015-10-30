//Una vez se haya cargado la página, permitir el login
window.onload = function () {
    //login.checkCookie();
    $(".input-login").removeAttr("disabled");
    $(".login-button:first").css("opacity", "1");
};
/**
 * @Variable login: Contenedor de todas las funciones necesarias para la identificación de usuario en el servidor
 **/
login = {
    //Debug. true para mostrar por consola el debug
    debug: true,
    /**
     * Función login.keypressed: Esperar que se pulse la tecla de enter para hacer login
     * @returns {undefined} | No devuelve ningún valor
     **/
    keypressed: function (e) {
        var keynum;
        if (window.event) { // IE                 
            keynum = e.keyCode;
        } else if (e.which) { // Netscape/Firefox/Opera                  
            keynum = e.which;
        }
        //Si es la 13 (Enter), comenzar
        if (keynum == "13") {
            this.start();
        }
    },
     /**
     * Función games.login.start: Leer los valores del formulario de acceso a los juegos
     * @returns {undefined} | No devuelve ningún valor
     **/
    start: function () {
        $(".input-login").attr("disabled", "disabled");
        $(".login-button:first").css("opacity", "0.5");
        username = $('#login-username').val();
        if (username === "") {
            //Usuario vacío
            alert("Introduce tu ID de usuario");
            $('#login-username').focus();
            $(".input-login").removeAttr("disabled");
            $(".login-button:first").css("opacity", "1");
            return;
        }
        password = $('#login-password').val();
        if (password === "") {
            //Contraseña vacía
            alert("Introduce tu contraseña");
            $('#login-password').focus();
            $(".input-login").removeAttr("disabled");
            $(".login-button:first").css("opacity", "1");
            return;
        }
        //Enviar los datos al servidor para verificarlo
        this.loginOnServer(username, password);
    },
    /**
     * Función login.loginOnServer: Enviar datos al servidor para el login
     * @param {string} username | Nombre de usuario (id_user)
     * @param {string} password | Contraseña de usuario (password)
     * @returns {undefined} | No devuelve ningún valor
     */
    loginOnServer: function (username, password) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/store-data/login",
            data: {
                username: username,
                password: password
            },
            //En caso de éxito, guardar una cookie con el usuario
            success: function (data) {
                if (data.ok === true) {
                    //Si todo es correcto...
                    login.debug && console.log(data);
                    login.userId=username; 
                    //Actualizar puntos
                    $("#user-pannel").html('<a href="/mis-puntos"><span>Hola '+username+'.</span> <span class="user-points">Tienes '+data.points+' puntos</span> <img src="images/movistar/user-icon.png"></a><a class="unlog-button" title="desconectar" href="/desconectar">X</a>');
                    //Almacenar las cookies
                    expiry = new Date();
                    expiry.setTime(expiry.getTime() + (60 * 60 * 24 * 30 * 6 * 1000));
                    document.cookie = "games-username=" + username + "; expires=" + expiry.toGMTString();
                    document.cookie = "games-st=" + data.token + "; expires=" + expiry.toGMTString();
                    //Si no ha respondido a la encuesta...
                    if(!data.survey){
                        //Esconder diálogo de login
                        $("#login-menu-container>div:first").hide();
                        //Mostrar la encuesta
                        $("#games-survey").show();
                    }else{
                        //Desvanecer diálogo de login
                        $("#login-menu-container").fadeOut(500);
                    }
                }else{
                    //En caso de error desbloquear los inputs y alertar al usuario
                    $(".input-login").removeAttr("disabled");
                    $(".login-button:first").css("opacity", "1");
                    alert("Usuario o contraseña incorrecta");
                }
            },
            //En caso de error alertar
            error: function (data) {
                alert("Parece que hubo un error en el servidor, inténtelo de nuevo en unos minutos");
            }
        });
    },
    /**
    * Función login.saveSurvey: Guardar respuesta de encuesta
    * @returns {undefined} | No devuelve ningún valor
    */
    saveSurvey: function(){        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/store-data/survey-answer",
            data: {
                userId: login.userId,
                answer: $("#games-survey [type=radio]:checked").val()
            },
            success: function (data) {
                //Desvanecer diálogo de login
                $("#login-menu-container").fadeOut(500);
            },
            //En caso de error desvanecer
            error: function (data) {
                //Desvanecer diálogo de login
                $("#login-menu-container").fadeOut(500);
            }
        });
    },

};


    /*
    /**
    * Función games.showSurvey: Mostrar respuesta en la encuesta
    * @returns {undefined} | No devuelve ningún valor
    */
    /*showSurvey: function(checked){
        games.debug && console.log("Stored survey answer", checked);
        //Mostrar la encuesta
        $("#games-survey").show(200);
        //Mostrar la última respuesta insertada si la hubo
        if(checked){
            $("#games-survey [type=radio][value='"+checked+"']").prop('checked', 'checked');
        }else{
            $("#games-survey [type=radio]").first().prop('checked', 'checked');
        }

        //En caso de elegir una nueva respuesta, registrarla
        $("#games-survey [type=radio]").click(function(){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/store-data/survey-answer",
                data: {
                    userId: games.userId,
                    answer: $("#games-survey [type=radio]:checked").val()
                },
                success: function (data) {
                    //No hacer nada...
                },
                //En caso de error alertar
                error: function (data) {
                    //No hacer nada...
                }
            });
        });
    }
    <div id="games-survey" style="display:none;">
    <h2>Encuesta: ¿Cómo sueles jugar a videojuegos?</h2>
    <form>
        <input type="radio" name="survey" value="No juego habitualmente" />No juego habitualmente<br/>
        <input type="radio" name="survey" value="Juego a videojuegos de ordenador" />Juego a videojuegos de ordenador<br/>
        <input type="radio" name="survey" value="Juego a videojuegos online" />Juego a videojuegos online<br/>
        <input type="radio" name="survey" value="Juego a videoconsolas" />Juego a videoconsolas<br/>
    </form>
</div>
*/
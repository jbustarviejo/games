//Una vez se haya cargado la página, permitir el login
window.onload = function () {
    //login.checkCookie();
    $(".input-login").removeAttr("disabled");
    $(".login-button").css("opacity", "1");
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
     * Función login.keypressed2: Esperar que se pulse la tecla de enter para hacer login
     * @returns {undefined} | No devuelve ningún valor
     **/
    keypressed2: function (e) {
        var keynum;
        if (window.event) { // IE                 
            keynum = e.keyCode;
        } else if (e.which) { // Netscape/Firefox/Opera                  
            keynum = e.which;
        }
        //Si es la 13 (Enter), comenzar
        if (keynum == "13") {
            this.startRegister();
        }
    },
     /**
     * Función login.start: Leer los valores del formulario de acceso a los juegos
     * @returns {undefined} | No devuelve ningún valor
     **/
    start: function () {
        $(".input-login").attr("disabled", "disabled");
        $(".login-button").css("opacity", "0.5");
        username = $('#login-username').val();
        if (username === "") {
            //Usuario vacío
            alert("Introduce tu ID de usuario");
            $('#login-username').focus();
            $(".input-login").removeAttr("disabled");
            $(".login-button").css("opacity", "1");
            return;
        }
        password = $('#login-password').val();
        if (password === "") {
            //Contraseña vacía
            alert("Introduce tu contraseña");
            $('#login-password').focus();
            $(".input-login").removeAttr("disabled");
            $(".login-button").css("opacity", "1");
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
                    $("#user-pannel").html('<a href="/mis-puntos"><span>Hola '+username+'.</span> <span class="user-points">Tienes '+data.points+' Movipuntos</span> <img src="images/movistar/user-icon.png"></a><a class="unlog-button" title="desconectar" href="/desconectar">X</a>');
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
                    $(".login-button").css("opacity", "1");
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
                answer: $("#games-survey [type=radio]:checked").val(),
                text_answer: $("#games-survey #survey-textarea").val(),
            },
            success: function (data) {
                //Mostrar cuestionario de objetivo
                login.displayGoalDialog();
            },
            //En caso de error desvanecer
            error: function (data) {
                //Desvanecer diálogo de login
                $("#login-menu-container").fadeOut(500);
            }
        });
    },
    /**
    * Función login.displayGoalDialog: Mostrar pregunta de objetivo
    * @returns {undefined} | No devuelve ningún valor
    */
    displayGoalDialog: function(){ 
        //Mostrar contenedor de diálogo
        $("#login-menu-container").show().find("div:first").css("height", "350px");;
        //Esconder diálogo de login y encuestas
        $("#login-menu-container>div:first").hide();
        $("#login-menu-container #games-survey").hide();
        //Mostrar la encuesta
        $("#games-goal").show();    
        //Hacer cronómetro de tiempo
        login.start_decission = new Date().getTime();
        //Atender a cambios de selección
        $("#select-goal").change(function(){
            //Esconder todas las descripciones
            $(".buy").hide();
            //Mostrar la descripción del item 
            $(".buy-"+$(this).val()).show()
            //Cambiar alto de pantalla
            $("#games-goal").css("height", $(".buy-"+$(this).val()).attr("height")+"px");
        });
    },
    /**
    * Función login.saveGoal: Guardar respuesta de objetivo
    * @returns {undefined} | No devuelve ningún valor
    */
    saveGoal: function(){        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/store-data/goal-answer",
            data: {
                userId: login.userId,
                answer: $("#select-goal").val(),
                time: new Date().getTime() - login.start_decission
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
    /**
     * Función login.initRegister: mostrar formulario de registro
     * @returns {undefined} | No devuelve ningún valor
     **/
    initRegister: function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("#create-account-form").show();
        $("#login-form").hide();
        $("#display-register-error").hide();
    },
    /**
     * Función login.initLogin: mostrar formulario de login
     * @returns {undefined} | No devuelve ningún valor
     **/
    initLogin: function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("#create-account-form").hide();
        $("#login-form").show();
    },
    /**
     * Función login.startRrgister: Leer los valores del formulario de registro y comprobar su validez
     * @returns {undefined} | No devuelve ningún valor
     **/
    startRegister: function () {
        $("#display-register-error").hide();
        $(".input-login").attr("disabled", "disabled");
        $(".login-button").css("opacity", "0.5");
        username = $('#create-username').val();
        if (username === "") {
            //Usuario vacío
            $("#display-register-error").show().text("Introduce un nombre de usuario");
            $('#create-username').focus();
            $(".input-login").removeAttr("disabled");
            $(".login-button").css("opacity", "1");
            return;
        }
        if(username.length<3){
            //Poca longitud
            $("#display-register-error").show().text("El nombre de usuario debe ser de al menos 3 caracteres");
            $('#create-username').focus();
            $(".input-login").removeAttr("disabled");
            $(".login-button").css("opacity", "1");
            return;
        }
        if(this.validarCaracteres(username)){
            //Caraceres inválidos
            $("#display-register-error").show().text("El nombre de usuario sólo puede tener caracteres alfanúmericos, '_' y '-'");
            $('#create-username').focus();
            $(".input-login").removeAttr("disabled");
            $(".login-button").css("opacity", "1");
            return;
        }
        password = $('#create-password').val();
        if (password === "") {
            //Contraseña vacía
            $("#display-register-error").show().text("Introduce una contraseña");
            $('#create-password').focus();
            $(".input-login").removeAttr("disabled");
            $(".login-button").css("opacity", "1");
            return;
        }
        if(password.length<3){
            //Poca longitud
            $("#display-register-error").show().text("La contraseña debe ser de al menos 3 caracteres");
            $('#create-password').focus();
            $(".input-login").removeAttr("disabled");
            $(".login-button").css("opacity", "1");
            return;
        }
        if(this.validarCaracteres(password)){
            //Caraceres inválidos
            $("#display-register-error").show().text("La contraseña sólo puede tener caracteres alfanúmericos, '_' y '-'");
            $('#create-password').focus();
            $(".input-login").removeAttr("disabled");
            $(".login-button").css("opacity", "1");
            return;
        }
        //Enviar los datos al servidor para verificarlo
        this.register(username, password);
    },
    /**
    * Función login.validarCaracteres: Valida que sólo haya caracteres tipo email
    * @returns {boolean} | True si son caracteres válidos
    */
    validarCaracteres: function(string){
        expr = /^([a-zA-Z0-9_\.\-])+$/;
        return !expr.test(string);
    },    
    /**
    * Función login.register: Guardar registro
    * @returns {undefined} | No devuelve ningún valor
    */
    register: function(username, password){        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/store-data/register",
            data: {
                username: username,
                password: password
            },
            success: function (data) {
                if(data.ok){
                    //Si todo es correcto...
                    $(".login-button").css("opacity", "1");
                    login.debug && console.log(data);
                    login.userId=username; 
                    //Actualizar puntos
                    $("#user-pannel").html('<a href="/mis-puntos"><span>Hola '+username+'.</span> <span class="user-points">Tienes '+data.points+' Movipuntos</span> <img src="images/movistar/user-icon.png"></a><a class="unlog-button" title="desconectar" href="/desconectar">X</a>');
                    //Almacenar las cookies
                    expiry = new Date();
                    expiry.setTime(expiry.getTime() + (60 * 60 * 24 * 30 * 6 * 1000));
                    document.cookie = "games-username=" + username + "; expires=" + expiry.toGMTString();
                    document.cookie = "games-st=" + data.token + "; expires=" + expiry.toGMTString();
                    //Si no ha respondido a la encuesta...
                    if(!data.survey){
                        //Esconder diálogo de registro
                        $("#login-menu-container #create-account-form").hide();
                        //Mostrar la encuesta
                        $("#games-survey").show();
                    }else{
                        //Desvanecer diálogo de login
                        $("#login-menu-container").fadeOut(500);
                    }
                }else{
                    //Mostrar error
                    if(data.msg){
                        $("#display-register-error").show().text(data.msg);
                    }else{
                        $("#display-register-error").show().text("Ha habido un error, inténtalo más tarde");
                    }
                    $(".input-login").removeAttr("disabled");
                    $(".login-button").css("opacity", "1");
                }
            },
            //En caso de error
            error: function (data) {
                $("#display-register-error").show().text("Ha habido un error, inténtalo más tarde");
                $(".input-login").removeAttr("disabled");
                $(".login-button").css("opacity", "1");
            }
        });
    }
};
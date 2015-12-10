/**
 * @Variable shop: Contenedor de todas las funciones necesarias para la tienda
 **/
var shop={
    //Debug. true para mostrar por consola el debug
	debug: true,
	 /**
     * Función shop.initShop: Iniciar el contenedor de la tienda
     * @param {string} userName | Id de usuario
     * @param {string} userToken | Token de seguridad de usuario
     * @param {boolean} firtsLogin | True si el usuario aún no ha fijado su primera meta (primer login)
     * @returns {undefined} | No devuelve ningún valor
     **/
	initShop: function(userName, userToken, firstLogin){
		shop.userName=userName;
		shop.userToken=userToken;
        shop.firstLogin=firstLogin;
		shop.debug && console.log("init");
        shop.start_decission = new Date().getTime();
		$("div.sale-container").click(function(){
			$(".sale-container.clicked").removeClass("clicked");
			$(this).addClass("clicked");
		});
		$(".sale-container .cancel").click(function(e){
			e.preventDefault();
			e.stopPropagation();
			$(this).parents(".sale-container ").removeClass("clicked");
		});
		$(".sale-container .buy").click(function(){
			shop.debug && console.log($(this).attr("id"));
			//Bloquear los botones durante la compra
			$(this).parents(".sale-container").find("button").addClass("disabled");
			shop.buyItem($(this).attr("id"));
		});
	},
	/**
     * Función shop.buyItem: Comprar item en la tienda
     * @param {string} itemID | Id de item
     * @returns {undefined} | No devuelve ningún valor
     **/
	buyItem: function(itemId){
		//Enviar solitud al servidor
		$.ajax({
            type: "POST",
            dataType: "json",
            url: "/store-data/buy-item",
            data: {
                userId: shop.userName,
                userToken: shop.userToken,
                itemId: itemId,
                time: new Date().getTime() - shop.start_decission
            },
            //En caso de éxito, guardar una cookie con el usuario
            success: function (data) {
                //Reset del cronómetro de tiempos
                shop.start_decission = new Date().getTime();
                if (data.ok === true) {
                    //Si todo es correcto...
                    var container = $("#"+itemId).parents(".sale-container");
                    //Esconder descripción
                    var description = container.find(".item-description").hide();
                    //Mostrar diálogo de adquisición
                    var itemPurchased = container.find(".item-purchased").show();
                    //Actualizar contador de puntos
                    $(".user-points").show().text("Tienes " + data.points + " Movipuntos");
                    //Al hacer click en cerrar, resetear HTML
                    container.find(".item-purchased button").click(function(e){
                        //Evitar otros eventos
                        e.preventDefault();
                        e.stopPropagation();
                        //Reset de HTML
                        itemPurchased.hide();
                        description.show();
                        container.attr("class","sale-container purchased");
                        return;
                    });
                }else if(data.notEnoughtPoints){
                	//No tiene suficientes puntos
                	alert("No tienes suficientes puntos para poder comprar esta oferta ¡ve a jugar y consigue más!");
            	}else{
                    //En caso de error alertar al usuario
                    alert("Usuario o contraseña incorrecta");
                }
                //Desbloquear los botones de la compra
                $("#"+itemId).parents(".sale-container").find("button").removeClass("disabled");
            },
            //En caso de error alertar
            error: function (data) {
                //Reset del cronómetro de tiempos
                shop.start_decission = new Date().getTime();
            	//Desbloquear los botones de la compra
            	$("#"+itemId).parents(".sale-container").find("button").removeClass("disabled");
                alert("Parece que hubo un error en el servidor, inténtelo de nuevo en unos minutos");
            }
        });
	},
    /**
    * Función login.saveGoal: Guardar respuesta de objetivo
    * @param {string} goal | Meta a guardar
    * @returns {undefined} | No devuelve ningún valor
    */
    saveGoal: function(goal){    
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/store-data/goal-answer",
            data: {
                userId: login.userId,
                answer: goal,
                time: new Date().getTime() - shop.start_decission
            },
            success: function (data) {
                //Reset del cronómetro de tiempos
                shop.start_decission = new Date().getTime();
                if(shop.firstLogin==true){ //Si es la primera vez que se fija el objetivo
                    //Desvanecer diálogo 
                    $(".sale-container.clicked .item-first-goal").show();
                }else{
                    //Desvanecer diálogo 
                    $(".sale-container.clicked").removeClass("clicked");
                }
                shop.showGoal(goal);
            },
            //En caso de error desvanecer
            error: function (data) {
                //Reset del cronómetro de tiempos
                shop.start_decission = new Date().getTime();
                //Desvanecer diálogo
                $(".sale-container.clicked").removeClass("clicked");
            }
        });
    },
    /**
     * Función shop.buyItem: Comprar item en la tienda
     * @param {string} itemID | Id de item
     * @returns {undefined} | No devuelve ningún valor
     **/
    showGoal: function(itemId){
        $(".box-left.goal").removeClass("goal");
        $("#buy-"+itemId).parents(".sale-container").find(".box-left").addClass("goal");
    },
    /**
    * Función login.returnItem: Devolver artículo en plazo
    * @param {string} itemID | Id de item
    * @returns {undefined} | No devuelve ningún valor
    */
    returnItem: function(itemId){ 
        //Diálogo de confirmación 
        if (confirm("¿Estás seguro de querer devolver el artículo " + $("#buy-"+itemId).siblings("h1").text() + "?")) {
            //Bloquear botones
            $("#buy-"+itemId).addClass("disabled").siblings("button").addClass("disabled");
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/store-data/return-item",
                data: {
                    userId: shop.userName,
                    userToken: shop.userToken,
                    itemId: itemId
                },
                success: function (data) {
                    //Reset del cronómetro de tiempos
                    shop.start_decission = new Date().getTime();
                    //Desbloquear botones
                    $("#buy-"+itemId).removeClass("disabled").siblings("button").removeClass("disabled");
                    console.log(data);
                    if(data.ok){
                        //Si todo es correcto...
                        var container = $("#buy-"+itemId).parents(".sale-container");
                        //Esconder descripción
                        container.find(".item-description").hide();
                        //Mostrar diálogo de devolución
                        container.find(".item-returned").show();
                    }else{
                        //En caso de error alertar
                        alert("No se ha podido devolver el artículo");
                    }
                },
                //En caso de error alertar
                error: function (data) {
                    //Reset del cronómetro de tiempos
                    shop.start_decission = new Date().getTime();
                    //Desbloquear botones
                    $("#buy-"+itemId).removeClass("disabled").siblings("button").removeClass("disabled");
                    alert("No se ha podido devolver el artículo");
                }
            });
        }    
    },
};
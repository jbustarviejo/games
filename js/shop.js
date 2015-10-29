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
     * @returns {undefined} | No devuelve ningún valor
     **/
	initShop: function(userName, userToken){
		shop.userName=userName;
		shop.userToken=userToken;
		shop.debug && console.log("init");
		$(".sale-container").click(function(){
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
                itemId: itemId
            },
            //En caso de éxito, guardar una cookie con el usuario
            success: function (data) {
                if (data.ok === true) {
                    //Si todo es correcto...
                    alert("Producto adquirido");
                    //Actualizar contador de puntos
                    $(".user-points").show().text("Tienes " + data.points + " Movipuntos");
                    //Esconder diálogo 
                    $("#"+itemId).parents(".sale-container").removeClass("clicked");
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
            	//Desbloquear los botones de la compra
            	$("#"+itemId).parents(".sale-container").find("button").removeClass("disabled");
                alert("Parece que hubo un error en el servidor, inténtelo de nuevo en unos minutos");
            }
        });
	}
};
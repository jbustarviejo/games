//Una vez se haya cargado la página, inicar la tienda
window.onload = function () {
    shop.initShop();
};
/**
 * @Variable shop: Contenedor de todas las funciones necesarias para la tienda
 **/
var shop={
	 /**
     * Función games.initShop: Iniciar el contenedor de la tienda
     * @returns {undefined} | No devuelve ningún valor
     **/
	initShop: function(){
		console.log("init");
		$(".sale-container").click(function(){
			$(".sale-container.clicked").removeClass("clicked");
			$(this).addClass("clicked");
		});
		$(".sale-container .cancel").click(function(e){
			e.preventDefault();
			e.stopPropagation();
			$(this).parents(".sale-container ").removeClass("clicked");
		});
	},
};
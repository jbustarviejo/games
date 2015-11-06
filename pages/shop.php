<h1 class="fake-title">Tienda de Movipuntos</h1>
<!--Contentedor principal-->    
<div id="points-container">
	<div class="sales-container-container">
	<small>* Las Moviofertas son ofertas ficticias, mostradas en esta página con finalidades de investigación. Igualmente, los Movipuntos no representan ningún tipo de cambio real.</small>
		<h2>Ofertas básicas</h2>
		<div class="sale-container">
			<div class="box-left">
				<p>Línea Movimovil: 30Mpts</p>
				<img src="/images/movistar/Movil.png"/>
			</div>
			<div class="shop-item-container">
	            <div class="item-description" style="height: 200px;">
	            	<p class="purchased-title">¡Ya adquirido!</p>
	                <h1>Línea Movimovil: 30 Movipuntos</h1>
	                <p>200 min.a fijos y móviles nacionales</p>
    				<p>1,5 GB</p>
    				<button class="cancel">Cancelar</button>
    				<button class="buy" id="buy-1">Comprar</button>
    				<button class="goal" onclick="shop.saveGoal(1)">Fijar como objetivo</button>
	            </div>
	            <div class="item-purchased">
					<h1>Producto adquirido</h1>
					<p>Acabas de comprar este producto, pero puedes seguir jugando para comprar más</p>
			    	<button>Cerrar</button>
				</div>
	        </div>
		</div>
		<div class="sale-container">
			<div class="box-left">
				<p>Movinternet fijo: 30Mpts</p>
				<img src="/images/movistar/Internet.png"/>
			</div>
			<div class="shop-item-container">
	            <div class="item-description" style="height: 270px;">
	            	<p class="purchased-title">¡Ya adquirido!</p>
	                <h1>Movinternet fijo: 30 Movipuntos</h1>
	                <p>Asistencia técnica</p>
					<p>Fibra Óptica 30Mb simétrica (sujeto a cobertura)</p>
					<p>Alta e instalación incluida</p>
					<p>Router Wi-Fi gratis</p>
    				<button class="cancel">Cancelar</button>
    				<button class="buy" id="buy-2">Comprar</button>
    				<button class="goal" onclick="shop.saveGoal(2)">Fijar como objetivo</button>
	            </div>
	            <div class="item-purchased">
					<h1>Producto adquirido</h1>
					<p>Acabas de comprar este producto, pero puedes seguir jugando para comprar más</p>
			    	<button>Cerrar</button>
				</div>
	        </div>
		</div>
		<h2>Ofertas de cloud</h2>

		<div class="sale-container">
			<div class="box-left">
				<p>MoviNubico y Movinternet: 35Mpts</p>
				<img src="/images/movistar/nubico.png" style="margin: 25px auto;"/>
			</div>
			<div class="shop-item-container">
	            <div class="item-description">
	            	<p class="purchased-title">¡Ya adquirido! <span class="return-item" onclick="shop.returnItem(3)">- Devolver</span></p>
	                <h1>MoviNubico y Movinternet: 35 Movipuntos</h1>
	                <p>Sin compromiso</p>
					<p>Internet 30Mb</p>
	    			<p>Acceso Cloud a todas las revistas y libros de forma ilimitada</p>
	    			<p>5 lectores simultáneos</p>
	    			<p>Garantía de devolución 20 días</p>
    				<button class="cancel">Cancelar</button>
    				<button class="buy" id="buy-3">Comprar</button>
    				<button class="goal" onclick="shop.saveGoal(3)">Fijar como objetivo</button>
	            </div>
	            <div class="item-purchased">
					<h1>Producto adquirido</h1>
					<p>Acabas de comprar este producto, pero puedes seguir jugando para comprar más</p>
			    	<button>Cerrar</button>
				</div>
				<div class="item-returned" style="display:none;height: 175px;">
					<h1>Producto devuelto</h1>
					<p>Acabas de devolver este producto. Haz click en cerrar para recargar la página</p>
			    	<button onclick="$(this).addClass('disabled'); location.reload();">Cerrar</button>
				</div>
	        </div>
		</div>
		<div class="sale-container">
			<div class="box-left">
				<p>Movimovil y Movisure: 35Mpts</p>
				<img src="/images/movistar/verisure.png" style="max-width: 80%; margin:25px auto;"/>
			</div>
			<div class="shop-item-container">
	            <div class="item-description" style="height: 190px;">
	            	<p class="purchased-title">¡Ya adquirido!</p>
	                <h1>Movimovil y Movisure: 35 Movipuntos</h1>
	                <p>Línea Móvil 4G</p>
					<p>Control de vigilancia en la nube de tu hogar</p>
    				<button class="cancel">Cancelar</button>
    				<button class="buy" id="buy-4">Comprar</button>
    				<button class="goal" onclick="shop.saveGoal(4)">Fijar como objetivo</button>
	            </div>
	            <div class="item-purchased">
					<h1>Producto adquirido</h1>
					<p>Acabas de comprar este producto, pero puedes seguir jugando para comprar más</p>
			    	<button>Cerrar</button>
				</div>
	        </div>
		</div>
		<h2>Ofertas de Movifusión</h2>
		<div class="sale-container">
			<div class="box-left">
				<p>Movifusión 1: 40Mpts</p>
				<img src="/images/movistar/fusion.png"/>
			</div>
			<div class="shop-item-container">
	            <div class="item-description" style="height: 265px;">
	            	<p class="purchased-title">¡Ya adquirido! <span class="return-item" onclick="shop.returnItem(5)">- Devolver</span></p>
	                <h1>Movifusión 1: 40 Movipuntos</h1>
	                <p>Internet 30Mb</p>
					<p>Línea fija</p>
					<p>Nubico</p>
	    			<p>Garantía de devolución 20 días</p>
    				<button class="cancel">Cancelar</button>
    				<button class="buy" id="buy-5">Comprar</button>
    				<button class="goal" onclick="shop.saveGoal(5)">Fijar como objetivo</button>
	            </div>
	            <div class="item-purchased">
					<h1>Producto adquirido</h1>
					<p>Acabas de comprar este producto, pero puedes seguir jugando para comprar más</p>
			    	<button>Cerrar</button>
				</div>
				<div class="item-returned" style="display:none;height: 175px;">
					<h1>Producto devuelto</h1>
					<p>Acabas de devolver este producto. Haz click en cerrar para recargar la página</p>
			    	<button onclick="$(this).addClass('disabled'); location.reload();">Cerrar</button>
				</div>
	        </div>
		</div>
		<div class="sale-container">
			<div class="box-left">
				<p>Movifusión 2: 40Mpts</p>
				<img src="/images/movistar/fusion.png"/>
			</div>
			<div class="shop-item-container">
	            <div class="item-description" style="height: 230px;">
	            	<p class="purchased-title">¡Ya adquirido!</p>
	                <h1>Movifusión 2: 40 Movipuntos</h1>
	                <p>Internet 30Mb</p>
					<p>Línea Móvil 4G</p>
					<p>Verisure</p>
    				<button class="cancel">Cancelar</button>
    				<button class="buy" id="buy-6">Comprar</button>
    				<button class="goal" onclick="shop.saveGoal(6)">Fijar como objetivo</button>
	            </div>
	            <div class="item-purchased">
					<h1>Producto adquirido</h1>
					<p>Acabas de comprar este producto, pero puedes seguir jugando para comprar más</p>
			    	<button>Cerrar</button>
				</div>
	        </div>
		</div>
	</div>
</div>
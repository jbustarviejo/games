<h1 class="fake-title">Tienda de Movipuntos</h1>
<!--Contentedor principal-->    
<div id="points-container">
	<div class="sales-container-container">
	<small>* Las Moviofertas son ofertas ficticias, mostradas en esta página con finalidades de investigación. Igualmente, los Movipuntos no representan ningún tipo de cambio real.</small>
		<h2>Ofertas básicas</h2>
		<div class="sale-container">
			<div class="box-left">
				<p>Línea Móvil: 30Mpts</p>
				<img src="/images/movistar/Movil.png"/>
			</div>
			<div class="shop-item-container">
	            <div class="item-description" style="height: 200px;">
	            	<div class="description-container">
		            	<p class="purchased-title">¡Ya adquirido!</p>
		                <h1>Línea Móvil: 30 Movipuntos</h1>
		                <p>200 min.a fijos y móviles nacionales</p>
	    				<p>1,5 GB</p>
	    				<button class="cancel">Cancelar</button>
	    				<button class="buy" id="buy-1">Comprar</button>
	    				<button class="goal" onclick="shop.saveGoal(1)">Fijar como objetivo</button>
    				</div>
	            </div>
	            <div class="item-purchased">
					<h1>Producto adquirido</h1>
					<p>Acabas de comprar este producto, pero puedes seguir jugando para comprar más</p>
			    	<button>Cerrar</button>
				</div>
				<div class="item-first-goal">
					<h1>¡Has fijado tu objetivo!</h1>
					<p>Ahora, vayamos a jugar</p>
					<p>Puedes elegir cualquiera de los tres juegos y después cambiar</p>
			    	<a href="/juegos"><button>¡A jugar!</button></a>
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
		            <div class="description-container">
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
	            </div>
	            <div class="item-purchased">
					<h1>Producto adquirido</h1>
					<p>Acabas de comprar este producto, pero puedes seguir jugando para comprar más</p>
			    	<button>Cerrar</button>
				</div>
				<div class="item-first-goal">
					<h1>¡Has fijado tu objetivo!</h1>
					<p>Ahora, vayamos a jugar</p>
					<p>Puedes elegir cualquiera de los tres juegos y después cambiar</p>
			    	<a href="/juegos"><button>¡A jugar!</button></a>
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
	            <div class="item-description" style="height: 315px;">
	            	<div class="description-container">
		            	<p class="purchased-title">¡Ya adquirido! <span class="return-item" onclick="shop.returnItem(3)">- Devolver</span></p>
		                <h1>MoviNubico y Movinternet: 35 Movipuntos</h1>
		                <p>Sin compromiso</p>
						<p>Internet 30Mb</p>
		    			<p>Acceso Cloud a todas las revistas y libros de forma ilimitada</p>
		    			<p>5 lectores simultáneos</p>
		    			<p><b>Garantía de devolución 20 días</b></p>
	    				<button class="cancel">Cancelar</button>
	    				<button class="buy" id="buy-3">Comprar</button>
	    				<button class="goal" onclick="shop.saveGoal(3)">Fijar como objetivo</button>
	    			</div>
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
				<div class="item-first-goal">
					<h1>¡Has fijado tu objetivo!</h1>
					<p>Ahora, vayamos a jugar</p>
					<p>Puedes elegir cualquiera de los tres juegos y después cambiar</p>
			    	<a href="/juegos"><button>¡A jugar!</button></a>
				</div>
	        </div>
		</div>
		<div class="sale-container">
			<div class="box-left">
				<p>Móvil y Movisure: 35Mpts</p>
				<img src="/images/movistar/verisure.png" style="max-width: 80%; margin:25px auto;"/>
			</div>
			<div class="shop-item-container">
	            <div class="item-description" style="height: 190px;">
		           	<div class="description-container">
		            	<p class="purchased-title">¡Ya adquirido!</p>
		                <h1>Móvil y Movisure: 35 Movipuntos</h1>
		                <p>Línea Móvil 4G</p>
						<p>Control de vigilancia en la nube de tu hogar</p>
	    				<button class="cancel">Cancelar</button>
	    				<button class="buy" id="buy-4">Comprar</button>
	    				<button class="goal" onclick="shop.saveGoal(4)">Fijar como objetivo</button>
	            	</div>
	            </div>
	            <div class="item-purchased">
					<h1>Producto adquirido</h1>
					<p>Acabas de comprar este producto, pero puedes seguir jugando para comprar más</p>
			    	<button>Cerrar</button>
				</div>
				<div class="item-first-goal">
					<h1>¡Has fijado tu objetivo!</h1>
					<p>Ahora, vayamos a jugar</p>
					<p>Puedes elegir cualquiera de los tres juegos y después cambiar</p>
			    	<a href="/juegos"><button>¡A jugar!</button></a>
				</div>
	        </div>
		</div>
		<h2>Ofertas de Movifusión</h2>
		<div class="sale-container">
			<div class="box-left">
				<p>Movifusión Nubico: 40Mpts</p>
				<img src="/images/movistar/fusion.png"/>
			</div>
			<div class="shop-item-container">
	            <div class="item-description" style="height: 265px;">
	            	<div class="description-container">
		            	<p class="purchased-title">¡Ya adquirido! <span class="return-item" onclick="shop.returnItem(5)">- Devolver</span></p>
		                <h1>Movifusión Nubico: 40 Movipuntos</h1>
		                <p>Internet 30Mb</p>
						<p>Línea fija</p>
						<p>Movinubico</p>
		    			<p><b>Garantía de devolución 20 días</b></p>
	    				<button class="cancel">Cancelar</button>
	    				<button class="buy" id="buy-5">Comprar</button>
	    				<button class="goal" onclick="shop.saveGoal(5)">Fijar como objetivo</button>
	    			</div>
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
				<div class="item-first-goal">
					<h1>¡Has fijado tu objetivo!</h1>
					<p>Ahora, vayamos a jugar</p>
					<p>Puedes elegir cualquiera de los tres juegos y después cambiar</p>
			    	<a href="/juegos"><button>¡A jugar!</button></a>
				</div>
	        </div>
		</div>
		<div class="sale-container">
			<div class="box-left">
				<p>Movifusión Verisure: 40Mpts</p>
				<img src="/images/movistar/fusion.png"/>
			</div>
			<div class="shop-item-container">
	            <div class="item-description" style="height: 230px;">
	            	<div class="description-container">
		            	<p class="purchased-title">¡Ya adquirido!</p>
		                <h1>Movifusión Verisure: 40 Movipuntos</h1>
		                <p>Internet 30Mb</p>
						<p>Línea Móvil 4G</p>
						<p>Movisure</p>
	    				<button class="cancel">Cancelar</button>
	    				<button class="buy" id="buy-6">Comprar</button>
	    				<button class="goal" onclick="shop.saveGoal(6)">Fijar como objetivo</button>
	    			</div>
	            </div>
	            <div class="item-purchased">
					<h1>Producto adquirido</h1>
					<p>Acabas de comprar este producto, pero puedes seguir jugando para comprar más</p>
			    	<button>Cerrar</button>
				</div>
				<div class="item-first-goal">
					<h1>¡Has fijado tu objetivo!</h1>
					<p>Ahora, vayamos a jugar</p>
					<p>Puedes elegir cualquiera de los tres juegos y después cambiar</p>
			    	<a href="/juegos"><button>¡A jugar!</button></a>
				</div>
	        </div>
		</div>
	</div>
</div>
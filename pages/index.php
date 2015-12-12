<!--Página de inicio de los juegos-->
<div id="index-container">
	<h1>Bienvenid@ a la página del Movijuego</h1>

	<p>Juega y consigue Movipuntos para poder cambiarlos por Moviofertas en la <a href="tienda">tienda<a> ¡Ese es el objetivo principal!</p>
	<p>Tienes para ello <b>tres minijuegos</b> con diferentes tipos de complejidad, cada uno de ellos con distintas recompensas al ganar. Ganando a juegos más complejos lograrás mejores puntuaciones. Cuantos más Movipuntos tengas, ¡mejores Moviofertas conseguirás!</p>
      <p>Pero no todo es tan fácil, administra bien tus puntos porque participar <b>tiene un coste de puntos</b> que varía según el juego. Eso puede hacer que llegues a la situación de que no puedas permitirte los juegos caros por no tener suficientes Movipuntos, en ese caso, tendrás que jugar con otros de menor coste hasta remontar un poco.
      De todas formas no son todo disgustos, <b>si te quedas sin puntos te regalaremos ocho Movipuntos</b> para que puedas seguir jugando.</p>

	No esperes más y <a href="/juegos">¡Juega ya!</a><br/><br/>
	<small>* Las Moviofertas son ofertas ficticias, mostradas en esta página con finalidades de investigación. Igualmente, los Movipuntos no representan ningún tipo de cambio real.</small><br/><br/>
      <small><i>La resolución óptima de la página es para dispositivos con una resolución mayor a los 1000px de ancho. Al utilizar elementos de HTML5 se recomienda un navegador lo más actualizado posible, por ejemplo Mozzilla Firefox 42.0</i></small>
	<img class="main-description-image" ondragstart="return false;" src="/images/general/main-description-image.jpg">

	<!--Recursos a pre-cargar-->
    <div id="resources-to-load">
        <!--Audio-->
        <div class="games-audios" style="display: none;">
            <!--Themes-->
            <audio id="main-theme" loop="loop"><source src="/audio/main-theme.ogg" type="audio/ogg"></source><source src="/audio/main-theme.mp3" type="audio/mpeg"></source></audio>
            <audio id="theme-audio1" loop="loop"><source src="/audio/theme1.ogg" type="audio/ogg"></source><source src="/audio/theme1.mp3" type="audio/mpeg"></source></audio>
            <audio id="theme-audio2" loop="loop"><source src="/audio/theme2.ogg" type="audio/ogg"></source><source src="/audio/theme2.mp3" type="audio/mpeg"></source></audio>
            <audio id="theme-audio3" loop="loop"><source src="/audio/theme3.ogg" type="audio/ogg"></source><source src="/audio/theme3.mp3" type="audio/mpeg"></source></audio>
            <!--Genericos / menú-->
            <audio id="blop-sound1"><source src="/audio/blop.ogg" type="audio/ogg"></source><source src="/audio/blop.mp3" type="audio/mpeg"></source></audio>
            <audio id="blop-sound2"><source src="/audio/blop.ogg" type="audio/ogg"></source><source src="/audio/blop.mp3" type="audio/mpeg"></source></audio>
            <audio id="blop-sound3"><source src="/audio/blop.ogg" type="audio/ogg"></source><source src="/audio/blop.mp3" type="audio/mpeg"></source></audio>
            <audio id="lose-sound"><source src="/audio/lose.ogg" type="audio/ogg"></source><source src="/audio/lose.mp3" type="audio/mpeg"></source></audio>
            <audio id="winner-sound"><source src="/audio/winner.ogg" type="audio/ogg"></source><source src="/audio/winner.mp3" type="audio/mpeg"></source></audio>
            <!--Straws game-->
            <audio id="strawAudio1"><source src="/audio/click.ogg" type="audio/ogg"></source><source src="/audio/click.mp3" type="audio/mpeg"></source></audio>
            <audio id="strawAudio2"><source src="/audio/click.ogg" type="audio/ogg"></source><source src="/audio/click.mp3" type="audio/mpeg"></source></audio>
            <audio id="strawAudio3"><source src="/audio/click.ogg" type="audio/ogg"></source><source src="/audio/click.mp3" type="audio/mpeg"></source></audio>
            <audio id="strawAudio4"><source src="/audio/click.ogg" type="audio/ogg"></source><source src="/audio/click.mp3" type="audio/mpeg"></source></audio>
            <audio id="strawAudio5"><source src="/audio/click.ogg" type="audio/ogg"></source><source src="/audio/click.mp3" type="audio/mpeg"></source></audio>
            <audio id="woosh-sound"><source src="/audio/woosh.ogg" type="audio/ogg"></source><source src="/audio/woosh.mp3" type="audio/mpeg"></source></audio>
            <!--Cards game-->
            <audio id="flipCardAudio1"><source src="/audio/card-flip.ogg" type="audio/ogg"></source><source src="/audio/card-flip.mp3" type="audio/mpeg"></source></audio>
            <audio id="flipCardAudio2"><source src="/audio/card-flip.ogg" type="audio/ogg"></source><source src="/audio/card-flip.mp3" type="audio/mpeg"></source></audio>
            <audio id="flipCardAudio3"><source src="/audio/card-flip.ogg" type="audio/ogg"></source><source src="/audio/card-flip.mp3" type="audio/mpeg"></source></audio>
            <audio id="flipCardAudio4"><source src="/audio/card-flip.ogg" type="audio/ogg"></source><source src="/audio/card-flip.mp3" type="audio/mpeg"></source></audio>
            <audio id="flipCardAudio5"><source src="/audio/card-flip.ogg" type="audio/ogg"></source><source src="/audio/card-flip.mp3" type="audio/mpeg"></source></audio>
            <audio id="move-hat-sound"><source src="/audio/move-hat.ogg" type="audio/ogg"></source><source src="/audio/move-hat.mp3" type="audio/mpeg"></source></audio>
            <audio id="fast-woosh-sound"><source src="/audio/fast-woosh.ogg" type="audio/ogg"></source><source src="/audio/fast-woosh.mp3" type="audio/mpeg"></source></audio>
            <!--Boxes game-->
            <audio id="boxAudio1"><source src="/audio/blob.ogg" type="audio/ogg"></source><source src="/audio/blob.mp3" type="audio/mpeg"></source></audio>
            <audio id="boxAudio2"><source src="/audio/blob.ogg" type="audio/ogg"></source><source src="/audio/blob.mp3" type="audio/mpeg"></source></audio>
            <audio id="boxAudio3"><source src="/audio/blob.ogg" type="audio/ogg"></source><source src="/audio/blob.mp3" type="audio/mpeg"></source></audio>
            <audio id="boxAudio4"><source src="/audio/blob.ogg" type="audio/ogg"></source><source src="/audio/blob.mp3" type="audio/mpeg"></source></audio>
            <audio id="boxAudio5"><source src="/audio/blob.ogg" type="audio/ogg"></source><source src="/audio/blob.mp3" type="audio/mpeg"></source></audio>
        </div>
        <!--Imágenes-->
        <div class="games-images" style="display: none;">
            <!--Genericos /menú-->
            <img src="/images/general/mute.png"/>
            <img src="/images/general/sound.png"/>
            <img src="/images/general/no-internet.png"/>
            <img src="/images/general/loading-title.png"/>
            <img src="/images/general/main-title.png"/>
            <img src="/images/general/first-button.jpg"/>
            <img src="/images/general/second-button.jpg"/>
            <img src="/images/general/third-button.jpg"/>
            <!--Straws game-->
            <img src="/images/largest-straw/helper-arrow.png"/>
            <img src="/images/largest-straw/helper-text.png"/>
            <img src="/images/largest-straw/close-hand-back.png"/>
            <img src="/images/largest-straw/close-hand-front.png"/>
            <img src="/images/largest-straw/open-hand-back.png"/>
            <img src="/images/largest-straw/open-hand-front.png"/>
            <img src="/images/largest-straw/straws-background.jpg"/>
            <img src="/images/largest-straw/straw1.jpg"/>
            <img src="/images/largest-straw/straw2.jpg"/>
            <img src="/images/largest-straw/straw3.jpg"/>
            <img src="/images/largest-straw/straw4.jpg"/>
            <!--Cards game-->
            <img src="/images/cards/black-card-background.jpg"/>
            <img src="/images/cards/red-card-background.jpg"/>
            <img src="/images/cards/black.png"/>
            <img src="/images/cards/red.png"/>
            <img src="/images/cards/cards-background.jpg"/>
            <img src="/images/cards/hat.png"/>
            <img src="/images/cards/title1.png"/>
            <img src="/images/cards/title2.png"/>
            <img src="/images/cards/do-click.jpg"/>
            <img src="/images/cards/done.jpg"/>
            <!--Boxes game-->
            <img src="/images/boxes/box-title-change.png"/>
            <img src="/images/boxes/box1.png"/>
            <img src="/images/boxes/box2.png"/>
            <img src="/images/boxes/box3.png"/>
            <img src="/images/boxes/box4.png"/>
            <img src="/images/boxes/boxes-top-title.png"/>
            <img src="/images/boxes/boxes-top.png"/>
            <img src="/images/boxes/open-box-win1.png"/>
            <img src="/images/boxes/open-box-win2.png"/>
            <img src="/images/boxes/open-box-win3.png"/>
            <img src="/images/boxes/open-box-win4.png"/>
            <img src="/images/boxes/open-box1.png"/>
            <img src="/images/boxes/open-box2.png"/>
            <img src="/images/boxes/open-box3.png"/>
            <img src="/images/boxes/open-box4.png"/>
            <img src="/images/boxes/table.png"/>
            <img src="/images/boxes/yourbox.png"/>
            <img src="/images/boxes/yourboxwhite.png"/>
            <img src="/images/boxes/boxes_background.jpg"/>
        </div>    
    </div>
</div>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="utf-8" /> 
        <title>Games</title>
    </head>

    <body id="body" style="width:100%; height: 100%; margin:0;">

        <div id="gameContainer" style="border-radius:8px;overflow:hidden;z-index:10;margin: 50px auto; position: relative; width: 90%; height: 90%; border: 1px solid #000;">
            <div id="instructions-screen" style="z-index:9;text-align:center;position: absolute; width: 100%; height: 100%; border: 1px solid black; background-color:rgba(0, 50, 69,0.95);">
                <div style="color: #fff; margin-top: 22%;">
                    <h2>La caña más corta</h2>
                    <p>Elige una de las tres cañas escondidas, si resulta ser la más larga, ¡enhorabuena! habrás ganado</p>
                </div>
                <button onclick="document.getElementById('instructions-screen').style.display = 'none'" style="cursor:pointer;border: 0 none;border-radius: 5px;font-size: 20px;height: 50px;width: 150px;">Jugar</button>
            </div>
            <div id="main-scren-game" style="z-index: 8; width: 100%; height: 100%; position: absolute; background-color: rgb(117, 117, 219);">
                <img id="close-hand" src="/images/close-hand.png" style=" display: block;margin: 15% auto auto;width: 30%;">
            </div>
        </div>

        <div>
            <h2>Dudas</h2>
            <ul>
                <li>Sistema de puntos</li>
                <li>Choose a game?</li>
                <li>Servidor?</li>
                <li>Login?</li>
            </ul>
            <h2>Todo</h2>
            <ul>
                <li></li>
                <li></li>
            </ul>
        </div>

        <script type="text/javascript">
            window.onload = function () {

            };

            //Returns Body tag width displayed on window
            function getBodyWidth() {
                return document.getElementById("body").offsetWidth;
            }

            //Function that controls the rigth width and height
            function resized() {
                var size = Math.round(getBodyWidth() * 0.75);
                document.getElementById("gameContainer").style.width = size + "px";
                document.getElementById("gameContainer").style.height = Math.round(size * 0.56) + "px";
            }
            resized();
            
            //Bind on resize
            window.onresize = function () {
                resized();
            };
        </script>
    </body>
</html>
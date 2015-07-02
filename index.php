<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="utf-8" /> 
        <title>Games</title>
    </head>

    <body id="body">
        <div id="gameContainer" class="">
            <div id="instructions-screen">
                <div style="color: #fff; margin-top: 22%;">
                    <h2>La caña más larga</h2>
                    <p>Elige una de las tres cañas escondidas, si resulta ser la más larga, ¡enhorabuena! habrás ganado</p>
                </div>
                <button class="play-button" onclick="sticksGame.playGame();">Jugar</button>
            </div>
            <div id="main-scren-game" style="z-index: 8; width: 100%; height: 100%; position: absolute; background-color: rgb(117, 117, 219);">
                <img id="close-hand" src="/images/larguest-stick/close-hand.png" style="bottom:10%;"/>
                <img class="stick" number="1" src="/images/larguest-stick/stick.png" style="left:43%"/>
                <img class="stick" number="2" src="/images/larguest-stick/stick.png"/>
                <img class="stick" number="3" src="/images/larguest-stick/stick.png"  style="left:57%"/>
            </div>
        </div>

        <div>
            <h2>Dudas</h2>
            <ul>
                <li>Sistema de puntos</li>
                <li>Choose a game?</li>
                <li>Servidor?</li>
                <li>Login?</li>
                <li>Juego de los palos, ¿sólo tiempo a elegir palo?</li>
            </ul>
            <h2>Todo</h2>
            <ul>
                <li></li>
                <li></li>
            </ul>
        </div>

        <script type="text/javascript">
            var sticksGame = {
                playGame: function () {
                    this.start_decission = new Date().getTime();
                    document.getElementById('instructions-screen').style.display = 'none';
                },
                init: function () {
                    var self = this;
                    var sticks = document.getElementsByClassName("stick");
                    self.winner_stick = Math.floor(Math.random() * 3) + 1;
                    for (var i = 0; i < sticks.length; i++) {
                        //Bind sticks onclicks
                        sticks[i].onclick = function () {
                            self.chooseStick(this.getAttribute("number"));
                        };
                    }
                    //Bind on resize
                    window.onresize = function () {
                        self.resized();
                    };
                    self.resized();
                },
                //Returns Body tag width displayed on window
                getBodyWidth: function () {
                    return document.getElementById("body").offsetWidth;
                },
                animateDown: function (obj, to, choosen) {
                    var self = this;
                    var bottomInit = obj.style.bottom;
                    bottomInit = bottomInit.substring(0, bottomInit.length - 1);
                    if (bottomInit <= to) {
                        self.finish(choosen);
                        return;
                    }
                    obj.style.bottom = (bottomInit - 0.5) + "%";
                    setTimeout(function () {
                        self.animateDown(obj, to, choosen);
                    }, 10);
                },
                //When a stick is choose
                chooseStick: function (choosen) {
                    ellapsed_time = new Date().getTime() - this.start_decission;
                    console.log(ellapsed_time);
                    console.log(this.winner_stick, choosen);
                    this.animateDown(document.getElementById("close-hand"), -8, choosen);
                },
                finish: function (choosen) {
                    console.log(this.winner_stick, choosen);
                    if (this.winner_stick.toString() === choosen) {
                        alert("Ganas! " + ellapsed_time);
                    } else {
                        alert("Pierdes! " + ellapsed_time);
                    }
                },
                //Function that controls the rigth width and height
                resized: function () {
                    var size = Math.round(this.getBodyWidth() * 0.75);
                    document.getElementById("gameContainer").style.width = size + "px";
                    document.getElementById("gameContainer").style.height = Math.round(size * 0.56) + "px";
                }
            };
            window.onload = function () {
                sticksGame.init();
            };
        </script>
        <style>
            #body{
                width:100%; height: 100%; margin:0;
            }
            #gameContainer{
                border-radius:8px;overflow:hidden;z-index:10;margin: 50px auto; position: relative; width: 90%; height: 90%; border: 1px solid #000;
            }
            #gameContainer #instructions-screen{
                z-index:9;text-align:center;position: absolute; width: 100%; height: 100%; border: 1px solid black; background-color:rgba(0, 50, 69,0.95);
            }
            #gameContainer button{
                cursor:pointer;border: 0 none;border-radius: 5px;font-size: 20px;height: 50px;width: 150px;
            }
            #gameContainer #close-hand{
                bottom: 10%;
                left: 35%;
                position: absolute;
                width: 30%;
                z-index: 7;
            }
            #gameContainer .stick{
                bottom: 50%;
                left: 50%;
                position: absolute;
                width: 5%;
                z-index: 6;
            }
            #gameContainer .stick:hover{
                width: 6%;
                cursor: pointer;
                opacity: 0.8;
            }
        </style>
    </body>
</html>
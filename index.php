<!DOCTYPE html>
<html>

<head>
    <meta name="description" content="Remake of classic puzzle game Blockout (3d tetris) in HTML 5" />
    <meta name='viewport' content='initial-scale=1.0,user-scalable=0' >
    <title>BlockOut</title>
    <link rel="icon" href="css/blockout.png" type="image/gif" sizes="16x16"> 
    <link type="text/css" rel="stylesheet" href="css/cubeout.css" />
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <script defer type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script defer type="text/javascript" src="js/jquery.cookie.js"></script>
    <script defer type="text/javascript" src="js/cookie.js"></script>
    <script defer type="text/javascript" src="js/cubeout.js"></script>
</head>

<body>
    <center>


        <div id="fps">&nbsp;</div>

        <div id="screenwrap">
			<div id="pst_rlt_cs">
		<canvas id="screen" class="shadow">
                    <div id="dummy">Sorry, you need to check this page in browser that supports HTML5 canvas (like current
                    version of Chrome, Opera, Firefox or Safari).</div>
	        </canvas>
				<div class="game-logo-cs">
                                  <a href="https://www.facebook.com/blockout3dtetris" target="_blank"> <img src="css/logo.png" alt="https://www.facebook.com/blockout3dtetris">
                                  </a>
				</div>
	       <div id="difficulty" class="hud">
                <span id="speed" title="Change game speed">
                    <span id="speed_label_details">
                        <span id="sped_label_label">LEVEL</span>
                        <span id="sped_label_no"></span>
                    </span>

                    <select name="speedSelect" id="speedSelect">
                        <option value='0' class="button on" selected>0</option> 
                        <option value='1' class="button">1</option> 
                        <option value='2' class="button">2</option> 
                        <option value='3' class="button">3</option> 
                        <option value='4' class="button">4</option>
                    </select>
	          </span>

                <span class="speed_label_text">Rotation</span>
                <select name="Rotationspeed" id="rotSpeed" title="Change Rotation speed">
                    <option value="Slow" class="button on" selected>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Slow</option>
                    <option value="Medium" class="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Medium</option>
                    <option value="Fast" class="button" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fast</option>
                </select>
	                
	                <span id="keys" title="Set custom keys">
	                    <span class="button">Settings</span>
                    </span>

                    <div id="cubes_played_label">Cubes Played</div>
                    <div id="cubes_played">&nbsp;</div>
                    
                    <div id="high_score_label">High Score</div>
	                <div id="high_score">&nbsp;</div>

	                <span class="pit_label_text">PIT</span>
	                <select name='pit' id="pit" title="Change pit size">
	                       <option value='3x3x10' class="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3x3x10</option> 
	                       <option value='5x5x10' class="button on" selected>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5x5x10</option> 
	                       <option value='5x5x12' class="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5x5x12</option>
	                </select>
			    
	                <span class="pieces_label_text">BLOCK SET</span>
	                <select id="pieces" title="Change pieces complexity">
                        <option value='Flat' class="button on" selected>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FLAT</option> 
                        <option value='Basic' class="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BASIC</option> 
                        <option value='Extended' class="button">&nbsp;&nbsp;EXTENDED</option>
	                </select>

                    <!-- <span id="pieces" title="Change pieces complexity">
                        <span class="button">Flat Fun</span> 
                        <span class="button">3-D Mania</span> 
                        <span class="button">Out of Control</span>
	                </span> -->
	    </div>
            
		<div id="score_label">Score</div>
	        <div id="score">&nbsp;</div>

            <div id="column"><canvas id="screen2"></canvas></div>

	</div>
            <div id="message" class="hud full">
                <div id="description" class="shadow">
                    <a href="http://en.wikipedia.org/wiki/Blockout"  target="_blank">Blockout (3d Tetris)</a> in HTML5/JavaScript.  <br />
                    <small><br />Works in Firefox, Chrome, Opera and Safari<br />
                        Best performance in Chrome and Opera</small>
                </div>

                <div id="controls">
                    <a href="https://www.youtube.com/watch?v=18BhnHFq_uc" style="color: #009fa0;"  target="_blank">Rotate with Q,W,E,A,S,D</a><br />
                    Move with arrows<br />
                    Drop with space<br />
                    <a href="https://www.youtube.com/watch?v=VVtXTV5iEeM" style="color: #009fa0;"  target="_blank">Swipe on Phone</a><br />
                    Quit ESC<br />
                    Pause P<br />
                    <br />
                    <span class="action"><span style="color: #009fa0;">Press key  "B"  on PC</span> to START <br />
                    or <a href="https://www.youtube.com/watch?v=VVtXTV5iEeM" target="_blank"> "Tap"  above here on your phone</a>, to START.</span>
                </div>

                <a href="#" class="hs" style="color: #009fa0; display:block;">Browser High Scores</a> </br>
                <a href="scoreboard.php" style="display:block;">Global Ranking Scoreboard</a>
            </div>

            <div id="keyset" class="hud full" style='display: none;'>
                <h3>Set custom keys</h3>
                <small>Click on the label and then press key</small>

                <ul>
                    <li><span class="lbl">left</span> <span class="val"></span></li>
                    <li><span class="lbl">right</span> <span class="val"></span></li>
                    <li><span class="lbl">up</span> <span class="val"></span></li>
                    <li><span class="lbl">down</span> <span class="val"></span></li>
                    <li><span class="lbl">rotate X+</span> <span class="val"></span></li>
                    <li><span class="lbl">rotate X-</span> <span class="val"></span></li>
                    <li><span class="lbl">rotate Y+</span> <span class="val"></span></li>
                    <li><span class="lbl">rotate Y-</span> <span class="val"></span></li>
                    <li><span class="lbl">rotate Z+</span> <span class="val"></span></li>
                    <li><span class="lbl">rotate Z-</span> <span class="val"></span></li>
                    <li><span class="lbl">drop</span> <span class="val"></span></li>
                </ul>
                <span class="button xb gold" id="keys_reset">Reset to default</span>
                <span class="button xb" id="keys_ok">Accept</span>
                <span class="button xb red" id="keys_cancel">Cancel</span>
            </div>

            <div id="highscores" class="hud full" style='display: none;'>
                <h3>High Scores</h3>
                <small>On this computer and browser</small>
                <div id="hscontent"></div>
                <span class="button xb" id="hs_back">Back</span>
            </div>

            <div id="getGamerName" class="hud" style='display: none;'>
                <h2>Game Over</h2>
                <br />
                <input name="username" placeholder="Name" class="username-input" id="username" autocomplete="off" autofocus>
                <br />
                <span class="username-rule">Your name may contain only alphabets, digits and underscores </br> (max 20 characters)</span>
                <button onclick="showScoreUI(event)" class="username-submit-btn">Save</button>
            </div>

            <div id="over" class="hud" style='display: none;'>
                <h2>Game over</h2>
                <br />
                <span id="namelabel">Gamer Name: </span><span id="username-label"></span><br />
                <br />
                <span id="scorelabel">Score</span> <span id="finalscore">0</span><br />
                <br />
                <span class="action">Press B to play again</span>
                
                <a href="#" class="hs" style="color: #009fa0; margin-top: 35px; display:block;">High Scores in Browser</a> </br>
                <a href="scoreboard.php" style="color: #009fa0; display:block;">High Scores on Server</a>
            </div>

            <div id="pause" class="hud" style='display: none;'>
                Pause
            </div>

        </div>
    </center>

    <div id="layers"></div>
    <div id="log" class="shadow"></div>


</body>

</html>

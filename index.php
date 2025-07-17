<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aincrad Shadow</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #111;
            color: #ccc;
            font-family: monospace;
            margin: 0;
            padding: 0;
            transition: background 0.3s, color 0.3s;
        }

        .light-mode {
            background-color: #f1f1f1;
            color: #111;
        }

        .header {
            padding: 10px;
            background-color: #000;
            text-align: center;
            color: #0f0;
            position: relative;
        }

        .light-mode .header {
            background-color: #ddd;
            color: #000;
        }

        .header span {
            color: #ff0;
        }

        .logout {
            float: right;
            color: red;
        }

        .darkmode-toggle {
            position: absolute;
            top: 10px;
            right: 20px;
            background: #444;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-weight: bold;
        }

        .light-mode .darkmode-toggle {
            background: #222;
            color: #fff;
        }

        .container {
            padding: 20px;
        }

        .box {
            background-color: #222;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .light-mode .box {
            background-color: #fff;
            color: #000;
        }

        textarea, input, select {
            width: 100%;
            background-color: #000;
            color: #0f0;
            border: 1px solid #555;
            padding: 10px;
            font-family: monospace;
            margin-top: 10px;
            box-sizing: border-box;
        }

        .light-mode textarea,
        .light-mode input,
        .light-mode select {
            background-color: #eee;
            color: #111;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .btn {
            flex: 1;
            min-width: 100px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            background-color: #333;
            color: #ccc;
            border: none;
            font-weight: bold;
        }

        .light-mode .btn {
            background-color: #ddd;
            color: #111;
        }

        .btn.green {
            background-color: #030;
        }

        .btn.red {
            background-color: #500;
        }

        .btn.yellow {
            background-color: #660;
        }

        .stats {
            margin-top: 10px;
            font-size: 14px;
        }

        .footer {
            padding: 15px;
            text-align: center;
            background-color: #111;
            color: #0f0;
        }

        .light-mode .footer {
            background-color: #ddd;
            color: #000;
        }

        .live-dead {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            gap: 10px;
        }

        .live-dead div {
            padding: 10px;
            background-color: #000;
            color: #0f0;
            border: 1px solid #333;
            width: 100%;
            text-align: center;
            flex: 1;
        }

        .light-mode .live-dead div {
            background-color: #fff;
            color: #000;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 600px) {
            .btn-group {
                flex-direction: column;
            }
            .btn {
                width: 100%;
            }
            .live-dead {
                flex-direction: column;
            }
            .live-dead div {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

<div class="header">
    Hello <span>Cloud</span> |
    Time remaining: <span>29 days and 23 hours and 58 mins</span> [
    <span>719:58:20</span> ] |
    <span class="logout">| Logout</span>

    <button class="darkmode-toggle" onclick="toggleDarkMode()">🌙 Toggle Mode</button>
</div>

<div class="container">
    <div class="box">
        <h2 style="text-align:center;">AINCRAD SHADOW</h2>
        <textarea placeholder="Generate/Paste you bins here" rows="6" class="form-control text-center form-checker mb-2"></textarea>
        <!-- Telegram ID and Proxy -->
        <div class="input-group mb-1">
        <input type="text" class="form-control" id="cslive" name="cslive" placeholder="Telegram ID" style="background-color:#000000; color:#00ff00; border: 1px solid #f1f1f1;">
        <input type="text" class="form-control" id="pklive" name="pklive" placeholder="Proxy" style="background-color:#000000; color:#00ff00; border: 1px solid #f1f1f1;">
        </div>

        <!-- Gateway selector -->
        <div class="col-md-6">
        <select id="gateSelector" class="form-control" style="background-color: #000000; color: #00ff00; border: 1px solid #00ff00; text-align-last: center;">
            <option style="background-color: #000000; color: #00ff00;" value="gate/authccn.php">[API-01] [AUTH] STRIPE [CCN-NO-CHARGE]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/authccn2.php">[API-02] [AUTH] STRIPE [CCN-NO-CHARGE]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/authcvv1.php">[API-03] [AUTH] STRIPE [CVV-NO-CHARGE]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/authcvv2.php">[API-04] [AUTH] STRIPE [CVV-NO-CHARGE]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/authcvv3.php">[API-05] [AUTH] STRIPE [CVV-NO-CHARGE]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/authcvv4.php">[API-06] [AUTH] STRIPE [CVV-NO-CHARGE]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/authcvv5.php">[API-07] [AUTH] STRIPE [CVV-NO-CHARGE]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/authcvv6.php">[API-08] [AUTH] STRIPE [CVV-NO-CHARGE]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/authcvv7.php">[API-09] [AUTH] STRIPE [CVV-NO-CHARGE]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/authcvv8.php">[API-10] [AUTH] STRIPE [CVV-NO-CHARGE + PROXYLESS]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/authcvv9.php">[API-11] [AUTH] STRIPE [CVV-NO-CHARGE]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/charge.php">[API-12] STRIPE [CVV-CHARGE + PROXYLESS]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/adyen.php">[API-13] ADYEN [CVV-CHARGE + PROXYLESS + NON VBV ONLY]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/authcvv10.php">[API-14] [AUTH] STRIPE [CVV-NO-CHARGE]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/braintree.php">[API-15] BRAINTREE [MASS 3DS CHECKER]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/porn.php">[API-16] PORN 4.99$ [CVV-CHARGE]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/new.php">[API-17] BIGCARTEL + STRIPE [CCN-CHARGE-RANDOM]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/bigcartelcvv.php">[API-18] BIGCARTEL + STRIPE [CVV-CHARGE-RANDOM]</option>
            <option style="background-color: #000000; color: #00ff00;" value="gate/paypal.php">[API-18] BIGCARTEL + PAYPAL [CVV-CHARGE RANDOM]</option>
</select>
        </select>
        </div>

        <div class="btn-group">
            <button class="btn btn-play text-white" style="width: 49%; float: left; background-color: #006400;"><i class="fa fa-play"></i> START</button>
            <button class="btn btn-stop btn-glow text-white" style="background-color: #b30000; width: 49%; float: right;" disabled><i class="fa fa-stop"></i> STOP</button>
            <button class="btn yellow" onclick="toggleSpeedOptions()">SPEED</button>
            <!--<button class="btn">GENERATE</button>
            <button class="btn">EXTRAP</button> -->
        </div>

        <!-- SPEED Options Dropdown (Initially Hidden) -->
        <div id="speedOptions" style="display: none; margin-top: 15px;">
            <h4 style="margin-bottom: 10px; color: #0f0; text-align: center;"><strong>Speed Preference</strong></h4>

            <div style="display: flex; justify-content: space-between; align-items: center; width: 60%; margin: 0 auto;">
                <select class="form-control text-center" id="speedSelector"
                        style="width: 48%; height: 40px; background-color: #000000; color: #00ff00; border: 1px solid rgb(250, 250, 250); text-align-last: center;">
                    <option value="100">[0.1 sec card interval] Fast</option>
                    <option value="5000">[5 sec card interval] Normal</option>
                    <option value="10000">[10 sec card interval] Slow</option>
                </select>

                <button class="btn btn-success" onclick="saveSpeed()" style="width: 48%; height: 40px;">Save</button>
            </div>
        </div>
        <!--<div id="speedOptions" style="display: none; margin-top: 15px;">
            <h4 style="margin-bottom: 10px; color: #0f0; text-align: center;"><strong>Speed Preference</strong></h4>

            <div class="d-flex justify-content-center align-items-center gap-2">
                <select class="form-control text-center" id="speedSelector"
                        style="width: 28%; height: 38px; background-color:#112132; color:white; border: 1px solid #ced4da;">
                    <option value="100">✅ Fast</option>
                    <option value="1000">✅ Normal</option>
                    <option value="10000">✅ Slow</option>
                </select>

                <button class="btn btn-success" onclick="saveSpeed()" style="width: 28%; height: 38px;">Save</button>
            </div>
        </div>-->

        <!-- <div class="stats">
            Live: 0 | Dead: 0 | Processed: 0 | Cards: 0 | Speed: <span id="currentSpeed">Normal</span> | Status: -
        </div>-->
        <div class="stats" style="color: #0f0; font-size: 14px; text-align: center;">
            CHARGED: <span class="text text-success charge">0</span> |
            LIVE: <span class="text text-success aprovadas">0</span> |
            DEAD: <span class="text text-danger reprovadas">0</span> |
            PROCESSED: <span class="text text-warning testadas">0</span> |
            CARDS: <span class="text text-primary carregadas">0</span> |
            SPEED: <span id="currentSpeed">Normal</span> |
            DATE: <span class="text text-light" id="datetime">01/01/2025</span> |
            TIME: <span class="text text-light" id="timenow">00:00:00 AM</span>
        </div>

        <!--<div class="live-dead">
            <div>Live [0]</div>
            <div>Dead [0]</div>
            <div><i class="fa fa-check-circle text-success"></i> Live <span id="cards_aprovadas">[0]</span></div>
            <div><i class="fa fa-times text-danger"></i> Dead <span id="cards_reprovadas">[0]</span></div>
        </div>
        <div class="live-dead">
            <div>Live <i class="text text-success aprovadas">[0]</i><br><span id="cards_aprovadas"></span></div>
            <div>Dead <i class="text text-danger reprovadas">[0]</i><br><span id="cards_reprovadas"></span></div>
        </div>-->
        <div class="live-dead">
            <div>
                Live <i class="text text-success aprovadas">[0]</i>
                <span class="show-lives text-action" onclick="toggleLive()">[Show]</span>
                <span class="btn-copy text-action" onclick="copyLive()">[Copy]</span><br>
                <span id="cards_aprovadas"></span>
            </div>
            <div>
                Dead <i class="text text-danger reprovadas">[0]</i>
                <span class="show-dies text-action" onclick="toggleDead()">[Show]</span>
                <span class="btn-trash text-action" onclick="clearDead()">[Trash]</span><br>
                <span id="cards_reprovadas"></span>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    Cloud Reacher | 2025
</div>
<script>
    function toggleDarkMode() {
        document.body.classList.toggle('light-mode');
        const mode = document.body.classList.contains('light-mode') ? 'light' : 'dark';
        localStorage.setItem('mode', mode);
    }

    window.onload = function() {
        if (localStorage.getItem('mode') === 'light') {
            document.body.classList.add('light-mode');
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="theme-assets/script/archer.js"></script>
</body>
</html>
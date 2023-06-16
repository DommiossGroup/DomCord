<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>An error has occured | DomCord</title>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            background: #2f4256 url("../themes/uploaded/error/service_pattern.png")repeat 0 0;
            text-align: center;
            font-family: "PT Sans", Verdana, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            display: table;
            min-width: 100%;
        }

        .layout {
            width: 400px;
            margin: 0 auto;
            margin: 0;
            display: table-cell;
            vertical-align: middle;
            height: 100%;
        }

        .text {
            font-size: 36px;
            color: #fff;
            font-weight: normal;
            margin: 0 auto;
            line-height: 1;
        }

        .title {
            font-size: 120px;
            color: #fff;
            font-weight: 700;
            margin: 0 auto 20px;
            line-height: 1;
            font-family: Arial, Verdana, sans-serif;
        }

        .icon:after {
            content: "";
            display: block;
            width: 202px;
            height: 202px;
            margin: 40px auto;
            background-repeat: no-repeat;
            background-position: 0 0;
        }

        .icon:after {
            background-image: url("../themes/uploaded/error/icon.png");
        }

        .buttons {
            text-align: center;
            display: inline-block;
            margin: auto;
            position: relative;
            border-top: 3px solid #667c93;
            width: 100%;
            text-align: center;
            width: 400px;
        }

        .buttons_wrap {
            padding-top: 35px;
        }

        .text_buttons_intro {
            font-size: 20px;
            font-weight: normal;
            color: #748ca5;
            line-height: 1.5em;
            padding: 0;
            margin: 0;
            width: 100%;
            padding: 35px 0 0;
            text-align: center;
        }

        a.button {
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            color: #fff !important;
            background: #5bb3ee;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            height: 40px;
            line-height: 40px;
            padding: 0 15px;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            margin-right: 10px;
            text-decoration: none;
        }

        .button+.button {
            margin-left: -4px;
        }

        .button:last-child {
            margin-right: 0;
        }

        a.button:hover {
            text-decoration: none;
        }

        .footer {
            color: #7e8186;
            font-size: 13px;
            margin: 45px auto 0;
        }
    </style>
</head>

<body>

    <div class="layout">
        <div class="title">Can't access to this website !</div>
        <div class="text icon">An error has occurred while loading this page.<br><small><code><?= $error ?></code></small></div>
        <div class="buttons">
            <p class="text_buttons_intro"><?= date("Y") ?> © DomCord<br>Edité par le Groupe Dommioss</p>
        </div>
    </div>

</body>

</html>
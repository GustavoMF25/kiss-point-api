<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiss - Point</title>
    <style>
        .container {
            width: 700px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%)
        }

        .ml5 {
            position: relative;
            font-weight: 300;
            font-size: 4.5em;
            color: #402d2d;
        }

        .ml5 .text-wrapper {
            position: relative;
            display: inline-block;
            padding-top: 0.1em;
            padding-right: 0.05em;
            padding-bottom: 0.15em;
            line-height: 1em;
        }

        .ml5 .line {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            height: 3px;
            width: 100%;
            background-color: #402d2d;
            transform-origin: 0.5 0;
        }

        .ml5 .ampersand {
            font-family: Baskerville, serif;
            font-style: italic;
            font-weight: 400;
            width: 1em;
            margin-right: -0.1em;
            margin-left: -0.1em;
        }

        .ml5 .letters {
            display: inline-block;
            opacity: 0;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            setTimeout(() =>{
                let url = window.location.href;
                window.location.href = url+'/login';
            }, 3000)
            anime.timeline({
                    loop: true
                })
                .add({
                    targets: '.ml5 .line',
                    opacity: [0.5, 1],
                    scaleX: [0, 1],
                    easing: "easeInOutExpo",
                    duration: 700
                }).add({
                    targets: '.ml5 .line',
                    duration: 600,
                    easing: "easeOutExpo",
                    translateY: (el, i) => (-0.625 + 0.625 * 2 * i) + "em"
                }).add({
                    targets: '.ml5 .ampersand',
                    opacity: [0, 1],
                    scaleY: [0.5, 1],
                    easing: "easeOutExpo",
                    duration: 600,
                    offset: '-=600'
                }).add({
                    targets: '.ml5 .letters-left',
                    opacity: [0, 1],
                    translateX: ["0.5em", 0],
                    easing: "easeOutExpo",
                    duration: 600,
                    offset: '-=300'
                }).add({
                    targets: '.ml5 .letters-right',
                    opacity: [0, 1],
                    translateX: ["-0.5em", 0],
                    easing: "easeOutExpo",
                    duration: 600,
                    offset: '-=600'
                }).add({
                    targets: '.ml5',
                    opacity: 0,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000
                });
        })
    </script>
</head>

<body class="container">
    <h1 class="ml5">
        <span class="text-wrapper">
            <span class="line line1"></span>
            <span class="letters letters-left">Kiss</span>
            <span class="letters ampersand">-</span>
            <span class="letters letters-right">Point</span>
            <span class="line line2"></span>
        </span>
    </h1>

    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
</body>

</html>
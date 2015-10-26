<!DOCTYPE html>
<html>
<head>
    <title>404</title>
    <style type="text/css">
        body { color: #fff; text-shadow: 0 1px 2px #000; font-family: "chaparral-pro", 'Helvetica Neue', arial, sans-serif; }
        div.dialog {
            width: 40%;
            padding: 2em;
            margin: 2em auto 0 2em;
        }
        h1 {
            font-style:italic;
            font-size:40px;
            line-height:48px;
            margin-bottom:.5em;
        }
        p {
            font-size:20px;
            line-height:30px;
        }
        a {
            color:#fff;
            font-weight:bold;
            text-decoration:none;
            border-bottom: 2px solid rgba(255,255,255,.5);
        }
        a:hover {
            border-bottom: 2px solid rgba(255,255,255,1);
        }
    </style>
    <meta charset="utf-8">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://s.cdpn.io/13060/jquery.anystretch.min_1.js"></script>
</head>

<body>
<!-- This file lives in public/404.html -->
<div class="dialog">
    <h1>Oops, algo deu errado!</h1>
    <p>Desculpe,a página que você está tentando acessar não foi encontrada!</p>
    <a href="{{ route('dashboard.index') }}">Voltar a página inicial</a>
</div>

<script type="text/javascript">
    //http://i.imgur.com/3mykX.gif
    //http://payload202.cargocollective.com/1/13/430252/6345864/Gif-Vache-_600.gif
    $.anystretch("https://media.giphy.com/media/12XMGIWtrHBl5e/giphy.gif", {speed: 150});
</script>

</body>
</html>

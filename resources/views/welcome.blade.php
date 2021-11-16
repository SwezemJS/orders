<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/79d332ed65.js"></script>
    <style>
        #app {
            margin: 0px;
            padding: 0px;
        }

        .sidebar {
            border-right: 5px solid lightgray;
        }

        html, body {
            height: 100%;
        }

        .sidebar-item {
            border: 1px solid lightgray;
            background-color: #1E1E1E;
            color: white;
        }

        .order-item-head > div {
            border: 2px solid #1E1E1E;
            background-color: #1E1E1E;
            color: white;
            font-size: 12pt;
            padding: 6px 0px 6px 0px;
        }

        #order-item-list > div {
            padding: 10px 0px 10px 0px;
            border: 1px solid lightgray;
        }
        #createOrder > div {
            border: 1px solid lightgray;
        }
    </style>
</head>
<body>
<div id="app" class="container-fluid h-100 mp-0">

</div>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>

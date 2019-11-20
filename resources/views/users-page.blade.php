<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo - Usuários</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fa-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/iziToast.min.css') }}">

</head>

<body>
    <main id="app" class="flex max-h-screen max-w-screen w-screen h-screen bg-gray-200 overflow-hidden">
        <my-sidebar></my-sidebar>
        <div class="flex flex-col w-full">
            <my-navbar></my-navbar>
            <div class="flex flex-grow overflow-y-scroll overflow-x-hidden">
                <my-user-manager></my-user-manager>
            </div>
        </div>
    </main>

</body>

<script src="{{ asset('js/iziToast.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

</html>
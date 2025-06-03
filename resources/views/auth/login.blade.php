<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT GATE INDONESIA</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{('css/login.css')}}">
    @vite([])
</head>
<body>
    <div class="container-fluid flex justify-center items-center h-screen">
        <div class="form w-full max-w-md p-6 rounded-lg shadow-lg">
            <h1>Login</h1>
            @include('components.login_form')
        </div>
    </div>
</body>
</html>
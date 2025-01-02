<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
      @vite('resources/css/app.css')

</head>
<body>

    <p class="bg-green-600">Hello</p>

       <main class="container mx-auto lg:px-44 p-6">
        @yield('auth-section')
    </main>
    
</body>
</html>
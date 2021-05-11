<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        

    </head>
    <body>
        
        <div id="app">
            {{-- <form-component></form-component> --}}
            {{-- <router-link to="/form">form</router-link>
            <router-link to="/teste">teste</router-link> --}}
            <Container />
        </div>
        
        
        
    </body>
    <script src="{{ asset('js/app.js') }}" defer></script>
</html>

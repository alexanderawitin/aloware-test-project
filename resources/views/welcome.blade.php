<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Aloware Test Project</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}"/>
        <script>
            window.__STATE__ = { posts: {!! json_encode($posts) !!} };
        </script>
    </head>
    <body>
        <div id="app">
            <div class="container mt-5">
                <alo-posts></alo-posts>
            </div>
        </div>

        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>

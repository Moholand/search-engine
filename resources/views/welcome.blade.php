<!DOCTYPE html>
<html dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>How To Install Vue 3 in Laravel 9 with Vite</title>

        @vite('resources/css/app.css')
    </head>
    <body style="background-color: #ffffff">
        <div id="app">
            <App />
        </div>

        @vite('resources/js/app.js')
    </body>
</html>
<script src="https://kit.fontawesome.com/35ccbb767b.js" crossorigin="anonymous"></script>
<script>
    import App from "../js/App";
    export default {
        components: {App}
    }
</script>

<!DOCTYPE html>
<html>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="/css/template.css">
    <link rel="stylesheet" href="/css/template.dark.css">

    <link rel="stylesheet" href="/css/app.css?v={{ env('APP_ENV') === 'local' ? time() : '1' }}" />

    <script src="/js/jquery.min.js"></script>
</head>
<body data-new-gr-c-s-check-loaded="8.895.0" data-gr-ext-installed="">
    <div id="app-root">
        <App />
    </div>
    <script src="/js/app.js?v={{ env('APP_ENV') === 'local' ? time() : '3' }}"></script>
</body>
</html>

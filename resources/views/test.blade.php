<!doctype html>
<html>
<head>
    <title>Test Page</title>
    <script type="text/javascript" src="{{ url('/js/jquery.min.js') }}"></script>
</head>
<body>
    <form method="post" action="/api/uninstall-application" id="appData">
        {{ csrf_field() }}
        <input type="text" name="username" value="mtengenezi">
        
    </form>
    <script type="text/javascript">
        document.getElementById('appData').submit();
        
    </script>

    
    
</body>

</html>


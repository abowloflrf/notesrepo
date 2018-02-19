<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NotesRepo - Workspace</title>
</head>
<style>
    body{
        margin:0;
    }
</style>
<body>
    <div id="notesrepo-app"></div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
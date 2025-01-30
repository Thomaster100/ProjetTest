<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enregistrement</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mt-5 mx-auto">
        <h1>Email Vérifié</h1>
        <p>Votre email a été vérifié avec succès.</p>
        <a href="{{ route('finish-register', $id) }}" class="btn btn-primary">Completer mes infos</a>
        
    </div>
    
</body>
</html>

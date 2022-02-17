<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
    <p>Added at: {{$created_at}}</p>
    <p>Fullname: {{$fullname}}</p>
    <p>Tel: {{$tel}}</p>
    <p>Description: {{$description}}</p>
    @if ($photo)
    <img style="width: 500px;object-fit:cover" src="{{ asset('images/'.$photo) }}" alt="problem photo">
    @endif
</body>
</html>
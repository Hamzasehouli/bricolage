<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>Added at: {{$created_at}}</p>
    <p>Fullname: {{$fullname}}</p>
    <p>tel: {{$tel}}</p>
    <p>description: {{$description}}</p>
    @if ($photo)
    <p>photo: {{$photo}}</p>
    @endif
</body>
</html>
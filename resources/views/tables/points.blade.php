<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Points</title>
</head>
<body>
    <h1>Points for {{ $user->name }}</h1>
    
    <p>Weekly Points: {{ $user->weekly_points }}</p>

    <a href="{{ route('users.index') }}">Back to Users List</a>
</body>
</html>

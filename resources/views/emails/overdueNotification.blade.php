<!DOCTYPE html>
<html>
<head>
    <title>Overdue Book Rental Notification</title>
</head>
<body>
    <h1>Overdue Notification</h1>
    <p>Hello {{ $user->name }},</p>
    <p>Your book rental for "{{ $book->title }}" is overdue. Please return it as soon as possible.</p>
</body>
</html>

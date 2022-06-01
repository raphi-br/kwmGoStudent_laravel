<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head></head>
<body>
<h1>{{$offer->title}}</h1>
<h2>{{$offer->subject}}</h2>

<p>{{$offer->description}}</p>
<hr>
<a href="/">Zurück zur Übersicht</a>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head></head>
<body>
<h1>Bookstore</h1>
@foreach($offers as $offer)
    <li>{{$offer->title}} {{$offer->description}}</li>
@endforeach
</body>
</html>

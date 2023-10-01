<!DOCTYPE html>
<html>
<head>
    <title>{{ $journal->title }}</title>
</head>
<body>
    <h1>{{ $journal->title }}</h1>
    <p>{!! $content !!}</p>
    <p>Created at: {{ $journal->created_at->format('F d, Y') }}</p>
</body>
</html>

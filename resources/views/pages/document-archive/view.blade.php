<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="System Idea Konsultan" name="description" />
    <meta content="Era Konsultan" name="author" />
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/idea-konsultan-tanpa-bg.png') }}">
    <title>SYSTEM</title>
</head>

<body>
    <iframe src="https://docs.google.com/gview?url={!! asset('storage/' . $documentName) !!}&embedded=true" width="100%" height="800"
        allowfullscreen webkitallowfullscreen></iframe>
</body>

</html>

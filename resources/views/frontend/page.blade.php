<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title ?? 'Page' }}</title>
    <style>{{ $page->css }}</style>
</head>
<body>

    {!! $page->html !!}

</body>
</html>

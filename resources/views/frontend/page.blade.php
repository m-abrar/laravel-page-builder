<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title ?? 'Page' }}</title>

    @if (!empty($page->css))
        <style>{!! html_entity_decode($page->css) !!}</style>
    @endif


    <meta name="description" content="{{ Str::limit($page->meta_description ?? 'Default description', 160) }}">
    <meta name="keywords" content="{{ $page->meta_keywords ?? 'keywords, here' }}">
    <meta property="og:title" content="{{ $page->title ?? 'Page' }}">
    <meta property="og:description" content="{{ Str::limit($page->meta_description ?? 'Default description', 200) }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('uploads/default-image.jpg') }}"> <!-- TODO Update with dynamic image -->
</head>
<body>

    @php
    $html = $page->html;
    $html = str_replace('[[widget-testimonial]]', view('widgets.testimonial')->render(), $html);
    @endphp

    {!! $html !!}

</body>
</html>

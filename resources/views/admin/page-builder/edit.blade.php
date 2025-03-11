<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Builder</title>
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <style id="dynamic-css">
        {!! $page->css !!}
    </style>
</head>
<body>

    <button id="savePage">Save Page</button>
    <div id="gjs">{!! $page->html !!}</div>

    <script>
        var csrfToken = "{{ csrf_token() }}";
        var savePageUrl = "{{ route('admin.page-builder.save', ['id' => $page->id]) }}";
        var pageCSS = `{!! $page->css !!}`;
    </script>

    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://unpkg.com/grapesjs-blocks-basic"></script>

    <script>
        var editor = grapesjs.init({
            container: '#gjs',
            height: '100vh',
            fromElement: true,
            storageManager: false,
            plugins: ['gjs-blocks-basic'],
            pluginsOpts: { 'gjs-blocks-basic': {} },
        });

        // APPLY SAVED CSS TO GRAPESJS
        if (pageCSS) {
            editor.setStyle(pageCSS); // Load saved styles into editor
        }

        editor.BlockManager.add('dynamic-testimonial', {
            label: 'Dynamic Testimonial',
            category: 'Widgets',
            content: `[[widget-testimonial]]` // Placeholder for dynamic testimonial
        });


    </script>

    {{-- Load Widgets --}}
    @include('admin.page-builder.widgets.testimonial-widget')
    @include('admin.page-builder.widgets.cta-widget')
    @include('admin.page-builder.widgets.feature-box-widget')
    @include('admin.page-builder.widgets.hero-section.load')


    <script>
        // SAVE PAGE TO DATABASE
        document.getElementById('savePage').addEventListener('click', function () {
            var html = editor.getHtml();
            var css = editor.getCss();

            fetch(savePageUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ html: html, css: css })
            })
            .then(response => response.json())
            .then(data => alert(data.message))
            .catch(error => console.error("Error saving page:", error));
        });
    </script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Builder</title>
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
</head>
<body>

    <button id="savePage">Save Page</button>
    <div id="gjs"></div>

    <!-- Pass Laravel variables to JavaScript -->
    <script>
        var csrfToken = "{{ csrf_token() }}";
        var savePageUrl = "{{ route('admin.page-builder.save', ['id' => $page->id]) }}";
        var pageHtml = `{!! addslashes($page->html) !!}`;
        var pageCss = `{!! addslashes($page->css) !!}`;
    </script>

    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://unpkg.com/grapesjs-blocks-basic"></script>

    <script>
        var editor = grapesjs.init({
            container: '#gjs',
            height: '100vh',
            fromElement: false,  // Prevent overriding HTML in <div id="gjs">
            storageManager: false,
            plugins: ['gjs-blocks-basic'],
            pluginsOpts: { 'gjs-blocks-basic': {} },
        });

        // Load saved HTML & CSS
        editor.setComponents(pageHtml);
        editor.setStyle(pageCss);

        // Save Page to Database
        document.getElementById('savePage').addEventListener('click', function() {
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

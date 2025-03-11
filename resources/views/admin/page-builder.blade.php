<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Builder</title>

    <!-- GrapesJS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <style>
        body {
            margin: 0;
        }
        #gjs {
            height: 100vh;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

    <div id="gjs"></div>

    <!-- GrapesJS JS -->
    <script src="https://unpkg.com/grapesjs"></script>
    <script>
        var editor = grapesjs.init({
            container: '#gjs',
            height: '100vh',
            fromElement: true,
            storageManager: false, // Disable local storage for now
            plugins: ['gjs-blocks-basic'], // Adds basic blocks
            pluginsOpts: {
                'gjs-blocks-basic': {} // Configuration for the plugin
            }
        });
    </script>

</body>
</html>

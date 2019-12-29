<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Api Test Task Docs</title>
    <link rel="stylesheet" type="text/css" href="//unpkg.com/swagger-ui-dist@3.24.3/swagger-ui.css"/>
</head>

<body>
<div id="swagger-ui"></div>
<script type="text/javascript" src="//unpkg.com/swagger-ui-dist@3.24.3/swagger-ui-standalone-preset.js"></script>
<script type="text/javascript" src="//unpkg.com/swagger-ui-dist@3.24.3/swagger-ui-bundle.js"></script>
<script type="text/javascript">
    window.onload = function () {
        window.ui = SwaggerUIBundle({
            url: '{{ $url }}',
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],
            layout: 'StandaloneLayout',
        });
    }
</script>
</body>
</html>

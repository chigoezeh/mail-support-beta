    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $_page_title; ?> - Mini Emailing System</title>
        <meta name="description" content="Better predicting environment for users and investors to ease the suffering of predicting currencies for the users of stock market.">
        <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/materialdesignicons.min.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/style.css?no_cache=<?php echo strtotime(date('Y-m-d H:i:s')) ?>" />
    <?php if ($editor_plugin === 'YY'): ?>
        <link href="https://cdn.quilljs.com/1.2.6/quill.snow.css" rel="stylesheet">
        <script src="https://cdn.quilljs.com/1.2.6/quill.min.js"></script>
    <?php endif; ?>
    </head>
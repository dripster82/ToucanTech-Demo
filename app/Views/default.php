<!doctype html>
<html>
<head>
    <title>Simple App</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <?= $this->renderSection('page_js') ?>
</head>
<body>
	<h1>ToucanTech Demo App</h1>
    <?= view('nav') ?>
    <div id="main_content">
        <?= $this->renderSection('content') ?>
    </div>
</body>
</html>
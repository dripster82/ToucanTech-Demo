<!doctype html>
<html>
<head>
    <title>Simple App</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <?= $this->renderSection('page_js') ?>
</head>
<body>
	<h1>ToucanTech Demo App</h1>
    <?= $this->renderSection('content') ?>
</body>
</html>
<?= $this->extend('default') ?>

<?= $this->section('page_js') ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/style.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>

    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
    <script type="text/javascript">
    	var options = {
			data: [              
				{
					type: "column",
					dataPoints: [
					<?php foreach($schools as $school): ?>
						{ label: "<?= $school->name ?>",  y: <?= count($school->members) ?>  },
					<?php endforeach ?>
					]
				}
			]
		};
		$(document).ready(function() {
			$("#school_chart1").CanvasJSChart(options);
		});
    </script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="main_title">
	<h2>Analysis of Schools</h2>
</div>
<div id="school_chart1" class="chart">
</div>
<?= $this->endSection() ?>
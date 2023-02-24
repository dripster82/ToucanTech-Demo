<dl class="nav">
	<dt>Menu</dt>
	<dd><a class="<?= str_replace('/index.php', '', current_url()) == base_url('schools') ? 'active' : ''?>" href="<?= base_url('schools') ?>">List of Schools</a></dd>
	<dd><a class="<?= str_replace('/index.php', '', current_url()) == base_url('schools/analysis') ? 'active' : ''?>" href="<?= base_url('schools/analysis') ?>">Analysis of Schools</a></dd>
	<dd><a href="<?= base_url('schools/export') ?>">Export to CSV</a></dd>
</dl>
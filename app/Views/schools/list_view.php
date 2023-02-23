<?= $this->extend('default') ?>

<?= $this->section('page_js') ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/style.css">
    <script src="<?php echo base_url() ?>js/school_list.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h2>List of Schools</h2>
<div id="list_of_schools">
<?php foreach($schools as $school): ?>
	<div id="school-<?= $school->id ?>" class="school_wrapper">
		<span class="school_name"><?= $school->name ?></span>
		<img class="members_toggle action_btn" alt="Toggle Members View" src="<?php echo base_url() ?>img/members_icon.png" />
		<img class="add_new_members_toggle action_btn" alt="Toggle Add New Members Form" src="<?php echo base_url() ?>img/add_member_icon.png" data-school-id="<?= $school->id ?>" />
		<ul class="<?= ($school_focus_id == $school->id) ? 'focused' : ''?>">
		<?php if (count($school->members) > 0): ?>
			<?php foreach($school->members as $member): ?>
				<?= view('schools/member', ['member' => $member, 'school' => $school]) ?>
			<?php endforeach ?>
		<?php else: ?>
			<li>No Members Assigned</li>
		<?php endif ?>
		</ul>
	</div>
<?php endforeach ?>
</div>
<?= $this->include('schools/add_member_form') ?>
<?= $this->endSection() ?>
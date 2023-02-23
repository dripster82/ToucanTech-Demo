<div id="add_member_to_school_form">
	<h2>Add Member to School</h2>
	<img class="close_btn action_btn" alt="Close" src="<?php echo base_url() ?>img/delete.png" />
	<script type="text/javascript">
		let school_members = <?= $school_members ?>
	</script>
	<div id="member_form_errors" >
	</div>
	<?= form_open(base_url().'schools/add_member') ?>
	
	<?= form_label('School', 'school') ?>
	<?= form_dropdown('school', $school_names, 'Select School', 'id="school" onChange="updateMembersDropdown()"') ?>
	
	<?= form_label('Member', 'member') ?>
	<?= form_dropdown('member', ['Please select a school first'], '', 'id="member" onChange="toggleNewMemberFields()"') ?>

	<div id="add_new_member_fields">
		<?= form_label('Name', 'name') ?>
		<?= form_input('name') ?>
		<?= form_label('Email', 'email') ?>
		<?= form_input('email') ?>
	</div>

	<?= form_submit('submit', 'Add Member', 'id="submit_form_btn"') ?>
	<?= form_close() ?>
</div>
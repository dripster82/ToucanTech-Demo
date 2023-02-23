<li id="item-<?= $school->id ?>-<?= $member->id ?>" class="member">
	<span><?= $member->name ?> (<?= $member->email_address ?>)</span>
	<img class="remove_member_btn action_btn" alt="Remove" src="<?php echo base_url() ?>img/delete.png" data-school-id="<?= $school->id ?>" data-member-id="<?= $member->id ?>"/>
</li>
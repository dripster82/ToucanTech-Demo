$( document ).ready(function() {
    $('.members_toggle').click(function(){
	     $(this).siblings('ul').toggle('swing');
	});
    $('.close_btn').click(function(){
	    $(this).parent('div').hide();
	    $('#add_member_to_school_form form').trigger("reset");
	    updateMembersDropdown();
	});

    $('.add_new_members_toggle').click(function(){
    	school_id = $(this).data("school-id");
    	$('#school').val(school_id).change();
    	centerPopup('#add_member_to_school_form');
	    $('#add_member_to_school_form').show();
	});

    $('.remove_member_btn').click(removeMember);

    $('#add_member_to_school_form form').submit(function(event){
  		event.preventDefault();
  		url = $(this).attr( "action" );

  		posting = $.post( url, $("#add_member_to_school_form form").serialize() );
 
		// Put the results in a div
		posting.done(function( data, textStatus, xhr ) {
			data = JSON.parse(data);
			school_id = data['school_id'];
			member_id = data['member_id'];
	    	$('#add_member_to_school_form').hide();
	    	$('#add_member_to_school_form form').trigger("reset");
	    	$('#school-'+school_id+' ul').append(data['member_html']);
	    	$('#school-'+school_id+' ul').show('swing');
	    	$('#school-'+school_id+' ul li.no_members_placeholder').remove();

			$('#item-'+school_id+'-'+member_id+' .remove_member_btn').click(removeMember);
			school_members = data['school_members'];
	    	updateMembersDropdown();
		});

		posting.fail(function( data, textStatus, xhr ) {
			$('#member_form_errors').html(data.responseText);
			console.log(data.responseText);
		});
	});

	if($('#add_member_to_school_form').hasClass('has_errors')) {
		centerPopup('#add_member_to_school_form');
	    $('#add_member_to_school_form').show();
	}

	$('.export_btn').click(function(){
        window.open( $(this).data("url") );
	});
});

function updateMembersDropdown() {
	school_id = $('#school').val();
	$dropdown = $('#member');
	$dropdown.empty();

	if(school_id == 0) {
		 $dropdown.append($('<option></option>')
		     .attr('value', '0').text('Please select a school first'));
		toggleNewMemberFields();
	}
	else {
		$dropdown.append($('<option></option>')
		     .attr('value', '').text('Select Member to add'));
		$dropdown.append($('<option></option>')
		     .attr('value', 'new').text('Create New Member'));
		$.each(school_members[school_id], function(key,value) {
		  $dropdown.append($('<option></option>')
		     .attr('value', key).text(value));
		});
	}
}

function toggleNewMemberFields() {
	if($('#member').val() == 'new')
		$('#add_new_member_fields').show();
	else
		$('#add_new_member_fields').hide();
}

function centerPopup(selector) {
	$(selector).css({
        'position' : 'absolute',
        'left' : '50%',
        'top' : '50%',
        'margin-left' : -$(selector).outerWidth()/2,
        'margin-top' : -$(selector).outerHeight()/2
    });
}

function removeMember(){
    	school_id = $(this).data("school-id");
    	member_id = $(this).data("member-id");
    	posting = $.ajax({
    		// url: '/schools/remove_member?'+$.param( { school:school_id, member: member_id } ), 
    		url: '/schools/'+school_id+'/remove_member/'+member_id, 
    		type: 'DELETE',
    	});
 
		// Put the results in a div
		posting.done(function( data, textStatus, xhr ) {
			data = JSON.parse(data);
			school_id = data['school_id'];
			member_id = data['member_id'];
			$('#item-'+school_id+'-'+member_id).remove();

	    	if($('#school-'+school_id+' ul li').length == 0)
				$('#school-'+school_id+' ul').append('<li class="no_members_placeholder">No Members Assigned</li>');
			school_members = data['school_members'];
	    	updateMembersDropdown();
		});

		posting.fail(function( data, textStatus, xhr ) {
			// $('#member_form_errors').html(data.responseText);
			console.log(data.responseText);
		});
	}
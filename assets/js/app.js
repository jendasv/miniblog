(function($) {

	/**
	 * INSERT FORM
	 */
	var form  = $('#add-form'),
		list  = $('#item-list'),
	    input = form.find('#text');

	input.val('').focus();

	/**
	 * ADD FORM
	 */
	var addForm = $('#add-form');

	addForm.find('#text').select();

	// Add tag select
	addForm.find('#tag-add').on('click', function (event) {

		event.preventDefault();

		var tagsSelect = $('#tags-select');
		tagsSelect.clone().appendTo('#selects');

	});

	//Remove tag select
	addForm.find('#selects').on('click', '#tag-remove', function (event) {
		event.preventDefault();
		console.log();
		$(this).parent().remove();
	})

	/**
	 * EDIT FORM
	 */
	var editForm = $('#edit-form');

	editForm.find('#text').select();

    // Add tag select
	editForm.find('#tag-add').on('click', function (event) {

	    event.preventDefault();

	    var tagsSelect = $('#tags-select');
	    tagsSelect.clone().appendTo('#selects');

    });

	//Remove tag select
    editForm.find('#selects').on('click', '#tag-remove', function (event) {
        event.preventDefault();
        console.log();
        $(this).parent().remove();
    })


	/**
	 * DELETE FORM
	 */
	$('#delete-form').on('submit', function() {
		return confirm('for sure?');
	});




}(jQuery));
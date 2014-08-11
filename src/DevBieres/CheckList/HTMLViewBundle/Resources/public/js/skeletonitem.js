/**
 * newSkeletonItem
 */
function newSkeletonItem(id) {
     //alert(id);
	 $.ajax({
			 url:urlNew.replace("__id__", id),
	         dataType:'html',
	         success: function(data) {
			    $('#newSubItem' + id).html(data);
		        $('#newSubItem' + id).show();
			 } // /success
	 });
} // /newSkeletonItem

/**
 * Create a new sub item
 */
function newSubItem(id) {
		$.ajax({
				url: urlNewSubItem.replace('__id__', id),
		        dataType:'html',
		        success: function(data) {
						$('#newSubItem'+id).html(data);
						$('#newSubItem'+id).show();
				}
		});
} // /newSubItem

/**
 * Close
 * */
function close(id) {
		$('.newitem').hide();
		$('.newitem').html('');
} // /close

/**
 * Submit
 */
function submit() {
		// Get the form
		var $form = $('#form_skeleton_item_new').closest("form");
		// Stop event
		//event.preventDefault();
	    // get url
		var url = $form.attr('action');
	    // Ajax
		$.ajax({
			type: "POST",
		    url: url,
		    data: $form.serialize(),
			dataType: "html",
			success: function(data) {
					  close();
					  $("#list").html(data);
			},
			error: function(data) {
					  alert(data.responseText);
			}
		}); // ajax
} // /submit


/**
 * Delete an item
 */
function del(sid, id) {
		// Url
		var url = urlDel.replace('__id__', sid).replace('__item_id__', id);
		// Ajax !
		$.ajax({
			type: "POST",
		    url: url,
			dataType: "html",
			success: function(data) {
				$("#list").html(data);
			},
			error: function(data) {
				alert(data.responseText);
			}
		}); // ajax
} // /delete



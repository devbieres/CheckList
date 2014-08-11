/**
 * Change state of an item
 */
function changeState(sid, id) {
		// Url
		var url = urlChangeState.replace('__id__', sid).replace('__item_id__', id);
		// Ajax !
		$.ajax({
			type: "GET",
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



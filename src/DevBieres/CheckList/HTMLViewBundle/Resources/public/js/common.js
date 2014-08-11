
/**
 * Show the message (bootbox) and if confirmed, redirect to the url
 * @param message
 * @param url
 */
function confirm(message, url) {
      bootbox.confirm(message, function(confirmed) {
        if (confirmed) {
		window.location = url;
	}
      });
}


/**
 * Appelée lorsqu'on veut supprimer un élément. Le message de confirmation est récupéré côté serveur
 * @param confirmMessageDeletePath
  */
function confirmAjaxDelete(confirmMessageDeletePath, deletePath) {
		$.ajax(confirmMessageDeletePath, {
			dataType: 'json',
			success: function (data) {
				confirm(data.message, deletePath);
			}
	});
}

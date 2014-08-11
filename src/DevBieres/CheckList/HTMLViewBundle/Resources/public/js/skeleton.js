

$(document).ready(function() { 
    $('#form_skeleton_new').hide();
});
// Ask for closing form
$('#close').click( function() { 
    $('#form_skeleton_new').hide();
});

$('#open').click( function() { 
    $('#form_skeleton_new').show();
});

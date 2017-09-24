jQuery(document).ready(function($) {
    $("button.test").click(function(){
        $("p.test").text("BOOM!! jQuery is working!");
    });
	$('#pbrx_submit').click(function() {
		$.ajax({
			type: "POST",            // use $_POST request to submit data
			url: pbrx_vars.pbrx_ajax_url,// URL to "wp-admin/admin-ajax.php"
			data: {
				action     : 'pbrx_action', // wp_ajax_*, wp_ajax_nopriv_*
				start     : $('#pbrx-form').serialize(),
				sample_content : 'Sample Content, which',      // PHP: $_POST['first_name']
				checks_functioning  : 'if showing, things are working.',      // PHP: $_POST['last_name']
				whatever   : 'whatever I say goes here',
		      	pbrx_nonce: pbrx_vars.pbrx_nonce,
		      	pbrx_url  : pbrx_vars.pbrx_ajax_url,
		      	pbrx_posted  : pbrx_vars.pbrx_posted,
			},
			success:function( data ) {
				$( '#pbrx-response' ).html( data );
			},
			error: function(){
				console.log(errorThrown); // error
			}
		});
	});
});
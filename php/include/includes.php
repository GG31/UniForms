<?php
ini_set('display_errors', 1);
error_reporting ( E_ALL );
function require_once_UniForms($path) {
	require_once dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/php/' . $path . '.php';
}

require_once_UniForms ( "include/connect" );
require_once_UniForms ( "include/verify_session" );

require_once_UniForms ( "class/User.class" );
require_once_UniForms ( "class/Form.class" );
require_once_UniForms ( "class/Answer.class" );
require_once_UniForms ( "class/Element.class" );
require_once_UniForms ( "class/FormGroup.class" );

require_once_UniForms ( "include/verify_access" );
?>

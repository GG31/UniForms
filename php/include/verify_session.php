<?php
// This file must be included in every page after the login. It verifies if there is a logged user.
session_start ();
if (!isset($_SESSION ["user_id"])) {
   $_SESSION ["user_id"] = 0;
}
?>

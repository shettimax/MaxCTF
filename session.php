<?php
session_name("mctf_session");
session_set_cookie_params([
  'path' => '/',
  'secure' => false,
  'httponly' => true,
  'samesite' => 'Lax'
]);
session_start();
?>

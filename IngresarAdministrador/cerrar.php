<?php
print "Se cerro la sesión";
session_start();
session_destroy();
header("Location:../index.php");
?>
<?php

include_once 'db.php';

$sql1="UPDATE schedule SET zone=2 WHERE group_name='12C3';";
mysqli_query($conn, $sql1);

?>

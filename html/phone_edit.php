<?php
  $edit_phone_id = $_REQUEST['edit_phone_id'];
  $edit_phone_note = $_REQUEST['edit_phone_note'];
  $edit_phone_phone = $_REQUEST['edit_phone_phone'];

  include_once 'db_connect/hupd.php';
  include_once 'address_db_functions.php';

  address_db_header();
  echo "<h1>003</h1>";

  $mysqli = address_db_connect($host, $user, $password, $db, $charset);

  if ($edit_phone_id != '' && $edit_phone_note != '' &&  $edit_phone_phone != '')
    $mysqli->query("UPDATE Phones SET phone='$edit_phone_phone', note='$edit_phone_note' WHERE id=$edit_phone_id");

  phone_form($mysqli, $edit_phone_id, 12);

  $mysqli->close();
?>
</body>
</html>



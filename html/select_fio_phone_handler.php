<?php
  $human_id = $_REQUEST['human_id'];

  $fio_f = $_REQUEST['fio_f'];
  $fio_i = $_REQUEST['fio_i'];
  $fio_o = $_REQUEST['fio_o'];

  $fio_upd_f = $_REQUEST['fio_upd_f'];
  $fio_upd_i = $_REQUEST['fio_upd_i'];
  $fio_upd_o = $_REQUEST['fio_upd_o'];
  $fio_upd_birth = $_REQUEST['fio_upd_birth'];
  $disconnect_phone_id = $_REQUEST['disconnect_phone_id'];

  include_once 'db_connect/hupd.php';
  include_once 'address_db_functions.php';

  address_db_header();
  echo "<h1>002</h1>";

  echo <<<END
  <form action="persons.php">
    <input type="hidden" name="fio_f" value="$fio_f" > 
    <input type="hidden" name="fio_i" value="$fio_i" > 
    <input type="hidden" name="fio_o" value="$fio_o" > 
    <input type="submit" name="submit" value="<"> 
  </form>
END;

  $mysqli = address_db_connect($host, $user, $password, $db, $charset);

  if ($fio_upd_f != '' && $fio_upd_i != '' &&  $fio_upd_o != '')
    $mysqli->query("UPDATE Humans SET f='$fio_upd_f', i='$fio_upd_i', o='$fio_upd_o', birth='$fio_upd_birth' WHERE id=$human_id");

  if ($human_id != '' && $disconnect_phone_id != '')
    $mysqli->query("DELETE FROM Human_Phone WHERE human_id='$human_id' AND phone_id='$disconnect_phone_id' LIMIT 1");

  person_form($mysqli, $human_id, 8);
  persons_phone_list($mysqli,$human_id);



  $mysqli->close();
?>
</body>
</html>



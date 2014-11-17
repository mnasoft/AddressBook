<?php
  $fio_f = $_REQUEST['fio_f'];
  $fio_i = $_REQUEST['fio_i'];
  $fio_o = $_REQUEST['fio_o'];
  

  $fio_add_f = $_REQUEST['fio_add_f'];
  $fio_add_i = $_REQUEST['fio_add_i'];
  $fio_add_o = $_REQUEST['fio_add_o'];
  $fio_add_birth = $_REQUEST['fio_add_birth'];

  $human_id_delete = $_REQUEST['human_id_delete'];

  $this_file = "persons.php";

  include_once 'db_connect/hupd.php';
  include_once 'address_db_functions.php';

  address_db_header();
  echo "<h1>Persons</h1>";

  if ($fio_add_f != '' && $fio_add_i != '' &&  $fio_add_o != '')
  {
    $mysqli = address_db_connect($host, $user, $password, $db, $charset);
    $mysqli->query("INSERT INTO Humans (f,i,o,birth) VALUES ('$fio_add_f','$fio_add_i','$fio_add_o','$fio_add_birth')");
    $mysqli->close();
    echo "$fio_add_f $fio_add_i $fio_add_o - INSERT(ed) INTO Humans";
  }

  if ($human_id_delete != '')
  {
    $mysqli = address_db_connect($host, $user, $password, $db, $charset);

    if (!$mysqli->query("DELETE FROM Humans WHERE id='$human_id_delete' LIMIT 1")) {
      printf("<p>Errorcode: %d</p><p>Error: %s</p>", $mysqli->errno, $mysqli->error);
    }

    $mysqli->close();
  }

  echo "<div class=\"block2\">";
  select_person_by_fiob_form($fio_f,$fio_i,$fio_o,$this_file);
  echo "<hr>";
  fio_add($this_file);
  echo "</div>";

  persons_list($host,$user,$password,$db,$charset,$this_file,$fio_f,$fio_i,$fio_o);

?>

</body>
</html>


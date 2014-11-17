<?php
/* 
   address_db_connect($host, $user, $password, $db, $charset)//Подключение к БД.
   address_db_header()//Заголовок страницы.

   select_person_by_fiob_form($f,$i,$o,$handler, $size=8)//Выполняет отбор персоны оп элементам ФИО.
   fio_add($f,$i,$o,$size="10")//Выполнят добавление персоны.

   person_form($mysqli, $human_id, $size=8)//Диалог для корректировки данных по отдельной персоне.
   persons_phone_list($mysqli,$human_id)//Список телефонов, связанный с отдельной персоной.
   phone_form($mysqli,$phone_id, $size=12)//Корректировка отдельного телефона.

**************************************************************************************************************
   phones_person_list($mysqli,$phone_id)//Список персон, связанный с отдельным телефоном.
   connect_person_phone($mysqli,$phone_id,$human_id)//Создание ассоциациативной связи между персоной и телефоном.
   disconnect_person__phone($mysqli,$phone_id,$human_id)//Удаление ассоциациативной связи между персоной и телефоном.

   phone_parts($phone,$note,$size=8)//Выполняет отбор телефона.

*/

function address_db_connect($host, $user, $password, $db, $charset)//Подключение к БД
{
  $mysqli = new mysqli($host, $user, $password, $db);
  if ($mysqli->connect_errno) /* проверка соединения */
  {
      printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
      exit();
  }

  if (!$mysqli->set_charset($charset)) /* изменение набора символов на $charset */
    printf("Ошибка при загрузке набора символов $charset: %s</br>", $mysqli->error);
  else 
    ;//printf("Текущий набор символов: %s</br>", $mysqli->character_set_name());

  return $mysqli;
}

function select_person_by_fiob_form($f,$i,$o,$handler="select_fio_handler.php",$size=8)//Выполняет отбор персоны оп элементам ФИО
{
echo <<<END
<form action="$handler">
  <table border='2'>
    <caption><input type="submit" value="Отобрать"></caption>
    <tbody>
      <tr>
        <th>Фамилия</th> 
        <td><input type="text" name="fio_f" size="$size" value="$f"></td>  
      </tr>
      <tr>
        <th>Имя</th>
        <td><input type="text" name="fio_i" size="$size" value="$i"></td>
      </tr>
      <tr>
        <th>Отчество</th>   
        <td><input type="text" name="fio_o" size="$size" value="$i"></td>
      </tr>
    <tbody>
  </table>
</form>
END;
}

function fio_add($handler="select_fio_handler.php",$size="10")//Выполнят добавление персоны.
{
echo <<<END

<form action="$handler">
  <table border='2'>
    <caption><input type="submit" value="Добавить"></caption>
    <tbody>
      <tr>
        <th>Фамилия</th> 
        <td><input type="text" name="fio_add_f" size="$size"></td>  
      </tr>
      <tr>
        <th>Имя</th>
        <td><input type="text" name="fio_add_i" size="$size"></td>
      </tr>
      <tr>
        <th>Отчество</th>   
        <td><input type="text" name="fio_add_o" size="$size"></td>
      </tr>
      <tr>
        <th>Д.рожденья</th>   
        <td><input type="text" name="fio_add_birth" size="$size"></td>
      </tr>
    <tbody>
  </table>
</form>
END;
}

function phone_parts($phone,$note,$size=8)//Выполняет отбор телефона.
{
echo <<<END
<form action="select_fio_handler.php">
  <p>Введите атрибуты телефона для отбора - 
    Тел.: <input type="text" name="select_phone" size="$size" value="$f">
    Прим.: <input type="text" name="select_phone_note" size="$size" value="$i">
    <input type="submit" value="Отобрать">
  </p>
</form>
END;
}

function address_db_header()//Заголовок страницы
{
echo <<<END
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>MNAsoft.Адресная книга</title>
  <link rel="stylesheet" type="text/css" href="http://mnasoft.mksat.net/mnasoft_style.css" />
  <meta name="keywords" content="MNASoft,фамилия,имя,отчество,телефон"/>
  <meta name="author" content="Николай Матвеев"/>
  <style type="text/css">
   .block1 { 
    width: 200px; 
    background: #ccc;
    padding: 5px;
    padding-right: 20px; 
    border: solid 1px black; 
    float: left;
   }
   .block2 { 

    background: #fc0; 
    padding: 5px; 
    border: solid 1px black; 
    float: right; 
    position: fixed; 
    top: 10px; 
    right: 10px; 
   }
  </style> 
</head>
<body>
END;
}

function person_form($mysqli, $human_id, $size=8)//Диалог для корректировки данных по отдельной персоне.
{
  /* Select запросы возвращают результирующий набор */
  if ($result = $mysqli->query("SELECT id,f,i,o,birth from `Humans` WHERE id=$human_id")) 
  {
    if ($result->num_rows > 0)
    {
      echo <<<END
      <form action="select_fio_phone_handler.php">
        <table border='2' cols='3'>
          <caption>Персона</caption>
          <tbody>
            <tr> 
              <th>id</th>
              <th>Фамилия</th>
              <th>Имя</th>
              <th>Отчество</th>
              <th>ДР</th>
              <th>Обновить</th>
            </tr>
END;
      while ($row = $result->fetch_assoc())
      {
        echo <<<END
	    <tr>
	      <td> $row[id]</td>
	      <td> <input type="text" name="fio_upd_f" size="$size" value="$row[f]"> </td>
	      <td> <input type="text" name="fio_upd_i" size="$size" value="$row[i]"> </td>
	      <td> <input type="text" name="fio_upd_o" size="$size" value="$row[o]"> </td>
	      <td> <input type="text" name="fio_upd_birth" size="$size" value="$row[birth]"> </td>
	      <td> <input type="submit" name="human_id" value="$row[id]"> </td>
	    <tr>
END;
      }
      echo <<<END
          </tbody>
        </table>
      </form>
END;
    }
    printf("Select вернул %d строк.\n", $result->num_rows);
    $result->close(); // очищаем результирующий набор
  }
}

function persons_phone_list($mysqli,$human_id)//Список телефонов, связанный с отдельной персоной
{
  if ($result = $mysqli->query("SELECT Phones.id,phone,note FROM Humans,Phones,Human_Phone WHERE Human_Phone.human_id=Humans.id AND Human_Phone.phone_id=Phones.id AND Humans.id=$human_id")) 
  {
    if ($result->num_rows > 0)
    {
      echo <<<END
        
          <table border="2">
            <caption>Список телефонов</caption>
            <tbody>
              <tr> 	
                <th>id</th>
                <th>Телефон</th>
                <th>Комментарий</th>
                <th>Изменить</th> 
                <th>Отсоединить</th> 	
              </tr>
END;
      while ($row = $result->fetch_assoc())
      {
        echo <<<END
	      <tr> 
	        <td>$row[id]</td>
                <td>$row[phone]</td>
                <td>$row[note]</td>
                <form action="phone_edit.php"> <td> <input type="submit" name="edit_phone_id" value="$row[id]"> </td></form>
              <form action="select_fio_phone_handler.php"> 
                <input type="hidden" name="human_id" value="$human_id" > 
                <td> <input type="submit" name="disconnect_phone_id" value="$row[id]"> </td> 
              </form>
                
	      </tr>
END;
      }
      echo <<<END
            </tbody>
          </table>
END;
//          <p><input type="submit"></p>
    }
    printf("Select вернул %d строк.\n", $result->num_rows);    
    $result->close(); // очищаем результирующий набор
  }
}

function phone_form($mysqli,$phone_id, $size=12)//Корректировка отдельного телефона.
{
  /* Select запросы возвращают результирующий набор */
  if ($result = $mysqli->query("SELECT id,phone,note FROM `Phones` WHERE id=$phone_id")) 

  {
    if ($result->num_rows > 0)
    {
      echo <<<END
      <form action="phone_edit.php">
        <table border='2' cols='3'>
          <caption>Телефон</caption>
          <tbody>
            <tr> 
              <th>id</th>
              <th>phone</th>
              <th>note</th>
              <th>Обновить</th>
            </tr>
END;
      while ($row = $result->fetch_assoc())
      {
        echo <<<END
	    <tr>
	      <td> $row[id]</td>
	      <td> <input type="text" name="edit_phone_phone" size="$size" value="$row[phone]"> </td>
	      <td> <input type="text" name="edit_phone_note" size="$size" value="$row[note]"> </td>
	      <td> <input type="submit" name="edit_phone_id" value="$row[id]"> </td>
	    <tr>
END;
      }
      echo <<<END
          </tbody>
        </table>
      </form>
END;
    }
    printf("Запрос вернул %d строк%s.\n", $result->num_rows, 
        $this->numberOf($result->num_rows, array(0=>"у",1=>"и",2=>"",)));
    $result->close(); // очищаем результирующий набор
  }
}

function persons_list($host,$user,$password,$db,$charset,$handler="select_fio_phone_handler.php",$fio_f="-",$fio_i="-",$fio_o="-")
{
  $mysqli = address_db_connect($host, $user, $password, $db, $charset);

  if ($result = $mysqli->query("SELECT id,f,i,o from `Humans` WHERE f LIKE '%$fio_f%' AND i LIKE '%$fio_i%' AND o LIKE '%$fio_o%' ORDER BY f,i,o"))   // Select запросы возвращают результирующий набор
  {
    if ($result->num_rows > 0)
    {
      echo <<<END
  <table border='2'>
    <caption>Список персон</caption>
    <tbody>
      <tr> 
        <th>id</th>
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th>Phones</th>
        <th>Delete</th>
      </tr>
END;
      while ($row = $result->fetch_assoc())
      {
        echo <<<END
      <tr> 
        <td>$row[id]</td> 
        <td>$row[f]</td> 
        <td>$row[i]</td> 
        <td>$row[o]</td>
      <form action="select_fio_phone_handler.php">
        <input type="hidden" name="fio_f" value="$fio_f" > 
        <input type="hidden" name="fio_i" value="$fio_i" > 
        <input type="hidden" name="fio_o" value="$fio_o" > 
        <td> <input type="submit" name="human_id" value="$row[id]"> </td>
      </form>
      <form action="$handler">
        <input type="hidden" name="fio_f" value="$fio_f" > 
        <input type="hidden" name="fio_i" value="$fio_i" > 
        <input type="hidden" name="fio_o" value="$fio_o" > 
        <td> <input type="submit" name="human_id_delete" value="$row[id]"> </td>
      </form>
      </tr>
END;
      }
      echo <<<END
    </tbody>
  </table>
END;
    }
    printf("Запрос вернул %d строк%s.\n", $result->num_rows, 
        $this->numberOf($result->num_rows, array(0=>"у",1=>"и",2=>"",)));
    );    // очищаем результирующий набор.
    $result->close();
  }
  $mysqli->close();
}

?>

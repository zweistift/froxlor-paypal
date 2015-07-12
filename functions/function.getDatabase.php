<?php
function getDatabase($db, $query){
  $location = "localhost";
  $username = "";
  $password = "";
  if (isset($db) && isset($query)){
    $connection = new mysqli($location, $username, $password, $db);
    if($connection->connect_errno > 0){
      return("DB Connection Error");
    }
    $sql = $query;
    if(!$result = $connection->query($sql)){
      return("SQL Querr Error");
    }
  }
  else{
    return("Idiot. You forgot to insert a Query or a DB-Name);
  }
}
?>

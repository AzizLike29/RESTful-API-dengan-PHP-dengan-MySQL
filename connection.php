<?php
// membuat suatu objek
class dbObject
{
  // variabel untuk menghubungkan ke database
  var $servername = "localhost";
  var $username = "root";
  var $password = "";
  var $dbname = "db_datakampus";
  var $conn;
  function getConnstring()
  {
    $con = mysqli_connect(
      $this->servername,
      $this->username,
      $this->password,
      $this->dbname,
    ) or
      die("Connection failed: " . mysqli_connect_error());
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    } else {
      $this->conn = $con;
    }
    return $this->conn;
  }
}

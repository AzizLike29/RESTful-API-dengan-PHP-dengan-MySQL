<?php
include("./connection.php");

function get_kampus()
{
  global $connection;
  $query = "SELECT * FROM tb_kampus";
  $response = array();
  $result = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_array($result)) {
    $response[] = array("nama" => $row["nama_kampus"], "id " => $row["id"], "daerah_kampus" => $row["daerah"], "jumlah_mahasiswa" => $row["jumlah_mahasiswa"]);
  }
  header('Content-Type: application/json');
  echo json_encode($response);
}

function get_kampusById($id = 0)
{
  global $connection;
  $query = "SELECT * FROM tb_kampus";
  if ($id != 0) {
    $query .= " WHERE id=" . $id . " LIMIT 1";
  }
  $response = array();
  $result = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_array($result)) {
    $response[] = array("nama" => $row["nama_kampus"], "id " => $row["id"], "daerah_kampus" => $row["daerah"], "jumlah_mahasiswa" => $row["jumlah_mahasiswa"]);
  }
  header('Content-Type: application/json');
  echo json_encode($response);
}

function insert_kampus()
{
  global $connection;
  $data = json_decode(file_get_contents('php://input'), true);
  $nama_kampus = $data["nama_kampus"];
  $daerah_kampus = $data["daerah"];
  $jumlah_mahasiswa = $data["jumlah_mahasiswa"];
  echo $query = "INSERT INTO tb_kampus SET 
     nama_kampus='" . $nama_kampus . "', 
     daerah='" . $daerah_kampus . "', 
    jumlah_mahasiswa='" . $jumlah_mahasiswa . "'";
  if (mysqli_query($connection, $query)) {
    $response = array(
      'status' => 1,
      'status_message' => 'Kampus Added Successfully.'
    );
  } else {
    $response = array(
      'status' => 0,
      'status_message' => 'Kampus Addition Failed.'
    );
  }
  header('Content-Type: application/json');
  echo json_encode($response);
}

function update_kampus($id)
{
  global $connection;
  $post_vars = json_decode(file_get_contents("php://input"), true);
  $nama_kampus = $post_vars["nama_kampus"];
  $daerah = $post_vars["daerah"];
  $jumlah_mahasiswa = $post_vars["jumlah_mahasiswa"];
  $query = "UPDATE tb_kampus SET nama_kampus='" . $nama_kampus . "', 
     daerah='" . $daerah . "', 
    jumlah_mahasiswa='" . $jumlah_mahasiswa . "' WHERE id=" . $id;
  if (mysqli_query($connection, $query)) {
    $response = array(
      'status' => 1,
      'status_message' => 'Kampus Updated Successfully.'
    );
  } else {
    $response = array(
      'status' => 0,
      'status_message' => 'Kampus Updation Failed.'
    );
  }
  header('Content-Type: application/json');
  echo json_encode($response);
}

function delete_kampus($id)
{
  global $connection;
  $query = "DELETE FROM tb_kampus WHERE id=" . $id;
  if (mysqli_query($connection, $query)) {
    $response = array(
      'status' => 1,
      'status_message' => 'Kampus Deleted Successfully.'
    );
  } else {
    $response = array(
      'status' => 0,
      'status_message' => 'Kampus Deletion Failed.'
    );
  }
  header('Content-Type: application/json');
  echo json_encode($response);
}


$db = new dbObject();
$connection = $db->getConnstring();
$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
  case 'GET':
    // Retrive Products
    if (!empty($_GET["id"])) {
      $id = intval($_GET["id"]);
      get_kampusById($id);
    } else {
      get_kampus();
    }
    break;
  case 'POST':
    // Insert Product
    insert_kampus();
    break;
  case 'PUT':
    // Update Product
    $id = intval($_GET["id"]);
    update_kampus($id);
    break;
  case 'DELETE':
    // Delete Product
    $id = intval($_GET["id"]);
    delete_kampus($id);
    break;
  default:
    // Invalid Request Method
    header("HTTP/1.0 405 Method Not Allowed");
    break;
}

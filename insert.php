<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            get_posts($id);
        } else {
            get_posts();
        }
        break;
    case 'POST':
        insert_post();
        break;
    case 'PUT':
        $id = intval($_GET["id"]);
        update_post($id);
        break;
    case 'DELETE':
        $id = intval($_GET["id"]);
        delete_post($id);
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_posts($id=0) {
    global $conn;
    $query = "SELECT * FROM posts";
    if($id != 0) {
        $query .= " WHERE id=$id LIMIT 1";
    }
    $response = array();
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
    echo json_encode($response);
}

function insert_post() {
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    $title = $data["title"];
    $content = $data["content"];
    $author_id = $data["author_id"];
    $query = "INSERT INTO posts (title, content, author_id) VALUES ('$title', '$content', $author_id)";
    if($conn->query($query)) {
        $response=array(
            'status' => 1,
            'status_message' =>'Post Added Successfully.'
        );
    } else {
        $response=array(
            'status' => 0,
            'status_message' =>'Post Addition Failed.'
        );
    }
    echo json_encode($response);
}

function update_post($id) {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    $title = $data["title"];
    $content = $data["content"];
    $author_id = $data["author_id"];
    $query="UPDATE posts SET title='$title', content='$content', author_id=$author_id WHERE id=$id";
    if($conn->query($query)) {
        $response=array(
            'status' => 1,
            'status_message' =>'Post Updated Successfully.'
        );
    } else {
        $response=array(
            'status' => 0,
            'status_message' =>'Post Updation Failed.'
        );
    }
    echo json_encode($response);
}

function delete_post($id) {
    global $conn;
    $query = "DELETE FROM posts WHERE id=$id";
    if($conn->query($query)) {
        $response=array(
            'status' => 1,
            'status_message' =>'Post Deleted Successfully.'
        );
    } else {
        $response=array(
            'status' => 0,
            'status_message' =>'Post Deletion Failed.'
        );
    }
    echo json_encode($response);
}

$conn->close();
?>

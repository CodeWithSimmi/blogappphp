<?php
include '../db.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;

$sql = "DELETE FROM posts WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Post deleted successfully"]);
} else {
    echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>

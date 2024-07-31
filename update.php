<?php
include '../db.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$title = $data->title;
$content = $data->content;
$author = $data->author;

$sql = "UPDATE posts SET title='$title', content='$content', author='$author' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Post updated successfully"]);
} else {
    echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>

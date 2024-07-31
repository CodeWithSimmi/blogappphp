<?php
include '../db.php';

$data = json_decode(file_get_contents("php://input"));

$title = $data->title;
$content = $data->content;
$author = $data->author;

$sql = "INSERT INTO posts (title, content, author) VALUES ('$title', '$content', '$author')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Post created successfully"]);
} else {
    echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>

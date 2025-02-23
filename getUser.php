<?php
header('Content-Type: application/json');
$users = [];
if (file_exists("users.json")) {
    $jsonData = file_get_contents("users.json");
    $users = json_decode($jsonData, true);
    if (!is_array($users)) {
        $users = [];
    }
}
echo json_encode($users);
?>

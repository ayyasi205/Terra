<?php
$db_file = __DIR__ . '/../database.json';
if (!file_exists($db_file)) {
    // Fallback if database.json doesn't exist
    $data = ["mountains" => [], "users" => [], "tickets" => []];
    file_put_contents($db_file, json_encode($data, JSON_PRETTY_PRINT));
} else {
    $data = json_decode(file_get_contents($db_file), true);
}

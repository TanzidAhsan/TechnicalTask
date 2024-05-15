<?php
$conn = new mysqli("localhost", "root", "", "DynamicTextboxDB");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numbers = $_POST['numbers'];
    $checkboxes = $_POST['checkboxes'];
    $selected_numbers = [];
    $total = 0;

    foreach ($checkboxes as $index) {
        $total += $numbers[$index];
        $selected_numbers[] = $numbers[$index];
    }

    $selected_numbers_str = implode(", ", $selected_numbers);
    $stmt = $conn->prepare("INSERT INTO TextboxData (selected_numbers, total) VALUES (?, ?)");
    $stmt->bind_param("si", $selected_numbers_str, $total);
    $stmt->execute();
    $stmt->close();
    header("Location: summary.php");
}
?>

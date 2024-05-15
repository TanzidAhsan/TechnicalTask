<?php
$conn = new mysqli("localhost", "root", "", "DynamicTextboxDB");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM TextboxData");
echo "<h1>Summary</h1>";
while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . " - Selected Numbers: " . $row['selected_numbers'] . " - Total: " . $row['total'] . "<br>";
}
$conn->close();
?>

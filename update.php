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
         
        if (isset($numbers[$index])) {
            $total += $numbers[$index];
            $selected_numbers[] = $numbers[$index];
        }
    }

    $selected_numbers_str = implode(", ", $selected_numbers);
    $id = $_POST['id'];   

    $stmt = $conn->prepare("UPDATE TextboxData SET selected_numbers = ?, total = ? WHERE id = ?");
    $stmt->bind_param("sii", $selected_numbers_str, $total, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: summary.php");  
} else {
     
    $result = $conn->query("SELECT * FROM TextboxData ORDER BY id DESC LIMIT 1");
    if ($data = $result->fetch_assoc()) {
        echo '<form method="post">';
        echo '<input type="hidden" name="id" value="' . $data['id'] . '">';   

        $existing_numbers = explode(", ", $data['selected_numbers']);
        foreach ($existing_numbers as $index => $value) {
            echo '<div class="textbox"><input type="number" name="numbers[]" value="' . $value . '"><input type="checkbox" name="checkboxes[]" value="' . $index . '" checked></div>';
        }
        echo '<button type="submit">Update</button>';
        echo '</form>';
    } else {
        echo 'No data found to update.';
    }
}
?>

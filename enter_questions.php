<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

require_once "config.php"; // Include your database configuration

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question_text = $_POST["question_text"];
    $option_a = $_POST["option_a"];
    $option_b = $_POST["option_b"];
    $option_c = $_POST["option_c"];
    $correct_option = strtoupper($_POST["correct_option"]);

    $stmt = $conn->prepare("INSERT INTO questions (question_text, option_a, option_b, option_c, correct_option) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $question_text, $option_a, $option_b, $option_c, $correct_option);

    if ($stmt->execute()) {
        echo "Question added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Questions</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Enter Questions</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="question_text">Question Text:</label>
        <input type="text" name="question_text" required>
        <br>
        <label for="option_a">Option A:</label>
        <input type="text" name="option_a" required>
        <br>
        <label for="option_b">Option B:</label>
        <input type="text" name="option_b" required>
        <br>
        <label for="option_c">Option C:</label>
        <input type="text" name="option_c" required>
        <br>
        <label for="correct_option">Correct Option (A, B, or C):</label>
        <input type="text" name="correct_option" required>
        <br><br>
        <input type="submit" value="Add Question">
    </form>
</body>
</html>

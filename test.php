<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

require_once "config.php"; // Include your database configuration

// Fetch questions from the database
$query = "SELECT * FROM questions";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $questions = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No questions found.";
    exit();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assume form fields are named 'answer_1', 'answer_2', etc.
    $score = 0;

    foreach ($questions as $key => $question) {
        $user_answer = strtoupper($_POST["answer_" . ($key + 1)]);
        $correct_answer = $question["correct_option"];

        if ($user_answer == $correct_answer) {
            $score++;
        }
    }

    echo "Your score: $score / " . count($questions);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Test Page</title>
</head>
<body>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="container-fluid">
    <div class="modal-dialog">
        <div class="modal-content">
    <div class="modal-header">
                <?php foreach ($questions as $key => $question): ?>
                    <h3><?php echo $question["question_text"]; ?></h3>
            </div>
            <div class="modal-body">
                <div class="col-xs-3 5"> </div>
                <div class="quiz" id="quiz" data-toggle="buttons"> 
            <label class="element-animation1 btn btn-lg btn-danger btn-block" for="answer_<?php echo $key + 1; ?>_a">
            <span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> 
                <input type="radio" name="answer_<?php echo $key + 1; ?>" value="A" required>
                <?php echo $question["option_a"]; ?>
            </label>
            <br>
            <label class="element-animation1 btn btn-lg btn-danger btn-block" for="answer_<?php echo $key + 1; ?>_b">
            <span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> 
                <input type="radio" name="answer_<?php echo $key + 1; ?>" value="B">
                <?php echo $question["option_b"]; ?>
            </label>
            <br>
            <label class="element-animation1 btn btn-lg btn-danger btn-block" for="answer_<?php echo $key + 1; ?>_c">
            <span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> 
                <input type="radio" name="answer_<?php echo $key + 1; ?>" value="C">
                <?php echo $question["option_c"]; ?>
            </label>
            </div>
            </div>
        </div>
    </div>
            <br><br>
        <?php endforeach; ?>
        <input class ="btn" type="submit" value="Submit">
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

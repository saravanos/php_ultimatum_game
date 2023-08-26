<!DOCTYPE html>
<html>
<head>
    <title>Ultimatum Game</title>
    <style>
        /* CSS styles go here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        /* ... Other CSS styles ... */
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php
    // Database connection setup
    $dbHost = "localhost";
    $dbUser = "saravano_game";
    $dbPass = "zxcDSA123!!!";
    $dbName = "saravano_game";

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // ... Existing code ...

        // Rest of the game logic...
        // ... Existing PHP code ...

        // Save additional Likert responses after game ends
        $q3Response = $_POST["q3"];
        $q4Response = $_POST["q4"];

        // Insert additional Likert responses into the database
        $insertFeedbackQuery = "INSERT INTO feedback_responses (question_3, question_4) VALUES (?, ?)";
        $stmtFeedback = $conn->prepare($insertFeedbackQuery);
        $stmtFeedback->bind_param("ii", $q3Response, $q4Response);
        $stmtFeedback->execute();

        // Generate and store a random compensation code
        $compensationCode = generateRandomCode();
        $insertCompensationCodeQuery = "INSERT INTO compensation_codes (code) VALUES (?)";
        $stmtCode = $conn->prepare($insertCompensationCodeQuery);
        $stmtCode->bind_param("s", $compensationCode);
        $stmtCode->execute();
    }

    function generateRandomCode() {
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $code = "";
        for ($i = 0; $i < 8; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $code .= $characters[$randomIndex];
        }
        return $code;
    }
    ?>

    <h1 class="title">Ultimatum Game</h1>

    <!-- Likert scale questions for participants -->
    <h2>Participant Questionnaire</h2>
    <p>Please rate the following statements:</p>
    <div id="likertQuestions">
        <!-- ... Existing Likert questions ... -->
    </div>
    <button id="startGame">Start Game</button>

    <!-- Player 1's view -->
    <div id="player1" class="view">
        <!-- ... Existing Player 1's view HTML ... -->
    </div>

    <!-- Player 2's view -->
    <div id="player2" class="view">
        <!-- ... Existing Player 2's view HTML ... -->
    </div>

    <!-- Results view -->
    <div id="results" class="view">
        <!-- ... Existing Results view HTML ... -->
    </div>

    <!-- Additional Likert scale questions after the game ends -->
    <div id="likertQuestionsEnd" style="display: none;">
        <!-- ... Additional Likert questions ... -->
        <button id="submitFeedback">Submit Feedback</button>
    </div>

    <!-- Thank you and compensation code -->
    <div id="thankYou" style="display: none;">
        <h2>Thank You!</h2>
        <p>Thank you for participating in the game and providing your feedback.</p>
        <p>Your compensation code is: <span id="compensationCode"></span></p>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ... Existing JavaScript code ...

            const likertQuestionsEnd = document.getElementById("likertQuestionsEnd");
            const submitFeedbackButton = document.getElementById("submitFeedback");
            const thankYouMessage = document.getElementById("thankYou");
            const compensationCodeElement = document.getElementById("compensationCode");

            submitFeedbackButton.addEventListener("click", function() {
                likertQuestionsEnd.style.display = "none";
                thankYouMessage.style.display = "block";
                const q3Response = document.querySelector('input[name="q3"]:checked').value;
                const q4Response = document.querySelector('input[name="q4"]:checked').value;
                sendData(q3Response, q4Response); // Send feedback to the server

                // Generate and display a random compensation code
                const compensationCode = generateRandomCode();
                compensationCodeElement.textContent = compensationCode;
            });

            // ... Existing JavaScript code ...
        });
    </script>
</body>
</html>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Placeholder database credentials - replace with your actual credentials
        $dbHost = "localhost";
        $dbUser = "saravano_game";
        $dbPass = "zxcDSA123!!!";
        $dbName = "saravano_game";

        // Connect to the database
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get the timestamp from POST data
        $timestamp = $_POST['time'];

        // Insert the timestamp into the database
        $sql = "INSERT INTO consent_records (timestamp) VALUES ('$timestamp')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }

        // Close the connection
        $conn->close();
        exit;
    }

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $q1Response = $_POST["q1"];
        $q2Response = $_POST["q2"];

        // Insert Likert responses into the database
        $insertLikertQuery = "INSERT INTO likert_responses (question_1, question_2) VALUES (?, ?)";
        $stmt = $conn->prepare($insertLikertQuery);
        $stmt->bind_param("ii", $q1Response, $q2Response);
        $stmt->execute();

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
<!DOCTYPE html>
<html>
    <head>
        <title>Ultimatum Game 2</title>
        <style>
            /* CSS styles go here */
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }

            .title {
                text-align: center;
                padding: 20px;
                font-size: 28px;
                color: #333;
            }

            .view {
                display: none;
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                margin: 20px auto;
                max-width: 400px;
            }

            .label {
                display: block;
                margin-bottom: 10px;
                font-weight: bold;
            }

            .input {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            .button {
                display: inline-block;
                background-color: #007bff;
                color: #fff;
                border: none;
                padding: 10px 20px;
                cursor: pointer;
                border-radius: 4px;
            }

            .button:hover {
                background-color: #0056b3;
            }

            .result {
                margin-top: 10px;
                font-size: 14px;
            }

            .proposal {
                font-size: 16px;
            }

            .amount {
                font-weight: bold;
            }

            .subtitle {
                font-size: 24px;
                margin-bottom: 10px;
                color: #333;
            }

            .table {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #ccc;
            }

            .table th, .table td {
                padding: 10px;
                text-align: left;
                border-bottom: 1px solid #ccc;
            }

            .table th {
                font-weight: bold;
                background-color: #f2f2f2;
            }

            .table tr:last-child td {
                border-bottom: none;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- jQuery UI -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    </head>
    <body>
        <div id="consentPage" class="view">
            <h2>Consent to Participate</h2>
            <p>Do you consent to participate in the Ultimatum Game 2?</p>
            <button id="consentYes" class="button">Yes</button>
        </div>

        <!-- Likert scale questions for participants -->
        <h2>Participant Questionnaire</h2>
        <p>Please rate the following statements:</p>
        <div id="page-likertQuestions" class="view">
            <p>1. I am excited to participate in this game:</p>
            <label><input type="radio" name="q1" value="1"> Strongly Disagree</label>
            <label><input type="radio" name="q1" value="2"> Disagree</label>
            <label><input type="radio" name="q1" value="3"> Neutral</label>
            <label><input type="radio" name="q1" value="4"> Agree</label>
            <label><input type="radio" name="q1" value="5"> Strongly Agree</label>

            <p>2. I feel uncertain about the outcome of the game:</p>
            <label><input type="radio" name="q2" value="1"> Strongly Disagree</label>
            <label><input type="radio" name="q2" value="2"> Disagree</label>
            <label><input type="radio" name="q2" value="3"> Neutral</label>
            <label><input type="radio" name="q2" value="4"> Agree</label>
            <label><input type="radio" name="q2" value="5"> Strongly Agree</label>
        </div>
        <button id="startGame" class="button">Start Game</button>

        <!-- Player 1's view -->
        <div id="page-player1" class="view">
            <label for="proposal" class="label">Player 1's Proposal: $</label>
            <input type="number" id="proposal" class="input" min="0" max="100" step="1">
        <button id="submit" class="ui-btn ui-btn-b ui-corner-all">Submit Proposal</button>
            <p id="result" class="result"></p>
        </div>

        <!-- Player 2's view -->
        <div id="player2" class="view">
            <p class="proposal">Player 1 proposes to give you: <span id="proposalAmount" class="amount"></span></p>
            <button id="accept" class="ui-btn ui-btn-b ui-corner-all">Accept</button>
            <button id="reject" class="ui-btn ui-btn-b ui-corner-all">Reject</button>
            <p id="result" class="result"></p>
        </div>

        <!-- Results view -->
        <div id="results" class="view">
            <h2 class="subtitle">Results</h2>
            <table class="table">
                <tr>
                    <th>Player 1 ID</th>
                    <th>Player 1 Proposal</th>
                    <th>Player 2 Decision</th>
                    <th>Player 1 Payoff</th>
                    <th>Player 2 Payoff</th>
                </tr>
                <!-- Display the results here -->
            </table>
        </div>

        <!-- Additional Likert scale questions after the game ends -->
        <div id="likertQuestionsEnd" class="view">
            <h2>Participant Feedback</h2>
            <p>Please rate the following statements:</p>
            <p>3. I enjoyed participating in the game:</p>
            <label><input type="radio" name="q3" value="1"> Strongly Disagree</label>
            <label><input type="radio" name="q3" value="2"> Disagree</label>
            <label><input type="radio" name="q3" value="3"> Neutral</label>
            <label><input type="radio" name="q3" value="4"> Agree</label>
            <label><input type="radio" name="q3" value="5"> Strongly Agree</label>

            <p>4. I felt satisfied with my decisions during the game:</p>
            <label><input type="radio" name="q4" value="1"> Strongly Disagree</label>
            <label><input type="radio" name="q4" value="2"> Disagree</label>
            <label><input type="radio" name="q4" value="3"> Neutral</label>
            <label><input type="radio" name="q4" value="4"> Agree</label>
            <label><input type="radio" name="q4" value="5"> Strongly Agree</label>

            <button id="submitFeedback" class="ui-btn ui-btn-b ui-corner-all">Submit Feedback</button>
        </div>

        <!-- Thank you and compensation code -->
        <div id="thankYou" class="view">
            <h2>Thank You!</h2>
            <p>Thank you for participating in the game and providing your feedback.</p>
            <p>Your compensation code is: <span id="compensationCode"></span></p>
        </div>

    <script>
        $(document).ready(function() {
            // Display consent page initially
            $('#consentPage').show();

            $('#consentYes').on('click', function() {
                // Record the consent in the database
                $.post('record_consent.php', { time: new Date().toISOString() }, function(data) {
                    if (data.success) {
                        $('#consentPage').hide();
                        // Display the next part of your game or instructions here
                    } else {
                        alert('Error recording consent. Please try again.');
                    }
                });
            });
        });

        $(function() {
            $(".button").button();
        });

        document.addEventListener("DOMContentLoaded", function() {
            // ... Existing JavaScript code ...

            const likertQuestions = document.getElementById("likertQuestions");
            const startGameButton = document.getElementById("startGame");

            startGameButton.addEventListener("click", function() {
                likertQuestions.style.display = "none";
                switchToPlayer2View();
            });

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
        });
        </script>
    </body>
</html
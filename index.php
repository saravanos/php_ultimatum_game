<!DOCTYPE html>
    <html>
        <head>
            <title>Ultimatum Game 3</title>
            <!-- jQuery UI -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.min.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
            <link rel="stylesheet" type="text/css" href="styles.css">
            <script>

                var player1order = ["consentPage", "likertQuestions", "page-both1", "page-both2", "page-both3", "page-both4", "page-player1-view1", "page-player1-view2", "page-both5", "page-player1-view3", "results", "likertQuestionsEnd", "thankYou"];
                var player2order = ["consentPage", "likertQuestions", "page-both1", "page-both2", "page-both3", "page-both4", "page-player2-view1", "page-player2-view2", "page-both5", "page-player2-view3", "results", "likertQuestionsEnd", "thankYou"];

                var role = assignRole();// 1 to indicate player1 or 2 to indicate player2
                var playerPosition = 0; // which page the player is on

                var player1offer = -1; // amount of offer, from 0 to 100, -1 indicated unset
                var player2decision = -1; // 0 to indicate offer was rejected 1 to indicate offer was accepted, -1 indicated unset

                function assignRole() {
                    return Math.floor(Math.random() * 2) + 1; // This will return either 1 or 2
                }
alert("xxx2");
                // Function to switch to the next view in the player1order array
                function switchToNextView() {
                    if (playerPosition < player1order.length) {
                        const nextPage = player1order[playerPosition];
                        $(".view").hide();
                        $("#" + nextPage).show();
                    }
                }

                // Event listener for the "Start Game" button
                startGameButton.addEventListener("click", function() {
                    likertQuestions.style.display = "none";
                    playerPosition++; // Move to the first player 1 view
                    switchToNextView();
                });


                $(".accept-button").click(function() {
                    // Handle accept logic here
                    playerPosition++; // Increment position
                    switchToView(role, playerPosition);
                });

                $(".reject-button").click(function() {
                    // Handle reject logic here
                    playerPosition++; // Increment position
                    switchToView(role, playerPosition);
                });

                $(document).ready(function() {
                    alert("Hi");
                    // Display consent page initially
                    $('#consentPage').show();  /*

                    $('#consentForm').on('submit', function(event) {
                        event.preventDefault();

                        if ($('#consentCheckbox').prop('checked')) {
                            // Record the consent in the database
                            $.post('record_consent.php', { time: new Date().toISOString() }, function(data) {
                                if (data.success) {
                                    $('#consentPage').hide();
                                } else {
                                    alert('Error recording consent. Please try again.');
                                }
                            });
                        } else {
                            alert('You must consent to participate.');
                        } */
                    });
    /*
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
                    }); */
                </script>
            </head>
        <body>
            <div id="consentPage" class="view">
                <h2>Consent to Participate</h2>
                <p>Do you consent to participate in the Ultimatum Game 2?</p>
                <form id="consentForm">
                    <label>
                        <input type="checkbox" id="consentCheckbox" required>
                        I consent to participate
                    </label>
                    <br>
                    <button id="consentSubmit" class="button" type="submit">Submit</button>
                </form>
            </div>

            <!-- Likert scale questions for participants -->
            <div id="page-likertQuestions" class="view">
                <h2>Participant Questionnaire</h2>
                <p>Please rate the following statements:</p>

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
                <button id="startGame" class="button">Submit</button>
            </div>

            <!-- Player 1's view -->
            <div id="page-both1" class="view">
                <label for="proposal" class="label">Ultimatum Game

                                                    1. Participants are matched in pairs.

                                                    2. Within each pair, one participant is assigned to Role A, while the other participant is assigned to Role B.

                                                    3. A makes an offer about how to allocate 100 units between A and B. A can offer X units to B, where 0 ≤ X ≤ 100. A would keep (100-X) units.

                                                    4. B decides whether to accept or reject A's offer. If B accepts the offer, A gets (100-X) units and B gets X units. If B rejects the offer, both participants get 0.

                                                    5. The experiment concludes.</label>
                <input type="number" id="proposal" class="input" min="0" max="100" step="1">
                <button id="submit" class="ui-btn ui-btn-b ui-corner-all">Start Experiment</button>
                <p id="result" class="result"></p>
            </div>


            <!-- Player 1's view -->
            <div id="page-both2" class="view">
                <label for="proposal" class="label">On the next screen, you will be matched with another participant.</label>
                <input type="number" id="proposal" class="input" min="0" max="100" step="1">
                <button id="submit" class="ui-btn ui-btn-b ui-corner-all">Next</button>
                <p id="result" class="result"></p>
            </div>

            <!-- Player 1's view -->
            <div id="page-both3" class="view">
                <label for="proposal" class="label">We are currently trying to match you with other participant(s).
                                                    Please wait patiently to be matched. This may take a few minutes.
                                                    Please do NOT minimize this window or navigate to another page.

                                                    (icon circle turning to indicate waiting)

                                                    Waiting for 1 participant(s) to join.</label>
                <input type="number" id="proposal" class="input" min="0" max="100" step="1">
                <button id="submit" class="ui-btn ui-btn-b ui-corner-all">Submit Proposal</button>
                <p id="result" class="result"></p>
            </div>

            <!-- Player 1's view -->
            <div id="page-both4" class="view">
                <label for="proposal" class="label">You have been successfully matched with another participant.</label>
                <input type="number" id="proposal" class="input" min="0" max="100" step="1">
                <button id="submit" class="ui-btn ui-btn-b ui-corner-all">Next</button>
                <p id="result" class="result"></p>
            </div>

            <!-- Player 1's view -->
            <div id="page-player1-view1" class="view">
                <label for="proposal" class="label">You have been assigned to Role A.

                                                    Your task is to allocate 100 units between you and B.

                                                    Please use the box below to indicate how many units (0-100) to offer to B. B will then make a decision whether to accept or reject this offer.

                                                    If B accepts your offer, he or she will get the units you offered to them, and you will keep the rest of the 100 units.
                                                    If B rejects your offer, both of you will get 0 units.

                                                    Your offer to B (0-100):</label>
                <input type="number" id="proposal" class="input" min="0" max="100" step="1">
                <button id="submit" class="ui-btn ui-btn-b ui-corner-all">Submit Proposal</button>
                <p id="result" class="result"></p>
            </div>

            <!-- Player 2's view -->
            <div id="page-player2-view1" class="view">
                <p class="proposal">You have been assigned to Role B.

                                    The other participant (A) will make an offer about allocating 100 units between him/her and you.
                                    Then, you can either accept or reject A's offer.

                                    If you accept A's offer, you will receive whatever amount A has offered you, and A will receive the rest of the 100 units.
                                    If you reject A's offer, both of you will get 0 units.

                                    On the next screen, you will have to wait until A makes a decision. <span id="proposalAmount" class="amount"></span></p>
                <button id="accept" class="ui-btn ui-btn-b ui-corner-all">Next</button>
                <p id="result" class="result"></p>
            </div>

             <!-- Player 1's view -->
            <div id="page-player1-view2" class="view">
                <label for="proposal" class="label">You offered 100 units to B.

                                                    On the next screen, you will have to wait until B makes a decision:</label>
                <input type="number" id="proposal" class="input" min="0" max="100" step="1">
                <button id="submit" class="ui-btn ui-btn-b ui-corner-all">Confirm</button>
                <p id="result" class="result"></p>
            </div>

            <!-- Player 1's view -->
            <div id="page-both5" class="view">
                <label for="proposal" class="label">waiting for 1 participant(s)</label>
                <input type="number" id="proposal" class="input" min="0" max="100" step="1">
                <button id="submit" class="ui-btn ui-btn-b ui-corner-all">Confirm</button>
                <p id="result" class="result"></p>
            </div>

            <!-- Player 2's view -->
            <div id="page-player2-view2" class="view">
                <p class="proposal">A has offered you 100 units.
                                    A would keep 0 units.

                                    Do you accept or reject this offer? <span id="proposalAmount" class="amount"></span></p>
                <button id="acceptButton" class="ui-btn ui-btn-b ui-corner-all">I accept A's offer (You get 100 units A gets 0 units)</button>
                <button id="rejectButton" class="ui-btn ui-btn-b ui-corner-all">I reject A's offer (You get 0 units A gets 0 units)</button>
                <p id="result" class="result"></p>
            </div>

            <!-- Player 2's view -->
            <div id="page-player1-view3" class="view">
                <p class="proposal">B has accepted your offer.

                                    You got 0 units and B got 100 units.<span id="proposalAmount" class="amount"></span></p>
                <button id="accept" class="ui-btn ui-btn-b ui-corner-all">Next</button>
                <p id="result" class="result"></p>
            </div>

             <!-- Player 2's view -->
            <div id="page-player2-view3" class="view">
                <p class="proposal">You have decided to accept A's offer.
                                    You got 100 units and A got 0 units.<span id="proposalAmount" class="amount"></span></p>
                <button id="accept" class="ui-btn ui-btn-b ui-corner-all">Next</button>
                <p id="result" class="result"></p>
            </div>

            <!-- Results view -->
            <div id="results" class="view">
                <h2 class="subtitle">Results</h2>
                <table class="table">
                    <tr>
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
        </body>
    </html
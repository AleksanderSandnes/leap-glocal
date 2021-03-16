<?php

    function get_myJobs() {
        include_once '\xampp\htdocs\skole\leap-glocal\backend\db.php';
        $returnOutput = "";

        $userIdMe = $_SESSION['userdata']->__get('id_user');

        $connen = new mysqli(getHostToDatabase(), getDbUsernameToDatabase(), getDbPasswordToDatabase(), getDbNameToDatabase());
        // Getting question and maybe answer from DB
        $stmtGetAllUnansweredQuestionFromUsers = "SELECT user_id_asked, id_specification, heading, question, price, isAnswered FROM consultant_answer_job
                                                  INNER JOIN question_to_consultant ON consultant_answer_job.id_question_to_consultant = question_to_consultant.id_question_to_consultant
                                                      WHERE id_consultant = ? AND isAnswered = ?;";
        $stmtGetAllUnansweredQuestionFromUsers = $connen->prepare($stmtGetAllUnansweredQuestionFromUsers);
        $stmtGetAllUnansweredQuestionFromUsers->bind_param('ss', $userIdMe, $userIdMe);
        $stmtGetAllUnansweredQuestionFromUsers->execute();
        $stmtGetAllUnansweredQuestionFromUsers->bind_result($userAskedId, $specificationID, $title, $question, $price, $isAnswered);
        $stmtGetAllUnansweredQuestionFromUsers->store_result();

        if ($stmtGetAllUnansweredQuestionFromUsers->num_rows > 0) {
            while ($stmtGetAllUnansweredQuestionFromUsers->fetch()) {
                $returnOutput .= '
                    <article>
                        <div>
                            <h2>'.$title.'</h2>
                            <p>'.$question.'</p>
                        </div>
                        <div><p>'.$price.' kr</p></div>
                    </article>
                ';
            }
        } else {
            $returnOutput = "Ingen spørsmål for øyeblikket";
        }

        return $returnOutput;
    }

    function get_answeredQuesitons() {
        include_once '\xampp\htdocs\skole\leap-glocal\backend\db.php';
        $returnOutput = "";

        $userIdMe = $_SESSION['userdata']->__get('id_user');

        $connen = new mysqli(getHostToDatabase(), getDbUsernameToDatabase(), getDbPasswordToDatabase(), getDbNameToDatabase());
        // Getting question and maybe answer from DB
        $stmtGetAllUnansweredQuestionFromUsers = "SELECT user_id_asked, id_specification, heading, question, price FROM consultant_answer_job
                                                  INNER JOIN question_to_consultant ON consultant_answer_job.id_question_to_consultant = question_to_consultant.id_question_to_consultant
                                                      WHERE id_consultant = ?;";
        $stmtGetAllUnansweredQuestionFromUsers = $connen->prepare($stmtGetAllUnansweredQuestionFromUsers);
        $stmtGetAllUnansweredQuestionFromUsers->bind_param('s', $userIdMe);
        $stmtGetAllUnansweredQuestionFromUsers->execute();
        $stmtGetAllUnansweredQuestionFromUsers->bind_result($userAskedId, $specificationID, $title, $question, $price);
        $stmtGetAllUnansweredQuestionFromUsers->store_result();

        if ($stmtGetAllUnansweredQuestionFromUsers->num_rows > 0) {
            while ($stmtGetAllUnansweredQuestionFromUsers->fetch()) {
                $returnOutput .= '
                    <article>
                        <div>
                            <h2>'.$title.'</h2>
                            <p>'.$question.'</p>
                        </div>
                        <div><p>'.$price.' kr</p></div>
                    </article>
                ';
            }
        } else {
            $returnOutput = "Ingen spørsmål for øyeblikket";
        }

        return $returnOutput;
    }

    function get_unansweredQuesitons() {
        include_once '\xampp\htdocs\skole\leap-glocal\backend\db.php';
        $returnOutput = "";

        $specification = $_SESSION['userdata']->__get('specification');
        $userIdMe = $_SESSION['userdata']->__get('id_user');

        $counter = 1;

        $connen = new mysqli(getHostToDatabase(), getDbUsernameToDatabase(), getDbPasswordToDatabase(), getDbNameToDatabase());
        // Getting question and maybe answer from DB
        $stmtGetAllUnansweredQuestionFromUsers = "SELECT * FROM question_to_consultant
                                                  WHERE id_specification = ?
                                                      AND id_question_to_consultant NOT IN (SELECT question_to_consultant.id_question_to_consultant FROM question_to_consultant
                                                  INNER JOIN consultant_answer_job ON consultant_answer_job.id_question_to_consultant = question_to_consultant.id_question_to_consultant
                                                  WHERE id_consultant = ?)
                                                      AND isAnswered IS NULL";
        $stmtGetAllUnansweredQuestionFromUsers = $connen->prepare($stmtGetAllUnansweredQuestionFromUsers);
        $stmtGetAllUnansweredQuestionFromUsers->bind_param('ss', $specification, $userIdMe);
        $stmtGetAllUnansweredQuestionFromUsers->execute();
        $stmtGetAllUnansweredQuestionFromUsers->bind_result($questionID, $userAskedID, $specificationID, $title, $question, $isAnswered);
        $stmtGetAllUnansweredQuestionFromUsers->store_result();

        if ($stmtGetAllUnansweredQuestionFromUsers->num_rows > 0) {
            while ($stmtGetAllUnansweredQuestionFromUsers->fetch()) {
                $returnOutput .= '
                    <article>
                        <div>
                            <h2>'.$title.'</h2>
                            <p>'.$question.'</p>
                        </div>
                        <form action="backend/sendPriceForQuestion.php" method="post">
                            <input style="display:none" value="'.$questionID.'" name="questionId">
                            <label for="pricefor'.$counter.'"></label>
                            <input type="number" placeholder="Pris" name="price" id="pricefor'.$counter.'">
                            <button class="asButton">Tilby pris</button>
                        </form>
                    </article>
                ';
                $counter++;
            }
        } else {
            $returnOutput = "Ingen spørsmål for øyeblikket";
        }

        return $returnOutput;
    }
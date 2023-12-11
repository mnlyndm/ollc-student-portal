    <?php

    include 'conn.php';

    header('Content-Type: application/json'); 

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        error_log(json_encode($_POST));
        $course = $_POST["course"];
        $surname = $_POST["stdSurname"];
        $first_name = $_POST["stdFirstname"];
        $middle_name = $_POST["stdMiddlename"];
        $suffix = $_POST["stdSuffix"];
        $city = $_POST["stdCity"];
        $email = $_POST["email"];
        $mobile = $_POST["stdMobile"];

        $firstLetterFirstName = ord(strtoupper(substr($first_name, 0, 1))) - ord('A') + 1;
        $firstLetterSurname = ord(strtoupper(substr($surname, 0, 1))) - ord('A') + 1;

        $studentNumber = strtoupper($firstLetterFirstName . date("His") . $firstLetterSurname);

        $password = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);

        $sqlStudentNumber = "INSERT INTO student_number (student_number) VALUES ('$studentNumber')";
            if ($conn->query($sqlStudentNumber) === TRUE) {
                $studentNumberId = $conn->insert_id;

                $sqlEnrollmentDetails = "INSERT INTO enrollment_details (course) VALUES ('$course')";
                if ($conn->query($sqlEnrollmentDetails) === TRUE) {
                    $enrollmentDetailsId = $conn->insert_id;

                $sqlContactInformation = "INSERT INTO contact_information (city, email, mobile_number) VALUES ('$city','$email','$mobile')";
                if ($conn->query($sqlContactInformation) === TRUE) {
                    $contactInformationId = $conn->insert_id;

                    $sqlStudent = "INSERT INTO students (student_number_id, surname, first_name, middle_name, suffix) VALUES ('$studentNumberId','$surname','$first_name','$middle_name','$suffix')";
                    if ($conn->query($sqlStudent) === TRUE) {
                        $studentId = $conn->insert_id;

                        $sqlSchoolAccount = "INSERT INTO school_account (student_number_id, password) VALUES ('$studentNumberId', '$password')";
                        if ($conn->query($sqlSchoolAccount) === TRUE) {
                            $schoolAccountId = $conn->insert_id;

                            $sqlStudentInformation = "INSERT INTO student_information (students_id, contact_information_id, enrollment_details_id, school_account_id, status) VALUES ('$studentId','$contactInformationId', '$enrollmentDetailsId', '$schoolAccountId','pre-registered')";
                            if ($conn->query($sqlStudentInformation) === TRUE) {
                                $result = [
                                    "studentNumber" => $studentNumber,
                                    "password" => $password,
                                    "status" => "recorded"
                                ];
                                echo json_encode($result);
                            } else {
                                echo json_encode(["status" => "error", "message" => "Error inserting into student information"]);
                            }
                        } else {
                            echo json_encode(["status" => "error", "message" => "Error inserting into school account: " . $conn->error]);
                        }
                    } else {
                        echo json_encode(["status" => "error", "message" => "Error inserting into students: " . $conn->error]);
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "Error inserting into contact information: " . $conn->error]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Error inserting into course: " . $conn->error]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Error inserting into student number: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid request"]);
    }
    ?>

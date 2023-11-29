<?php

include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $course = $_POST["course"];
    $surname = $_POST["stdSurname"];
    $first_name = $_POST["stdFirstname"];
    $middle_name = $_POST["stdMiddlename"];
    $suffix = $_POST["stdSuffix"];
    $city = $_POST["stdCity"];
    $email = $_POST["email"];
    $mobile = $_POST["stdMobile"];

    $studentNumber = strtoupper(substr($first_name, 0, 1) . date ("His") . substr($surname, 0, 1));

    $password = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1);

    $sqlStudent = "INSERT INTO students (surname, first_name, middle_name, suffix) VALUES ('$surname','$first_name','$middle_name','$suffix')";
    if ($conn->query($sqlStudent) === TRUE) {
        $studentId = $conn->insert_id;

        $sqlCourse = "INSERT INTO course (name) VALUES ('$course')";
        if ($conn->query($sqlCourse) === TRUE) {
           $courseId = $conn->insert_id;

           $sqlContactInformation = "INSERT INTO contact_information (city, email, mobile_number) VALUES ('$city','$email','$mobile')";
           if ($conn->query($sqlContactInformation) === TRUE) {
            $contactInformationId = $conn->insert_id;

                $sqlStudentNumber = "INSERT INTO student_number (student_number) VALUES ('$studentNumber')";
                if ($conn->query($sqlStudentNumber) === TRUE) {
                    $studentNumberId = $conn->insert_id;
                    
                    $sqlSchoolAccount = "INSERT INTO school_account (student_number_id, password) VALUES ('$studentNumberId', '$password')";
                    if ($conn->query($sqlSchoolAccount) === TRUE) {
                        $schoolAccountId = $conn->insert_id;

                        $sqlStudentInformation = "INSERT INTO student_information (students_id, contact_information_id, course_id, school_account_id) VALUES ('$studentId','$contactInformationId', '$courseId', '$schoolAccountId')";
                        if ($conn->query($sqlStudentInformation) === TRUE) {
                            echo 
                            "<script>
                                document.getElementById('studentNumber').innerText = 'Generated Student Number: $studentNumber';
                                document.getElementById('password').innerText = 'Generated Password: $password';
                                document.getElementById('popup').style.display = 'block';
                            </script>";
                        }
                    } else {
                        echo "Error inserting into school account: " . $conn->error;
                    }
                } else {
                    echo "Error inserting into student number: " . $conn->error;
                }
            } else {
            echo "Error inserting into contact information: " . $conn->error;
            }
        } else {
            echo "Error inserting into course: " . $conn->error;
        }
    } else {
        echo "Error inserting into students: " . $conn->error;
    }
?>

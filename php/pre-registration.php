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

    $sqlStudent = "INSERT INTO students (surname, first_name, middle_name, suffix) VALUES ('$surname','$first_name','$middle_name','$suffix')";
    if ($conn->query($sqlStudent) === TRUE) {
        $studentId = $conn->insert_id;

        $sqlCourse = "INSERT INTO course (name) VALUES ('$course')";
        if ($conn->query($sqlCourse) === TRUE) {
            $courseId = $conn->insert_id;

            $sqlContactInformation = "INSERT INTO contact_information (city, email, mobile_number) VALUES ('$city','$email','$mobile')";
            if ($conn->query($sqlContactInformation) === TRUE) {
                $contactInformationId = $conn->insert_id;

                $sqlStudentInformation = "INSERT INTO student_information (students_id, contact_information_id, course_id) VALUES ('$studentId','$contactInformationId', '$courseId')";
                if ($conn->query($sqlStudentInformation) === TRUE) {
                    echo "Recorded";
                } else {
                    echo "Error inserting into student_information: " . $conn->error;
                }
            } else {
                echo "Error inserting into contact_information: " . $conn->error;
            }
        } else {
            echo "Error inserting into course: " . $conn->error;
        }
    } else {
        echo "Error inserting into students: " . $conn->error;
    }
}

?>

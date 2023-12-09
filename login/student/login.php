<?php

include '../../php/conn.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $student_number = $_POST["student_number"];
    $password = $_POST["password"];

    $student_number = mysqli_real_escape_string($conn, $student_number);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT sn.*, si.status
        FROM student_number sn 
        JOIN school_account sa ON sn.student_number_id = sa.student_number_id
        JOIN student_information si ON sa.school_account_id = si.school_account_id
        WHERE sn.student_number = '$student_number' AND sa.password = '$password'";

    $result = $conn->query($sql);

    if ($result === false) {
        echo "Error: " . $conn->error;
    } else {
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['student_id'] = $row['students_id'];
            $_SESSION['student_number'] = $row['student_number'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['surname'] = $row['surname'];
            $_SESSION['status'] = $row['status'];

            switch ($row['status']) {
                case 'pre-registered':
                    header("Location: ../../student/admission.php");
                    break;

                case 'registered':
                    header("Location: enrollment_process.html");
                    break;

                case 'enrolled':
                    header("Location: student.html");
                    break;

                case 'not-enrolled':
                    header("Location: enrollment_process.html");
                    break;

                default:
                    echo "Invalid student status";
                    break;
            }
            exit();
        } else {
            $error_message = "Invalid Credentials";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <form action="" method="post">
        <div class="w-screen h-screen inline flex ">
            <div class="justify-center items-center inline-flex w-full" style="background: url('../../assets/img/school1.png') no-repeat center/cover;">
                <div class="p-14 bg-white rounded-2xl drop-shadow-xl border border-blue-800 border-opacity-60">
                    <div class="justify-center items-center inline-flex gap-1">
                        <div><img src="../../assets/svg/ollcLogoNoName.svg" class="w-[56px]" alt="OLLC Logo"></div>
                        <div class="text-2xl font-medium">INFORMATION SYSTEM</div>
                    </div>
                    <div class="my-4">
                    <form action="/ollcInformationSystem/login.php" method="post">
                        <div class='text-xl text-center font-medium'>ADMIN LOGIN</div>
                        <div class='text-lg py-2 font-medium'>Username:</div>
                        <div class='text-lg p-1 border border-blue-200 rounded-md'><input type="text" id='student_number' name='student_number' autoComplete='none' class='w-full p-1' placeholder='Enter your Username'/></div>
                        <div class='text-lg py-2 font-medium'>Password:</div>
                        <div class='text-lg p-1 border border-blue-200 rounded-md'><input type="password" id='password' name='password' autoComplete='none' class='w-full p-1' placeholder='Enter your Password' /></div>
                        
                        <?php if (!empty($error_message)) : ?>
                            <div class="text-red-500 text-sm mt-2"><?php echo $error_message; ?></div>
                        <?php endif; ?>

                        <div class="w-full inline-flex justify-center">
                            <button type="submit" name="submit" value="Login" class="bg-blue-400 mt-2 py-2 px-8 shadow justify-center items-center inline-flex gap-2 text-white rounded-full hover:bg-blue-600 hover:font-semibold">Login</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>

<?php
session_start();

if (!isset($_SESSION['student_number'])) {
    header("Location: ../../login.php");
    exit();
}

include '../php/conn.php';

$studentNumber = $_SESSION['student_number'];

$sql = "SELECT st.first_name, st.surname, st.middle_name, si.status, ed.course, ci.city, ci.mobile_number, ci.email
        FROM student_number sn 
        JOIN school_account sa ON sn.student_number_id = sa.student_number_id
        JOIN student_information si ON sa.school_account_id = si.school_account_id
        JOIN students st ON si.students_id = st.students_id
        JOIN enrollment_details ed ON si.enrollment_details_id = ed.enrollment_details_id
        JOIN contact_information ci ON si.contact_information_id = ci.contact_information_id
        WHERE sn.student_number = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error in SQL query: " . $conn->error);
}

$stmt->bind_param("s", $studentNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die("Error in query execution: " . $stmt->error);
}

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    $firstName = $row['first_name'];
    $surname = $row['surname'];
    $middleName = $row['middle_name'] ?? '';
    $status = $row['status'];
    $course = $row['course'];
    $city = $row['city'];
    $mobile_number = $row['mobile_number'];
    $email = $row['email'];

    $stmt->close();
} else {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
    error_log(json_encode($_POST));
    $suffix = isset($_POST['suffix']) ? $_POST['suffix'] : '';
    $gender = $_POST["gender"];
    $birthDate = $_POST["birthDate"];
    $stdAge = $_POST["stdAge"];
    $birthPlace = $_POST["birthPlace"];
    $citizenship = $_POST["citizenship"];
    $height = $_POST["height"];
    $weight = $_POST["weight"];
    $complexion = $_POST["complexion"];
    $iMarks = $_POST["iMarks"];
    $baptismPlace = $_POST["baptismPlace"];
    $baptismDate = $_POST["baptismDate"];
    $confPlace = $_POST["confPlace"];
    $confDate = $_POST["confDate"];
    $stdAddress = $_POST["stdAddress"];
    $kinderSchoolYear = $_POST["kinderSchoolYear"];
    $kinderSchoolName = $_POST["kinderSchoolName"];
    $kinderSchoolAddress = $_POST["kinderSchoolAddress"];
    $primarySchoolYear = $_POST["primarySchoolYear"];
    $primarySchoolName = $_POST["primarySchoolName"];
    $primarySchoolAddress = $_POST["primarySchoolAddress"];
    $secondarySchoolYear = $_POST["secondarySchoolYear"];
    $secondarySchoolName = $_POST["secondarySchoolName"];
    $secondarySchoolAddress = $_POST["secondarySchoolAddress"];
    $collegeSchoolYear = $_POST["collegeSchoolYear"];
    $collegeSchoolName = $_POST["collegeSchoolName"];
    $collegeSchoolAddress = $_POST["collegeSchoolAddress"];
    $fatherName = $_POST["fatherName"];
    $fatherAddress = $_POST["fatherAddress"];
    $fatherCompanyName = $_POST["fatherCompanyName"];
    $fatherCompanyAddress = $_POST["fatherCompanyAddress"];
    $fatherMobile = $_POST["fatherMobile"];
    $motherName = $_POST["motherName"];
    $motherAddress = $_POST["motherAddress"];
    $motherCompanyName = $_POST["motherCompanyName"];
    $motherCompanyAddress = $_POST["motherCompanyAddress"];
    $motherMobile = $_POST["motherMobile"];
    $ECName = $_POST["ECName"];
    $relationship = $_POST["relationship"];
    $ECAddress = $_POST["ECAddress"];
    $ECCompanyName = $_POST["ECCompanyName"];
    $ECCompanyAddress = $_POST["ECCompanyAddress"];
    $ECMobile = $_POST["ECMobile"];

    $sqlBaptism = "INSERT INTO baptism (place, date) VALUES ('$baptismPlace', '$baptismDate')";
    if ($conn->query($sqlBaptism) === TRUE) {
        $baptismId = $conn->insert_id;

        $sqlConfirmation = "INSERT INTO confirmation (place, date) VALUES ('$confPlace', '$confDate')";
        if ($conn->query($sqlConfirmation) === TRUE) {
            $confirmationId = $conn->insert_id;

            $sqlPersonalInformation = "INSERT INTO personal_information (gender, birthday, age, birth_place, citizenship, height, weight, baptism_id, confirmation_id) VALUES ('$gender', '$birthDate', '$stdAge', '$birthPlace', '$citizenship', '$height', '$weight', '$baptismId', '$confirmationId')";
            if ($conn->query($sqlPersonalInformation) === TRUE) {
                $personalInformationId = $conn->insert_id;

                $sqlContactInformation ="UPDATE contact_information SET address ='$stdAddress' WHERE address IS NULL";
                if ($conn->query($sqlContactInformation) === TRUE) {

                    $sqlKindergarten = "INSERT INTO kindergarten (year, name, address) VALUES ('$kinderSchoolYear', '$kinderSchoolName', '$kinderSchoolAddress')";
                    if ($conn->query($sqlKindergarten) === TRUE) {
                        $kindergartenId = $conn->insert_id;

                        $sqlPrimary = "INSERT INTO primary_educ (year, name, address) VALUES ('$primarySchoolYear', '$primarySchoolName', '$primarySchoolAddress')";
                        if ($conn->query($sqlPrimary) === TRUE) {
                            $primaryId = $conn->insert_id;
                        
                            $sqlSecondary = "INSERT INTO secondary (year, name, address) VALUES ('$secondarySchoolYear', '$secondarySchoolName', '$secondarySchoolAddress')";
                            if ($conn->query($sqlSecondary) === TRUE) {
                                $secondaryId = $conn->insert_id;

                                $sqlCollege = "INSERT INTO college (year, name, address) VALUES ('$collegeSchoolYear', '$collegeSchoolName', '$collegeSchoolAddress')";
                                if ($conn->query($sqlCollege) === TRUE) {
                                    $collegeId = $conn->insert_id;

                                    $sqlEducationalAttainment ="INSERT INTO educational_attainment (kindergarten_id, primary_educ_id, secondary_id, college_id) VALUES ('$kindergartenId', '$primaryId', '$secondaryId', '$collegeId')";
                                    if ($conn->query($sqlEducationalAttainment) === TRUE) {
                                        $educationalAttainmentId = $conn->insert_id;

                                        $sqlFather ="INSERT INTO father (name, address, company, company_address, mobile_number) VALUES ('$fatherName', '$fatherAddress', '$fatherCompanyName', '$fatherCompanyAddress', '$fatherMobile')";
                                        if ($conn->query($sqlFather) === TRUE) {
                                            $fatherId = $conn->insert_id;

                                            $sqlMother ="INSERT INTO mother (name, address, company, company_address, mobile_number) VALUES ('$motherName', '$motherAddress', '$motherCompanyName', '$motherCompanyAddress', '$motherMobile')";
                                            if ($conn->query($sqlMother) === TRUE) {
                                                $motherId = $conn->insert_id;

                                                $sqlEmergencyContact = "INSERT INTO emergency_contact (name, relationship, address, company, company_address, mobile_number) VALUES ('$ECName', '$relationship', '$ECAddress', '$ECCompanyName', '$ECCompanyAddress', '$ECMobile')";

                                                if ($conn->query($sqlEmergencyContact) === TRUE) {
                                                    $emergencyContactId = $conn->insert_id;

                                                    $sqlFamilyRecord = "INSERT INTO family_record (father_id, mother_id, emergency_contact_id) VALUES ('$fatherId', '$motherId', '$emergencyContactId')";
                                                    if ($conn->query($sqlFamilyRecord) === TRUE) {
                                                        $familyRecordId = $conn->insert_id;

                                                        $sqlStudentInformation = "UPDATE student_information SET personal_information_id = '$personalInformationId', educational_attainment_id = '$educationalAttainmentId', family_record_id = '$familyRecordId', status = 'registered' WHERE personal_information_id IS NULL AND educational_attainment_id IS NULL AND family_record_id IS NULL AND status = 'pre-registered'";
                                                        if ($conn->query($sqlStudentInformation) === TRUE) {
                                                            header("Location: enrollment.html");
                                                            exit();
                                                        } else {
                                                            echo json_encode(["status" => "error", "message" => "Error updating student information: " . $conn->error]);
                                                        }
                                                    } else {
                                                        echo json_encode(["status" => "error", "message" => "Error inserting into family record: " . $conn->error]);
                                                    }
                                                } else {
                                                    echo json_encode(["status" => "error", "message" => "Error inserting into emergency contact: " . $conn->error]);
                                                }
                                            } else {
                                                echo json_encode(["status"=> "error", "message" => "Error inserting into mother: " .$conn->error]);
                                            }
                                        } else {
                                            echo json_encode(["status"=> "error", "message" => "Error inserting into father: " .$conn->error]);
                                        }
                                    } else {
                                        echo json_encode(["status"=> "error", "message" => "Error inserting into educational attainment: " .$conn->error]);
                                    }
                                } else {
                                    echo json_encode(["status"=> "error", "message" => "Error inserting into college: " .$conn->error]);
                                }                 
                            } else {
                                echo json_encode(["status"=> "error", "message" => "Error inserting into secondary: " .$conn->error]);
                            }
                        } else {
                            echo json_encode(["status"=> "error", "message" => "Error inserting into primary: " .$conn->error]);
                        }
                    } else {
                        echo json_encode(["status"=> "error", "message" => "Error inserting into kindergarten: " .$conn->error]);
                    }
                } else {
                    echo json_encode(["status"=> "error", "message" => "Error inserting into contact information: " .$conn->error]);
                }
            } else {
                echo json_encode(["status"=> "error", "message" => "Error inserting into personal information: " .$conn->error]);
            }
        } else {
            echo json_encode(["status"=> "error", "message" => "Error inserting into confirmation: " .$conn->error]);
        }
    } else {
        echo json_encode(["status"=> "error", "message" => "Error inserting into bapstism: " .$conn->error]);
    }
} else {
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Page</title>
</head>
<body>
    <div>
        <div>
            <?php include '../php/topbar.php'; ?>
        </div>
        <form action="./admission.php" method="post">
            <div class="w-full inline-flex justify-center">
                <div class="w-1/2 border border-blue-100 shadow-md p-4">
                    <div class="italic mb-6">Welcome to our admission form! We're excited to have you on board. <br><br>To make the process quick and easy, we just need some basic personal information, 
                        contact information, educational attainment, and family record. Your privacy is important to us, and all information provided will be kept confidential. 
                        <br><br>Let's get started on this journey together - fill out the form, and you'll be on your way to enrolling with us!
                    </div>
                    <div class="flex justify-start items-center gap-2">
                        <div><img src="../assets/svg/applying-icon.svg" alt=""></div>
                        <div>APPLYING FOR:</div>
                        <div class="font-semibold"><?php echo htmlspecialchars($course, ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                    <div class="mt-2 border border-blue-800 border-opacity-20 p-4 w-full">
                        <div class="inline-flex justify-start items-center gap-2 mt-1">
                            <div><img src="../assets/svg/three-lines.svg" class="w-5 h-5" alt=""></div>
                            <div>Personal Information</div>
                        </div>
                        <div class="w-full justify-between items-center">
                            <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-4 justify-items-start ">
                                <div class="flex justify-start items-center grid grid-cols-2 gap-1">
                                    <div class="w-auto">Surname:</div>
                                    <div class="text-s w-full font-semibold"><?php echo htmlspecialchars($surname, ENT_QUOTES, 'UTF-8'); ?></div>
                                </div>
                                <div class="flex justify-start items-center grid grid-cols-2 gap-1">
                                    <div class="w-auto">First Name:</div>
                                    <div class="text-s w-full font-semibold"><?php echo htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8'); ?></div>
                                </div>
                                <div class="flex justify-start items-center grid grid-cols-2 gap-1">
                                    <div>Middle Name:</div>
                                    <div class="text-s w-full font-semibold"><?php echo htmlspecialchars($middleName, ENT_QUOTES, 'UTF-8'); ?></div>
                                </div>
                                <div class="flex justify-start items-center grid grid-cols-2 gap-1">
                                    <div>Suffix:</div>
                                    <div>
                                        <div><select name="suffix" id="suffixMenu" class="text-sm p-1 border border-blue-200 rounded-md"></select></div>
                                    </div>
                                </div>
                            </div>
                            <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-3 justify-items-start ">
                                <div class="flex justify-start items-center grid grid-cols-2 gap-1">
                                    <div>Gender:</div>
                                    <div>
                                        <div><select name="gender" id="genderMenu" class="text-sm p-1 border border-blue-200 rounded-md"></select></div>
                                    </div>
                                </div>
                                <div class="inline-flex justify-start items-center gap-2">
                                    <div class="w-full">Date of Birth:</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="date" name="birthDate" id="birthDate" onchange="calculateAge()"></div>
                                </div>
                                <div class="inline-flex justify-start items-center gap-2">
                                    <div>Age:</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full">
                                        <input required type="number" name="stdAge" id="stdAge" class="w-8">
                                    </div>
                                </div>
                                <div class="inline-flex justify-start items-center gap-2">
                                    <div class="w-full">Birth Place:</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="birthPlace" id="birthPlace"></div>
                                </div>
                                <div class="inline-flex justify-start items-center gap-2">
                                    <div>Citizenship:</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="citizenship" id="citizenship"></div>
                                </div>
                                <div class="flex justify-start items-center gap-2 w-auto">
                                    <div>Height:</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md inline-flex"><input required type="number" name="height" id="height" class="w-8">cm</div>
                                </div>
                            </div>
                            <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-5 justify-items-start ">
                                <div class="flex justify-start items-center gap-2 w-auto">
                                    <div>Weight:</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md inline-flex"><input required type="number" name="weight" id="weight" class="w-8">kg</div>
                                </div>
                                <div class="flex justify-start items-center gap-2 col-span-2 w-auto">
                                    <div>Complexion:</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="complexion" id="complexion"></div>
                                </div>
                                <div class="flex justify-start items-center gap-2 col-span-2 w-auto">
                                    <div class="w-full">Identifying Marks:</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="iMarks" id="iMarks"></div>
                                </div>
                            </div>
                            <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-2 justify-items-start ">
                                <div class="justify-start items-center w-full">
                                    <div>Baptism:</div>
                                    <div class="inline-flex justify-start items-center gap-2 w-full">
                                        <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="baptismPlace" id="baptismPlace" class="w-full" placeholder="Place"></div>
                                        <div class="text-sm p-1 border border-blue-200 rounded-md w-auto"><input required type="date" name="baptismDate" id="baptismDate" class="w-full"></div>
                                    </div>
                                </div>
                                <div class="justify-start items-center w-full">
                                    <div>Confirmation:</div>
                                    <div class="inline-flex justify-start items-center gap-2 w-full">
                                        <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="confPlace" id="confPlace" class="w-full" placeholder="Place"></div>
                                        <div class="text-sm p-1 border border-blue-200 rounded-md w-auto"><input required type="date" name="confDate" id="confDate" class="w-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 border border-blue-800 border-opacity-20 p-4 w-full">
                        <div class="inline-flex justify-start items-center gap-2">
                            <div><img src="../assets/svg/three-lines.svg" alt=""></div>
                            <div>Contact Information</div>
                        </div>
                        <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-1 justify-items-start ">
                            <div class="w-full">
                                <div>Address </div>
                                <div class="text-sm p-1 border border-blue-200 rounded-md w-auto"><input type="text" id="stdAddress" name="stdAddress" required style="text-transform: capitalize;" class="w-full px-1" placeholder="Unit No. / Building / Street / Barangay"></div>
                            </div>
                        </div>
                        <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-5 justify-items-start ">
                            <div class="flex justify-start items-center gap-1">
                                <div>City:</div>
                                <div class="text-s w-full font-semibold">
                                    <?php echo htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                            </div>
                            <div class="flex justify-start items-center col-span-2 gap-1">
                                <div>Email:</div>
                                <div class="text-s w-full font-semibold">
                                    <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                            </div>
                            <div class="flex justify-start items-center col-span-2 gap-1">
                                <div>Cellphone:</div>
                                <div class="text-s w-full font-semibold">
                                    <?php echo htmlspecialchars($mobile_number, ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 border border-blue-800 border-opacity-20 p-4 w-full">
                        <div class="inline-flex justify-start items-center gap-2 mt-1">
                            <div><img src="../assets/svg/educational-attainment-icon.svg" class="w-5 h-5" alt=""></div>
                            <div>Educational Attainment</div>
                        </div>
                        <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-4 justify-items-center ">
                            <div>
                                
                            </div>
                            <div>
                                School Year
                            </div>
                            <div>
                                Name of School
                            </div>
                            <div>
                                Address of School
                            </div>
                        </div>
                        <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-4 justify-items-start ">
                            <div>
                                Kindergarten
                            </div>
                            <div class="text-sm p-1 border border-blue-200 rounded-md w-full">
                                <input required type="text" name="kinderSchoolYear" id="kinderSchoolYear" class="w-full">
                            </div>
                            <div class="text-sm p-1 border border-blue-200 rounded-md w-full">
                                <input required type="text" name="kinderSchoolName" id="kinderSchoolName" class="w-full" style="text-transform: capitalize;">
                            </div>
                            <div class="text-sm p-1 border border-blue-200 rounded-md w-full">
                                <input required type="text" name="kinderSchoolAddress" id="kinderSchoolAddress" class="w-full">
                            </div>
                        </div>
                        <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-4 justify-items-start ">
                            <div>
                                Elementary
                            </div>
                            <div class="text-sm p-1 border border-blue-200 rounded-md w-full">
                                <input required type="text" name="primarySchoolYear" id="primarySchoolYear" class="w-full" >
                            </div>
                            <div class="text-sm p-1 border border-blue-200 rounded-md w-full">
                                <input required type="text" name="primarySchoolName" id="primarySchoolName" class="w-full">
                            </div>
                            <div class="text-sm p-1 border border-blue-200 rounded-md w-full">
                                <input required type="text" name="primarySchoolAddress" id="primarySchoolAddress" class="w-full">
                            </div>
                        </div>
                        <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-4 justify-items-start ">
                            <div>
                                Secondary
                            </div>
                            <div class="text-sm p-1 border border-blue-200 rounded-md w-full">
                                <input required type="text" name="secondarySchoolYear" id="secondarySchoolYear" class="w-full">
                            </div>
                            <div class="text-sm p-1 border border-blue-200 rounded-md w-full">
                                <input required type="text" name="secondarySchoolName" id="secondarySchoolName" class="w-full">
                            </div>
                            <div class="text-sm p-1 border border-blue-200 rounded-md w-full">
                                <input required type="text" name="secondarySchoolAddress" id="secondarySchoolAddress" class="w-full">
                            </div>
                        </div>
                        <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-4 justify-items-start ">
                            <div>
                                College
                            </div>
                            <div class="text-sm p-1 border border-blue-200 rounded-md w-full">
                                <input required type="text" name="collegeSchoolYear" id="collegeSchoolYear" class="w-full">
                            </div>
                            <div class="text-sm p-1 border border-blue-200 rounded-md w-full">
                                <input required type="text" name="collegeSchoolName" id="collegeSchoolName" class="w-full">
                            </div>
                            <div class="text-sm p-1 border border-blue-200 rounded-md w-full">
                                <input required type="text" name="collegeSchoolAddress" id="collegeSchoolAddress" class="w-full">
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 border border-blue-800 border-opacity-20 p-4 w-full">
                        <div class="inline-flex justify-start items-center  gap-2">
                            <div><img src="../assets/svg/family-record-icon.svg" class="w-5 h-5" alt=""></div>
                            <div>Family Record</div>
                        </div>
                        <div class="p-4 mt-1 border border-blue-600 border-opacity-20">
                            <div class="flex justify-start items-center gap-2">
                                <div><img src="../assets/svg/three-lines.svg" class="w-5 h-5" alt=""></div>
                                <div>Father</div>
                            </div>
                            <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-1 justify-items-start ">
                                <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-3 justify-items-start ">
                                    <div class="flex justify-start items-center mt-1 gap-1">
                                        <div>Name:</div>
                                        <div class="text-sm p-1 border border-blue-200 rounded-md w-auto"><input required type="text" name="fatherName" id="fatherName" class="w-full"></div>
                                    </div>
                                    <div class="flex justify-start items-center gap-1 col-span-2">
                                        <div class="w-auto">Mobile No.:</div>
                                        <div class="text-sm p-1 border border-blue-200 rounded-md inline-flex"><span class="border-r border-blue-200 pr-2">+63</span><span><input required type="text" name="fatherMobile" id="fatherMobile" class="w-full"></span></div>
                                    </div>
                                </div>
                                <div class="flex justify-start items-center mt-1 gap-1 w-full">
                                    <div>Address:</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="fatherAddress" id="fatherAddress" class="w-full"></div>
                                </div>
                                <div class="flex justify-between items-center mt-1 gap-1 w-full">
                                    <div class="flex justify-start items-center gap-1 w-full">
                                        <div class="w-3/5">Company Connected With:</div>
                                        <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="fatherCompanyName" id="fatherCompanyName" class="w-full"></div>
                                    </div>
                                    <div class="flex justify-start items-center gap-1 w-full">
                                        <div class="w-3/5">Address of Company:</div>
                                        <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="fatherCompanyAddress" id="fatherCompanyAddress" class="w-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 mt-1 border border-blue-600 border-opacity-20">
                            <div class="flex justify-start items-center gap-2">
                                <div><img src="../assets/svg/three-lines.svg" class="w-5 h-5" alt=""></div>
                                <div>Mother</div>
                            </div>
                            <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-1 justify-items-start ">
                                <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-3 justify-items-start ">
                                    <div class="flex justify-start items-center mt-1 gap-1">
                                        <div>Name:</div>
                                        <div class="text-sm p-1 border border-blue-200 rounded-md w-auto"><input required type="text" name="motherName" id="motherName" class="w-full"></div>
                                    </div>
                                    <div class="flex justify-start items-center gap-1 col-span-2">
                                        <div class="w-auto">Mobile No.:</div>
                                        <div class="text-sm p-1 border border-blue-200 rounded-md inline-flex"><span class="border-r border-blue-200 pr-2">+63</span><span><input required type="text" name="motherMobile" id="motherMobile" class="w-full"></span></div>
                                    </div>
                                </div>
                                <div class="flex justify-start items-center mt-1 gap-1 w-full">
                                    <div>Address:</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="motherAddress" id="motherAddress" class="w-full"></div>
                                </div>
                                <div class="flex justify-between items-center mt-1 gap-1 w-full">
                                    <div class="flex justify-start items-center gap-1 w-full">
                                        <div class="w-3/5">Company Connected With:</div>
                                        <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="motherCompanyName" id="motherCompanyName" class="w-full"></div>
                                    </div>
                                    <div class="flex justify-start items-center gap-1 w-full">
                                        <div class="w-3/5">Address of Company:</div>
                                        <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="motherCompanyAddress" id="motherCompanyAddress" class="w-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 mt-1 border border-blue-600 border-opacity-20">
                            <div class="flex justify-start items-center gap-2">
                                <div><img src="../assets/svg/three-lines.svg" class="w-5 h-5" alt=""></div>
                                <div>Emergency Contact</div>
                            </div>
                            <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-1 justify-items-start ">
                                <div class="justify-start items-center gap-4 mt-1 w-full grid grid-cols-4 justify-items-start ">
                                    <div class="flex justify-start items-center mt-1 gap-1">
                                        <div>Name:</div>
                                        <div class="text-sm p-1 border border-blue-200 rounded-md w-auto"><input required type="text" name="ECName" id="ECName" class="w-full"></div>
                                    </div>
                                    <div class="flex justify-start items-center gap-2">
                                        <div class="w-auto">Relationship:</div>
                                        <div class="w-full"><select name="relationship" id="relationshipMenu" class="text-sm p-1 border border-blue-200 rounded-md"></select></div>
                                    </div>
                                    <div class="flex justify-start items-center gap-1 col-span-2 ml-4">
                                        <div class="w-auto">Mobile No.:</div>
                                        <div class="text-sm p-1 border border-blue-200 rounded-md inline-flex"><span class="border-r border-blue-200 pr-2">+63</span><span><input required type="text" name="ECMobile" id="ECMobile" class="w-full"></span></div>
                                    </div>
                                </div>
                                <div class="flex justify-start items-center mt-1 gap-1 w-full">
                                    <div>Address:</div>
                                    <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="ECAddress" id="ECAddress" class="w-full"></div>
                                </div>
                                <div class="flex justify-between items-center mt-1 gap-1 w-full">
                                    <div class="flex justify-start items-center gap-1 w-full">
                                        <div class="w-3/5">Company Connected With:</div>
                                        <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="ECCompanyName" id="ECCompanyName" class="w-full"></div>
                                    </div>
                                    <div class="flex justify-start items-center gap-1 w-full">
                                        <div class="w-3/5">Address of Company:</div>
                                        <div class="text-sm p-1 border border-blue-200 rounded-md w-full"><input required type="text" name="ECCompanyAddress" id="ECCompanyAddress" class="w-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex justify-center items-center mt-4">
                            <button class="btn flex justify-center items-center group relative" type="submit" name="submit">
                                Enroll Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="../assets/js/admission-menu.js"></script>
</body>
</html>

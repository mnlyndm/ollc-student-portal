<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title>Topbar</title>
</head>
<body>
    <form action="../login/student/logout.php" method="post">
        <div class="flex py-4 px-14 justify-between items-center">
                <div>
                    <img src="../assets/svg/ollclogo.svg" alt="">
                </div>
                <div class="inline-flex justify-between items-center gap-4">
                    <div>
                        <div class="text-base font-semibold"><?php echo htmlspecialchars($firstName . ' ' . $middleName . ' ' . $surname, ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                    <div>
                        <button class="text-base btn hover:bg-blue-400 hover:text-white font-semibold" type="submit" name="logout" value="Logout">Logout</button>
                    </div>
                </div>
            </div>
    </form>
</body>
</html>
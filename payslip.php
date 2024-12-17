<?php
   include 'conn.php';

function sanitized($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

if(isset($_POST["add"])){
    $empnum = sanitized($_POST["empnum"]);
    $name = sanitized($_POST["name"]);
    $position = sanitized($_POST["position"]);
    $hours = sanitized($_POST["hours"]);
    $deduction = sanitized($_POST["deduction"]);
}

$insert = mysqli_query($db, "INSERT INTO users(employee_num, name, position, hours_rend, deduction) VALUES('$empnum', '$name', '$position', '$hours', '$deduction')");

if($insert){
    $_SESSION['add'] = "Data inserted succefully.";
    echo "<script>location.href='payroll.php<?script>";
}
else{
    $_SESSION["add"] = "Data failed";
    echo "<script>location.href='payroll.php</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Payslip</title>
    <style> 
        h2{
             width: 800px;
            background-color: rgb(0,0,0,0.5);
            margin: auto;
            color: #FFFFFF;
            padding: 10px 0px 10px 0px;
            text-align: center;
            border-radius: 15px 15px 0px 0px;
        }
        .card{
            background-color: rgb(0,0,0,0.2);
            width: 800px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="mt-5">
        <h2 class="text-center">Payslip</h2>
        <?php
        function calculateTax($grossPay) {
            if ($grossPay <= 10000) {
                return $grossPay * 0.05;
            } elseif ($grossPay <= 30000) {
                return 500 + 0.10 * ($grossPay - 10000);
            } elseif ($grossPay <= 70000) {
                return 2500 + 0.15 * ($grossPay - 30000);
            } elseif ($grossPay <= 140000) {
                return 8500 + 0.20 * ($grossPay - 70000);
            } elseif ($grossPay <= 250000) {
                return 22500 + 0.25 * ($grossPay - 140000);
            } elseif ($grossPay <= 500000) {
                return 50000 + 0.30 * ($grossPay - 250000);
            } else {
                return 125000 + 0.34 * ($grossPay - 500000);
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $employeeNo = $_POST['employeeNo'];
            $name = $_POST['name'];
            $position = $_POST['position'];
            $hoursRendered = $_POST['hoursRendered'];


            $payRates = [
                "Instructor I" => 890.75,
                "Instructor II" => 940.50,
                "Instructor III" => 1200.75,
                "Associate Professor I" => 1700.25,
                "Associate Professor II" => 5000.75,
                "Associate Professor III" => 7500.50,
            ];


            $grossPay = $payRates[$position] * $hoursRendered;


            $withholdingTax = calculateTax($grossPay);


            $totalDeductions = 0;
            if (isset($_POST['deductions'])) {
                foreach ($_POST['deductions'] as $deduction) {
                    $totalDeductions += (float)$deduction;
                }
            }


            $netPay = $grossPay - $totalDeductions - $withholdingTax;
            

            echo "<div class='card mt-4'>";
            echo "<div class='card-body'>";
            echo "<p><strong>Employee No:</strong> $employeeNo</p>";
            echo "<p><strong>Name:</strong> $name</p>";
            echo "<p><strong>Position:</strong> $position</p>";
            echo "<p><strong>Gross Pay:</strong> " . number_format($grossPay, 2) . "</p>";
            echo "<p><strong>Total Deductions:</strong> " . number_format($totalDeductions, 2) . "</p>";
            echo "<p><strong>Withholding Tax:</strong> " . number_format($withholdingTax, 2) . "</p>";
            echo "<p><strong>Net Pay:</strong> " . number_format($netPay, 2) . "</p>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
 session_start();
 include 'conn.php';

 if(isset($_SESSION["add"])){
    echo $_SESSION["add"];
    unset($_SESSION["add"]);
 }

 $query = "SELECT * FROM users";
 $fetch = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Payroll System</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body{
            background-color: aliceblue;
            font-family: sans-serif;
        }
        .container{
            width: 800px;
            background-color: rgb(0,0,0,0.5);
            margin: auto;
            color: #FFFFFF;
            padding: 10px 0px 10px 0px;
            text-align: center;
            border-radius: 15px 15px 0px 0px;
        }
        .container-form{
            background-color: rgb(0,0,0,0.2);
            width: 800px;
            margin: auto;
        }
            form{
                padding: 10px;
                
        }
        #form-name{
            width: 100%;
            height: 80px;
        }
        .form-label{
            margin-left: 25px;
            margin-top: 20px;
            width: 200px;
            color: white;
            font-size: 18px;
            font-weight: 800px;
        }
        .form-control{
            position: relative;
            left: 20px;
            line-height: 40px;
            border-radius: 6px;
            padding: 0 22px;
            font-size: 16px;
            width: 735px;
        }
        .form-check-input{
            position: relative;
            left: 20px;
        }
        .form-check-label{
            position: relative;
            left: 20px;
            color: white;
            font-size: 15px;
        }
        .form-button{
            margin-top: 80px;
        }
        .button{
            background-color: #A5CAD2;
            display: block;
            margin: 20px 0px 0px 20px;
            text-align: center;
            border-radius: 12px;
            border: 2px solid #003041;
            padding: 14px 50px;
            outline: none;
            color: #FFFFFF;
            cursor: pointer;
            transition: 0.25px;
        }
        .button:hover{
            background-color: aqua;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Payroll Web Application</h1>
    </div>
    <div class="container-form">
        <form method="POST" action="payslip.php" class="mt-4">
            <div class="mb-3">
                <label for="employeeNo" class="form-label">Employee No</label>
                <input type="text" class="form-control" id="employeeNo" name="employeeNo" required>
            </div>
            <div class="mb-3" id="form-name">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required minlength="10" maxlength="100">
            </div>
            <div class="mb-3" id="form-name">
                <label for="position" class="form-label">Position</label>
                <select class="form-control" id="position" name="position" required>
                    <option value="Instructor I">Instructor I</option>
                    <option value="Instructor II">Instructor II</option>
                    <option value="Instructor III">Instructor III</option>
                    <option value="Associate Professor I">Associate Professor I</option>
                    <option value="Associate Professor II">Associate Professor II</option>
                    <option value="Associate Professor III">Associate Professor III</option>
                </select>
            </div>
            <div class="mb-3" id="form-name">
                <label for="hoursRendered" class="form-label">Hours Rendered</label>
                <input type="number" class="form-control" id="hoursRendered" name="hoursRendered" required>
            </div>
            <div class="mb-3" id="form-name">
                <label class="form-label">Deductions</label><br>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gsis" name="deductions[]" value="550">
                    <label class="form-check-label" for="gsis">GSIS Deduction</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="philhealth" name="deductions[]" value="150">
                    <label class="form-check-label" for="philhealth">Philhealth Deduction</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="pagibig" name="deductions[]" value="256">
                    <label class="form-check-label" for="pagibig">Pagibig Deduction</label>
                </div>
            </div>
            <div class="form-button">
                        <input type="submit" class="button" name="add" value="Compute Payroll">
            </div>
        </form>
    </div>

        <br><br>

        <table>
            <thead>
                <tr>
                    <th>Employee Number</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Hours Rendered</th>
                    <th>Deduction</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(mysqli_num_rows($fetch)) {
                        $ctr =1;
                    while($row = mysqli_fetch_assoc($fetch)){
                                 ?>
                                <tr>
                                    <td><?=$ctr?></td>
                                    <td><?php echo $row['employee_num'];?></td>
                                    <td><?php echo $row['name'];?></td>
                                    <td><?php echo $row['position'];?></td>
                                    <td><?php echo $row['hours_rend'];?></td>
                                    <td><?php echo $row['deduction'];?></td>
                                </tr>
                                <?php
                                    $ctr++;
                            }
                    }
                    else{
                        echo "No Employee Found.";
                    }
                ?>
            </tbody>
        </table>
    </form>
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave App</title>
</head>
<body>
    <?php
        echo htmlspecialchars($_SERVER["PHP_SELF"]) . "</br></br>";
        function handleFormPostRequest(){
            $employee_name  = verifyPostTextData("employee_name");
            $designation    = verifyPostTextData("employee_designation");
            $department     = verifyPostTextData("employee_dept");
            $leave_purpose  = verifyPostTextData("leave_purpose");
            $leave_address  = verifyPostTextData("leave_address");
            $duties_carried_by  = verifyPostTextData("duties_carried_by");
            $supervisor_select  = verifyPostTextData("supervisor_select");
            $hod_select         = verifyPostTextData("hod_select");
            $employee_signature = verifyPostTextData("employee_signature");
            
            // TODO: Verify date & contact number 
            $dateinput_from     = $_POST["dateinput_from"];
            $dateinput_to       = $_POST["dateinput_to"];
            $employee_contact   = $_POST["employee_contact"];

            echo "Employee Name: "          . $employee_name   . '</br>';
            echo "Employee Designation: "   . $designation     . '</br>';
            echo "Employee Department: "    . $department    . '</br>';
            echo "leave_purpose: "      . $leave_purpose     . '</br>';
            echo "leave_address: "      . $leave_address     . '</br>';
            echo "duties_carried_by: "  . $duties_carried_by . '</br>';
            echo "supervisor_select: "  . $supervisor_select . '</br>';
            echo "hod_select: "         . $hod_select        . '</br>';
            echo "employee_signature: " . $employee_signature   . '</br>';
            echo "dateinput_from: "     . $dateinput_from       . '</br>';
            echo "dateinput_to: "       . $dateinput_to         . '</br>';
            echo "employee_contact: "   . $employee_contact     . '</br>';
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            handleFormPostRequest();
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function verifyPostTextData($post_key){
            $temporay_var = "";
            if (empty($_POST[$post_key])) {
                echo "$post_key is required! </br>";
            } else {
                $temporay_var = test_input($_POST[$post_key]);
                if (!preg_match("/^[a-zA-Z ]*$/", $temporay_var)) {
                    echo "Only letters and white space allowed in $post_key field </br>";
                }
            }
            return $temporay_var;
        }

    ?>    
</body>
</html>

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

            $dbobject = new Database("mydb");
            $dbobject->connect();
            // $dbobject->createTable('leaveApp');
            $dbobject->insertData('leaveApp', $employee_name, $designation, $department, "SIL", $dateinput_from, $dateinput_to, 
                                $leave_purpose, $leave_address, $employee_contact, $duties_carried_by, $supervisor_select, $hod_select);
            $dbobject->disconnect();
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


        class Database{
            public $db_connect;
            public $dbname;
            const SERVERNAME = "localhost";
            const USERNAME   = "root";
            const PASSWORD   = "";

            public function __construct($dbName){
                $this->dbname = $dbName;
            }

            public function connect(){
                // create db connection
                $this->db_connect = new mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, $this->dbname);

                // check connection establishment 
                if($this->db_connect->connect_error){
                    die("db connection failed! " . $this->db_connect->connect_error);
                }else{
                    echo "db connection successfull </br>";
                }
            }

            public function createTable($tableName){
                $sql = "CREATE TABLE $tableName (
                        id                  INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        employee_name       VARCHAR(40)     NOT NULL,
                        designation         VARCHAR(30)     NOT NULL,
                        department          VARCHAR(40)     NOT NULL,
                        company_div         VARCHAR(10)     NOT NULL,
                        leave_from          DATE,
                        leave_to            DATE,
                        leave_purpose       VARCHAR(50),
                        leave_address       VARCHAR(50),
                        contact             VARCHAR(20),
                        duties_carried_by   VARCHAR(40),
                        supervisor          VARCHAR(40),
                        hod                 VARCHAR(40)
                        )";

                if ($this->db_connect->query($sql) === TRUE) {
                    echo "Table $tableName created successfully";
                } else {
                    echo "Error creating table: " . $this->db_connect->error;
                }
            }

            public function insertData($tableName, $name, $designation, $dept, $div, $from, $to, $purpose, $addr, $contact, $duty_carry, $sup, $hod){
                $sql = "INSERT INTO $tableName (employee_name, designation, department, company_div, leave_from, leave_to, leave_purpose, leave_address, contact, duties_carried_by, supervisor, hod) 
                        VALUES ('$name', '$designation', '$dept', '$div', '$from', '$to', '$purpose', '$addr', '$contact', '$duty_carry', '$sup', '$hod')";

                if ($this->db_connect->query($sql) === TRUE) {
                    $last_id = $this->db_connect->insert_id;
                    echo "Data inserted successfully to $tableName table, at id=$last_id </br>";
                } else {
                    echo "Error inserting data: " . $this->db_connect->error;
                }
            }

            public function updateData($tableName, $dataField, $data, $id){
                $sql = "UPDATE $tableName SET $dataField='$data' WHERE id=$id";
                if ($this->db_connect->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $this->db_connect->error;
                }
            }

            public function deleteData($tableName, $id){
                $sql = "DELETE FROM $tableName WHERE id=$id";
                if ($this->db_connect->query($sql) === TRUE) {
                    echo "Record deleted successfully </br>";
                } else {
                    echo "Error deleting record: " . $this->db_connect->error;
                }
            }

            // public function createDatabase($db){ 
            //     $sql = "CREATE DATABASE $db";
            //     if($this->db_connect->query($sql)){
            //         echo "database created successfully </br>";
            //     }else{
            //         echo "error creating database. " . $this->db_connect->error . "</br>";
            //     }      
            // }

            public function disconnect(){
                $this->db_connect->close();
                echo "db disconnected </br>";
            }
        }  

    ?>    
</body>
</html>

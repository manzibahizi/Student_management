<?php
class Backend_handler{

 private $host="localhost";
 private $user = "root";
 private $password = "";
 private $database = "student_management";
 private $conn;
    public function __construct(){
        $this->conn=mysqli_connect($this->host,$this->user,$this->password,$this->database);
        


    }

    public function validateName($data){
        if(empty($data)){
            $error =$data." must not be empty";
        }elseif(!preg_match("/^[a-zA-Z]+$/",$data)){
        $error=$data." is invalid";
        }else{
            $error=false;
        }
 return $error;
    }


    public function validateRegno($data){
        if(empty($data)){
            $error =$data." must not be empty";
        }elseif(!preg_match("/^[a-zA-Z0-9]+$/",$data)){
        $error=$data." is invalid";
        }else{
            $error=false;
        }
 return $error;
    }

    public function validateemail($data){
        if(empty($data)){
            $error =$data." must not be empty";
        }elseif(!filter_var($data,FILTER_VALIDATE_EMAIL)){
            $error=$data." is invalid";
        }else{
            $error=false;
            
            
        }
        return  $error;

    }

    public function test_input($data){
        $data=htmlspecialchars($data);
        $data=trim($data);
        $data=stripslashes($data);
        return $data;
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($this->conn, $sql);
    
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION['names'] = $row['names'];
                $_SESSION['user_id'] = $row['user_id'];  // Fixed missing underscore

                $userinf=[
                    "email"=>$row['email'],
                    "password"=>$row['password']
                ];
                setcookie('user', serialize($userinf), time() + 3600, '/');
    
                header("Location: admin_dashboard.php");
                exit();  // Stop script execution after redirection
            }
        } else {
            echo "<script>alert('No account found'); window.location.href='index.php';</script>";
        }
    }

    public function add_student($names,$email,$department,$regno) {
        $sql="INSERT INTO students_info(names,email,department,regno)
        VALUES('$names','$email','$department','$regno')";
        $save=mysqli_query($this->conn,$sql);
        if($save){
            echo "<script>alert('student registred successfully');</script>";
        }else{
            echo "<script>alert('something went wrong'); window.location.href='backend_handler.php';</script>";
        }
    }

    public function select_student() {
        $sql = "SELECT * FROM students_info ORDER BY date DESC";
        $result = mysqli_query($this->conn, $sql);
    
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['names']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['regno']}</td>
                    <td>{$row['department']}</td>
                    <td>{$row['date']}</td>
                    <td>
                        <form action='' method='get'>
                            <input type='hidden' name='student_id' value='{$row['student_id']}'>
                            <input type='hidden' name='names' value='{$row['names']}'>
                            <input type='submit' class='btn btn-success update_student_b' name='edit' value='Edit'>
                            <input type='submit' class='btn btn-danger' name='delete' value='Remove'>
                        </form>
                    </td>
                </tr>";
            }
        }
    
        // Handle form submissions for delete and edit outside of the loop
        if (isset($_GET['delete'])) {
            $student_id = $_GET['student_id'];
            $this->delStudent($student_id);
        }
    
        if (isset($_GET['edit'])) {
                    // Check if the session variable exists and unset it
            if (isset($_SESSION['student_id'])) {
                unset($_SESSION['student_id']);
                $_SESSION['student_id'] = $_GET['student_id'];
            }else{
                $_SESSION['student_id'] = $_GET['student_id'];
            }

                
            

            // Set the session variable with the new student ID
            
               
            

    
            echo "<div class='confirm bg-dark'>
                <form action='' method='post'>
                   <span class='text-white text-center'> Are you sure you want to update student called {$_GET['names']}?</span>
                    <input type='submit' class='btn btn-success update_student_btn' name='confirm_edit' value='Confirm Edit'>
                </form>
            </div>";
        }
    }
    
    
    
    public function delStudent($student_id){
        $sql="delete from students_info where student_id='$student_id'";
        if(mysqli_query($this->conn,$sql)){
            echo "<script>alert('student removed successfully'); window.location.href='admin_dashboard.php';</script>";
        }else{
            echo "<script>alert('something went wrong');window.location.href='admin_dashboard.php';</script>";
        }
    }

    public function updatestudent($student_id,$names,$email,$department,$regno){
        $sql="UPDATE students_info set names='$names' ,email='$email', department='$department' ,regno='$regno' where student_id='$student_id'";
        if(mysqli_query($this->conn,$sql)){
          
            echo "<script>alert('student called $names updated successfully'); window.location.href='admin_dashboard.php';</script>";
     
        }else{
             
            echo "<script>alert('something went wrong');window.location.href='admin_dashboard.php';</script>";
           
        }
    }
    public function studentToUpdateInfo($student_id){
        $sql="SELECT * FROM students_info where student_id='$student_id' order by date desc";
        $result = mysqli_query($this->conn, $sql);
    
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $names=$row['names'];
              $email=$row['email'];
              $regno=$row['regno'];
              $department=$row['department'];
              $studinfo=[
                "names"=>$names,
                "email"=>$email,
                "regno"=>$regno,
                "department"=>$department
              ];
              return $studinfo;


        }

    }
    }


}
?>
<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location:index.php");
}
include("backend_handler.php");
$check=new Backend_handler();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .add_student{
        margin-top: -50px;
        padding:1%;
        width:40%;
        box-shadow: 0 10px 10px 10px;
        margin-bottom: 1%;
        margin-left: 30%;
        display: none;
    }
    .update_student{
        margin-top: -50px;
        padding:1%;
        width:40%;
        box-shadow: 0 10px 10px 10px;
        margin-bottom: 1%;
        margin-left: 30%;
        display: none;
    }

    .header {
    position: fixed; /* Fixed at the top of the viewport */
    top: 0;
    width: 100%;
    display: flex;
    justify-content: center; /* Center the content horizontally */
    align-items: center; /* Center the content vertically */
    background-color: #f1f1f1; /* Background color */
    padding: 10px; /* Padding */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Shadow for visibility */
    z-index: 1000; /* Ensures header is above other content */
}

.footer {
    position: fixed; /* Fixed at the bottom of the viewport */
    bottom: 0;
    width: 100%;
    display: flex;
    justify-content: center; /* Center the content horizontally */
    align-items: center; /* Center the content vertically */
    background-color: #f1f1f1; /* Background color */
    padding: 10px; /* Padding */
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1); /* Shadow for depth */
    z-index: 1000; /* Ensures footer is above other content */
}
.container {
    margin-top:100px
}

</style>
<body>
    <div class="header p-3 bg-secondary m-1">
    <h2 class="text-white text-center"><u>Student Management System</u></h2>
    </div>
    <div class="container">

        <div class="user_info m-2">
           
            <span class="add">
                <button class="btn btn-success" data-toggle="collapse" id="add_student" data-target="#">Add student</button>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
                
                <div class="add_student" id="add_student_form">
                    <div class="col-lg-12">
                <form action=""method="POST">
                    
        <h2 class="text-primary m-2">Add student</h2>
        <div class="row">
         <div class="col-lg-3">
           <label for="">Names:</label>
         </div>  
         <div class="col">
          <input type="text" name="names" class="form-control" placeholder="Enter student names">
         <span class="text-danger"> <?php echo isset($_POST['names']) ?$check->validateName($_POST['names']):"";?></span>

         </div>
        </div> <br>

        <div class="row">
         <div class="col-lg-3">
           <label for="">Reg number:</label>
         </div>  
         <div class="col">
          <input type="text" name="regno" class="form-control" placeholder="Enter student registration number">
         <span class="text-danger"> <?php echo isset($_POST['regno']) ?$check->validateRegno($_POST['regno']):"";?></span>

         </div>
        </div> <br>

        <div class="row">
         <div class="col-lg-3">
           <label for="">Department:</label>
         </div>  
         <div class="col">
          <input type="text" name="department" class="form-control" placeholder="Enter student department">
         <span class="text-danger"> <?php echo isset($_POST['department']) ?$check->validateName($_POST['department']):"";?></span>
         </div>
        </div> <br>
        <div class="row">
         <div class="col-lg-3">
           <label for="">Email:</label>
         </div>  
         <div class="col">
          <input type="email" name="email" class="form-control" placeholder="Enter your email address">
         <span class="text-danger"> <?php echo isset($_POST['email']) ?$check->validateemail($_POST['email']):"";?></span>
         </div>
        </div> <br>
    
    <input type="submit" name="register"value="Register" class="btn btn-primary">

    <?php

if(isset($_POST['register'])){
 
    $errorvalidateemail= $check->validateemail($_POST['email']);
    $errorvalidatename= $check->validateName($_POST['names']);
    $errorvalidateDepartment=$check->validateName($_POST['department']);
    $errorvalidateRegno=$check->validateRegno($_POST['regno']);
  

    if(!$errorvalidateemail && !$errorvalidatename && !$errorvalidateDepartment && !$errorvalidateRegno){
        $email=$check->test_input($_POST['email']);
        $names=$check->test_input($_POST['names']);
        $department=$check->test_input($_POST['department']);
        $regno=$check->test_input($_POST['regno']);
        $check->add_student($names,$email,$department,$regno);
    }else{
        echo" <script> alert('All inputs are required and make  sure you have valid data inserted')</script>";
    }
}
?>
        
    </form>
    </div>
                </div>


                <div class="update_student" id="update_student_form">
                    <div class="col-lg-12">
                <form action=""method="POST">
                    
                    <?php 

                   
                    $student_id=$_GET["student_id"];
                    $info = $check->studentToUpdateInfo($student_id);
                    ?>
                    
        <h2 class="text-primary m-2">update student's information</h2>
        <div class="row">
         <div class="col-lg-3">
           <label for="">Names:</label>
         </div>  
         <div class="col">
          <input type="text" name="names" class="form-control" value="<?php echo $info['names'] ?>" placeholder="Enter student names">
         <span class="text-danger"> <?php echo isset($_POST['names']) ?$check->validateName($_POST['names']):"";?></span>

         </div>
        </div> <br>

        <div class="row">
         <div class="col-lg-3">
           <label for="">Reg number:</label>
         </div>  
         <div class="col">
          <input type="text" name="regno" class="form-control" value="<?php echo $info['regno'] ?>" placeholder="Enter student registration number">
         <span class="text-danger"> <?php echo isset($_POST['regno']) ?$check->validateRegno($_POST['regno']):"";?></span>

         </div>
        </div> <br>

        <div class="row">
         <div class="col-lg-3">
           <label for="">Department:</label>
         </div>  
         <div class="col">
          <input type="text" name="department" class="form-control"value="<?php echo $info['department'] ?>" placeholder="Enter student department">
         <span class="text-danger"> <?php echo isset($_POST['department']) ?$check->validateName($_POST['department']):"";?></span>
         </div>
        </div> <br>
        <div class="row">
         <div class="col-lg-3">
           <label for="">Email:</label>
         </div>  
         <div class="col">
          <input type="email" name="email" value="<?php echo $info['email'] ?>"class="form-control" placeholder="Enter your email address">
         <span class="text-danger"> <?php echo isset($_POST['email']) ?$check->validateemail($_POST['email']):"";?></span>
         </div>
        </div> <br>
    
    <input type="submit" name="update"value="Update" class="btn btn-primary">

    <?php

if(isset($_POST['update'])){
 
    $errorvalidateemail= $check->validateemail($_POST['email']);
    $errorvalidatename= $check->validateName($_POST['names']);
    $errorvalidateDepartment=$check->validateName($_POST['department']);
    $errorvalidateRegno=$check->validateRegno($_POST['regno']);
  

    if(!$errorvalidateemail && !$errorvalidatename && !$errorvalidateDepartment && !$errorvalidateRegno){
        $email=$check->test_input($_POST['email']);
        $names=$check->test_input($_POST['names']);
        $department=$check->test_input($_POST['department']);
        $regno=$check->test_input($_POST['regno']);
        $check->updatestudent($student_id,$names,$email,$department,$regno);
    }else{
        echo" <script> alert('All inputs are required and make  sure you have valid data inserted')</script>";
    }
}
?>
        
    </form>
    </div>
                </div>                

            </span>
            <table class="table table-hover">
       <thead>
            <th>Names</th>
            <th>Email</th>
            <th>Reg number</th>
             <th>Department</th>
             <th>Date of registration</th>
             <th>Action</th>
        </thead>
        <tbody>
       <?php
       
       $check->select_student();
       ?></tbody>
          

            
            </table>
        </div>
    </div>
    <div class="footer p-4 bg-secondary">
        Designed by <a  class="text-center text-white " href=""> Manzi Bahizi Bertin</a>
    </div>
    <script src="script.js"></script>
    
</body>
</html>
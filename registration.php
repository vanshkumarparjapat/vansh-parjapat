 
<?php
 session_start();
 include 'include/dbconnection.php';
  
 $NameErr = "";
 $EmailErr = "";
 $PasswordErr = "";
 
 function test_input($data)
 {
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
 }
 
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
     $Name = test_input($_POST["Name"]);
     $Email = test_input($_POST["Email"]);
     $Password = test_input($_POST["Password"]);
 
     if (empty($Name)) {
         $NameErr = "<br>Name Field is required";
     } elseif (empty($Email)) {
         $EmailErr = "<br>Email field is required";
     } elseif (empty($Password)) {
         $PasswordErr = "<br>Password field is required";
     }
 
 
     
     
     // Check for errors
     if ($NameErr == "" && $EmailErr == "" && $PasswordErr == "") {
         // Check if email already exists
         $sql = "SELECT * FROM registration WHERE Email='$Email'";
         $result = mysqli_query($conn, $sql);
     
         if (mysqli_num_rows($result) > 0) {
             $EmailErr = "Email Already Exists";
         } else {
             // Hash the password
             $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
     
             // Insert new record
             $sql = "INSERT INTO registration (Name, Email, Password) VALUES ('$Name', '$Email', '$hashedPassword')";
             if (mysqli_query($conn, $sql)) {
                 $_SESSION['success_message'] = "<h2>Your message has been sent successfully!</h2>";
                 header("Location: registration.php");
                 exit;
             } else {
                 echo "Error: " . $sql . "<br>" . mysqli_error($conn);
             }
         }
     }
    }
     ?>
     
 
 <!DOCTYPE html>
 <html lang="en">
 
 <head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
   <link rel="icon" type="image/png" href="../assets/img/favicon.png">
   <title>
     Material Dashboard 2 by Creative Tim
   </title>
   <!--     Fonts and icons     -->
   <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
   <!-- Nucleo Icons -->
   <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
   <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
   <!-- Font Awesome Icons -->
   <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
   <!-- Material Icons -->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
   <!-- CSS Files -->
   <link id="pagestyle" href="assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
   <!-- Nepcha Analytics (nepcha.com) -->
   <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
   <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
 </head>
 <style>.error {
   color: red;
   
 } 
  
 </style>
 <body class="">
   <div class="container position-sticky z-index-sticky top-0">
     <div class="row">
       <div class="col-12">
         <!-- Navbar -->
          <?php include "include/loginregisternav.php";?>
         <!-- End Navbar -->
       </div>
     </div>
   </div>
   <main class="main-content  mt-0">
     <section>
       <div class="page-header min-vh-100">
         <div class="container">
           <div class="row">
             <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
               <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center" style="background-image: url('assets/img/illustrations/illustration-signup.jpg'); background-size: cover;">
               </div>
             </div>
             <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
               <div class="card card-plain">
                 <div class="card-header">
                   <h4 class="font-weight-bolder">Sign Up</h4>
                   <p class="mb-0">Enter your email and password to register</p>
                 </div>
                 <div class="card-body">
                 <?php if(isset($_SESSION['success_message'])): ?>
        <div style="color: red;">
            <?php echo $_SESSION['success_message']; ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
                   <form class="omn" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

                   <h1 class="project3">Register form </h1>
                   <div class="iph">Name: <input type="text" name="Name">
                   <span class="error">* <?php  echo $NameErr; ?></span>
                   <br><br>
                   E-mail: <input type="text" name="Email">
 
                   <span class="error">* <?php echo $EmailErr;?></span>
                   <br><br></div>
                   
                   
                   Password: <input type="text" name="Password">
                   <span class="error">* <?php echo $PasswordErr; ?> </span>
                 </div>
                 <br><br>
                   <input type="submit" name="submit" value="Register">  
                    <a href ="login.php"><h1>Go to login</h1></a>
                 </form>
                 </div>   
                 <div class="card-footer text-center pt-0 px-lg-2 px-1">
                   <p class="mb-2 text-sm mx-auto">
                     Already have an account?
                     <a href="login.php" class="text-primary text-gradient font-weight-bold">Sign in</a>
                   </p>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </section>
   </main>
   <!--   Core JS Files   -->
   <script src="assets/js/core/popper.min.js"></script>
   <script src="assets/js/core/bootstrap.min.js"></script>
   <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
   <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
   <script>
     var win = navigator.platform.indexOf('Win') > -1;
     if (win && document.querySelector('#sidenav-scrollbar')) {
       var options = {
         damping: '0.5'
       }
       Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
     }
   </script>
   <!-- Github buttons -->
   <script async defer src="https://buttons.github.io/buttons.js"></script>
   <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
   <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>
 </body>
 
 </html>
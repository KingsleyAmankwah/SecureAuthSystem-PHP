<?php
include './function/utils.php';


if (isset($_POST['submit'])) {
  $name = validateUserInput($_POST['name']);
  $email = validateUserInput($_POST['email']);
  $password = validateUserInput($_POST['password']);

  $C = connect();
  
  if($C){
    $res = sqlSelect($C, 'SELECT email FROM users WHERE email=?', 's', $email);
      if($res && $res->num_rows == 0){
        $hash = password_hash($password , PASSWORD_DEFAULT);

        $id = sqlInsert($C, 'INSERT INTO users VALUES(NULL, ?, ?, ?)', 'sss', $name, $email, $hash);
          if($id !== -1){
            $_SESSION['status'] = "Account created successfully";
            $_SESSION['icon'] = "success";
            // header('Location : login.php');
          }
        else{
          $_SESSION['msg'] = 'Registeration failed. Try again';
          $_SESSION['type'] = 'error';
        }
      }else{
        $_SESSION['msg'] = 'Email already exists!';
        $_SESSION['type'] = 'error';
      }
  }


}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Secure Auth System</title>

  <!-- core:css -->
  <link rel="stylesheet" href="assets/vendors/core/core.css">
  <!-- endinject -->

  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="assets/vendors/sweetalert2/sweetalert2.min.css">
  <!-- End plugin css for this page -->

  <!-- Layout styles -->
  <link rel="stylesheet" href="assets/css/demo1/style.css">
  <!-- End layout styles -->
</head>

<body>
  <div class="main-wrapper">
    <div class="page-wrapper full-page bg-black">
      <div class="page-content d-flex align-items-center justify-content-center">

        <div class="row w-100 mx-0 auth-page">
          <div class="col-md-8 col-xl-6 mx-auto">
            <div class="card">
              <div class="row">
                <div class="col-md-2 pe-md-0">
                  <!-- <div class="auth-side-wrapper">

                  </div> -->
                </div>
                <div class="col-md-8 ps-md-0">
                  <div class="auth-form-wrapper px-4 py-5">
                    <h5 class=" text-center mb-4 mt-4">Secure Authentication System</h5>
                    <form class="forms-sample" method="POST">
                     <h5 class="text-muted font-weight-normal mb-4">Create a free account.</h5>

                      <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter username...">
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email....">
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" autocomplete="current-password" placeholder="Enter Password...">
                      </div>
                      <div class="form-check mb-0">
                      </div>
                      <div>
                        <button type="submit" name="submit" class="btn btn-success me-2 mb-2 mb-md-0 text-white">
                          Sign up
                        </button>
                      </div>
                      <a href="login.php" class="d-block mt-3 text-muted">Already a user? Sign in</a>
                    </form>
                  </div>
                </div>
                <div class="col-md-2 pe-md-0">
                  <!-- <div class="auth-side-wrapper">

                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- core:js -->
  <script src="assets/vendors/core/core.js"></script>
  <!-- endinject -->

  <!-- Plugin js for this page -->
  <script src="assets/vendors/sweetalert2/sweetalert2.min.js"></script>
  <!-- End plugin js for this page -->


</body>

</html>


<?php if(isset($_SESSION['msg']) && $_SESSION['msg'] !== ''){ ?>

  <script>
    Swal.fire({
      title: '<?php echo $_SESSION['msg'] ?>',
      icon: '<?php echo $_SESSION['type'] ?>',
      timer: 2000,
    })
  </script>

<?php 
  unset($_SESSION['msg']);
} 
?>
<?php if(isset($_SESSION['status']) && $_SESSION['status'] !== ''){ ?>

  <script>
    Swal.fire({
      title: '<?php echo $_SESSION['status'] ?>',
      icon: '<?php echo $_SESSION['icon'] ?>',
      timer: 2000,
    }).then(function () {
      window.location = 'login.php'
    })
  </script>

<?php 
  unset($_SESSION['status']);
} 
?>
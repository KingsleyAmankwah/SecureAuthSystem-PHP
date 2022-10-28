<?php
include './function/utils.php';

if(!isset($_SESSION['uid']) && $_SESSION['uid'] !== ''){
    header('Location: login.php');
    exit;
}

if(isset($_POST['reset'])){
    $password = validateUserInput($_POST['password']);
    $confirmPwd = validateUserInput($_POST['confirmPassword']);
    

    if($password === $confirmPwd){
        $C = connect();
        if($C){
            $hash = password_hash($confirmPwd, PASSWORD_DEFAULT);
            //   $id = sqlSelect($C, 'SELECT * FROM users WHERE id=?', 'i', $_SESSION['uid']);
           sqlUpdate($C , 'UPDATE users SET password=? WHERE id=?', 'si' ,$hash, $_SESSION['uid']);
            $_SESSION['stats'] = "Password changed successfully";
            $_SESSION['type'] = "success";
            // header('Location: login.php');
          }
            
    }else{
        $_SESSION['msg'] = "The two passwords do not match";
        $_SESSION['type'] = "error";
       
    }

 
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Secure Auth System</title>

    <!-- core:css -->
    <link rel="stylesheet" href="assets/vendors/core/core.css" />
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <link
      rel="stylesheet"
      href="assets/vendors/sweetalert2/sweetalert2.min.css"
    />
    <!-- End plugin css for this page -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/demo1/style.css" />
    <!-- End layout styles -->
  </head>

  <body>
    <div class="main-wrapper">
      <div class="page-wrapper full-page bg-black">
        <div
          class="page-content d-flex align-items-center justify-content-center"
        >
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
                      <section
                        style="display: flex; justify-content: space-between"
                      ></section>
                      <h5 class="text-center mb-4 mt-4">
                        Secure Authentication System
                      </h5>
                      <form class="forms-sample" method="POST">
                        <h5 class="text-muted font-weight-normal mb-4">
                          Reset password.
                        </h5>

                       

                        <div class="mb-3">
                          <label class="form-label">Password</label>
                          <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter password"
                          />
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Confirm Password</label>
                          <input
                            type="password"
                            name="confirmPassword"
                            class="form-control"
                            placeholder="Confirm password"
                          />
                        </div>

                        <div>
                          <button
                            type="submit"
                            name="reset"
                            class="btn btn-primary me-2 mb-2 mb-md-0 text-white"
                          >
                            Reset Password
                          </button>
                        </div>

                

                        <a href="login.php" class="d-block mt-3 text-muted"></a>
                      </form>
                    </div>
                  </div>
                  <div class="text-center mb-4">
                    <div class="auth-side-wrapper">
                      <a href="login.php" class="d-block mt-3 text-muted"
                        >Go back to log in</a
                      >
                    </div>
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


<?php if(isset($_SESSION['stats']) && $_SESSION['stats'] !== ''){ ?>

<script>
  Swal.fire({
    'title': '<?php echo $_SESSION['stats']; ?>',
    'icon': '<?php echo $_SESSION['type']; ?>',
     timer: 3000,
  }).then((function () {
    window.location = 'login.php';
  }))
</script>

<?php 
  unset($_SESSION['stats']);
} 
?>
<?php if(isset($_SESSION['msg']) && $_SESSION['msg'] !== ''){ ?>

<script>
  Swal.fire({
    'title': '<?php echo $_SESSION['msg']; ?>',
    'icon': '<?php echo $_SESSION['type']; ?>',
     timer: 2000,
  })
</script>

<?php 
  unset($_SESSION['msg']);
} 
?>

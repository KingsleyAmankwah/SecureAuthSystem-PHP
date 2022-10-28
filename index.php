<?php 
    require_once './function/utils.php';

    if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true){
        header("Location : login.php");
        exit;
    }

    $C = connect();
    if($C){
        $res = sqlSelect($C, 'SELECT * FROM users WHERE id=?', 'i', $_SESSION['user_id']);
            if($res && $res->num_rows == 1){
                $user = $res->fetch_assoc();
            }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Hello <?php echo $user['name']; ?> Welcome <br/>
    <a href="logout.php">Logout</a>
</body>
</html>
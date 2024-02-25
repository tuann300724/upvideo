<?php
include("../connect.php");
$name = $email = $password = "";
$nameerror = $passworderror = $emailerror = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = filter_input(INPUT_POST,'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if(empty($name)){
        $nameerror = "Không được bỏ trống name";
    }
    if(strlen($name) > 10){
        $nameerror = "Tên chỉ được 10 ký tự trở xuống";
    }
    if(empty($email)){
        $emailerror = "Không được bỏ trống email";
    }
    if(empty($password)){
        $passworderror = "Không được bỏ trống password";
    }
    if(empty($nameerror) && empty($emailerror) && empty($passworderror)){
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name,email,password) value (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name,$email,$passwordhash);
        $stmt->execute();
        $stmt->close();
        $success = True;
        header("Location: login.php?success=".$success);
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Đăng Ký</h2>
  <form method="post">
    <div class="mb-3 mt-3">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php echo $name ?>">
    </div>
    <span class="text-danger"><?php echo $nameerror ?></span>
    <div class="mb-3 mt-3">
      <label for="email">Email:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <span><?php echo $email ?></span>
    <span class="text-danger"><?php echo $emailerror ?></span>

    <div class="mb-3">
      <label for="password">Password:</label>
      <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
    </div>
    <span class="text-danger"><?php echo $passworderror ?></span>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>

</body>
</html>

<?php
session_start();
include("../connect.php");

$email = $password = "";
$error = "";

if(isset($_SESSION['logged'])){
    header("Location: ../home/index.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($password)) {
        $error = "Ko đc đế trống password";
    }
    if (empty($error)) {
        $sql = "SELECT password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $passwordhash = $row["password"];

            if (password_verify($password, $passwordhash)) {
                $_SESSION['logged'] = True;
                header("Location: ../home/index.html");
                exit;
            } else {
                $error = "Sai tài khoản hoặc mật khẩu";
            }
        } else {
            $error = "Người Dùng Chưa Đăng Ký";
        }
    }
   
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="popup.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php
    if(isset($_GET["success"])) { ?>
        <div class="popup" id="popup">
        <img src="404-tick.png">
        <h2>Đăng Ký Thành Công</h2>
        <button type="button" onclick="closepopup()">OK</button>
    </div> 
    
    <?php  }
    ?>
    <div class="container mt-3">
        <h2>Đăng Nhập</h2>
        <form method="post">
            <div class="mb-3 mt-3">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="mb-3">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
            </div>
            <span class="text-danger">
                <?php echo $error . "<br>" ?>
            </span>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script>
        let popup = document.getElementById("popup");
        function closepopup() {
            popup.style.transform = "translate(-50%,-50%) scale(0.1)";
            popup.style.top = "-200px";
            // popup.style.visibility = "hidden";
        }
        function showPopup() {
            popup.classList.add("show");
        }
        window.onload = function () {
            showPopup();
        };
    </script>
</body>

</html>
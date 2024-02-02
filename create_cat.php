<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
     require_once("connect.php");
     $name = "";
         if($_SERVER['REQUEST_METHOD'] == "POST"){
             $name = $_POST["name"];
     
             if(empty($name)){
                 $nameError = "Name is required";
             }
          
             if(empty($nameError)){
                     $sql = "INSERT INTO category
                         (name)
                         VALUES(?)";
                     $stmt = $conn->prepare($sql);
                     $stmt->bind_param("s", $name);
                     $stmt->execute();
                     $stmt->close();
                     header("Location: show.php");
             }
         }
    ?>
    <form method="post">
    <input type="text" class="form-control"
                 id="name" placeholder="Enter name" name="name">
    <button type="submit">Submit</button>
</form> 
</body>
</html>

<?php 
include "connect.php";
 $categories = "SELECT * FROM category";
 $result_categories = mysqli_query($conn, $categories);
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }
        input{
            font-size: 2rem;
        }
    </style>
</head>
<body>
    <a href="view.php">back</a>
    <?php if(isset($_GET['error'])){ ?>
<p>ko the up file nay</p>
        <?php }?>
    <form action="create.php"
    method="post"
    enctype="multipart/form-data"
 >

        <input type="file" name="video">
        <input type="text" name="name">
 
        
        <select name="cat_id">
    <option value="">Select category...</option>
    <?php while ($category = mysqli_fetch_assoc($result_categories)) { ?>
        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
    <?php } ?>
</select>
     
        <input type="submit"
        name="submit"
        value="Upload">
    </form>
</body>
</html>
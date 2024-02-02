<?php 
if(isset($_POST['submit']) && isset($_FILES['video']) ){
    include "connect.php"; // Include the file for database connection (adjust the path if needed)

    // Fetch categories from the database
    $categories_query = "SELECT * FROM category";
    $result_categories = mysqli_query($conn, $categories_query);

    // Check if there is an error in the uploaded file
    $video_name = $_FILES['video']["name"];
    $tmp_name = $_FILES['video']["tmp_name"];
    $name = $_POST['name'];
    $error = $_FILES['video']["error"];

    if($error === 0){
        // File upload is successful, process the file
        $video_ex = pathinfo($video_name, PATHINFO_EXTENSION);
        $video_ex_lc = strtolower($video_ex);
        $allowed_exs = array("mp4",'webm','avi','flv');

        if(in_array($video_ex_lc, $allowed_exs)){
            // Generate a new unique name for the uploaded file
            $new_name = $name;
            $new_video_name = uniqid("video-", true) . '.' . $video_ex_lc;
            $video_upload_path = 'uploads/'.$new_video_name;
            move_uploaded_file($tmp_name, $video_upload_path);

            // Get the selected category ID
            $cat_id = $_POST['cat_id'];

            // Execute the SQL query to insert into the database
            $sql= "INSERT INTO video(video_url, name, cat_id) VALUES('$new_video_name','$new_name', '$cat_id')";
            mysqli_query($conn, $sql);

            // Redirect after the query execution
            header("Location: view.php");
            exit; // Ensure script stops here
        } else {
            // Invalid file type, redirect with error message
            $em = "Không thể upload file này.";
            header("Location: show.php?error=$em");
            exit; // Ensure script stops here if redirecting
        }
    }
} else {
    // Redirect if form is not submitted properly
    header("Location: show.php");
    exit; // Ensure script stops here if redirecting
}
?>

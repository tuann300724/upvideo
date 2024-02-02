

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            min-height: 100vh;
        } */

        .video-container {
            margin: 10px;
        }

        video {
            width: 320px;
            height: 180px;
        }

        li {
            list-style: none;
        }

        /* Style for the video links */
        .video-link {
            text-decoration: none;
            /* Remove underline */
            color: #333;
            /* Set text color */
            padding: 5px 10px;
            /* Add padding */
            background-color: #f0f0f0;
            /* Add background color */
            border-radius: 5px;
            /* Add border radius */
            margin: 5px;
            /* Add margin */
            display: inline-block;
            /* Make the link a block element */
            transition: background-color 0.3s;
            /* Add transition effect */
        }

        /* Hover effect for the video links */
        .video-link:hover {
            background-color: #ddd;
            /* Change background color on hover */
        }
    </style>
</head>

<body>
        <h1>Video Thể loại 1</h1>
    <a href="show.php">Upload</a> 
    <a href="view.php">Thể loại 2</a>
    <div class="video-container">
        <?php
        include "connect.php";
        $sql = "SELECT * FROM video  WHERE cat_id = 1 ORDER BY id ASC";
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            while ($video = mysqli_fetch_assoc($res)) {
                
        ?>
                <ul>
                    <li>
                        <a class="video-link" href="#" onclick="showVideo('<?= $video['video_url'] ?>','<?= $video['name'] ?>')"><?= $video['name'] ?></a>
              
                    </li>
                </ul>
        <?php
            }
        } else {
            echo "<h1>Empty</h1>";
        }
        ?>
    </div>
    <script>
        function showVideo(videoUrl, videoName) {
            var videoPlayer = document.createElement('video');
            videoPlayer.src = "uploads/" + videoUrl;
            videoPlayer.controls = true;
            videoPlayer.autoplay = true;
            videoPlayer.style.width = "640px";
            videoPlayer.style.height = "360px";
            var modal = document.createElement('div');
            modal.style.position = "fixed";
            modal.style.top = "0";
            modal.style.left = "0";
            modal.style.width = "100%";
            modal.style.height = "100%";
            modal.style.backgroundColor = "rgba(0, 0, 0, 0.7)";
            modal.style.display = "flex";
            modal.style.justifyContent = "center";
            modal.style.alignItems = "center";
            modal.appendChild(videoPlayer);
            modal.onclick = function() {
                modal.remove();
            };
            document.body.appendChild(modal);
        }
        function getVideoDuration(filePath) {
            var video = document.createElement('video');
            video.src = filePath;
            video.preload = "metadata";
            return new Promise((resolve, reject) => {
                video.onloadedmetadata = function() {
                    var duration = Math.floor(video.duration);
                    var minutes = Math.floor(duration / 60);
                    var seconds = duration % 60;
                    var formattedDuration = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
                    resolve(formattedDuration);
                };
                video.onerror = function() {
                    reject('Unable to retrieve duration.');
                };
            });
        }
    </script>
</body>

</html>

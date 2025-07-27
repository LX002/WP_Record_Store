<?php
    require_once ("classes/Beat.php");
    require_once ("classes/Korisnik.php");
    require_once ("db_utils.php");
    session_start();
    $db = new Database();
    $username = htmlspecialchars($_GET["username"]);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Beat upload</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="beat">
        <p id="heading">Upload a beat</p>
        <form action="beat_upload.php?username=<?php echo $username; ?>"  id="upload-form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="MAX_FILE_SIZE" value="16777216" />
            <input type="file" name="beat" /> &nbsp;&nbsp;
            <input type="submit" name="uploadBeat" value="Upload" />
        </form>
    </div>
    <?php
        if(isset($_POST["uploadBeat"])) {
            if(isset($_FILES["beat"]) && $_FILES["beat"]["error"] == UPLOAD_ERR_OK) {
                if($_FILES["beat"]["type"] != "audio/mpeg") {
                    echo "<div class=\"fail\">Only mp3 files can be uploaded!</div>";
                } else if(!move_uploaded_file($_FILES["beat"]["tmp_name"], "beats/" . basename($_FILES["beat"]["name"]))) {
                    echo "<div class=\"fail\">The beat upload was not successful - {$_FILES["beat"]["error"]}<br>";
                    echo "<a href=\"albumGrid.php?username={$username}\">Go back to the albums {$username}</a></div>";
                } else {
                    $korisnik = $db->findUserByUsername($username);
                    $beat = new Beat("beats/" . basename($_FILES["beat"]["name"]), $korisnik->getIdKorisnik());
                    if($db->insertBeat($beat)) {
                        echo "<div class=\"success\">The beat is uploaded successfuly!<br>";
                        echo "<a href=\"albumGrid.php?username={$username}\">Go back to the albums {$username}</a></div>";
                    } else {
                        echo "<div class=\"warning\">The beat is uploaded, but not inserted into database!<br>";
                        echo "<a href=\"albumGrid.php?username={$username}\">Go back to the albums {$username}</a></div>";
                    }
                }
            } else {
                switch($_FILES["beat"]["error"]) {
                    case UPLOAD_ERR_INI_SIZE:
                        $message = "Beat has a larger size than the server allows.";
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $message = "Beat has a larger size than the form allows.";
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $message = "No file was uploaded - make sure you select a beat you want to upload.";
                        break;
                    default:
                        $message = "";
                }
                echo "<div class=\"fail\">The beat upload was not successful.<br>$message";
                echo "<a href=\"albumGrid.php?username={$username}\">Go back to the albums {$username}</a></div>";
            }
        }
    ?>
</body>
</html>
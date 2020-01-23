<?php
    $sqllink=mysqli_connect("shareddb-r.hosting.stackcp.net","my_daiyry-3132333d53","Admin@741","my_daiyry-3132333d53");
    if(mysqli_connect_error()){
        $error.="connection Error";
        die("Database Connection Error");
    }
?>
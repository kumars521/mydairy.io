<?php

    session_start();
    if( array_key_exists("id",$_COOKIE)){

        $_SESSION['id']=$_COOKIE['id'];
    }

    if(array_key_exists("id",$_SESSION)){
        echo "<p>logged in ! <a href='index.php?logout=1'>log out</a></P>";
    }else{
        header("Location: index.php");
    }
    include("headerfile.php");
?>

    <div class="container-fluid">
        <textarea id="Dairy" class="form-control"></textarea>
    </div>

    <?php include("footerfile.php");?>

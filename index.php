<?php
    session_start();
    $error="";
    //$salt="kgdfldkfj65612565DSKJSJJK";
    if(array_key_exists("logout",$_GET)){
        unset($_SESSION);

        setcookie("id",time()-60*60);
        $_COOKIE["id"]="";
    }else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        header("Location: loggedinpage.php");
    }
    if(array_key_exists("submit",$_POST)){
        include("Mysqlconnection.php");
        if(!$_POST['email']){
            $error.="An email address is required! <br>";
        }
        if(!$_POST['password']){
            $error.="Password is required! <br>";
        }
        
        if($error!=""){
            $error.="<p>There were error(s) in your form : </P>".$error;
        }else{
            if($_POST['signup']=='1'){
                $Sel_Query="Select id from my_Daily_Data where email='".mysqli_real_escape_string($sqllink,$_POST['email'])."'";
                $QResult=mysqli_query($sqllink,$Sel_Query);
                
                if(mysqli_num_rows($QResult)>0){
                    $error.= "This email Id is already registered !";
                    
                }else{
                    //$ins_Query="insert into `my_Daily_Data` (`email`,`password`) values(email='".mysqli_real_escape_string($sqllink,$_POST['email'])."','".mysqli_real_escape_string($sqllink,$_POST['password'])."')";
                    $ins_Query="insert into `my_Daily_Data` (`email`,`password`) values ('".mysqli_real_escape_string($sqllink,$_POST['email'])."','".mysqli_real_escape_string($sqllink,$_POST['password'])."')";
                    if(!mysqli_query($sqllink,$ins_Query)){
                    $error.="<p> Could not sign you up - Please try again. </P>";  
                    }else{
                       // $Up_Query="Update `my_Daily_Data` set password='".md5(md5(mysqli_insert_id($sqllink)).$_POST['passowrd'])."' where Id=".mysqli_insert_id($sqllink)." limit 1";
                        $Up_Query="Update `my_Daily_Data` set password='".md5($_POST['passowrd'])."' where id=".mysqli_insert_id($sqllink)." limit 1";
                        mysqli_query($sqllink,$Up_Query);
                        $_Session['Id']=mysqli_insert_id($sqllink);
                        if($_POST['stayLoggedin']=='1'){
                        setcookie("id",mysqli_insert_id($sqllink),time()+60*60*24*365);  
                        //header("Location : loggedinpage.php");
                        }
                        header("Location: loggedinpage.php");
                    //$error.="You are signed up successfully!";
                    }
                    
                    //$Sel_Query_2="Select * from my_Daily_Data where email='".mysqli_real_escape_string($sqllink,$_POST['email'])."'";
                    
                    //$InsResult=mysqli_query($sqllink,$Sel_Query_2);
                    //$row=mysqli_fetch_array($InsResult);
                    //$error.="Data From Database " .$row['email'];
                }
            }else{

                $Sel_Query1="Select * from `my_Daily_Data` where email='".mysqli_real_escape_string($sqllink,$_POST['email'])."'";//and password='".mysqli_real_escape_string($sqllink,$_POST['password'])."'";
                $QResult1=mysqli_query($sqllink,$Sel_Query1);
                if(mysqli_num_rows($QResult1)>0){
                    $row="";
                    $row=mysqli_fetch_array($QResult1);
                    if(isset($row)){
                   // if(array_key_exists("Id",$row)){
                        //$hashedpassword=md5(md5($row['Id']).$_POST['password']);
                        $hashedpassword=md5($_POST['password']);
                       //$error.=md5(md5($row['id']).$_POST['password']);
                        if($hashedpassword==$row['Password']){
                            $_Session['Id']=$row['Id'];
                            if($_POST['stayLoggedin']=='1'){
                                setcookie("Id",$row['Id'],time()+60*60*24*365); 
                            }
                            header("Location: loggedinpage.php");
                        }else{
                            $error.="Provided password does not match !<br>";
                        }

                    } else{
                        $error.="That email address not found <br>";

                    }
                }else{
                    $error.= "No recods found ". $Sel_Query1."";
                }

            }
            
        }

    }

?>
<?php include("headerfile.php");?>
    <div class="container" id="homepagecontainer">

        <h1>My Dairy</h1>
        <p><strong>Store your thoughts permanently and securly.</strong></P>
        <div id="error">
            <?php echo $error;  ?> </div>
        <form method="post" id="signupform">
            <p>Interested ! Sign up now.</p>
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="youremail">
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="password" placeholder="">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" name="stayLoggedin" class="form-check-input" id="exampleCheck1" value="1">
                <label class="form-check-label" for="exampleCheck1">Stay Logged in</label>
            </div>

            <div class="form-group">
                <input type="hidden" name="signup" value="1">
                <input class="btn btn-success" type="submit" name="submit" value="sign Up" placeholder="your email">
            </div>
            <p><a class="toggleforms">log in! If you already Registred</a></p>
        </form>
        <form method="post" id="loginform">
            <p>Login with registered user name and password</p>
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="youremail">
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="password" placeholder="">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" name="stayLoggedin" class="form-check-input" id="exampleCheck1" value="1">
                <label class="form-check-label" for="exampleCheck1">Stay Logged in</label>
            </div>
            <div class="form-group">
                <input type="hidden" name="signup" value="0">
                <input class="btn btn btn-primary" type="submit" name="submit" value="Login " placeholder="your email">
            </div>
            <p><a class="toggleforms">Sign up New User</a></p>
        </form>
    </div>
    <?php include("footerfile.php");?>
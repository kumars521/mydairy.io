<?php
    if(array_key_exists('email',$_POST) or array_key_exists('password',$_POST) or array_key_exists('name',$_POST)){
        //echo .$_POST['email']." " .$_POST['password'];
        $sqllink=mysqli_connect("shareddb-r.hosting.stackcp.net","db_Users_Data-3132332586","Admin@123","db_Users_Data-3132332586");
        if(mysqli_connect_error()){
            die("Ther was an error while connecting database"); 
        }

        if($_POST['email']==''){
            echo "<p>Email id is not provided!</P>";
        }else if ($_POST['password']==''){
            echo "<p>Password id is not provided!</P>";
        }else if ($_POST['Name']==''){
            echo "<p>Name id is not provided!</P>";
        }else{
 
            $Select_Query="Select * from my_Attn_Data where email ='".mysqli_real_escape_string($sqllink,$_POST['email'])."'";//".$_post['email']."
            $result=mysqli_query($sqllink,$Select_Query);
            $row=mysqli_fetch_array($result);
            if(mysqli_num_rows($result)>0){
                echo "Used Id exists";
                //echo "<form action='https://kumars521.github.io/my_Web_Development.github.io/'></form>";
                //echo "<form><a href='https://kumars521.github.io/codeplayer.github.io/'>Code Player</a></form>";
            }else{
              $inst_query="insert into `my_Attn_Data` (`Email`,`Password`,`Name') VALUES('".mysqli_real_escape_string($sqllink,$_POST['email'])."','".mysqli_real_escape_string($sqllink,$_POST['password'])."','".mysqli_real_escape_string($sqllink,$_POST['name'])."')";
              if(mysqli_query($sqllink,$inst_query)){
                //echo "<form><a href='registeruser.html'>Register New User</a></form>";
                
                echo "Your User details has been registred !";
              }
            }
        }
    }
?>
    <form method="post">
        <p><a href="http://sunnymysqldb-in.stackstaging.com/">Home</a></p>
        <div id="wrapper">
            <div class="form_elements"></div>
                <p><label for="email" style="width:50px;">Email</label>
                <input type="text" name="email" id="email" placeholder="eg: youremail@anz.com"></p>
            </div>
            <div class="form_elements"></div>
                <p><label for="Name" style="width:50px;">name</label>
                <input type="text" name="Name" id="Name" placeholder="eg: John"></p>
            </div>
            <div class="form_elements"></div>
                <p><label for="password" style="width:50px;">Password</label>
                <input type="password" name="password" id="password" ></p>
            </div>
            <div class="form_elements"></div>
                <p><label for="confirm_Password" style="width:50px;">Confirm Password</label>
                <input type="password" name="password" id="confirm_Password" ></p>
            </div>
            <div class="form_elements"></div>
                <p><input type="submit" id="submitbtn" value="sign up"></p>
            </div>
        </div>
        
    </form>

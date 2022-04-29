<?php
session_start();
    if(isset($_SESSION['user'])){
        header('Location:dashbord/index.php');
    }else{

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Login</title>
</head>
<body style="height:100vh;background-image:url('dashbord/img/back.jpg');background-size:cover;background-position:center;background-repeat:no-repeat">

    <form method="post" >
        
        <div class="form-group card card-body " style="min-width:30%;width:30%;height:400px;position: absolute;top:50%;left:50%;transform:translate(-50%,-50%)">
        <div class="" style="width: 350px;height: 60px;position: absolute;top:18%;left:50%;transform:translate(-50%,-50%);z-index:99;">
    <center>   <img src="dashbord/img/logo.png" alt="" width="250" ></center> 
    </div>    
        <label for="user" class="" style="margin-top: 100px;">Email</label>
            <input type="email" name="username" id="user" class="form-control" maxlength="50" value="<?php if(isset($_COOKIE['user'])) echo $_COOKIE['user'] ?>">
            <label for="pass" class=" mt-3">password</label>
            <input type="password" name="password" id="pass" maxlength="50" class="form-control" value="<?php if(isset($_COOKIE['pass'])) echo $_COOKIE['pass'] ?>">
            <button type="submit" class="btn btn-outline-info mt-3" name="send">Login</button>
            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" value="" name="checkcookie" id="defaultCheck1" style="cursor: pointer;">
                <label class="form-check-label" for="defaultCheck1">
                Se souvenir avec moi ?
            </label>

        </div>
    </form>
    <?php
    $con = new PDO("mysql:host=localhost;dbname=latecoere;port=3306;charset=utf8",'root','');
    if(isset($_POST["send"]))
        {
            try{
                if (filter_var($_POST["username"], FILTER_VALIDATE_EMAIL)) {
            $username =strip_tags($_POST["username"]);
            $password =strip_tags($_POST["password"]);
            $sql = "SELECT * FROM `users` WHERE `Email`='$username' and `password`='$password'";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $lin = $stmt->rowCount();
            $arr = $stmt->fetch();
            if($lin>0){
                $_SESSION['id']=$arr[0];
                $_SESSION['nom'] = $arr[1];
                $_SESSION['role'] = $arr[5];
                $_SESSION['nicknom']=$arr[2];
                $_SESSION['job']=$arr[6];
                $_SESSION['img']=$arr[7];
                $_SESSION['user'] = $username;
                $_SESSION['pass'] = $password;
            if(isset($_POST["checkcookie"]))
            {
                setcookie('user',$username,time()+365*24*3600);
                setcookie('pass',$password,time()+365*24*3600);
            }
                echo "connecting...";
                 
                header('refresh:1;url=dashbord/index.php');
                }else{
                    echo "user ou pass incorrect";
                }
            }else{
                echo "email format incorrect";   
            }
        }catch(PDOException $E)
        {
            die("data incorrect");
        }
            
            
        }
    
    ?>

 







<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
<?php } ?>
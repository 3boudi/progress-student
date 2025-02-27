<?php
session_start();
require_once "db.php";
if(isset($_POST['calc'])){
    if($conn){
        if(!empty($_POST['username']) && !empty($_POST['password'])){
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            header("Location:  index.php");

        }
    }

}
  if (isset($_POST['calc']) ) {

$name = mysqli_real_escape_string($conn, $_POST['name']);
$password = $_POST['password'];
$sql = "SELECT * FROM etudents WHERE etudent = '$name'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows(($result))>0){

    $row = mysqli_fetch_assoc($result);
    if(password_verify($password, $row['password'])){
        echo "<div class='output'>";
        echo "<br>";
        echo "STUDENT NAME:".$row['etudent'];
        echo "<br>";
        echo $row['moyen'];
        if($row['moyen']<10){
            echo "<br>";
            echo '<p class="fail">Sorry, you failed!</p>';
        }
        else{
            echo "<br>";
            echo '<p class="success">Congratulations, you passed!</p>';
        }
        echo "</div>";
    }
    else{
        echo "<div class='output'>";
        echo "<br>";
        echo '<p class="fail">Invalid password!</p>';
        echo "</div>";
    }
}else{
    echo "<div class='output'>";
    echo '<p class="fail">User not found!</p>';
    echo "</div>";
}


}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROGRES-Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>WELCOME STUDENT ENTER YOUR INFOMATION</h1>
        <form id="usernote" action="" method="post">
            <div class="form-group">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>">     
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required minlength="8" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>">
            </div>
            <button type="submit" name="calc">ENTER</button>
        </form>
        <div class="output" id="outputSection" style="display: none;"></div>
    </div>
    <script src="script.js"></script> 
</body>
</html>

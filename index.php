<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style> 
    .error {
        color: red;
    }
    .invalid {
        color: red;
    }
    </style>
</head>
<body>
    <?php 
$name = $email = $gender = $checkbox = "";
$nameErr = $emailErr = $genderErr = $checkboxErr = "";
$EmailInvalid = false;
    
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $nameErr = "Only letters and space are allowed!";
    }
    if (empty($_POST["name"])) {
        $nameErr = "Full name is required!";
    } else {
        $name = clean_input($_POST["name"]);
    }
    if (empty($_POST["email"])) {
        $emailErr = "Email is required!";
    } else {
        $email = clean_input($_POST["email"]);
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $EmailInvalid = true;
        $emailErr = "Invalid email format";
    }
    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required!";
    } else {
        $gender = $_POST["gender"];
    }
    
    if (empty($_POST["checkbox"])) {
        $checkboxErr = "Agreeing is required!";
    } else {
        $checkbox = $_POST["checkbox"];
    }
    $date = date("m/d/y l G:i:s A \n", time());

    function clean_input($data) {
      $data = htmlspecialchars($data);
      $data = stripslashes($data);
      $data = trim($data);
      return $data;
    }
    ?>

    <form action="<?php echo ($_SERVER["PHP_SELF"]);?>" method="post" >
       Full Name: <input type="text" name="name" value="<?php echo $name;?>" />
            <span class="error">* <?php echo $nameErr;?></span>
       <br><br>
       Email: <input type="email" name="email" value="<?php echo $email;?>"/>
            <span class="error">* <?php echo $emailErr;?></span>
       <br><br>
       Gender:
        <input type="radio" name="gender" value="male" <?php if (isset($gender) && $gender=="male") echo "checked";?> /> Male
        <input type="radio" name="gender" value="female" <?php if (isset($gender) && $gender=="female") echo "checked";?>/> Female
            <span class="error">* <?php echo $genderErr;?></span>
        <br><br>
        <input type="checkbox" name="checkbox" value="Agreed to data harvesting"
            <?php 
                if (isset($_POST['checkbox'])) {
                    echo "checked";
                }
                    
            ?>
        /> Do you agree to give your data to us? (!optional) <span class="error">* <?php echo $checkboxErr;?></span>
        <br><br>

       <input type="submit" 
        <?php 
            $userDetails = $name ." ". $email ." ". $gender ." ". $checkbox ." ". $date;
            $invalid = '<br><h1 class="invalid">Some/All details are empty, fill them up to continue!</h1>';
            if (empty($name) || empty($email) || empty($gender) || empty($checkbox) || $EmailInvalid) {
                echo $invalid;
            } else {
                $filename = "submissions.txt";
                $file = fopen($filename, "a+");
                fwrite($file, $userDetails);
                echo "<br><h1>These are your details:</h1>";
                echo $name;
                echo "<br>";
                echo $email;
                echo "<br>";
                echo $gender;
                echo "<br>";
                echo $checkbox;
                echo "<br><br>";
                echo "The following details are saved in a .txt database called 'submissions.txt'. Everything is logged :)";
            }
        ?>
    </form>
</body>
</html>
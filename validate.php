/**
* Created by PhpStorm.
* User: chaitanyapilla
* Date: 3/30/17
* Time: 6:20 PM
*/

<?php
if(isset($_POST['inputEmail']) && isset($_POST['inputPwd'])){
    $username = ($_POST['inputEmail']);
    $password = ($_POST['inputPwd']);
    $pass_hash = md5($password);
    if(empty($username)){
        die("Empty or invalid email address");
    }
    if(empty($password)){
        die("Enter your password");
    }
    $con = new MongoClient();
    // Select Database
    if($con){
        $db = $con->tickets;
        // Select Collection
        $collection = $db->admin;   // you may use 'admin' instead of 'Admin'
        $qry = array("inputEmail" => $username, "inputPwd" => $pass_hash);
        $result = $collection->findOne($qry);

        if(!empty($result)){
            echo "You are successfully loggedIn";
        }else{
            echo "Wrong combination of username and password";
        }
    }else{
        die("Mongo DB not connected!");
    }
}
?>

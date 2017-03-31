/**
* Created by PhpStorm.
* User: chaitanyapilla
* Date: 3/30/17
* Time: 6:45 PM
*/

<?php
session_start();

if($_POST['submit']){
    $iname=strip_tags($_POST['inputName']);
    $uname=strp_tags($_POST['uniName']);
    $email=strip_tags($_POST['email']);
    $password=strip_tags($_POST['password']);
    $password2=strip_tags($_POST['password2']);

    $error = array();

    if(empty($email) or !filter_var($email,FILTER_SANITIZE_EMAIL))
    {
        $error[] = "Email id is empty or invalid";
    }
    if(empty($password2)){
        $error[] = "Please enter Confirm password";
    }
    if($password != $password2){
        $error[] = "Password and Confirm password are not matching";
    }
    if(empty($fname)){
        $error[] = "Enter first name";
    }
    if(empty($lname)){
        $error[] = "Enter last name";
    }

    if(count($error == 0)){
        //database configuration
        $host = 'localhost';
        $database_name = 'mongo1';
        $database_user_name = '';
        $database_password = '';

        $connection=new Mongo('localhost');

        if($connection){

            //connecting to database
            $database=$connection->$database_name;

            //connect to specific collection
            $collection=$database->user;

            $query=array('email'=>$email);
            //checking for existing user
            $count=$collection->findOne($query);

            if(!count($count)){
                //Save the New user
                $user=array('inputName'=>$iname,'uniName'=>$uname,'email'=>$email,'password'=>md5($password),'password'=>$password2);
                $collection->save($user);
                echo "You are successfully registered.";
            }else{
                echo "Email is already existed.Please register with another Email id!.";
            }

        }else{

            die("Database are not connected");
        }

    }else{
        //Displaying the error
        foreach($error as $err){
            echo $err.'</br>';
        }
    }
}

?>
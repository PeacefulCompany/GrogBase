<?php
        //potential layout for the login/register endpoint
        function checkDuplicates($email,$conn)
        {
            $query = $conn->prepare("SELECT COUNT(*) FROM `users` WHERE `email` = ?");
            $e = null;
            $query->bind_param("s", $e);
            $e = $email;
            $query->execute();
            $result = null;
            $query->bind_result($result);
            $query->fetch();
            $query->close();
            return $result;
        }

        function createUser($name, $surname, $email, $pwd, $apikey, $conn)
        {
            if(checkDuplicates($email,$conn)>0)
            {
                echo "User already exists";
                return;
            }
            else{
                $query = $conn->prepare("INSERT INTO users( firstname, surname, email, pass, apikey) VALUES (?,?,?,?,?,?)");
                $pass = password_hash($pwd,PASSWORD_ARGON2ID);
                $n = null;
                $s = null;
                $e = null;
                $p = null;
                $ak = null;
                $sa = null;
                $query->bind_param("ssssss",$n,$s, $e, $p, $ak);
                $n = $name; 
                $s = $surname;
                $e = $email;
                $p = $pass;
                $ak = $apikey;
                $query->execute();
                $query->close();
                echo "Congrats, you're now one of us :)";
                echo "\nYour API key is: ". $apikey;
                return;
            }
        }

        function validateDetails($uname, $password, $conn)
        {
            if(!(checkDuplicates($uname,$conn)>0))
            {
                echo "No user with that email exists, please create an account.";
            }
            else{
                $em = null;
                $query2 = $conn->prepare("SELECT `pass` FROM `users` WHERE `email` = ?");
                $em = null;
                $query2->bind_param('s',$em);
                $em = $uname;
                $query2->execute();
                $hashed = "";
                $query2->bind_result($hashed);
                $query2->fetch();
                $query2->close();
                if(password_verify($password,$hashed))
                {
                    $query3 = $conn->prepare("SELECT `apikey` FROM `users` WHERE `email` = ?");
                    $ak = null;
                    $query3->bind_param("s",$ak);
                    $ak = $uname;
                    $query3->execute();
                    $apikey = "";
                    $query3->bind_result($apikey);
                    $query3->fetch();
                    $query3->close();
                    echo json_encode(array(
                        "status"=>200,
                        "apikey"=>$apikey,
                        "logged"=>true
                    ));
                }
                else{
                    echo json_encode(array(
                        "status"=>401,
                        "logged"=>false
                    ));
                }
            }
        }
?>
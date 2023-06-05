<?php
        require_once "lib/Database.php";
        require_once "lib/Controller.php";
        function checkDuplicates($details)
        {
            $email = $details['email'];
            $params = array();
            array_push($params,$email);
            $query = "SELECT COUNT(*) FROM `users` WHERE `email` = ?";
            $db = new Database;
            $res = $db->query($query,'s',$params);
            return $res[0]["COUNT(*)"];
        }

        function createUser($controller)
        {
            $req = $controller->get_post_json();//gets the json object request
            $details = $req['details'];//gets the array that stores the details to be inserted
            $pwd = $details['password'];//user's password
            $apikey = bin2hex(random_bytes(10));//generated apikey
            $details['password'] = password_hash($pwd,PASSWORD_ARGON2ID);
            $details['userType'] = "User";
            $details['api_key'] = $apikey;
            $params = array();
            $params2 = array();
            $email = $details['email'];
            array_push($params2,$email);
            foreach($details as $value)
            {
                array_push($params,$value);
            }
            if(checkDuplicates($details)>0)
            {
                throw new Exception("A user with this email already exists.", 409);
                return;
            }
            $query = "INSERT INTO users(first_name, last_name, email, password, user_type,api_key) VALUES (?,?,?,?,?,?)";
            $query2 = "SELECT `user_id` FROM `users` WHERE `email`=?";
            $types = "ssssss";
            $db = new Database;
            $db->query($query,$types,$params);
            $uid = $db->query($query2,'s',$params2);
            $return = array();
            $return['user_id'] = $uid[0]['user_id'];
            $return['api_key'] = $apikey;
            $return['user_type'] = $details['userType'];
            $controller->success($return);
        }

        function validateDetails($controller)
        {
            $db = new Database;
            $req = $controller->get_post_json();
            $details = $req['details'];
            if(!(checkDuplicates($details)>0))
            {
                throw new Exception("No user with those credentials exists",401);
                return;
            }
            else{
                $query1 = "SELECT `password` FROM `users` WHERE `email` = ?";
                $params1 = array();
                $email = $details['email'];
                array_push($params1,$email);
                $res = $db->query($query1,'s',$params1);
                $hashed = $res[0]['password'];
                if(password_verify($details['password'],$hashed))
                {
                    $query2 = "SELECT `user_id`,`api_key`,`user_type` FROM `users` WHERE `email` = ?";
                    $res2 = $db->query($query2,'s',$params1);
                    $controller->success($res2[0]);
                }
                else{
                    throw new Exception("Incorrect credentials.",401);
                    return;
                }
            }
        }
?>

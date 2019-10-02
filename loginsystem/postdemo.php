<?php
    //Connect to database
    require('connectDB.php');
//**********************************************************************************************
    //Get current date and time
    date_default_timezone_set('Asia/Damascus');
    $d = date("Y-m-d");
    $t = date("H:i:sa");
//**********************************************************************************************
    $Tarrive = mktime(01,30,00);
    $TimeArrive = date("H:i:sa", $Tarrive);
//**********************************************************************************************   
    $Tleft = mktime(02,30,00);
    $Timeleft = date("H:i:sa", $Tleft);
//**********************************************************************************************

if(!empty($_GET['test'])){
    if($_GET['test'] == "test"){
        echo "The Website is online";
        exit();
    }
}

if(!empty($_GET['CardID'])){

    $Card = $_GET['CardID'];

    $sql = "SELECT * FROM users WHERE CardID=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select_card";
        exit();
    }
    else{
        mysqli_stmt_bind_param($result, "s", $Card);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)){ 
            //*****************************************************
            //An existed card has been detected for Login or Logout
            if (!empty($row['username'])){
                $Uname = $row['username'];
                $Number = $row['SerialNumber'];
                $sql = "SELECT * FROM logs WHERE CardNumber=? AND DateLog=CURDATE()";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select_logs";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($result, "s", $Card);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);
                    //*****************************************************
                    //Login
                    if (!$row = mysqli_fetch_assoc($resultl)){
                        if ($t <= $TimeArrive) {
                            $UserStat = "Arrived on time";
                        }
                        else{
                            $UserStat = "Arrived late";
                        }
                        $sql = "INSERT INTO logs (CardNumber, Name, SerialNumber, DateLog, TimeIn, UserStat) VALUES (? ,?, ?, CURDATE(), CURTIME(), ?)";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_Select_login1";
                            exit();
                        }
                        else{
                            mysqli_stmt_bind_param($result, "ssds", $Card, $Uname, $Number, $UserStat);
                            mysqli_stmt_execute($result);

                            echo "login";
                            exit();
                        }
                    }
                    //*****************************************************
                    //Logout
                    else {
                        
                        if ($t >= $Timeleft && $row['TimeIn'] <= $TimeArrive) {
                            $UserStat = "Arrived and Left on time";
                        }
                        elseif ($t < $Timeleft && $row['TimeIn'] > $TimeArrive){   
                            $UserStat = "Arrived late and Left early";
                        }
                        elseif ($t < $Timeleft && $row['TimeIn'] <= $TimeArrive) {
                            $UserStat = "Arrived on time and Left early";
                        }
                        elseif ($t >= $Timeleft && $row['TimeIn'] > $TimeArrive) {
                            $UserStat = "Arrived late and Left on time";
                        }
                        $sql="UPDATE logs SET TimeOut=CURTIME(), UserStat=? WHERE CardNumber=? AND DateLog=CURDATE()";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_insert_logout1";
                            exit();
                        }
                        else{
                            mysqli_stmt_bind_param($result, "sd", $UserStat, $Card);
                            mysqli_stmt_execute($result);

                            echo "logout";
                            exit();
                        }
                    }
                }
            }
            //*****************************************************
            //An available card has been detected
            else{
                $sql = "SELECT CardID_select FROM users WHERE CardID_select=?";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select";
                    exit();
                }
                else{
                    $card_sel = 1;
                    mysqli_stmt_bind_param($result, "i", $card_sel);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);
                    
                    if ($row = mysqli_fetch_assoc($resultl)) {

                        $sql="UPDATE users SET CardID_select =?";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_insert";
                            exit();
                        }
                        else{
                            $card_sel = 0;
                            mysqli_stmt_bind_param($result, "i", $card_sel);
                            mysqli_stmt_execute($result);

                            $sql="UPDATE users SET CardID_select =? WHERE CardID=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error_insert_An_available_card";
                                exit();
                            }
                            else{
                                $card_sel = 1;
                                mysqli_stmt_bind_param($result, "is", $card_sel, $Card);
                                mysqli_stmt_execute($result);

                                echo "Cardavailable";
                                exit();
                            }
                        }
                    }
                    else{
                        $sql="UPDATE users SET CardID_select =? WHERE CardID=?";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_insert_An_available_card";
                            exit();
                        }
                        else{
                            $card_sel = 1;
                            mysqli_stmt_bind_param($result, "is", $card_sel, $Card);
                            mysqli_stmt_execute($result);

                            echo "Cardavailable";
                            exit();
                        }
                    }
                } 
            }
        }
        //*****************************************************
        //New card has been added
        else{
            $Uname = "";
            $Number = "";
            $gender= "";

            $sql = "SELECT CardID_select FROM users WHERE CardID_select=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo "SQL_Error_Select";
                exit();
            }
            else{
                $card_sel = 1;
                mysqli_stmt_bind_param($result, "i", $card_sel);
                mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
                if ($row = mysqli_fetch_assoc($resultl)) {

                    $sql="UPDATE users SET CardID_select =?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error_insert";
                        exit();
                    }
                    else{
                        $card_sel = 0;
                        mysqli_stmt_bind_param($result, "i", $card_sel);
                        mysqli_stmt_execute($result);

                        $sql = "INSERT INTO users (username , SerialNumber, gender, CardID, CardID_select) VALUES (?, ?, ?, ?, ?)";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_Select_add";
                            exit();
                        }
                        else{
                            $card_sel = 1;
                            mysqli_stmt_bind_param($result, "sdssi", $Uname, $Number, $gender, $Card, $card_sel);
                            mysqli_stmt_execute($result);

                            echo "succesful";
                            exit();
                        }
                    }
                }
                else{
                    $sql = "INSERT INTO users (username , SerialNumber, gender, CardID, CardID_select) VALUES (?, ?, ?, ?, ?)";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error_Select_add";
                        exit();
                    }
                    else{
                        $card_sel = 1;
                        mysqli_stmt_bind_param($result, "sdssi", $Uname, $Number, $gender, $Card, $card_sel);
                        mysqli_stmt_execute($result);

                        echo "succesful";
                        exit();
                    }
                }
            } 
        }    
    }
}
//***************************************************** 
//Empty Card ID
else{
    echo "Empty_Card_ID";
    exit();
}
mysqli_stmt_close($result);
mysqli_close($conn);
?>

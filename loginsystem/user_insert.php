<?php
session_start();

//Connect to database
require 'connectDB.php';
//**********************************************************************************************
//**********************************************************************************************
if ($_SERVER["REQUEST_METHOD"] == "POST"){

	if(isset($_POST['login'])) {

      $Uname = $_POST['Uname'];
      $Number = $_POST['Number'];
      $gender= $_POST['gender'];
      //check if there any selected card
      $sql = "SELECT CardID FROM users WHERE CardID_select=?";
      $result = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($result, $sql)) {
          header("location: AddCard.php?error=SQL_Error");
          exit();
      }
      else{
          $card_sel = 1;
          mysqli_stmt_bind_param($result, "i", $card_sel);
          mysqli_stmt_execute($result);
          $resultl = mysqli_stmt_get_result($result);
          if ($row = mysqli_fetch_assoc($resultl)) {
              //check if there any user had already the Serial Number
              $sql = "SELECT SerialNumber FROM users WHERE SerialNumber=?";
              $result = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($result, $sql)) {
                  header("location: AddCard.php?error=SQL_Error");
                  exit();
              }
              else{
                  mysqli_stmt_bind_param($result, "d", $Number);
                  mysqli_stmt_execute($result);
                  $resultl = mysqli_stmt_get_result($result);
                  if (!$row = mysqli_fetch_assoc($resultl)) {
                      //Add the user into the database
                      $sql = "UPDATE users SET username=?, SerialNumber=?, gender=? WHERE CardID_select=?";
                      $result = mysqli_stmt_init($conn);
                      if (!mysqli_stmt_prepare($result, $sql)) {
                          header("location: AddCard.php?error=SQL_Error");
                          exit();
                      }
                      else{
                          $card_sel = 1;
                          mysqli_stmt_bind_param($result, "sdsi", $Uname, $Number, $gender, $card_sel);
                          mysqli_stmt_execute($result);
                          header("location: AddCard.php?success=registerd");
                          exit();
                      }
                  }
                  //Add the Serial Number already exist
                  else{
                      header("location: AddCard.php?error=Nu_Exist");
                      exit();
                  }
              }
          }
          //there is no selected card to add
          else{
              header("location: AddCard.php?error=No_SelID");
              exit();
          }
      }
  }
//**********************************************************************************************  
//**********************************************************************************************  
  if (isset($_POST['update'])) {
        
      $Uname = $_POST['Uname'];
      $Number = $_POST['Number'];
      $gender= $_POST['gender'];
      
      $sql = "SELECT CardID FROM users WHERE CardID_select=?";
      $result = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($result, $sql)) {
          header("location: AddCard.php?error=SQL_Error");
          exit();
      }
      else{
          $card_sel = 1;
          mysqli_stmt_bind_param($result, "i", $card_sel);
          mysqli_stmt_execute($result);
          $resultl = mysqli_stmt_get_result($result);
          if ($row = mysqli_fetch_assoc($resultl)) {
              //check if there any user had already the Serial Number
              $sql = "SELECT SerialNumber FROM users WHERE SerialNumber=?";
              $result = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($result, $sql)) {
                  header("location: AddCard.php?error=SQL_Error");
                  exit();
              }
              else{
                  mysqli_stmt_bind_param($result, "d", $Number);
                  mysqli_stmt_execute($result);
                  $resultl = mysqli_stmt_get_result($result);
                  if (!$row = mysqli_fetch_assoc($resultl)) {
                      //Add the user into the database
                      $sql = "UPDATE users SET username=?, SerialNumber=?, gender=? WHERE CardID_select=?";
                      $result = mysqli_stmt_init($conn);
                      if (!mysqli_stmt_prepare($result, $sql)) {
                          header("location: AddCard.php?error=SQL_Error");
                          exit();
                      }
                      else{
                          mysqli_stmt_bind_param($result, "sdsi", $Uname, $Number, $gender, $card_sel);
                          mysqli_stmt_execute($result);
                          header("location: AddCard.php?success=Updated");
                          exit();
                      }
                  }
                  //The Serial Number already exist
                  else{
                      header("location: AddCard.php?error=Nu_Exist");
                      exit();
                  }
              }
          }
          else{
              header("location: AddCard.php?error=No_SelID");
              exit();
          }
      }
  }
//**********************************************************************************************  
//**********************************************************************************************
    if(isset($_POST['del']))  {

        
        if (!empty($_POST['CardID'])) {

            $CardID = $_POST['CardID'];
            $sql = "SELECT CardID FROM users WHERE CardID=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                header("location: AddCard.php?error=SQL_Error");
                exit();
            }
            else{
                mysqli_stmt_bind_param($result, "s", $CardID);
                mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
                if ($row = mysqli_fetch_assoc($resultl)) {

                    $sql ="DELETE FROM users WHERE CardID=?";
                    $result = mysqli_stmt_init($conn);
                    if ( !mysqli_stmt_prepare($result, $sql)){
                        header("location: AddCard.php?error=sqlerror");
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "s", $CardID);
                        mysqli_stmt_execute($result);
                        header("location: AddCard.php?success=deleted");
                        exit();
                    }
                }
                else{
                    header("location: AddCard.php?error=No_ExID");
                    exit();
                }
            }
        }
        else{
            header("location: AddCard.php?error=No_SelID");
            exit();
        }
    }
//**********************************************************************************************
//**********************************************************************************************
    if(isset($_POST['set'])) {

        if (!empty($_POST['CardID'])) {
          
            $CardID = $_POST['CardID'];

            $sql = "SELECT CardID FROM users WHERE CardID=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                header("location: AddCard.php?error=SQL_Error");
                exit();
            }
            else{
                mysqli_stmt_bind_param($result, "s", $CardID);
                mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
                if ($row = mysqli_fetch_assoc($resultl)) {

                    $sql = "SELECT CardID_select FROM users WHERE CardID_select=?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        header("location: AddCard.php?error=SQL_Error");
                        exit();
                    }
                    else{
                        $card_sel = 1;
                        mysqli_stmt_bind_param($result, "i", $card_sel);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if ($row = mysqli_fetch_assoc($resultl)) {

                            $sql = "UPDATE users SET CardID_select=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                header("location: AddCard.php?error=SQL_Error");
                                exit();
                            }
                            else{
                                $card_sel = 0;
                                mysqli_stmt_bind_param($result, "i", $card_sel);
                                mysqli_stmt_execute($result);

                                $sql = "UPDATE users SET CardID_select=? WHERE CardID=?";
                                $result = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($result, $sql)) {
                                    header("location: AddCard.php?error=SQL_Error");
                                    exit();
                                }
                                else{
                                    $card_sel = 1;
                                    mysqli_stmt_bind_param($result, "is", $card_sel, $CardID);
                                    mysqli_stmt_execute($result);
                                    header("location: AddCard.php?success=Selected");
                                    exit();
                                }
                            }
                        }
                        else{
                            $sql = "UPDATE users SET CardID_select=? WHERE CardID=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                header("location: AddCard.php?error=SQL_Error");
                                exit();
                            }
                            else{
                                $card_sel = 1;
                                mysqli_stmt_bind_param($result, "is", $card_sel, $CardID);
                                mysqli_stmt_execute($result);
                                header("location: AddCard.php?success=Selected");
                                exit();
                            }
                        }
                    }    
                }
                else{
                    header("location: AddCard.php?error=No_ExID");
                    exit();
                }
            }
        }
        else{
            header("location: AddCard.php?error=No_SelID");
            exit();
        }
    }
}
//**********************************************************************************************
?>
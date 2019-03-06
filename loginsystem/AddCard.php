<?php
session_start();

    //Connect to database
    require('connectDB.php');
//**********************************************************************************************
//**********************************************************************************************
  if (empty($Cid)) 
  {
    $result = $conn->query("SELECT CardID FROM users WHERE username='' ");
  if ( $result->num_rows > 0 )
      { 
        $row=$result->fetch_assoc();
        $Cid= $row['CardID'];
        $_SESSION[ 'card' ] = $row['CardID'];
        $_SESSION[ 'alert' ] = "<img src='image/al.png' style='margin-right: 20px' width='30'>There's an available cards. ";
        $_SESSION[ 'message' ] ="";
      }
  else{
        $_SESSION[ 'alert' ] = "<img src='image/al.png' style='margin-right: 20px' width='30'>There's no available cards. ";
        $Cid= "";
        $_SESSION[ 'message' ] ="No thing";
      }
  }
//**********************************************************************************************
//**********************************************************************************************
	if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(isset($_POST['login']) && !empty($_SESSION[ 'card' ]) && !empty($Cid)) 
  {
		    $CardID = $_SESSION[ 'card' ];
        //define other variables with submitted values from $_POST
        $Uname = $conn->escape_string($_POST['Uname']);
        $Number = $conn->escape_string($_POST['Number']);
        $gender= $conn->escape_string($_POST['gender']);
                            
  $result = $conn->query("SELECT * FROM users WHERE SerialNumber='$Number' ");
       if ( $result->num_rows > 0 )
          { 
           $_SESSION[ 'message' ] = "The Number already taken!";
          }
         else 
         {  

  $sqll = "UPDATE users SET username='$Uname',SerialNumber='$Number' ,gender='$gender' WHERE CardID='$CardID'";

          if ($conn->query($sqll) === true){
               $_SESSION[ 'message' ] = "<img src='image/add.png' style='margin-right: 20px' width='30'>Registration succesful. ";
               $Cid ="";
               $_SESSION[ 'card' ] = "";
               }
          else {
               $_SESSION[ 'message' ] = "Registration failed!";
               } 
    	   }
	}
//**********************************************************************************************  
//**********************************************************************************************  
  if (isset($_POST['update']) && !empty($_SESSION[ 'card' ])) 
    {
        $CardID = $_SESSION[ 'card' ];
        //define other variables with submitted values from $_POST
        $Uname = $conn->escape_string($_POST['Uname']);
        $Number = $conn->escape_string($_POST['Number']);
        $gender= $conn->escape_string($_POST['gender']);
      
      $result = $conn->query("SELECT * FROM users WHERE CardID='$CardID'");
       if ( $result->num_rows > 0 )
          { 
          $row=$result->fetch_assoc();

          if (empty($row['username'])) 
            {
            $_SESSION[ 'message' ] = "<img src='image/add.png' style='margin-right: 20px' width='30'>Add the card first!";
            }

          else 
            {
              $result = $conn->query("SELECT * FROM users WHERE SerialNumber='$Number' And NOT username='$Uname'");

              if ( $result->num_rows > 0 )
                  { 
                   $_SESSION[ 'message' ] = "The Number already taken!";
                  }
              else
                  {

          $sqll = "UPDATE users SET username='$Uname',SerialNumber='$Number' ,gender='$gender' WHERE CardID='$CardID'";

                if ($conn->query($sqll) === true)
                    {
                         $_SESSION[ 'message' ] = "<img src='image/up.png' style='margin-right: 20px' width='25'>Updated succesfully. ";
                     $Cid ="";
                    $_SESSION[ 'card' ] = "";
                    }
                else
                    {
                    $_SESSION[ 'message' ] = "Updated failed!";
                     } 
                  }           
               }
            }  
    }
//**********************************************************************************************  
//**********************************************************************************************
  if(isset($_POST['del'])) 
   {
    $id = $_POST['CardID'];

    $sqll = $conn->query("SELECT * FROM users WHERE CardID='$id'");
          if ($sqll->num_rows > 0)
              {
            $sql ="DELETE FROM users WHERE CardID='$id'";

              if ($conn->query($sql) === true)
                  {
                  $_SESSION[ 'message' ] = "<img src='image/che.png' style='margin-right: 20px' width='30'>The card deleted. ";
                  $Cid =""; 
                   }
              else
                 {
                   $_SESSION[ 'message' ] = "The card didn't delete!";
                  }
              }
          else
              {
                $_SESSION[ 'message' ] = "Select an existed card to deleted it.";
              }    
    }
//**********************************************************************************************
//**********************************************************************************************
    if(isset($_POST['set'])) 
    {
    $Cid = $_POST['CardID'];

    $sqll = $conn->query("SELECT CardID FROM users WHERE CardID='$Cid'");
          if ($sqll->num_rows > 0)
               {
               $_SESSION[ 'message' ] = "Set the Card ID to $Cid to Update.";
               $_SESSION[ 'card' ] = $Cid ;
               }
          else
              {
               $_SESSION[ 'message' ] = "Select an existed card to modified it.";
               $Cid = "";
              }     
    }
}
//**********************************************************************************************
//**********************************************************************************************
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add a new User</title>
<script src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous">
</script>
<script>
  $(document).ready(function(){
    setInterval(function(){
      $("#User").load("add-users.php")
    });
  });
</script>
<style type="text/css">
body {background-image:url("image/2.jpg");background-repeat:no-repeat;background-attachment:fixed;
    background-position: top right;
    background-size: cover;}
header .head h1 {font-family:aguafina-script;text-align: center;color:#ddd;}
header .head img {float: left;}
header a {float: right;text-decoration: none;font-family:cursive;font-size:25px;color:red;margin:-60px 0px 0px 20px;padding-right: 100px}
a:hover {opacity: 0.8;cursor: pointer;}
.bod {background-color:#ddd; opacity: 0.7;border-collapse: collapse;width:100%;height:220px;padding-bottom:20px}
.opt {float: left;margin: 20px 80px 0px 20px;}
.opt input {padding:4px 0px 2px 6px;margin:4px;border-radius:10px;background-color:#ddd; color: black;font-size:16px;border-color: black}
.opt p {font-family:cursive;text-align: left;font-size:19px;color:#f2f2f2;}
.opt label {color:black;font-size:23px}
.opt label:hover {color:red;opacity: 0.8;cursor: pointer;}
.opt table tr td {font-family:cursive;font-size:19px;color:black;}
.opt #lo {padding:4px 8px;margin-left:28px;background-color:#00A8A9;border-radius:7px;font-size:15px}
.opt #up {padding:4px 8px;margin-left:28px;background-color:#00A8A9;border-radius:7px;font-size:15px}
#lo:hover{opacity: 0.8;cursor: pointer;background-color:red}
#up:hover{opacity: 0.8;cursor: pointer;background-color:green}

.car {font-family:cursive;font-size:19px;padding-top: 45px;margin: 10px}

.op input {border-radius:10px;background-color:#ddd; color: black;font-size:16px;padding-left:5px;margin:18px 0px 0px 10px;border-color: black}
.op button {margin:7px 0px 5px 82px}
.op button:hover {cursor: pointer;}

#table {font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;border-collapse: collapse;width:      100%;}
#table td, #table th {border: 1px solid #ddd;padding: 8px;opacity: 0.6;}
#table tr:nth-child(even){background-color: #f2f2f2;}
#table tr:nth-child(odd){background-color: #f2f2f2;opacity: 0.9;}
#table tr:hover {background-color: #ddd; opacity: 0.8;}
#table th {opacity: 0.6;padding-top: 12px;padding-bottom: 12px;text-align: left;background-color:         #00A8A9;color: white;}
   
</style>
</head>
<body>
  <header >
    <div class="head">
      <img src="image/rfid1.jpg" width="80" height="80">
      <h1>RFID auto recorder<br>
      Login System</h1>
    </div>
    <a href="view.php">Users Logs</a>
  </header>
<form action="" method="POST" >
  <div class="bod">

  <div class="opt">
	<table>
		<tr>
			<td>Card ID</td>
			<td><?php echo $Cid ;?></td>
		</tr>
		<tr>
			<td>Name :</td>
			<td><input type="text" placeholder="User Name" name="Uname" required></td>
		</tr>
		<tr>
			<td>Number :</td>
			<td><input type="text" placeholder="Serial Number" name="Number" required></td>
		</tr>
		<tr>
			<td>Gender :</td>
		    <td><input type="radio" name="gender" value="Female" required /><label >Female</label >
      <input type="radio" name="gender" value="Male" required /><label>Male</label ></td>
		</tr>
		<tr>
    	    <td><input type="submit" value="Add" name="login" id="lo"></td>
          <td><input type="submit" value="Update" name="update" id="up"></td>
   		 </tr>
	</table>
 </div>
</form>

<div class="car">
    <?php echo '<label style="color:green;"> '.$_SESSION[ "message" ].'</label><br><br>';
          echo '<label style="color:red"> '.$_SESSION[ "alert" ].'</label>'; 
    ?> 
</div>
<div class="op">
  
  <form method="POST" action="">
    <label style="font-size:19px;">Options:</label>
      <input type="text" name="CardID" placeholder="Card ID"><br>
      <button type="submit" name="del" style="border:none;background: none;" title="Remove"><img src="image/del.png" width="25" ></button>
      <button type="submit" name="set" style="border:none;background: none;" title="Select"><img src="image/set.png" width="30" ></button>
  </form>  
</div>
<img src="image/wi.png" style="float: right;width:200px;margin:-220px 50px 0px 0px">
<a href="https://www.youtube.com/ElectronicsTechHaIs"><img src="image/icon.png" style="float: right;margin:-50px 30px 0px 0px"></a>
</div>
<div id="User">
  
</div>
</body>
</html>
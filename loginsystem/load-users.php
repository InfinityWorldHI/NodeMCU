<TABLE id='table'>
<TR>
    <TH>ID.No</TH>
    <TH>Name</TH>
    <TH>CardID</TH>
    <TH>SerialNumber</TH>
    <TH>Date</TH>
    <TH>Time In</TH>
    <TH>Time Out</TH>
    <TH>User Status</TH>
</TR>
<?php
session_start();
//Connect to database
require'connectDB.php';

$seldate = $_SESSION["exportdata"];

$sql = "SELECT * FROM logs WHERE DateLog='$seldate' ORDER BY id DESC";
$result=mysqli_query($conn,$sql);

if (mysqli_num_rows($result) > 0)
{
  while ($row = mysqli_fetch_assoc($result))
  {
?>
        <TR>
        <TD><?php echo $row['id'];?></TD>
        <TD><?php echo $row['Name'];?></TD>
        <TD><?php echo $row['CardNumber'];?></TD>
        <TD><?php echo $row['SerialNumber'];?></TD>
        <TD><?php echo $row['DateLog'];?></TD>
        <TD><?php echo $row['TimeIn'];?></TD>
        <TD><?php echo $row['TimeOut'];?></TD>
        <TD><?php echo $row['UserStat'];?></TD>
        </TR>
<?php
  }
}
?>
</TABLE>
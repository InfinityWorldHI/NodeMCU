<TABLE  id="table">
  <TR>
    <TH>Sr.No.</TH>
    <TH>Name</TH>
    <TH>Number</TH>
    <TH>Gender</TH>
    <TH>CardID</TH>
  </TR>
<?php 
    //Connect to database
    require('connectDB.php');

$sql ="SELECT * FROM users ORDER BY id DESC";
$result=mysqli_query($conn,$sql);

if (mysqli_num_rows($result) > 0)
{
  while ($row = mysqli_fetch_assoc($result))
    {
?>
   <TR>
      <TD><?php echo $row['id']?></TD>
      <TD><?php echo $row['username']?></TD>
      <TD><?php echo $row['SerialNumber']?></TD>
      <TD><?php echo $row['gender']?></TD>
      <TD><?php echo $row['CardID']?></TD>
   </TR>
<?php   
    }
}
?>
</TABLE>
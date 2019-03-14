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
      <TD><?php echo $row['CardID'];
          if ($row['CardID_select'] == 1) {
              echo '<img src="image/che.png" style="margin-right: 60%; float: right;" width="20" height="20" title="The selected Card">';
          }
          else{
              echo '';
          }?>
      </TD>
   </TR>
<?php   
    }
}
?>
</TABLE>
<?php
session_start();
$_SESSION['ActiveUser']=1;
$staffID=$_SESSION['ActiveUser'];
//get sql for rates rates
try{
	require('connection.php');
	//$rates= $db->query("select rate.rid,did,cid,rate, comment from rate ,reply where rate.rid <> reply.rid"); // dont show rates that have reply
	$rates= $db->query("SELECT * FROM rate WHERE rid not in ( select rateID
                     from reply);"); // dont show rates that have reply

	}
  catch(PDOException $ex)
  {
	die($ex->getMessage());
  }


//insert the reply after submit
extract($_POST);
if(isset($reply))
{	
	try
	{
		require('connection.php');
		$stmt = $db->exec("iNSERT INTO reply (rateID,reply,sid) VALUES ('$rateID', '$reply','$staffID')");
	}
	catch(PDOException $ex)
	{die($ex->getMessage());}
}

?>

<div calss='container'>
	<table border='2' align='center' width='500'>
			<tr>
				<th>Username</th>	<th>Dish name</th>	<th>Rate</th>	<th>Comment</th>	<th>Reply</th> <th>Send reply</th>
			</tr>
			
			<?php
			foreach($rates as $r)
			{ 	//get username and dishName
				try{
					require('connection.php');
					$sqlUsername = $db->query("select username from customer where cid=$r[2]");
					$sqlDishName= $db->query("select name from dish where did=$r[1]");
					$db=NULL;
				  
					}
				  catch(PDOException $ex)
				  {
					die($ex->getMessage());
				  }
				//Extract username and dishName
				foreach($sqlUsername as $ur){$username=$ur[0];}
				foreach($sqlDishName as $dn){$dishName=$dn[0];}
				?>
				<tr>
					<?php echo "<th>$username</th>	<th>$dishName</th>	<th>$r[3]</th>	<th>$r[4]</th>";	?>
					<form action='#' method='POST'>
						<th><input type='text' name='reply'></th>
						<th><input type='submit' value='Send reply'></th>
						<!--Send the values to upload it-->
						<?php echo "<input type='hidden' name='rateID' value='$r[0]' />";
									echo "<input type='hidden' name='staffID' value=$staffID />"; ?>
					</form>
						
				</tr>
				
			<?php } ?>

			
	</table>
</div>
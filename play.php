<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
    $uname=$_SESSION['username'];
	include_once "function.php";
	 ob_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media browse</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <style>
body {background-color: #2d2d30;
color:white;
}
</style>
<script type="text/javascript" src="js/jquery-latest.pack.js"></script>
<script type="text/javascript">

function saveDownload(id)
{
	$.post("media_download_process.php",
	{
       id: id,
	},
	function(message) 
    { }
 	);
} 
</script>
</head>


<body>


	<!--<div align = "center">
         <div align = "center">

            <div><br/><b><h2>Welcome <?php echo $_SESSION['username'];?></h2></b>
            <div align="right"> 
            <ul class="nav navbar-nav navbar-right">
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
        </ul></div>
            </div> <br><br>-->
           
           <div align = "center">
         <div align = "center">
		<div class="container-fluid">
    	<div class="navbar-header">
      <br> <b><h2>Welcome <?php echo $_SESSION['username'];?></h2></b>
    </div>
	 <div class="collapse navbar-collapse" id="myNavbar"><br>
      <ul class="nav navbar-nav navbar-right">
		<li><a href='media_upload.php'  style="color:#FF9900;">Upload File</a></li> 
        <li><a href="update.php" style="color:#FF9900;">Profile</a></li>
        <li><a href="allmedia.php" style="color:#FF9900;">All media</a></li>		  
        <li><a href="contacts.php"  style="color:#FF9900;">Contacts</a></li>		  
        <li><a href="mychannel.php" style="color:#FF9900;">My channel</a></li>
		  <li class="nav-item dropdown">
		 <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          MORE
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item"  href="browse_list.php">Browse by category</a><br>
        <a class="dropdown-item"  href="blocklist.php">Block List</a><br>
        <a class="dropdown-item"  href="playlist.php">Playlist</a><br>
        <a class="dropdown-item"  href="most_viewed.php">Most viewed</a><br>
        <a class="dropdown-item"  href="most_recent.php">Recently uploaded</a><br>
        <a class="dropdown-item"  href="channel.php">Browse by channel</a><br>
        <a class="dropdown-item" href="favlist.php">Favlist</a><br>
        </div>
		</li>
        <li><a href="index.php" style="color:#FF9900;">Signout</a></li>
        </ul>
    </div>
    
  </div></div>

<!--<a href='media_upload.php'  style="color:#FF9900;">Upload File</a>-->
<div id='upload_result'>
<?php 
	if(isset($_REQUEST['result']) && $_REQUEST['result']!=0)
	{		
		echo upload_error($_REQUEST['result']);
	}
?>
</div>
<br/><br/>
			   
		
		
	<?php

	$query = "SELECT * from media order by vcount desc limit 4"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>
			   <table width="50%" cellpadding="0" cellspacing="0" align="right">
	<tr valign="top" >
			<th> </th>
			</tr>
				<tr valign="top" >
			<th>Most viewed Media</th>
			</tr>
		<?php
		$j=1;
			while ($result_row = mysql_fetch_row($result)) //filename, username, type, mediaid, path
			{ 
				$mediaid[$j] = $result_row[3];
				//echo "$mediaid[$i]";
				$filename [$j]= $result_row[0];
				$filenpath [$j]= $result_row[4];
				$ufname [$j]= $result_row [5];
				$desc [$j]= $result_row[7];
				$username [$j]= $result_row[1];
				$category[$j]= $result_row[6];
				$count[$j]=$result_row[9];
				$j++;
		?>
			<?php
			}
		?>
		<?php for($y=1;$y<=$j-1;$y++){
		$bs="select mediaid from block where mediaid='$mediaid[$y]' and username='$uname'";
		$out= mysql_query($bs);
		$b1 = mysql_fetch_assoc($out);
		$blist=$b1['mediaid'];
		$ps="select mediaid from playlist where mediaid='$mediaid[$y]' and username='$uname'";
		$out= mysql_query($ps);
		$p1 = mysql_fetch_assoc($out);
		$plist=$p1['mediaid'];
		$fs="select mediaid from favlist where mediaid='$mediaid[$y]' and username='$uname'";
		$out= mysql_query($fs);
		$f1 = mysql_fetch_assoc($out);
		$flist=$f1['mediaid'];
		
	
	
	if ($mediaid[$y]==$blist){  ?>

								<?php

								} 
							else {?>
		
        	 <tr >	
                        <td>

            	            <a target="_blank"><?php echo $ufname[$y];?> </a> 
                        </td>
				  <form method='get' action=''>
                        <td>
							
            	            <button class="btn btn-success" name=" 'submit'<?php echo$y;?>" type="submit" value="submit">VIEW</button>
                        </td>
				 		<td>
							
							<button class="btn btn-success" name=" 'block'<?php echo$y;?>" type="submit" value="submit">BLOCK</button>
							
						</td>	
					  <td>
						  <?php if ($mediaid[$y]==$plist){  ?>

								<button class="btn btn-success" name=" 'Playlist'<?php echo$y;?>" type="submit" value="submit" disabled>Added playlist</button>
								<?php

								} 
							else {?>
							<button class="btn btn-success" name=" 'Playlist'<?php echo$y;?>" type="submit" value="submit">Add playlist</button>
						  <?php } ?>
						</td>
					  <td>
						  <?php if ($mediaid[$y]==$flist){  ?>

								<button class="btn btn-success" name=" 'favlist'<?php echo$y;?>" type="submit" value="submit" disabled>Added favlist</button>
								<?php

								} 
							else {?>
							<button class="btn btn-success" name=" 'favlist'<?php echo$y;?>" type="submit" value="submit">add favlist</button>
						  <?php } ?>
						</td>
		</form></tr>
		<?php } ?>
        	<?php } ?>
				   <?php

	$query = "SELECT * from media order by upload_date desc limit 4"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>
	<tr valign="top" >
			<th> </th>
			</tr>
				<tr valign="top" >
			<th>Recently uploaded</th>
			</tr>
		<?php
		$i=1;
			while ($result_row = mysql_fetch_row($result)) //filename, username, type, mediaid, path
			{ 
				$mediaid[$i] = $result_row[3];
				//echo "$mediaid[$i]";
				$filename [$i]= $result_row[0];
				$filenpath [$i]= $result_row[4];
				$ufname [$i]= $result_row [5];
				$desc [$i]= $result_row[7];
				$username [$i]= $result_row[1];
				$category[$i]= $result_row[6];
				$count[$i]=$result_row[9];
				$i++;
		?>
			<?php
			}
		?>
		<?php for($y=1;$y<=$i-1;$y++){
		$bs="select mediaid from block where mediaid='$mediaid[$y]' and username='$uname'";
		$out= mysql_query($bs);
		$b1 = mysql_fetch_assoc($out);
		$blist=$b1['mediaid'];
		$ps="select mediaid from playlist where mediaid='$mediaid[$y]' and username='$uname'";
		$out= mysql_query($ps);
		$p1 = mysql_fetch_assoc($out);
		$plist=$p1['mediaid'];
		$fs="select mediaid from favlist where mediaid='$mediaid[$y]' and username='$uname'";
		$out= mysql_query($fs);
		$f1 = mysql_fetch_assoc($out);
		$flist=$f1['mediaid'];
		
	
	
	if ($mediaid[$y]==$blist){  ?>

								<?php

								} 
							else {?>
		
        	 <tr >	
                        <td>

            	            <a target="_blank"><?php echo $ufname[$y];?> </a> 
                        </td>
				  <form method='get' action=''>
                        <td>
							
            	            <button class="btn btn-success" name=" 'submit'<?php echo$y;?>" type="submit" value="submit">VIEW</button>
                        </td>
				 		<td>
							
							<button class="btn btn-success" name=" 'block'<?php echo$y;?>" type="submit" value="submit">BLOCK</button>
							
						</td>	
					  <td>
						  <?php if ($mediaid[$y]==$plist){  ?>

								<button class="btn btn-success" name=" 'Playlist'<?php echo$y;?>" type="submit" value="submit" disabled>Added playlist</button>
								<?php

								} 
							else {?>
							<button class="btn btn-success" name=" 'Playlist'<?php echo$y;?>" type="submit" value="submit">Add playlist</button>
						  <?php } ?>
						</td>
					  <td>
						  <?php if ($mediaid[$y]==$flist){  ?>

								<button class="btn btn-success" name=" 'favlist'<?php echo$y;?>" type="submit" value="submit" disabled>Added favlist</button>
								<?php

								} 
							else {?>
							<button class="btn btn-success" name=" 'favlist'<?php echo$y;?>" type="submit" value="submit">add favlist</button>
						  <?php } ?>
						</td>
		</form></tr>
		<?php } ?>
        	<?php } ?>
		</table>
		</div>
	<?php
			
			for ($z=1;$z<=$y;$z++){
			if(isset($_GET["'submit'$z"]))
			{
  			$insert = "insert into view(mediaid, username)".
							  "values('$mediaid[$z]','$uname')";
			$output1 = mysql_query( $insert);
				$c=$count[$z];
				$c++;
			$update = "update media set vcount='$c' where mediaid='$mediaid[$z]'";
			$output7= mysql_query ($update);
			?>
			<h3><?php echo $ufname[$z];?></h3>
			<video width="500" height="300" align="left" overflow="hidden" controls>
  			<source src="<? echo $filenpath[$z];?>" type="video/mp4">
			</video><br>
			<p> uploaded by:  <?php echo $username[$z]; ?></p><br>
			<p> description: <?php echo $desc[$z]; ?></p>
	<?php

	$query = "SELECT * from comment where mediaid='$mediaid[$z]'"; 
	$result = mysql_query( $query );
				if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
	$qquery = "SELECT avg(rating) from rating where mediaid='$mediaid[$z]'"; 
	$rresult = mysql_query( $qquery );
	$dresult = mysql_fetch_row($rresult);
	$rating = $dresult[0];
	
?>
		<table width="50%" cellpadding="0" cellspacing="0" align="left">
	<form method='post' action=''>
	<tr valign="top" >
		<th> Average rating:  <?php echo"$rating"?></th>
		</tr><tr valign="top" >
			<th>Rate this : 
	  <input type="radio" name="rating" value="1" checked> 1
  	  <input type="radio" name="rating" value="d"> 2
      <input type="radio" name="rating" value="3"> 3
      <input type="radio" name="rating" value="4"> 4
      <input type="radio" name="rating" value="5"> 5
	  <button class="btn btn-success" name="'rate'<?php echo$z;?>" type="submit" value="rate" class="myButton">RATE</button>
		</th>
			</tr>
		</form>
				<tr valign="top" >
			<th>comments:</th>
			</tr>
		<?php
		$i=1;
			while ($result_row = mysql_fetch_row($result)) //filename, username, type, mediaid, path
			{ 
				$mediaid[$i] = $result_row[1];
				//echo "$mediaid[$i]";
				$cid [$i]= $result_row[0];
				$comment [$i]= $result_row[2];
				$ucname [$i]= $result_row [3];
				$i++;
		?>
			<?php
			}
		?>
		<?php for($y=1;$y<=$i-1;$y++){
		/*$bs="select mediaid from block where mediaid='$mediaid[$y]' and username='$uname'";
		$out= mysql_query($bs);
		$b1 = mysql_fetch_assoc($out);
		$blist=$b1['mediaid'];
		$ps="select mediaid from playlist where mediaid='$mediaid[$y]' and username='$uname'";
		$out= mysql_query($ps);
		$p1 = mysql_fetch_assoc($out);
		$plist=$p1['mediaid'];
		$fs="select mediaid from favlist where mediaid='$mediaid[$y]' and username='$uname'";
		$out= mysql_query($fs);
		$f1 = mysql_fetch_assoc($out);
		$flist=$f1['mediaid'];
		
	
	
	if ($mediaid[$y]==$blist){  ?>

								<?php

								} 
							else {*/?>
		
        	 <tr >	
                        <td>
            	            <p><?php echo $ucname[$y];?> : <?php echo $comment[$y];?> </p>
                        </td>
			</tr>
		<?php } //}?>
	

     	<form method='post' action=''>
			 <tr><th>Write your comment</th></tr>
			<tr><td>
          <textarea name="comment" rows="3" cols="80" style="color:black"></textarea>
			</td><td>
          <button class="btn btn-success" name="'xyz'<?php echo$z;?>" type="submit" value="xyz" class="myButton">Comment</button>
			</td></tr>
			</form>
			 </table>
			 
       
      
		
			
			<?php
  			
			}
			if(isset($_GET["'block'$z"]))
			{
  			$insert1 = "insert into block(mediaid, username)".
							  "values('$mediaid[$z]','$uname')";
			$output2 = mysql_query( $insert1);
			$delete1="delete from playlist where mediaid='$mediaid[$z]' and username='$uname'";
			$delete2="delete from favlist where mediaid='$mediaid[$z]' and username='$uname'";
			$out= mysql_query($delete1);
			$out1= mysql_query($delete2);
			if($out && $out1)
			{
			  
			  header('Location: browse.php');
			  }
			      else{
			        die ("Could not update into the database: <br />". mysql_error());    
			      }
			}
			}
			for ($w=1;$w<=$y;$w++){
			if(isset($_GET["'Playlist'$w"]))
			{
			
  			$insert2 = "insert into playlist(mediaid, username)".
							  "values('$mediaid[$w]','$uname')";
			$output3 = mysql_query( $insert2);
			if($output3)
			{
			  
			  header('Location: browse.php');
			  }
			      else{
			        die ("Could not update into the database: <br />". mysql_error());    
			      }

			}
			if(isset($_GET["'favlist'$w"]))
			{
  			$insert3 = "insert into favlist(mediaid, username)".
							  "values('$mediaid[$w]','$uname')";
			$output4 = mysql_query( $insert3);

			if($output4)
			{
			  
			  header('Location: browse.php');
			  }
			      else{
			        die ("Could not update into the database: <br />". mysql_error());    
			      }


		}
			}

		for ($s=1;$s<=$z;$s++){	 
       if(isset($_POST["'xyz'$s"])){
		   //echo "hi";
       	  $comment=$_POST["comment"];
       	$query15="insert into comment(mediaid,comment,username) values ('$mediaid[$s]','$comment','$uname')";
       	$insert15 = mysql_query($query15);
       	if($insert15){
				header("Refresh:0");
			}
			else{
				die ("Could not insert into the table : <br />". mysql_error());	
       }
   }
		}
	for ($k=1;$k<=$z;$k++){	 
       if(isset($_POST["'rate'$k"])){
		   //echo "hi";
       	  $rating=$_POST["rating"];
       	$query16="insert into rating(rid,mediaid,rating) values (NULL,'$mediaid[$k]','$rating')";
       	$insert17 = mysql_query($query16);
       	if($insert17){
				header("Refresh:0");
			}
			else{
				die ("Could not insert into the table : <br />". mysql_error());	
       }
   }
		}
  
       
       
			ob_end_flush();
		?>

		
   
</body>
</html>
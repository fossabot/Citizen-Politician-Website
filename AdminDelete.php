<?php
$photo;
require "Connection.php";
session_start();
if(!isset($_SESSION["username"])||$_SESSION["usertype"]!=="admin"){
	header("Location: Homepage.php");
	return;
}
if($_SESSION['gender']==='male'){
	$photo='user.png';
}else{
	$photo='userFemale.png';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Mwananchi</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" type="image/png" href="MwananchiIcon.png">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Cookie" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="Logged.css">
	<link rel="stylesheet" type="text/css" href="LoggedPhone.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script src="MainJS.js"></script>
</head>
<body>
<div class="container-fluid">
	<nav class="navbar bg-info navbar-light navbar-expand-lg fixed-top" style="border-radius: 5px;">
		<a class="navbar-brand text-dark" href="StartAdmin.php" style="font-family: Cookie,cursive;font-size: 24px;padding-bottom: 2px;padding-top: 2px;"><i class="fas fa-user"></i> Mwananchi</a>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#smallScreen" style="outline: none;">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="smallScreen">
			<ul class="navbar-nav mr-auto">
		      <li class="nav-item navigationBar">
		        <a class="nav-link text-light" href="StartAdmin.php">Home</a>
		      </li>
		      <li class="nav-item navigationBar">
		        <a class="nav-link text-light" href="BugReport.php">Bug Report</a>
		      </li>
		      <li class="nav-item navigationBar">
		        <a class="nav-link text-light" href="ContactsPage.php">Contacts</a>
		      </li> 
		      <li class="nav-item navigationBar">
		        <a class="nav-link text-light" href="HelpPage.php">Help</a>
		      </li> 
		    </ul>
		    <ul class="navbar-nav">
		    	<li class="nav-item navigationBar"><a class="nav-link text-light" href="Settings.php"><span class="fas fa-cog"></span> Settings</a></li>
		    	<li class="nav-item dropdown navigationBar"><a class="nav-link dropdown-toggle text-light" data-toggle="dropdown" href=""><span class="rounded-circle"><img src="<?php echo $photo; ?>" width="25px" height="25px"></span> My Profile </a>
		    		<div class="dropdown-menu bg-info" style="padding: 3px;border-radius: 5px;padding-top: 13px">
		    			<a class="dropdown-item text-dark" href="MyProfile.php">@ <?php echo $_SESSION["username"]; ?></a><hr>
			    			<a class="dropdown-item text-dark" href="Stories.php">Recent Stories</a>
			    			<a class="dropdown-item text-dark" href="Functions.php">Functions</a>
			    			<a class="dropdown-item text-dark" href="SiteSettings.php">Site Settings</a>
			    			<a class="dropdown-item text-dark" href="SendEmails.php">Send Emails</a>
			    			<a class="dropdown-item text-dark" href="RegisterAdmin.php">Add Admin</a>
			    			<a class="dropdown-item text-dark" href="Logout.php">Logout</a>
		    		</div>
		    	</li>
		    </ul>
		</div>
	</nav>
	<div class="container" style="position:relative;top:100px">
		<div class="alerts"></div>
		<script>
			var del=Cookies.get("delete")
			if(del.localeCompare("undefined")!==0){
				$('.alerts').addClass('alert').addClass('alert-info').html(del)
				$("html, body").animate({ scrollTop: 0 }, "fast");
				Cookies.remove("delete")
			}
		</script>
		<table class="table table-borderless">
			<thead>
				<tr><td colspan="4"><div class="jumbotron"><span class="display-4 text-danger">Account Termination</span><br><small>The following are accounts registered on the system.</small></div></td><tr>
			</thead>
			<?php
			$stmt=$connection->query("select adminUserName,userGender,userType from admin_profile union all select username,gender,type from citizen_profile union all select userName,gender,accountType from politician_profile");
			if($stmt){
				if(mysqli_num_rows($stmt)>0){
					for($count=0;$row = $stmt->fetch_array(MYSQLI_NUM);$count++){
						if($count%4===0&&$count!==0){
							echo "</tr><tr>";
						}
						if($count===0){
							echo "<tr>";
						}
						if($row[1]==="male") $photo='user.png';
						else $photo='userFemale.png';
						echo "<td><div class='card' style='width:250px'><img class='card-img-top' src='$photo' alt='Card image'><div class='card-body'><h4 class='card-title'>$row[0]</h4><p class='card-text'>$row[1]<br>$row[2]<br></p><a href='' class='btn btn-danger delete' id='$row[0]'>Delete Account</a></div></div></td>";
					}
					echo "</tr>";
				}else{
					echo "<script>$('.alerts').addClass('alert').addClass('alert-danger').html('The database has no records.')</script>";
					return;
				}
			}else{
				echo "<script>$('.alerts').addClass('alert').addClass('alert-danger').html(\"".$connection->error."\")</script>";
				return;
			}
			?>
		</table>
	</div>
	<script>
		$(".delete").click(event=>{
			event.preventDefault();
			var ans=confirm("Are you sure you want to delete account where username is "+$(event.currentTarget).attr("id")+"?");
			if(ans){
				$.post("Delete.php",{user:$(event.currentTarget).attr("id")},data=>{
					Cookies.set("delete",data)
					location.reload()
				})
			}
		})
	</script>
</div>
</body>
</html>
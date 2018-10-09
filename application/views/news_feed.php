<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $head;?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js" type="text/javascript"></script>
</head>
<body>
<?php echo $navbar;?>
<div class="container-fluid" style="position: relative;top: 65px;">
	<div class="row mb-3">
		<div class="col-md-3 mb-3">
			<form>
				<div class="input-group">
					<input class="form-control" type="text" name="search" placeholder="Search for something . . . " required="">
					<div class="input-group-append">
						<button type="submit" class="btn btn-info">Search</button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-6 text-center text-info">
			<legend>News_Feed</legend>
		</div>
		<div class="col-md-3 text-center" id="online">
			<div class="custom-control custom-radio">
				<input type="radio" class="custom-control-input" id="isOnline" name="isOnline" disabled="">
				<label class="custom-control-label text-info" for="isOnline">Online</label>
			</div>
		</div>
		<script>
			$("#isOnline").prop("checked",navigator.onLine)
			function checkOnline(){
				$("#isOnline").prop("checked",navigator.onLine)
			}
			setInterval(checkOnline,3000)
		</script>
	</div>
	<div class="row d-flex">
		<div class="col-lg-3 mb-5">
			<div class="text-center">
				<a class="text-muted" style="text-decoration: none;" href="">
	            <img src="<?php echo $this->session->userdata('photo');?>" class="rounded-circle img-thumbnail mb-2 w-50"><br>
	            <span style="text-transform: capitalize;font-size: 24px;font-weight: bolder;">@ <?php echo $this->session->userdata('username');?></span></a>
	        </div><hr><hr>
	        <?php echo $activity;?>
		</div>
		<div class="col-lg-6 mb-5 p-0" style="width: 100%">
			<div>
				<ul class="nav nav-tabs bg-info d-flex justify-content-between">
		            <li class="nav-item" style="width: 33%"><a class="nav-link active" style="color: darkslategray;border-radius: 0" data-toggle="tab" href="#Comments">Comments</a></li>
		            <li class="nav-item" style="width: 34%"><a class="nav-link" style="color: darkslategray;border-radius: 0" data-toggle="tab" href="#Achievements">Achievements</a></li>
		            <li class="nav-item" style="width: 33%;"><a class="nav-link" style="color: darkslategray;border-radius: 0;w" data-toggle="tab" href="#Critiques">Critiques</a></li>
		        </ul>
		        <div class="tab-content mb-5" style="border: 1px solid rgba(0,0,0,0.1);border-radius: 10px;border-top-left-radius: 0px;border-top-right-radius: 0px;background-color: white">
	            	<div class="tab-pane container active show mt-3 mb-4" id="Comments">
                		<?php echo $comments;?>
					</div>
					<div class="tab-pane container fade" id="Achievements">
						<?php echo $achievements;?>
					</div>
					<div class="tab-pane container fade" id="Critiques">
						<?php echo $critiques;?>
					</div>
				</div>
		    </div>
		</div>
	</div>
</div>
</body>
<script>$("textarea").autogrow();$("table").DataTable({ordering:false,"info":false,"pageLength":25,"lengthChange":false});</script>
</html>
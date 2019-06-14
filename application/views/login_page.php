<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>CodeIgniter Ajax Login using jQuery</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
	<style>
		body{
			background-image:url("<?php echo base_url(); ?>assets/images/bg.png");
			background-size:     cover;          
			background-repeat:   no-repeat;
		}
	</style>
</head>
<body>
<div class="container">
	
	<div class="row mx-auto" style="margin-top:200px; width: 600px;">
		<div style="background-color:black; height:500px; width:800px; padding:50px; border-radius:20px; background-color: rgba(0,0,0,0.5);"> 
			<div class="col-sm-6 text-center mx-auto" style="margin-top:50px;">
				<div class="login-panel panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title" style="color:white;"><span class="glyphicon glyphicon-lock"></span> Login </h3> <br>
					</div>
					<div class="panel-body">
						<form id="logForm">
							<fieldset>
								<div class="form-group">
									<input class="form-control" placeholder="Email" type="text" name="email">
								</div>
								<div class="form-group">
									<input class="form-control" placeholder="Password" type="password" name="password">
								</div>
								<button type="submit" class="btn btn-primary btn-block"><span id="logText"></span></button>
								<a href="<?php echo base_url(); ?>index.php/user/reg_view" class="btn btn-danger btn-block">Register</a>
							</fieldset>
						</form>
					</div>
				</div>
			</div>        
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/popper.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#logText').html('Login');
		$('#logForm').submit(function(e){ 
			e.preventDefault();
			$('#logText').html('Checking...');		
			var url = '<?php echo base_url(); ?>';
			var user = $('#logForm').serialize();
				$.ajax({
					type: 'POST',
					url: url + 'index.php/user/login',
					dataType: 'json',
					data: user,
					success:function(response){
						$('#message').html(response.message);
						$('#logText').html('Login');
						if(response.error){
							$('#responseDiv').removeClass('alert-success').addClass('alert-danger').show();
						}
						else{
							$('#responseDiv').removeClass('alert-danger').addClass('alert-success').show();
							location.reload();						
						}
					}
				});
		});
	});
</script>
</body>
</html>
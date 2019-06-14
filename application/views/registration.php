<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>CodeIgniter Ajax Regitster using jQuery</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="register-panel panel panel-primary">
		        <div class="panel-heading">
		            <h3 class="panel-title"><span class="glyphicon glyphicon-lock"></span> Register
		            </h3>
		        </div>
		    	<div class="panel-body">
		        	<form id="logForm">
		            	<fieldset>
                            <div class="form-group">
		                    	<input class="form-control" placeholder="First Name" type="text" name="firstname">
		                	</div>
		                	<div class="form-group">
		                    	<input class="form-control" placeholder="Email" type="text" name="email">
		                	</div>
		                	<div class="form-group">
		                    	<input class="form-control" placeholder="Password" type="password" name="password">
		                	</div>
		                	<button type="submit" class="btn btn-lg btn-primary">Register</button>
		            	</fieldset>
		        	</form>
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
		$('#logForm').submit(function(e){
			e.preventDefault();
			var user = $('#logForm').serialize();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('user/registration')?>",
                data: user,
                success:function(){	
                    location.href = "<?php echo site_url('user/index')?>"
                }
            });
		});
	});
</script>
</body>
</html>
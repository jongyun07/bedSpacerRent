<!DOCTYPE html> 
<html lang = "en"> 

   <head> 
      <meta charset = "utf-8"> 
      <title>CodeIgniter View Example</title> 
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"> 

  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->

  <link href="<?php echo base_url(); ?>assets/css/jquery.bdt.css" type="text/css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/jquery.bdt.min.css" type="text/css" rel="stylesheet">
  

  <script src="<?php echo base_url(); ?>assets/js/jquery.bdt.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/jquery.bdt.min.js"></script>
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/BDatePicker/css/datepicker.css" type="text/css" rel="stylesheet">
  <script src="<?php echo base_url(); ?>assets/BDatePicker/js/bootstrap-datepicker.js"></script>


    
   </head>
	
   <body>  
      <nav class="navbar navbar-expand-md bg-dark navbar-dark rounded-0">
         <a class="navbar-brand" href="#">BrandName</a>
         <button class="navbar-toggler" style="margin-left: 408px;" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
               <li class="nav-item">
                   <a href="<?php echo base_url(); ?>index.php/user/home" class="nav-link"><i class="fa fa-bars"></i> &nbsp; List of Tenants</a> 
               </li>
               <li class="nav-item">
                  <a href="<?php echo base_url(); ?>index.php/user/room" class="nav-link"><i class="fa fa-th-large"></i> &nbsp; Room Grid</a>
               </li>   
            </ul>
            
         </div>  
         <form class="form-inline">
               <a href="<?php echo base_url(); ?>index.php/user/logout" class="nav-link" style="color:#CCCECF;"><i class="fas fa-sign-out-alt"></i> Logout</a>  
            </form>
      </nav>
<br>

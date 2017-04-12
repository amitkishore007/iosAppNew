<!DOCTYPE html>
<html>

<head>
    <title>Forever marathon</title>
    <meta name="msapplication-TileColor" content="#ffffff">

    <meta name="theme-color" content="#ffffff">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <?php echo link_tag('assets/css/styles.css'); ?>
   <?php echo link_tag('assets/css/toastr.min.css'); ?>
   <?php echo link_tag('assets/css/zebra_pagination.css'); ?>

   <script>
        var base_url = "<?php echo base_url(); ?>";
    </script>

    <script type="text/JavaScript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script type="text/JavaScript" src="<?php echo base_url(); ?>assets/js/plugins.js"></script>
    <script type="text/JavaScript" src="<?php echo base_url(); ?>assets/js/funcs.js?v=1"></script>
    <script type="text/JavaScript" src="<?php echo base_url(); ?>assets/js/script.js"></script>
    <script type="text/JavaScript" src="<?php echo base_url(); ?>assets/js/toastr.min.js"></script>
</head>

<body>
    <header class="cf" id="header">
        <div class="logo">
            <a href="#" target="SB"><!-- <img src="/images/" /> -->Forever Marathon</a>
        </div>
        <nav id="nav">
            <ul class="menu">
            <?php if ($this->session->userdata('is_logged_in')) { ?>
               
                <li><span>welcome <?php echo $this->session->userdata('role'); ?></span>
                
                 <?php } ?>
            
                </li>
                <!-- <li ><a href="/view_events.php">Events</a></li> -->
                <li class="Selected"><a href="client_list.php">Users</a>
                </li>
                <li><a href="donations.php">Donations</a>
                </li>
                <!--<li ><a href="/media_list.php">Media</a></li>
				<li ><a href="/view_shareddata.php">Sharing Data</a></li>
				<li ><a href="/server_info.php">Server Info</a></li>-->
                <li><a href="logout.php">Logout</a>
                </li>
                <!-- <li ><a href="/view_userdata.php">User Data</a></li> -->
                <!-- <li><a href="/occpucation_list.php">Occupations</a></li> -->
                <!-- <li ><a href="/change_password.php">Change Password</a></li> -->

            </ul>
        </nav>
    </header>
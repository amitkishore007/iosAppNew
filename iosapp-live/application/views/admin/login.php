<!DOCTYPE html>
<html>

<head>
    <title>Forever marathon</title>
    <meta name="msapplication-TileColor" content="#ffffff">

    <meta name="theme-color" content="#ffffff">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php echo link_tag('assets/css/styles.css?v=1.7'); ?>
    <?php echo link_tag('assets/css/zebra_pagination.css'); ?>
    <script>
        var base_url = "<?php echo base_url(); ?>";
    </script>

    <script type="text/JavaScript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script type="text/JavaScript" src="<?php echo base_url(); ?>assets/js/plugins.js"></script>
    <script type="text/JavaScript" src="<?php echo base_url(); ?>assets/js/funcs.js?v=1"></script>
    <script type="text/JavaScript" src="<?php echo base_url(); ?>assets/js/sha512.js"></script>
    <script type="text/JavaScript" src="<?php echo base_url(); ?>assets/js/forms.js"></script>
    <script type="text/JavaScript" src="<?php echo base_url(); ?>assets/js/script.js"></script>
    
    <style type="text/css">
        #msg-flash {
            margin-left: 0;
        }
    </style>
</head>

<body class="login-page" >

    <div class="login">
    <div class="error-message"></div>
        <!-- <form action="login.php" method="post" name="login_form"> -->
        <?php $form_array = array('method'=>'post','name'=>'login_form' ); ?>
        <?php echo form_open('admin/login',$form_array); ?>
            <fieldset>
                <div class="logo">
                    <!-- <a href="http://localhost/ios-admin/admindashboard.php"> -->
                    <!-- <img src="<?php //echo base_url(); ?>assets/images/studiobooth.png" /> -->
                    <h3>Marathon Forever</h3>
                    <!-- </a> -->
                </div>
                <div class="field">
                    <label for="email">Email:</label>
                  
                    <?php $input = array(
                            'type' =>'email',
                            'id'   =>'email',
                            'name' =>'email'    

                    ); ?>
                    <?php echo form_input($input); ?>
                </div>
                <div class="field">
                    <label for="password">Password:</label>
                      <?php
                           $input = array(
                                'type' =>'password',
                                'id'   =>'password',
                                'name' =>'password'    

                            ); 
                    ?>
                    <?php echo form_input($input); ?>
              
                </div>
                <div class="action">
                <?php echo form_submit('submit','Login',array('id'=>'login')); ?> 
                    <!-- <input type="submit" value="Login" id='adminLogin'/> -->
                    <!-- <a href="javascript:void(0);" class="forgot-password-link">Forgot Password?</a> -->
                    <div style="clear:both;"></div>
                </div>
            </fieldset>
            <!-- <pre>
							</pre> -->
        <!-- </form> -->
        <?php echo form_close(); ?>
    </div>
    <div class="forgot-password">
        <form action="" method="post"  name="forgot_pass_form">
            <fieldset>
                <div class="logo">
                    <a href="#"><img src="#" /> Marathon Forever</a>
                </div>
                <b>Note:</b> Reset password link will be send on your registered email id.
                <br />
                <br />
                <div id="forgot-pass-result"></div>
                <div class="field">
                    <label for="email">Registered Email:</label>
                    <input type="email" id="registered_email" name="registered_email" required />
                </div>
                <div class="action">
                    <input type="submit" value="Send mail" />
                    <a href="javascript:void(0);" class="forgot-password-login">Login?</a>
                    <div style="clear:both;"></div>
                </div>
            </fieldset>
        </form>

    </div>
    </body>

</html>
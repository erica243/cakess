<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LcIf5YqAAAAAG0L3taRMqsOaNi2IyHx2l3F-yYAd"></script>
</head>
<body>
<div class="container-fluid">
    <!-- Login Section -->
    <div id="login-section" class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form action="" id="login-frm">
                        <div class="form-group">
                            <label for="email" class="control-label">Email</label>
                            <input type="email" name="email" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" name="password" required class="form-control">
                            <small><a href="javascript:void(0)" class="text-dark" id="new_account">Create New Account</a></small>
                        </div>
                        
                        <button type="submit" class="btn btn-dark btn-sm btn-block">Login</button>
                        <div class="text-center mt-2">
                            <a href="javascript:void(0)" class="text-dark" id="forgot_password">Forgot Password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Section -->
    <div id="forgot-password-section" style="display: none;" class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Forgot Password</div>
                <div class="card-body">
                    <form action="" id="forgot-password-frm">
                        <div class="form-group">
                            <label for="email" class="control-label">Enter your Email</label>
                            <input type="email" name="email" required class="form-control" placeholder="Enter your email">
                        </div>
                        <button type="submit" class="btn btn-dark btn-sm btn-block">Submit</button>
                        <div class="text-center mt-2">
                            <a href="javascript:void(0)" class="text-dark" id="back_to_login">Back to Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // reCAPTCHA initialization
    grecaptcha.ready(function() {
        grecaptcha.execute('6LcIf5YqAAAAAG0L3taRMqsOaNi2IyHx2l3F-yYAd', {action: 'login'});
    });

    // New Account Modal
    $('#new_account').click(function () {
        uni_modal("Create an Account", 'signup.php?redirect=index.php?page=home')
    });

    // Login Form Submission
    $('#login-frm').submit(function (e) {
        e.preventDefault();
        
        // Generate reCAPTCHA token
        grecaptcha.execute('6LcIf5YqAAAAAG0L3taRMqsOaNi2IyHx2l3F-yYAd', {action: 'login'}).then(function(token) {
            // Prepare form data with reCAPTCHA token
            var formData = $('#login-frm').serialize() + '&recaptcha_token=' + token;
            
            // Disable submit button and show loading
            $('#login-frm button[type="submit"]').attr('disabled', true).html('Logging in...');
            
            // Remove any existing error messages
            $('#login-frm .alert-danger').remove();
            
            // AJAX login submission
            $.ajax({
                url: 'login_process.php',
                method: 'POST',
                data: formData,
                dataType: 'json',
                error: function(err) {
                    console.log(err);
                    $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                    $('#login-frm').prepend('<div class="alert alert-danger">An unexpected error occurred.</div>');
                },
                success: function(resp) {
                    if (resp.status === 'success') {
                        window.location.href = resp.redirect || 'dashboard.php';
                    } else {
                        $('#login-frm').prepend('<div class="alert alert-danger">' + resp.message + '</div>');
                        $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                    }
                }
            });
        });
    });

    // Forgot Password Section Navigation
    $('#forgot_password').click(function () {
        $('#login-section').hide();
        $('#forgot-password-section').show();
    });

    $('#back_to_login').click(function () {
        $('#forgot-password-section').hide();
        $('#login-section').show();
    });

    // Forgot Password Form Submission
    $('#forgot-password-frm').submit(function (e) {
        e.preventDefault();
        
        // Generate reCAPTCHA token
        grecaptcha.execute('6LcIf5YqAAAAAG0L3taRMqsOaNi2IyHx2l3F-yYAd', {action: 'forgot_password'}).then(function(token) {
            // Prepare form data with reCAPTCHA token
            var formData = $('#forgot-password-frm').serialize() + '&recaptcha_token=' + token;
            
            // Disable submit button and show loading
            $('#forgot-password-frm button[type="submit"]').attr('disabled', true).html('Submitting...');
            
            // Remove any existing messages
            $('#forgot-password-frm .alert').remove();
            
            // AJAX forgot password submission
            $.ajax({
                url: 'forgot_password.php',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(resp) {
                    $('#forgot-password-frm button[type="submit"]').removeAttr('disabled').html('Submit');
                    
                    if (resp.status === 'success') {
                        $('#forgot-password-frm').prepend('<div class="alert alert-success">' + resp.message + '</div>');
                    } else {
                        $('#forgot-password-frm').prepend('<div class="alert alert-danger">' + resp.message + '</div>');
                    }
                },
                error: function() {
                    $('#forgot-password-frm button[type="submit"]').removeAttr('disabled').html('Submit');
                    $('#forgot-password-frm').prepend('<div class="alert alert-danger">An unexpected error occurred. Please try again.</div>');
                }
            });
        });
    });
});
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <!-- Login Section -->
            <div id="login-section">
                <h2 class="text-center mb-4">Login</h2>
                <form id="login-frm" method="POST">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                    
                    <div class="text-center">
                        <a href="#" id="forgot_password" class="text-decoration-none">Forgot Password?</a>
                        <br>
                        <a href="#" id="new_account" class="text-decoration-none">Create New Account</a>
                    </div>
                </form>
            </div>

            <!-- Forgot Password Section -->
            <div id="forgot-password-section" style="display: none;">
                <h2 class="text-center mb-4">Forgot Password</h2>
                <form id="forgot-password-frm" method="POST">
                    <div class="form-group">
                        <label for="forgot-email" class="form-label">Enter your Email</label>
                        <input type="email" id="forgot-email" name="email" class="form-control" required placeholder="Enter your email">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                    <div class="text-center mt-3">
                        <a href="#" id="back_to_login" class="text-decoration-none">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- reCAPTCHA v3 -->
    <script src="https://www.google.com/recaptcha/api.js?render=YOUR_RECAPTCHA_SITE_KEY"></script>

    <script>
    // Replace with your actual reCAPTCHA site key
    const RECAPTCHA_SITE_KEY = 'YOUR_RECAPTCHA_SITE_KEY';

    // Initialize reCAPTCHA
    grecaptcha.ready(function() {
        grecaptcha.execute(RECAPTCHA_SITE_KEY, {action: 'login'}).then(function(token) {
            // The token will be added to the form on submission
        });
    });

    $(document).ready(function() {
        // Login Form Submission
        $('#login-frm').on('submit', function(e) {
            e.preventDefault();
            
            // Generate reCAPTCHA token
            grecaptcha.ready(function() {
                grecaptcha.execute(RECAPTCHA_SITE_KEY, {action: 'login'}).then(function(token) {
                    // Prepare form data with reCAPTCHA token
                    var formData = $('#login-frm').serialize() + '&recaptcha_token=' + token;
                    
                    // Disable submit button and show loading
                    $('#login-frm button[type="submit"]')
                        .prop('disabled', true)
                        .html('Logging in...');
                    
                    // AJAX Login Request
                    $.ajax({
                        url: 'login_handler.php',
                        method: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(resp) {
                            if (resp.status === 'success') {
                                // Redirect on successful login
                                window.location.href = resp.redirect || 'dashboard.php';
                            } else {
                                // Show error message
                                alert(resp.message || 'Login failed');
                                
                                // Re-enable submit button
                                $('#login-frm button[type="submit"]')
                                    .prop('disabled', false)
                                    .html('Login');
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr);
                            alert('An error occurred. Please try again.');
                            
                            // Re-enable submit button
                            $('#login-frm button[type="submit"]')
                                .prop('disabled', false)
                                .html('Login');
                        }
                    });
                });
            });
        });

        // Forgot Password Form Submission
        $('#forgot-password-frm').on('submit', function(e) {
            e.preventDefault();
            
            // Generate reCAPTCHA token
            grecaptcha.ready(function() {
                grecaptcha.execute(RECAPTCHA_SITE_KEY, {action: 'forgot_password'}).then(function(token) {
                    // Prepare form data with reCAPTCHA token
                    var formData = $('#forgot-password-frm').serialize() + '&recaptcha_token=' + token;
                    
                    // Disable submit button and show loading
                    $('#forgot-password-frm button[type="submit"]')
                        .prop('disabled', true)
                        .html('Submitting...');
                    
                    // AJAX Forgot Password Request
                    $.ajax({
                        url: 'forgot_password_handler.php',
                        method: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(resp) {
                            if (resp.status === 'success') {
                                alert(resp.message || 'Password reset instructions sent');
                            } else {
                                alert(resp.message || 'Failed to process request');
                            }
                            
                            // Re-enable submit button
                            $('#forgot-password-frm button[type="submit"]')
                                .prop('disabled', false)
                                .html('Reset Password');
                        },
                        error: function(xhr) {
                            console.error(xhr);
                            alert('An error occurred. Please try again.');
                            
                            // Re-enable submit button
                            $('#forgot-password-frm button[type="submit"]')
                                .prop('disabled', false)
                                .html('Reset Password');
                        }
                    });
                });
            });
        });

        // Navigation between login and forgot password sections
        $('#forgot_password').on('click', function(e) {
            e.preventDefault();
            $('#login-section').hide();
            $('#forgot-password-section').show();
        });

        $('#back_to_login').on('click', function(e) {
            e.preventDefault();
            $('#forgot-password-section').hide();
            $('#login-section').show();
        });

        // New Account Creation
        $('#new_account').on('click', function(e) {
            e.preventDefault();
            window.location.href = 'signup.php';
        });
    });
    </script>
</body>
</html>
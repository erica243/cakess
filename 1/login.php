<?php session_start(); ?>
<div class="container-fluid">
    <!-- Login Section -->
    <div id="login-section">
        <form action="" id="login-frm">
            <div class="form-group">
                <label for="" class="control-label">Email</label>
                <input type="email" name="email" required class="form-control">
            </div>
            <div class="form-group">
                <label for="" class="control-label">Password</label>
                <input type="password" name="password" required class="form-control">
                <small><a href="javascript:void(0)" class="text-dark" id="new_account">Create New Account</a></small>
            </div>
             
            <!-- reCAPTCHA widget -->
            <div class="g-recaptcha" data-sitekey="your-site-key"></div>
            
            <button class="button btn btn-dark btn-sm">Login</button>
            <div>
                <br><a href="javascript:void(0)" class="text-dark" id="forgot_password">Forgot Password?</a>
            </div>
        </form>
    </div>

    <!-- Forgot Password Section -->
    <div id="forgot-password-section" style="display: none;">
        <form action="" id="forgot-password-frm">
            <div class="form-group">
                <label for="" class="control-label">Enter your Email</label>
                <input type="email" name="email" required class="form-control" placeholder="Enter your email">
            </div>
            <button class="button btn btn-dark btn-sm">Submit</button>
            <div>
                <br><a href="javascript:void(0)" class="text-dark" id="back_to_login">Back to Login</a>
            </div>
        </form>
    </div>
</div>

<!-- Include reCAPTCHA script -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<style>
    #uni_modal .modal-footer {
        display: none;
    }
</style>

<script>
    // Show sign-up modal
    $('#new_account').click(function () {
        uni_modal("Create an Account", 'signup.php?redirect=index.php?page=home')
    });

    // Handle login form submission
    $('#login-frm').submit(function (e) {
        e.preventDefault();
        $('#login-frm button[type="submit"]').attr('disabled', true).html('Logging in...');
        
        if ($(this).find('.alert-danger').length > 0)
            $(this).find('.alert-danger').remove();
        
        $.ajax({
            url: 'admin/ajax.php?action=login2',
            method: 'POST',
            data: $(this).serialize(), // Serialize the form data
            dataType: 'json',
            error: function (err) {
                console.log(err);
                $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
            },
            success: function (resp) {
                if (resp.status === 'success') {
                    location.href = '<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php?page=home' ?>';
                } else {
                    $('#login-frm').prepend('<div class="alert alert-danger">' + resp.message + '</div>');
                    $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                }
            }
        });
    });

    // Handle forgot password navigation
    $('#forgot_password').click(function () {
        $('#login-section').hide();
        $('#forgot-password-section').show();
    });

    $('#back_to_login').click(function () {
        $('#forgot-password-section').hide();
        $('#login-section').show();
    });

    // Handle Forgot Password Form submission
    $('#forgot-password-frm').submit(function (e) {
        e.preventDefault();
        if (!$(this).find('[name="email"]').val()) {
            alert('Please enter a valid email address.');
            return;
        }

        let submitButton = $('#forgot-password-frm button[type="submit"]');
        submitButton.attr('disabled', true).html('Submitting...');
        $('#forgot-password-frm .alert').remove();

        $.ajax({
            url: 'forgot_password.php', // Ensure correct path
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (resp) {
                submitButton.removeAttr('disabled').html('Submit');
                if (resp.status === 'success') {
                    $('#forgot-password-frm').prepend('<div class="alert alert-success">' + resp.message + '</div>');
                } else {
                    $('#forgot-password-frm').prepend('<div class="alert alert-danger">' + resp.message + '</div>');
                }
            },
            error: function () {
                submitButton.removeAttr('disabled').html('Submit');
                $('#forgot-password-frm').prepend('<div class="alert alert-danger">An unexpected error occurred. Please try again later.</div>');
            }
        });
    });
</script>

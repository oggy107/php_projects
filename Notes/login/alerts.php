<?php
$scriptName =  basename($_SERVER["SCRIPT_NAME"]);

if($scriptName == 'index.php')
{
    if($successLogin)
    {
        $userName = $_SESSION['user_name'];

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Ssuccess!</strong> Welcome back .' . $userName . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }

    if ($emailLoginError)
    {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Sorry!</strong> Please recheck your email.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }

    if ($passwordLoginError)
    {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Sorry!</strong> Please recheck your password.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
}

if($scriptName == 'signup.php')
{
    if ($signupError)
    {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Sorry!</strong> Unable to sign you up at the moment.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }

    if ($signupSuccess)
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your account was created successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }

    if($accountExistSignupError)
    {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> An account with given email address already exists.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
}

if($scriptName == 'change_password.php')
{
    if ($changePasswordSuccess)
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your password was changed successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }

    if ($changePasswordError)
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Error!</strong> We are unable to change your password at the moment.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
}

?>
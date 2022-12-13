function validatePassword() {
    if (document.getElementById('password').value != document.getElementById('confirmpassword').value) {
        alert("New Password and Confirm Password Field do not match  !!");
        document.getElementById('confirm-password').focus();
        return false;
    }
    return true;
}

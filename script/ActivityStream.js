(function ($, window, undefined) {
    ActivityStream = {
        Events: () => {
            var cookieSub = [];
            var cookieString = document.cookie.split(';');
            $.each(cookieString, function (i, item) {
                if(item){
                cookieSub.push(item.split("=")[0].trim());
                cookieSub.push(item.split("=")[1].trim());
            }
            });

            if ($.inArray("USID", cookieSub) !== -1 && cookieSub[1]!="") {
                window.location.href = SITEPATH+'menuListing.php';
            }
            $(document).on('click', '.go-registration', (e) => {

                $("#sign-in").find('input').val('');
                $('.sign-in-form-div').css('display', 'none');
                $('.sign-up-form-div').css('display', 'block');
            });
            $(document).on('click', '.go-signin', (e) => {
                $("#sign-up").find('input').val('');
                $('.sign-up-form-div').css('display', 'none');
                $('.sign-in-form-div').css('display', 'block');
            });
            
        },
        Registration: () => {
            $(document).on('click', ".reg-submit", function (e) {
                e.preventDefault();
                if ($('.name').val() == '') {
                    alert('Please enter name');
                    return false;
                } else if ($('.reg-username').val() == '') {
                    alert('Please enter username');
                    return false;
                } else if ($('.reg-password').val() != $('.confirmpassword').val()) {
                    alert('confrim password is not same as password');
                    return false;
                } else {

                    $.ajax({
                        url: SITEPATH + 'Controllers/activityStream.php',
                        type: "POST",
                        data: $('#sign-up').serialize() + '&action=signup',
                        dataType: "json",
                        success: function (data) {
                            if (data.status == 1) {
                                alert('registration success.Please login');
                                window.location.href = SITEPATH;
                            } else if (data.status == 0) {
                                alert('some error occured');
                            } else if (data.status == 2) {
                                alert('username already exist. pick another one');
                            }
                        }

                    });
                }
            });
            $(document).on('click', ".reg-cancel", function (e) {
                e.preventDefault();
                $("#sign-up").find('input').val('');

            });
            

        },
        Login: () => {
            $(document).on('click', ".login-submit", function (e) {
                e.preventDefault();

                $.ajax({
                    url: SITEPATH + 'Controllers/activityStream.php',
                    type: "POST",
                    data: $('#sign-in').serialize() + '&action=signin',
                    dataType: "json",
                    success: function (data) {
                        if (data.status == 1) {
                            alert('Login SUccess');
                            window.location.href = SITEPATH+'menuListing.php';
                        } else if (data.status == 2) {
                            alert('Login Error');
                        }
                    }
                });

            });
            $(document).on('click', ".login-cancel", function (e) {
                e.preventDefault();
                $("#sign-in").find('input').val('');

            });
        },
        LoadAllFunctions: () => {
            ActivityStream.Events();
            ActivityStream.Registration();
            ActivityStream.Login();

        }
    }
})(jQuery, this);



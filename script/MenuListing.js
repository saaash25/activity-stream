(function ($, window, undefined) {
    MenuListing = {
        MenuEvents: () => {
            $(document).on('click', ".logout", function (e) {
                var cookieSub = [];
                var cookieString = document.cookie.split(';');
                $.each(cookieString, function (i, item) {
                    if (item) {
                        cookieSub.push(item.split("=")[0].trim());
                        cookieSub.push(item.split("=")[1].trim());
                    }
                });
                
                    $.ajax({
                        url: SITEPATH + 'Controllers/activityStream.php',
                        type: "POST",
                        data: $('#sign-in').serialize() + '&action=logout&USID=' + cookieSub[1],
                        dataType: "json",
                        success: function (data) {
                            if (data.status == 1) {
                                alert('Logout SUccess');
                                document.cookie = "";
                                window.location.href = SITEPATH;
                            } else if (data.status == 2) {
                                alert('Login Error');
                            }
                        }
                    });
                

            });
        },
        LoadAllFunctions: () => {
            MenuListing.MenuEvents();
        }
    }

})(jQuery, this);
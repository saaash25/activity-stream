(function ($, window, undefined) {
    var checkdelay;
    MenuListing = {
        MenuEvents: () => {
            $(document).on('click', ".logout", function (e) {
                var USID = $(".logout").attr('usid');
                if(USID){
                $.ajax({
                    url: SITEPATH + 'Controllers/activityStream.php',
                    type: "POST",
                    data: 'USID=' + USID + '&action=logout',
                    dataType: "json",
                    success: function (data) {
                        if (data.status == 1) {
                            $(".logout").removeAttr('usid');
                            alert('Logout Success');
                            window.location.href = SITEPATH;
                        } else if (data.status == 2) {
                            alert('Login Error');
                        }
                    }
                });
            }else{
                 alert('Session Expired');
                 window.location.href = SITEPATH;
            }
            });
            $(document).on('mousemove', 'body', function (e) {
                clearTimeout(checkdelay);
                checkdelay = setTimeout(function () {
                    var USID = $(".logout").attr('usid');
                    $.ajax({
                        url: SITEPATH + 'Controllers/activityStream.php',
                        type: "POST",
                        data: 'USID=' + USID + '&action=checkLoginStatus',
                        dataType: "json",
                        success: function (data) {
                            if (data.status == 1) {

                            } else if (data.status == 2) {
                                $(".logout").removeAttr('usid');
                                alert('Session Expired');
                                window.location.href = SITEPATH;
                            }
                        }
                    });
                }, 500);
            });
        },
        LoadAllFunctions: () => {
            MenuListing.MenuEvents();
        }
    }

})(jQuery, this);
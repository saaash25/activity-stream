(function ($, window, undefined) {
    var checkdelay;
    MenuListing = {
        MenuEvents: () => {
            $(document).on('click', ".logout", function (e) {
                var USID = $(".logout").attr('usid');
                if (USID) {
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
                } else {
                    alert('Session Expired');
                    window.location.href = SITEPATH;
                }
            });
            $(".section-div").not('#activityListing').css('display', 'none');
            MenuListing.ActivityLogList();
            $(document).on('mousemove', 'body', function (e) {
                var USID = $(".logout").attr('usid');
                if (!USID) {
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
                }
            });
            $(document).on('click', '.nav-link', function (e) {
                e.preventDefault();
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
                $(".section-div").css('display', 'none');
                $($(this).attr('href')).css('display', 'block');
                if ($(this).attr('toSection') == 'activity') {
                    MenuListing.ActivityLogList();

                } else if ($(this).attr('toSection') == 'menu') {
                    MenuListing.MenuList();
                }
            });
            $(document).on('click', '.add-menu', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                $(this).prop('disable', true);
                var menu = $('.menu').val();
                var USID = $(".logout").attr('usid');
                if (menu) {
                    $.ajax({
                        url: SITEPATH + 'Controllers/activityStream.php',
                        type: "POST",
                        data: 'USID=' + USID + '&menu=' + menu + '&action=menuAdd',
                        dataType: "json",
                        success: function (data) {
                            $(this).prop('disable', false);
                            if (data.status == 1) {
                                alert('Menu Added!');
                                $('.cancel-menu').click();
                            } else if (data.status == 2) {
                                alert('Menu Adding Failed');
                            }
                        }
                    });
                }
            });
            $(document).on('click', '.cancel-menu', function () {
                $("#menu-add").find('input').val('');
            });

        },
        ActivityLogList: () => {
            var pagelength;
            pagelength = 10;
            var cookieString = document.cookie.split(';');
            var cookieSub = [];
            $.each(cookieString, function (i, item) {
                cookieSub.push(item.split("=")[0].trim());
                cookieSub.push(item.split("=")[1].trim());
            });

            if ($.inArray("actLength", cookieSub) !== -1) {
                var arrayIndex = cookieSub.indexOf("actLength") + 1;
                pagelength = cookieSub[arrayIndex];
            }
            var columnData = [];
            if ($('#menuListingTable').DataTable())
                $('#menuListingTable').DataTable().destroy();
            if ($('#activityListingTable').DataTable())
                $('#activityListingTable').DataTable().destroy();
            var USID = $(".logout").attr('usid');
            var urlParams = {action: 'activityListing', USID: USID};
            columnData.push(
                    {data: 'SLNO', "width": "5%", "class": "text-center align-middle"},
                    {data: 'AC_ActivityLog', "width": "70%", "class": "text-left align-middle text-break"},
                    {data: 'AddedDate', "width": "25%", "class": "text-center align-middle text-break"}
            );
            $('#activityListingTable').DataTable({
                "processing": true,
                "searching": false,
                "serverSide": true,
                "ordering": false,
                "autoWidth": false,
                "responsive": true,
                "pageLength": pagelength,
                "dom": 'lt<"bottom"rip><"clear">',
                "ajax": {
                    url: SITEPATH + 'Controllers/activityStream.php',
                    type: "post",
                    data: urlParams
                },
                "aoColumns": columnData
            });
        },
        MenuList: () => {
            var menuPageLength;
            menuPageLength = 10;
            var cookieString = document.cookie.split(';');
            var cookieSubMenu = [];
            $.each(cookieString, function (i, item) {
                cookieSubMenu.push(item.split("=")[0].trim());
                cookieSubMenu.push(item.split("=")[1].trim());
            });

            if ($.inArray("menuLength", cookieSubMenu) !== -1) {
                var arrayIndex = cookieSubMenu.indexOf("menuLength") + 1;
                menuPageLength = cookieSubMenu[arrayIndex];
            }
            var columnDataMenu = [];
            if ($('#activityListingTable').DataTable())
                $('#activityListingTable').DataTable().destroy();
            if ($('#menuListingTable').DataTable())
                $('#menuListingTable').DataTable().destroy();
            var USID = $(".logout").attr('usid');
            var urlParamsMenu = {action: 'menuListing', USID: USID};
            columnDataMenu.push(
                    {data: 'SLNO', "width": "5%", "class": "text-center align-middle"},
                    {data: 'MN_Name', "width": "70%", "class": "text-left align-middle text-break"},
                    {data: 'MN_Name', "width": "25%", "class": "text-center align-middle text-break"}
            );
            $('#menuListingTable').DataTable({
                "processing": true,
                "searching": false,
                "serverSide": true,
                "ordering": false,
                "autoWidth": false,
                "responsive": true,
                "pageLength": menuPageLength,
                "dom": 'lt<"bottom"rip><"clear">',
                "ajax": {
                    url: SITEPATH + 'Controllers/activityStream.php',
                    type: "POST",
                    data: urlParamsMenu
                },
                "aoColumns": columnDataMenu
            });
        },
        LoadAllFunctions: () => {
            MenuListing.MenuEvents();

        }
    }

})(jQuery, this);
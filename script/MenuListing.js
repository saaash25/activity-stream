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
            $(".update-menu").parent().css("display",'none');
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
                }else if ($(this).attr('toSection') == 'addMenu') {
                    $('.cancel-menu').click();
                    
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
                }else{
                    alert('menu name manadatory!')
                }
            });
            $(document).on('click', '.update-menu', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                $(this).prop('disable', true);
                var menu = $('.menu').val();
                var MNID = $('.menuid').val();
                var MNNAME = $(this).attr('MNNAME');
                var USID = $(".logout").attr('usid');
                if (menu) {
                    $.ajax({
                        url: SITEPATH + 'Controllers/activityStream.php',
                        type: "POST",
                        data: 'USID=' + USID + '&menu=' + menu +'&MNID=' + MNID + '&MN_Name=' + MNNAME + '&action=menuUpdate',
                        dataType: "json",
                        success: function (data) {
                            $(this).prop('disable', false);
                            if (data.status == 1) {
                                alert('Menu Updated!');
                                $('.cancel-menu').click();
                            } else if (data.status == 2) {
                                alert('Menu Updation Failed');
                            }
                        }
                    });
                }else{
                    alert('menu name manadatory!')
                }
            });
            $(document).on('click', '.cancel-menu', function () {
                $("#menu-add").find('input').val('');
                $(".update-menu").parent().css("display",'none');
                $(".add-menu").parent().css("display",'block');
            });
            $(document).on('click', '.menuEdit', function () {
                var MNID = $(this).attr('MNID');
                $.ajax({
                    url: SITEPATH + 'Controllers/activityStream.php',
                    type: "POST",
                    data: 'MNID=' + MNID + '&action=getMenuData',
                    dataType: "json",
                    success: function (data) {
                        console.log(data.data[0]);
                        if(data.data[0]){
                            $('.nav-link:eq(1)').click();
                            $(".update-menu").parent().css("display",'block');
                            $(".add-menu").parent().css("display",'none');
                            $(".menuid").val(data.data[0].MN_Id);
                            $(".menu").val(data.data[0].MN_Name);
                            $(".update-menu").attr('MNNAME',data.data[0].MN_Name)
                            
                        }

                    }
                });
            });
            $(document).on('click', '.menuDelete', function () {
                var MNID = $(this).attr('MNID');
                var MNNAME = $(this).attr('MNNAME');
                var USID = $(".logout").attr('usid');
                var deleteConfirm = confirm("Are You sure You want to delete!");
                if (deleteConfirm == true) {
                    $.ajax({
                        url: SITEPATH + 'Controllers/activityStream.php',
                        type: "POST",
                        data: 'USID=' + USID + '&MNID=' + MNID + '&MN_Name=' + MNNAME + '&action=menuDelete',
                        dataType: "json",
                        success: function (data) {
                            if (data.status == 1) {
                                alert('Menu Deleted Successfully!');
                                MenuListing.MenuList();
                            } else if (data.status == 2) {
                                alert('Deletion Error');
                            }
                        }
                    });
                }

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

            if ($('#menuListingTable').DataTable())
                $('#menuListingTable').DataTable().destroy();
            var USID = $(".logout").attr('usid');
            var urlParamsMenu = {action: 'menuListing', USID: USID};
            columnDataMenu.push(
                    {data: 'SLNO', "width": "5%", "class": "text-center align-middle"},
                    {data: 'MN_Name', "width": "80%", "class": "text-left align-middle text-break"},
                    {data: 'MN_Id', "width": "15%", "class": "text-center align-middle text-break",
                        render: function (data, type, row) {
                            return '<button class="float-left btn btn-sm btn-outline-success menuEdit"  MNID="' + row.MN_Id + '" MNNAME="' + row.MN_Name + '">Edit</button><button  class="float-right btn btn-sm btn-outline-danger menuDelete" MNID="' + row.MN_Id + '" MNNAME="' + row.MN_Name + '">Delete</button>'
                        }
                    }
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
                    type: "post",
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
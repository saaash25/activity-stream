<?php
require_once '_conf.php';
if (!isset($_COOKIE['usid'])) {
    header('location:' . SITEPATH);
}
?><html>
    <head>
        <meta charset="UTF-8">
        <title>Activity Stream</title>
        <!--<link rel="shortcut icon" href="<?= SITEPATH ?>assets/images/favicon.ico">-->
        <link rel="stylesheet" href="<?= SITEPATH ?>assets/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?= SITEPATH ?>style/style.css" />
        <link rel="stylesheet" href="<?= SITEPATH ?>assets/bootstrap/css/datatables.min.css" />
    </head>
    <body>
        <?php
        include(BASEPATH . 'includes/header.php');
        ?>
        <div class="container">
            <div class="row">
                <div class="col">

                </div>
            </div>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" toSection="activity" href="#activityListing">Activity List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#addMenu" >Add Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#listmenu" toSection="menu">Menu List</a>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-danger btn-sm logout" usid="<?= $_COOKIE['usid'] ? $_COOKIE['usid'] : '' ?>">Logout</button>
                </li>
            </ul>
            <div id="activityListing" class="section-div">
                <div class="row">
                    <div class="table-responsive col">
                        <table id="activityListingTable" class="table table-striped table-bordered display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" width="5%">#</th>
                                    <th scope="col" width="50%">Activity Log</th>
                                    <th scope="col" width="35%">Time</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="addMenu" class="section-div col-6">
                <form id="menu-add" action="#" method='POST' autocomplete="off">
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="menu">Menu</label>
                            <input  type="text" name="menu" class="form-control menu" id="menu"  placeholder="Enter Menu"/>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <button  type="submit" name="add-menu" class="btn btn-sm btn-success add-menu" id="add-menu" >Add Menu</button>
                            <button  type="button" name="cancel-menu" class="btn btn-sm btn-secondary cancel-menu" >Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="listmenu" class="section-div">
                <div class="row">
                    <div class="table-responsive">
                        <table id="menuListingTable col" class="table table-striped table-bordered display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" width="5%">#</th>
                                    <th scope="col" width="50%">Menu Name</th>
                                    <th scope="col" width="35%">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <script src="<?= SITEPATH ?>assets/jquery/jquery.min.js"></script>
        <script src="<?= SITEPATH ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?= SITEPATH ?>assets/bootstrap/js/datatables.min.js"></script>
        <script src="<?= SITEPATH ?>script/MenuListing.js"></script>
        <script>
            var BASEPATH = '<?php echo BASEPATH ?>';
            var SITEPATH = '<?php echo SITEPATH ?>';
            $(document).ready(function () {
                MenuListing.LoadAllFunctions();
            })
        </script>
    </body>
</html>
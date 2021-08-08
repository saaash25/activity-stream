<?php
require_once '_conf.php';
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
        include(BASEPATH . 'includes/header.php')
        ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-danger btn-sm logout">Logout</button>
                </div>
            </div>
            <div class="row">
            <div class="table-responsive">
                <table id="urlListingTable" class="table table-striped table-bordered display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">#</th>
                            <th scope="col" width="50%">Menu Name</th>
                            <th scope="col" width="35%">Edit</th>
                            <th scope="col" width="15%">Date</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
            </div>

        <script src="<?= SITEPATH ?>assets/jquery/jquery.min.js"></script>
        <script src="<?= SITEPATH ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?= BASEPATH ?>assets/bootstrap/js/datatables.min.js"></script>
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
<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['bbdmsdid']) == 0) {
    header('location:logout.php');
} else {
    $uid = $_SESSION['bbdmsdid'];
    ?>

    <!DOCTYPE html>
    <html lang="zxx">

    <head>
        <title>My Blood Requests | BBDMS</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
        <link rel="stylesheet" href="css/fontawesome-all.css">
        <link rel="stylesheet" href="css/jquery-ui.css" />
        <style>
            .status-badge {
                padding: 5px 10px;
                border-radius: 4px;
                color: white;
                font-size: 0.85rem;
                text-transform: uppercase;
            }

            .status-pending {
                background-color: #f0ad4e;
            }

            .status-approved {
                background-color: #5cb85c;
            }

            .status-rejected {
                background-color: #d9534f;
            }
        </style>
    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <div class="inner-banner-w3ls">
            <div class="container"></div>
        </div>

        <div class="breadcrumb-agile">
            <div aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Blood Requests</li>
                </ol>
            </div>
        </div>

        <div class="appointment py-5">
            <div class="py-xl-5 py-lg-3">
                <div class="w3ls-titles text-center mb-5">
                    <h3 class="title">My Blood Requests</h3>
                    <span><i class="fas fa-heartbeat"></i></span>
                </div>
                <div class="d-flex">
                    <div class="contact-right-w3l appoint-form" style="width:100%;">
                        <h5 class="title-w3 text-center mb-4">Your Request Details</h5>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Requirer Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Required For</th>
                                        <th>Message</th>
                                        <th>Apply Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT r.name, r.EmailId, r.ContactNumber, r.BloodRequirefor, r.Message, r.ApplyDate, r.status
										FROM tblbloodrequirer r
										WHERE r.BloodDonarID = :uid
										ORDER BY r.ApplyDate DESC";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':uid', $uid, PDO::PARAM_INT);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;

                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $row) {
                                            echo "<tr>";
                                            echo "<td>" . $cnt++ . "</td>";
                                            echo "<td>" . htmlentities($row->name) . "</td>";
                                            echo "<td>" . htmlentities($row->ContactNumber) . "</td>";
                                            echo "<td>" . htmlentities($row->EmailId) . "</td>";
                                            echo "<td>" . htmlentities($row->BloodRequirefor) . "</td>";
                                            echo "<td>" . htmlentities($row->Message) . "</td>";
                                            echo "<td>" . htmlentities($row->ApplyDate) . "</td>";
                                            $status = strtolower($row->status);
                                            echo "<td>";
                                            if ($status == 'approved') {
                                                echo "<span class='status-badge status-approved'>Approved</span>";
                                            } elseif ($status == 'rejected') {
                                                echo "<span class='status-badge status-rejected'>Rejected</span>";
                                            } else {
                                                echo "<span class='status-badge status-pending'>Pending</span>";
                                            }
                                            echo "</td></tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='8' class='text-center text-danger'>No Requests Found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="clerafix"></div>
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>

        <script src="js/jquery-2.2.3.min.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script>
            $(function () {
                $("#datepicker,#datepicker1").datepicker();
            });
        </script>
        <script src="js/SmoothScroll.min.js"></script>
        <script src="js/move-top.js"></script>
        <script src="js/easing.js"></script>
        <script src="js/medic.js"></script>
        <script src="js/bootstrap.js"></script>
    </body>

    </html>
<?php } ?>
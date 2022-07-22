<?php  
include "includes/check_login.php";
include "includes/database.php";
include "includes/users.php";

$database = new database();
$db = $database->connect();

$my_user = new user($db);
$my_user->n_user_id = $_SESSION['user_id'];
$my_user->read_single();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['update_user_profile'])) {

        if (!empty($_FILES['image_profile']['name'])) {
            $target_file = 'images/avatars/';
            $image_name = $_FILES['image_profile']['name'];
            move_uploaded_file($_FILES['image_profile']['tmp_name'], $target_file . $image_name);
        } else {
            $image_name = $_POST['old_image_profile'];    
        }

        $my_user->n_user_id = $_POST['user_id'];
        $my_user->v_fullname = $_POST['name'];
        $my_user->v_email = $_POST['email'];
        $my_user->v_username = $_POST['username'];
        $my_user->v_password = ($_POST['password'] == $_POST['old_password']) ? $_POST['old_password'] : md5($_POST['password']);
        $my_user->v_phone = $_POST['phone'];
        $my_user->v_image = $image_name;
        $my_user->v_message = $_POST['about'];

        if ($my_user->update()) {
            $flag = "Upload user profile successfully!";
        }

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Edit User Profile</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
    
    <!-- Include summernote css/js -->
    <link href="summernote/summernote.min.css" rel="stylesheet" />

</head>

<body class="animsition">
    <div class="page-wrapper">

        <?php include 'sidebar.php' ?>

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            
            <?php include 'header.php' ?>

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Edit User Profile</h2>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($flag)) { ?>
                        <div class="alert alert-primary" role="alert">
                            <?php echo $flag ?>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Edit User Profile</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <form role="form" method="POST" action="" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="title">Fullname</label>
                                                <input type="text" id="name" name="name" value="<?php echo $my_user->v_fullname; ?>" placeholder="Enter your fullname" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" id="email" name="email" value="<?php echo $my_user->v_email; ?>" placeholder="Enter email" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" id="username" name="username" value="<?php echo $my_user->v_username; ?>" placeholder="Enter username" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control">
                                                <input type="hidden" name="old_password" value="<?php echo $my_user->password; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="text" id="phone" name="phone" value="<?php echo $my_user->v_phone; ?>" placeholder="Enter your phone" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Image Profile</label>
                                                <br/>
                                                <input type="file" name="image_profile">
                                                <?php 
                                                    if ($my_user->v_image != '') {
                                                ?>
                                                <br/>
                                                <img src="images/upload/<?php echo $my_user->v_image; ?>" width="400px">
                                                <?php
                                                    }
                                                ?>
                                                <input type="hidden" name="old_image_profile" value="<?php echo $my_user->v_image; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>About me</label>
                                                <textarea class="form-control" id="summernote_profile" name="about"><?php echo htmlspecialchars_decode($my_user->v_message); ?></textarea>
                                            </div>
                                            <input type="hidden" name="user_id" value="<?php echo $my_user->n_user_id; ?>">
                                            <button type="submit" class="btn btn-warning" name="update_user_profile">Update User Profile</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include 'footer.php' ?>

                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

    <!-- Summernote Js -->
    <script src="summernote/summernote.min.js"></script>

    <script>
        $('#summernote_profile').summernote({
            placeholder: 'About me',
            height: '100',
        });
    </script>

</body>

</html>
<!-- end document-->

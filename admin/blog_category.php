<?php 
    include "includes/check_login.php";
    
    include 'includes/database.php';
    include 'includes/categories.php';
    include "includes/users.php";

    $database = new database();
    $db = $database->connect();
    $category = new category($db);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($_POST['form_name'] == 'add_category') {
            $title = $_POST['category_title'];
            $metaTitle = $_POST['category_meta_title'];
            $path = $_POST['category_path'];

            // Bind Params
            $category->v_category_title = $title;
            $category->v_category_meta_title = $metaTitle;
            $category->v_category_path = $path;
            $category->d_date_created = date('Y/m/d', time()); 
            $category->d_time_created = date('h:i:s', time());
            
            if ($category->create()) {
                $flag = "Create category successfully!";
            }

        }

        if ($_POST['form_name'] == 'edit_category') {
            $title = $_POST['category_title'];
            $metaTitle = $_POST['category_meta_title'];
            $path = $_POST['category_path'];
            $id = $_POST['category_id'];

            // Bind Params
            $category->n_category_id = $id;
            $category->v_category_title = $title;
            $category->v_category_meta_title = $metaTitle;
            $category->v_category_path = $path;
            $category->d_date_created = date('Y/m/d', time()); 
            $category->d_time_created = date('h:i:s', time());
            
            if ($category->update()) {
                $flag = "Edit category successfully!";
            }

        }

        if ($_POST['form_name'] == 'delete_category') {
            $id = $_POST['category_id'];

            // Bind Params
            $category->n_category_id = $id;
            if ($category->delete()) {
                $flag = "Delete category successfully!";
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
    <title>Blog Category</title>

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
                                    <h2 class="title-1">Blog Categories</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-25">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Add Category</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <form role="form" method="POST" action="">
                                            <div class="form-group">
                                                <label for="title" class="form-control-label">Title</label>
                                                <input type="text" id="title" name="category_title" placeholder="Enter title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_title" class="form-control-label">Meta Title</label>
                                                <input type="text" id="meta_title" name="category_meta_title" placeholder="Enter meta title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="path" class="form-control-label">Path</label>
                                                <input type="text" id="path" name="category_path" placeholder="Enter path" class="form-control">
                                            </div>
                                            <input type="hidden" name="form_name" value="add_category">
                                            <button type="submit" class="btn btn-primary">Add Category</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Meta Title</th>
                                                <th>Path</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $result = $category->read();
                                                $num = $result->rowCount();
                                                if ($num > 0){
                                                    while ($rows = $result->fetch()){
                                            ?>
                                            <tr>
                                                <td><?php echo $rows['n_category_id']; ?></td>
                                                <td><?php echo $rows['v_category_title']; ?></td>
                                                <td><?php echo $rows['v_category_meta_title']; ?></td>
                                                <td><?php echo $rows['v_category_path']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" onclick="location.href='../categories.php?id=<?php echo $rows['n_category_id']; ?>'">View</button>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit-category<?php echo $rows['n_category_id']; ?>">Edit</button>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#delete-category<?php echo $rows['n_category_id']; ?>">Delete</button>
                                                </td>
                                            </tr>
                                            <?php
                                                   }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END DATA TABLE-->
                            </div>
                        </div>
                        <?php include 'footer.php' ?>

                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->

            
            <?php
                $result = $category->read();
                $num = $result->rowCount();
                if ($num > 0){
                    while ($rows = $result->fetch()){
            ?>

			<div class="modal fade" id="edit-category<?php echo $rows['n_category_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="title" class="form-control-label">Title</label>
                                    <input type="text" id="title" name="category_title" placeholder="Enter title" class="form-control" value="<?php echo $rows['v_category_title']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="meta_title" class="form-control-label">Meta Title</label>
                                    <input type="text" id="meta_title" name="category_meta_title" placeholder="Enter meta title" class="form-control" value="<?php echo $rows['v_category_meta_title']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="path" class="form-control-label">Path</label>
                                    <input type="text" id="path" name="category_path" placeholder="Enter path" class="form-control" value="<?php echo $rows['v_category_path']; ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="form_name" value="edit_category">
                                <input type="hidden" name="category_id" value="<?php echo $rows['n_category_id']; ?>">
                                <button type="submit" class="btn btn-warning">OK</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>

            <div class="modal fade" id="delete-category<?php echo $rows['n_category_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
                    <form role="form" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Delete Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete category with title <b><?php echo $rows['v_category_title']; ?></b>?</p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="form_name" value="delete_category">
                                <input type="hidden" name="category_id" value="<?php echo $rows['n_category_id']; ?>">
                                <button type="submit" class="btn btn-danger">Yes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>

            <?php
                    }
                }
            ?>


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

</body>

</html>
<!-- end document-->

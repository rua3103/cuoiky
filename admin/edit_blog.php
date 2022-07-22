<?php  
include "includes/check_login.php";
include "includes/database.php";
include "includes/categories.php";
include "includes/blogs.php";
include "includes/tags.php";
include "includes/users.php";

$database = new database();
$db = $database->connect();
$new_blog = new blog($db);

if(isset($_GET['id'])){
    
    $new_blog->n_blog_post_id = $_GET['id'];
    $new_blog->read_single();
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
    <title>Edit Blog</title>

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
                                    <h2 class="title-1">Edit Blog</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Edit Blog</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <form role="form" method="POST" action="blogs.php" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" id="title" name="title" value="<?php echo $new_blog->v_post_title; ?>" placeholder="Enter title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_title">Meta Title</label>
                                                <input type="text" id="meta_title" name="meta_title" value="<?php echo $new_blog->v_post_meta_title; ?>" placeholder="Enter meta title" class="form-control">
                                            </div>
                                            <?php
                                                $cate = new Category($db);
                                                $result = $cate->read();
                                            ?>
                                            <div class="form-group">
                                                <label>Blog Category</label>
                                                <select class="form-control" name="select_category">
                                                    <?php while ($rs = $result->fetch()): ?>
                                                    <option value="<?php echo $rs['n_category_id']; ?>" <?php echo $rs['n_category_id'] == $new_blog->n_category_id ? 'selected' : ''; ?>><?php echo $rs['v_category_title']; ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Main Image</label>
                                                <br/>
                                                <input type="file" name="main_image">
                                                <?php 
                                                    if ($new_blog->v_main_image_url != ''):
                                                ?>
                                                <br/>
                                                <img src="images/upload/<?php echo $new_blog->v_main_image_url; ?>" width="400px">
                                                <?php
                                                    endif;
                                                ?>
                                                <input type="hidden" name="old_main_image" value="<?php echo $new_blog->v_main_image_url; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Alt Image</label>
                                                <br/>
                                                <input type="file" name="alt_image">
                                                <?php 
                                                    if ($new_blog->v_alt_image_url != ''):
                                                ?>
                                                <br/>
                                                <img src="images/upload/<?php echo $new_blog->v_alt_image_url; ?>" width="400px">
                                                <?php
                                                    endif;
                                                ?>
                                                <input type="hidden" name="old_alt_image" value="<?php echo $new_blog->v_alt_image_url; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Summary</label>
                                                <textarea class="form-control" id="summernote_summary" name="blog_summary"><?php echo htmlspecialchars_decode($new_blog->v_post_summary); ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Blog Content</label>
                                                <textarea class="form-control" id="summernote_content" name="blog_content"><?php echo htmlspecialchars_decode($new_blog->v_post_content); ?></textarea>
                                            </div>
                                            <?php
                                                $tag = new Tag($db);
                                                $tag->n_blog_post_id = $new_blog->n_blog_post_id;
                                                $tag->read_single();
                                            ?>
                                            <div class="form-group">
                                                <label>Blog Tags</label>
                                                <input class="form-control" name="blog_tags" value="<?php echo $tag->v_tag; ?>" placeholder="Enter meta title">
                                            </div>
                                            <div class="form-group">
                                                <label>Blog Path</label>
                                                <input class="form-control" name="blog_path" value="<?php echo $new_blog->v_post_path; ?>" placeholder="Enter meta title">
                                            </div>
                                            <div class="form-group">
                                                <label>Home Page Placement</label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="opt_place" id="optionsRadiosInline1" value="1" <?php echo $new_blog->n_home_page_place == 1 ? 'checked' : '' ?>>1
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="opt_place" id="optionsRadiosInline2" value="2" <?php echo $new_blog->n_home_page_place == 2 ? 'checked' : '' ?>>2
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="opt_place" id="optionsRadiosInline3" value="3" <?php echo $new_blog->n_home_page_place == 3 ? 'checked' : '' ?>>3
                                                </label>
                                            </div>
                                            <input type="hidden" name="blog_id" value="<?php echo $new_blog->n_blog_post_id; ?>">
                                            <input type="hidden" name="date_created" value="<?php echo $new_blog->d_date_created; ?>">
                                            <input type="hidden" name="time_created" value="<?php echo $new_blog->d_time_created; ?>">
                                            <input type="hidden" name="post_view" value="<?php echo $new_blog->n_blog_post_views; ?>">
                                            <input type="hidden" name="status" value="<?php echo $new_blog->f_post_status; ?>">
                                            <button type="submit" class="btn btn-warning" name="update_blog">Update Blog</button>
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
        $('#summernote_summary').summernote({
            placeholder: 'Blog summary',
            height: '100',
        });
        $('#summernote_content').summernote({
            placeholder: 'Blog content',
            height: '200',
        });
    </script>

</body>

</html>
<!-- end document-->

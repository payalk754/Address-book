<?php
require_once('./includes/functions.inc.php');
$id = $_GET['id'];
$query = "SELECT  * FROM contacts WHERE id=$id";
$row = db_select($query);
// dd($row);
$contact = $row[0];
$error_flag = false;

if (isset($_POST['action'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $birthdate = myDate($_POST['birthdate']);
    $telephone = $_POST['telephone'];
    $address = $_POST['address'];
    $image_name = $contact['image_name'];
    

    //file handling
    if (!empty($_FILES['pic'])) {
        $file_name = $_FILES['pic']['name'];
        //extraction the extension
        $data = explode('.', $file_name);
        $ext = strtolower(end($data));
        $first_name_lower = strtolower($first_name);
        $last_name_lower = strtolower($last_name);
        $image_name = "$id.$ext";
        $source = $_FILES['pic']['tmp_name'];
        $destination = "./images/users/$image_name";
        unlink("images/users/$contact[image_name]");
        move_uploaded_file($source, $destination);
    }
    
    if(! $error_flag)
    {
        // $image_name = $first_name . "_" . $last_name . ".jpg";
        $query = "UPDATE contacts SET first_name='$first_name',last_name='$last_name',email='$email',birthdate='$birthdate',telephone='$telephone',address='$address',image_name='$image_name'WHERE id = '$id'";
        $result = db_query($query);
        if (!$result) {
            $error_flag = true;
            $error_msg = "Something went wrong with Database!";
        } else {
            //header('Location:index.php?op=add&status=sucess');
            redirect("index.php?op=edit&status=success");
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

    <!--Import Csutom CSS-->
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Edit Contact</title>
</head>

<body>
    <!--NAVIGATION BAR-->
    <nav>
        <div class="nav-wrapper">
            <!-- Dropdown Structure -->
            <ul id="dropdown1" class="dropdown-content">
                <li><a href="#!">Profile</a></li>
                <li><a href="#!">Signout</a></li>
            </ul>
            <nav>
                <div class="nav-wrapper">
                    <a href="#!" class="brand-logo center">Contact Info</a>
                    <ul class="right hide-on-med-and-down">

                        <!-- Dropdown Trigger -->
                        <li><a class="dropdown-trigger" href="#!" data-target="dropdown1"><i class="material-icons right">more_vert</i></a></li>
                    </ul>
                </div>
            </nav>
            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
    </nav>
    <!--/NAVIGATION BAR-->
    <div class="container">
        <div class="row mt50">
            <h2>Edit Contact</h2>
        </div>
        <?php
        if ($error_flag):
        ?>
            <div class="row">
                <div class="materialert error">
                    <div class="material-icons">error_outline</div>
                    <?= $error_msg; ?>
                    <button type="button" class="close-alert"></button>
                </div>
            </div>
            <?php
            endif;
            ?>
            
            <div class="row">
                <form class="col s12 formValidate" action="" id="edit-contact-form" method="POST" enctype="multipart/form-data">
                    <div class="row mb10">
                        <div class="input-field col s6">
                            <input id="first_name" name="first_name" type="text" class="validate" data-error=".first_name_error" value="<?=getOldValue($_POST,'first_name',$contact['first_name'])?>">
                            <label for="first_name">First Name</label>
                            <div class="first_name_error " ></div>
                        </div>
                        <div class="input-field col s6">
                            <input id="last_name" name="last_name" type="text" class="validate" data-error=".last_name_error" value="<?=getOldValue($_POST,'last_name',$contact['last_name'])?>">
                            <label for="last_name">Last Name</label>
                            <div class="last_name_error " ></div>
                        </div>
                    </div>
                    <div class="row mb10">
                        <div class="input-field col s6">
                            <input id="email" name="email" type="email" class="validate" data-error=".email_error" value="<?= getOldValue($_POST,'email',$contact['email']);?>">
                            <label for="email">Email</label>
                            <div class="email_error "></div>
                        </div>
                        <div class="input-field col s6">
                            <input id="birthdate" name="birthdate" type="text" class="datepicker" data-error=".birthday_error" value="<?= getOldValue($_POST,'birthdate',$contact['birthdate']) ;?>">
                            <label for="birthdate">Birthdate</label>
                            <div class="birthday_error " ></div>
                        </div>
                    </div>
                    <div class="row mb10">
                        <div class="input-field col s12">
                            <input id="telephone" name="telephone" type="tel" class="validate" data-error=".telephone_error" value="<?= getOldValue($_POST,'telephone',$contact['telephone']); ?>">
                            <label for="telephone">Telephone</label>
                            <div class="telephone_error "></div>
                        </div>
                    </div>
                    
                    <div class="row mb10">
                        <div class="input-field col s12">
                            <textarea id="address" name="address" class="materialize-textarea" data-error=".address_error" ><?= getOldValue($_POST,'address',$contact['address']); ?></textarea>
                            <label for="address">Address</label>
                            <div class="address_error "value=""></div>
                        </div>
                    </div>
                    <div class="row mb10">
                        <div class="col s2">
                            <img id="tmp_image" src="images/users/<?=$contact['image_name'];?>" alt="" width="100%">
                        </div> 
                        <div class="file-field input-field col s9">
                            <div class="btn">
                                <span>Image</span>
                                <input type="file" name="pic" id="pic" data-error=".pic_error">
                            </div>

                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Upload Your Image">
                            </div>
                            <div class="pic_error "></div>
                        </div>
                    </div>
                    <button class="btn waves-effect waves-light right" type="submit" name="action">Submit
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
    </div>
    <footer class="page-footer p0">
        <div class="footer-copyright ">
            <div class="container">
                <p class="center-align">©  Payal Kukreja</p>
            </div>
        </div>
    </footer>
    <!--JQuery Library-->
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--JQuery Validation Plugin-->
    <script src="vendors/jquery-validation/validation.min.js" type="text/javascript"></script>
    <script src="vendors/jquery-validation/additional-methods.min.js" type="text/javascript"></script>
    <!--Include Page Level Scripts-->
    <script src="js/pages/edit-contact.js"></script>
    <!--Custom JS-->
    <script src="js/custom.js" type="text/javascript"></script>
</body>

</html>
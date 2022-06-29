<?php
require "./includes/functions.inc.php";
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
                        <li><a class="dropdown-trigger" href="#!" data-target="dropdown1"><i
                                    class="material-icons right">more_vert</i></a></li>
                    </ul>
                </div>
            </nav>
            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
    </nav>
    <!--/NAVIGATION BAR-->

    <!-- Add a New Contact Link-->
    <div class="row mt50">
        <div class="col s12 right-align">
            <a class="btn waves-effect waves-light blue lighten-2" href="add-contact.php"><i
                    class="material-icons left">add</i> Add
                New</a>
        </div>
    </div>
    
    <!-- /Add a New Contact Link-->

    <!-- Table of Contacts -->
    <div class="row">
        <div class="col s12">
            <table class="highlight centered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email ID</th>
                        <th>Date Of Birth</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $page = 1;
                    if(isset($_GET['page']))
                    {
                        $page = $_GET['page'];
                    }
                    $num_of_records_per_page = 5;
                    $start = ($page-1) * $num_of_records_per_page;
                    $query = "SELECT count(*) as total_records FROM contacts";
                    $row = db_select($query);
                    $total_records = $row[0]['total_records'];
                    $total_pages = ceil($total_records/$num_of_records_per_page);

                    $prev_page_num = $page == 1 ? $page:$page-1;
                    $next_page_num = $page == $total_pages ? $total_pages:$page+1;

                    $query = "SELECT * FROM contacts LIMIT $start, $num_of_records_per_page";
                    $rows = db_select($query);
                    if($rows !== false):
                        foreach($rows as $row):
                    ?>
                    <tr>
                        <td>
                            <img class="circle" src="images/users/<?= $row['image_name'];?>" alt="" height="100px" width="100px"> </td>
                        <td><?=$row['first_name']. " " . $row['last_name']; ?></td>
                        <td><?=$row['email']?></td>
                        <td><?=$row['birthdate']?></td>
                        <td><?=$row['telephone']?></td>
                        <td><?=$row['address']?></td>
                        <td><a class="btn btn-floating green lighten-2"  href = "edit-contact.php?id=<?=$row['id'];?>"><i class="material-icons">edit</i></a></td>
                        <td><a class="btn btn-floating red lighten-2 modal-trigger delete-contact" href="#deleteModal" data-id="<?=$row['id'];?>"><i class="material-icons">delete_forever</i></a>
                        </td>
                    </tr>
                <?php
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /Table of Contacts -->
    <!-- Pagination -->
    <div class="row">
        <div class="col s12">
            <ul class="pagination">
                <li class="<?=$page==1 ? 'disabled' : 'waves-effect';?>">
                    <a href="?page=<?=$prev_page_num;?>">
                        <i class="material-icons">chevron_left</i>
                    </a>
                </li>
                <?php
                for($i = 1; $i<=$total_pages;$i++):
                ?>
                    <li class="<?=$i==$page ? 'active' : 'waves-effect';?>"><a href="?page=<?=$i;?>"><?=$i;?></a></li>

                <?php
                endfor;
                ?>
                <li class="<?= $page==$total_pages ?'disabled ': 'waves-effect';?>"><a href="?page=<?=$next_page_num;?>"><i class="material-icons">chevron_right</i></a></li>
                
            </ul>
        </div>
    </div>
    <!-- /Pagination -->
    <!-- Footer -->
    <footer class="page-footer p0">
        <div class="footer-copyright ">
            <div class="container">
                <p class="center-align">© Payal Kukreja</p>
            </div>
        </div>
    </footer>
    <!-- /Footer -->
    <!-- Delete Modal Structure -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h4>Delete Contact?</h4>
            <p>Are you sure you want to delete the record?</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close btn blue-grey lighten-2 waves-effect">Cancel</a>
            <a href="delete-contact.php" id="deleteModalAgreeButton" class="modal-close btn waves-effect red lighten-2">Agree</a>
        </div>
    </div>
    <!-- /Delete Modal Structure -->
    <!--JQuery Library-->
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--Include Page Level Scripts-->
    <script src="js/pages/home.js"></script>
    <!--Custom JS-->
    <script src="js/custom.js" type="text/javascript"></script>
    <script>
            // <?php
            // $op = "";
            // $status = "";
            // if(isset($_GET['op']))
            // {
            //     $op = $_GET['op'];
            // }
            // if(isset($_GET['status']))
            // {
            //     $status = $_GET['status'];
            // }
            // if($op === 'add' && $status === 'success')
            // {
            // ?>
            // M.toast({
            //     html: 'contact addedd successfully',
            //     classes: 'green darken-1'
            // });
            // <?php
            // }
            // ?>
        </script>
</body>

</html>

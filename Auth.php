<?php
require_once './Source/Database/Connection.php';
require_once './Source/Controller/Session.php';
require_once './Source/Controller/Redirect.php';
?>
<?php
if (isset($_POST['Register'])) {
    $Fullname = $_POST['Firstname'];
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    $db = new Connection();
    $SPassword = password_hash($Password, PASSWORD_BCRYPT);
    $db->register($Fullname, $Username, $Email, $SPassword);
}

if (isset($_POST['Login'])) {
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $db = new Connection();
    $db->Login($Email, $Password);
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>ToDoList</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col">
                    <?php
                    echo SuccessMessage();
                    echo ErrorMessage();
                    ?>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <!-- LOGIN FORM SIDE  -->
                    <div class="jumbotron">
                        <!-- IMAGE OF THE WEBSITE -->
                        <img src="" class="rounded mx-auto d-block" alt="LOGO" style="width: 100px;">
                        <!-- tITLE  -->
                        <h5>Welcome Back To Our Plateform </h5>
                        <hr>
                        <!-- ********************** -->
                        <!-- THE MAIN FORM -->
                        <!-- ********************** -->
                        <form action="Auth.php" method="post">
                            <!-- EMAIL -->
                            <div class="form-group">
                                <label for="Email"><i class="fa fa-envelope"></i> Email address</label>
                                <input type="email" class="form-control" id="Email" aria-describedby="emailHelp" placeholder="Enter email" name="Email" required>
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            <!-- PASSWORD -->
                            <div class="form-group">
                                <label for="Password"><i class="fa fa-lock"></i> Password</label>
                                <input type="password" class="form-control" id="Password" placeholder="Password" name="Password" required>
                            </div>
                            <!-- REMEMBER ME -->
                            <!--                            <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck1" name="customCheck1">
                                                            <label class="custom-control-label" for="customCheck1">Remember me</label>
                                                        </div>-->
                            <!-- BUTTON -->
                            <button type="submit" class="btn btn-outline-primary btn-sm mt-3" name="Login"> <i class="fa fa-sign-in-alt"></i> Sign IN</button>
                        </form>
                    </div>
                    <a href="index.php"><i class="fa fa-arrow-left"></i> Back To The Home Page</a>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="jumbotron">
                        <img src="..." class="rounded mx-auto d-block" alt="LOGO" style="width: 100px;">
                        <h5> Build Your Account </h5>
                        <hr>
                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-sign-out-alt"></i> Sign Up</button>

                        <div class="icons mt-5">
                            <h6>Follow Us :</h6>
                            <a href="#"> <i class="fa fa-facebook"></i></a>
                            <a href="#"> <i class="fa fa-twitter"></i></a>
                            <a href="#"> <i class="fa fa-instagram"></i></a>
                        </div>

                        <!-- Modal -->
                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-xl">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">


                                        <h6 class="modal-title"> Build Your Account </h6> <span><button type="button" class="close" data-dismiss="modal">&times;</button></span>
                                    </div>
                                    <div class="modal-body">
                                        <form action="Auth.php" method="post">

                                            <div class="form-row">
                                                <!-- Firstname -->
                                                <div class="col">
                                                    <label for="Firstname">FullName</label>
                                                    <input type="text" class="form-control" placeholder="First name" id="Firstname" name="Firstname" required>
                                                </div>
                                                <!--Username-->
                                                <div class="col">
                                                    <label for="Username">Username</label>
                                                    <input type="text" class="form-control" placeholder="Username" id="Username" name="Username" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <!-- Email -->
                                                    <div class="form-group">
                                                        <label for="Email"> Email address</label>
                                                        <input type="email" class="form-control" id="Email" aria-describedby="emailHelp" placeholder="Enter email" name="Email" required>
                                                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="Password">Password</label>
                                                        <input type="password" class="form-control" id="Password" name="Password" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Button -->
                                            <button type="submit" class="btn btn-outline-primary mt-5" name="Register">REGISTER</button>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>








        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="https://kit.fontawesome.com/1b86f0e672.js" crossorigin="anonymous"></script>
    </body>

</html>

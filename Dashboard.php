<?php
require_once './Source/Controller/Redirect.php';
require_once './Source/Controller/Session.php';
require_once './Source/Database/Connection.php';

confirmLogin();

if (isset($_POST['AddTask'])) {
    $ID = $_GET['id'];
    $TName = $_POST['TName'];
    date_default_timezone_set('Africa/Casablanca');
    $currentTime = time();
    $dateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
    if (empty($TName)) {
        $_SESSION['ErrorMessage'] = 'Name Task Required';
    } else {
//        code here
        $db = new Connection();
        $db->addTask($TName, $dateTime, $ID);
        
    }
}


if (isset($_POST['newTDL'])) {
    date_default_timezone_set('Africa/Casablanca');
    $currentTime = time();
    $dateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
    $CreatedBy = $_SESSION['Email'];
    $Name = $_POST['Name'];
    $Color = $_POST['Color'];

    if (empty($Name)) {
        $_SESSION["ErrorMessage"] = "Name Required";
        redirectTo("Dashboard.php");
    } elseif (empty($Color)) {
        $_SESSION["ErrorMessage"] = "Color Required";
        redirectTo("Dashboard.php");
    } else {
//        add function
        $db = new Connection();
        $db->addTDL($Name, $Color, $dateTime, $CreatedBy);
    }
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>ToDoList Demo</title>
        <link rel="stylesheet" href="https://bootswatch.com/4/united/bootstrap.min.css">
    </head>
    <body>




        <div class="container">

            <div class="row">
                <div class="col">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="#">Navbar</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <?php if ($_SESSION['Userid']) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link " href="logout.php" tabindex="-1" aria-disabled="true">Logout</a>
                                    </li>
                                <?php } else { ?>
                                    <li class="nav-item">
                                        <a class="nav-link " href="Auth.php" tabindex="-1" aria-disabled="true">Authentication</a>
                                    </li>
                                <?php } ?>


                            </ul>

                        </div>
                    </nav>
                </div>  
            </div>        
        </div>


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
                <div class="col">
                    <div class="jumbotron">
                        <h1 class="display-4">Hello, <?php echo $_SESSION['Email']; ?>!</h1>
                        <hr class="my-4">
                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            TODOLIST +
                        </a>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <form method="post" action="Dashboard.php">
                                    <div class="form-group">
                                        <label for="Name">Name</label>
                                        <input type="text" class="form-control" id="Name" name="Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="Color">SELECT COLOR</label>
                                        <input type="color" class="form-control" id="Color"name="Color" required="">
                                    </div>

                                    <button type="submit" class="btn btn-primary" name="newTDL"> + </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>




        <div class="container">
            <div class="row">
                <div class="col-3">
                    <?php
                    $db = new Connection();
                    $rows = $db->getTDL();

                    foreach ($rows as $item) {
                        $idtdl = $item['idtdl'];
//                        echo $idtdl;
                        ?>


                        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <strong class="mr-auto"><?php echo $item['name']; ?></strong>
                                <small><?php echo $item['date']; ?></small>

                                <a href="delete.php?id=<?php echo $idtdl; ?>"> <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button></a>


                            </div>
                            <div class="toast-body" style="background-color:<?php echo $item['color']; ?> ">
                                <?php echo $item['createdby']; ?>



                                <!-- Content -->
                                <!-- get list tasks-->

                                <?php
                                $db = new Connection();
                                $row = $db->getTasks($idtdl);

                                foreach ($row as $i) { ?>
                                    <!-- get list tasks-->
                                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="toast-header">
                                        <strong class="mr-auto"><?php echo $i['name']; ?></strong>
                                        <small><?php echo $i['date'];?></small>
                                        <a href="deleteTask.php?id=<?php echo $i['idtask'];?>"> <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </a>
                                    </div>
                                    <div class="toast-body">
                                        Hello, world! This is a toast message.
                                    </div>
                                </div>

                                <!-- end get list tasks-->
                               <?php }
                                ?>
                                


                                <!-- ADD NEW TASK-->
                                <!-- TASKS -->
                                <a class="btn btn-primary" data-toggle="collapse" href="#TDL<?php echo htmlentities($idtdl); ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    Task +
                                </a>
                                <div class="collapse" id="TDL<?php echo htmlentities($idtdl); ?>">
                                    <div class="card card-body">
                                        <!-- Formulaire pour l'ajoute -->
                                        <form method="post" action="Dashboard.php?id=<?php echo htmlentities($idtdl); ?>">
                                            <div class="form-group">
                                                <label class="col-form-label" for="TName">Task Name</label>
                                                <input type="text" class="form-control" placeholder="Default input" id="TName" name="TName">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm" name="AddTask">+</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- END TASKS -->

                            </div>
                        </div>







                    </div>
                <?php } ?>

            </div>
        </div>
    </div>







    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>

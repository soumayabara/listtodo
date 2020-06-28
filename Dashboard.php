<?php
require_once './Source/Controller/Redirect.php';
require_once './Source/Controller/Session.php';
require_once './Source/Database/Connection.php';

confirmLogin();




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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/sketchy/bootstrap.min.css">
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

                        <div class="card-body">
                            <div class="card-header"><?php echo $item['name']; ?></div>
                            <h4 class="card-title"><?php echo $item['color']; ?></h4>
                            <p class="card-text"><?php echo $item['date']; ?>.</p>
                            <h5><?php echo $item['createdby']; ?></h5>
                            <a href="delete.php?id=<?php echo $idtdl; ?>">delete</a>
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

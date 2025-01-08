<?php
$insert = false;
$update = false;
$delete = false;

$server = "localhost";
$username = "root";
$password = "";
$dbname = "notes";

$conn  = mysqli_connect($server, $username, $password, $dbname);

if (!$conn) {
    die("Sorry connect faild" . mysqli_connect_error());
}


if (isset($_GET['delete'])) {
    $slno = $_GET['delete'];


    $delete = true;
    $sql = "DELETE FROM `notestable` WHERE `slno` = $slno";
    $result = mysqli_query($conn, $sql);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['slnoEdit'])) {
        $slno = $_POST["slnoEdit"];
        $title = $_POST['titleEdit'];
        $description = $_POST['descriptionEdit'];

        $sql = "UPDATE `notestable` SET `title` = '$title' , `description` = '$description' WHERE `notestable` . `slno` = '$slno' ";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $update = true;
        } else {
            echo "We could not update the record successfully";
        }
    } else {

        $title = $_POST['title'];
        $description = $_POST['description'];

        $sql = "INSERT INTO `notestable`(`title`,`description`) VALUES ('$title','$description')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // echo "record insert successfully";
            $insert = true;
        } else {
            echo "the record not insert successfully";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.8/datatables.min.js"></script>
    <title>PHP-CURD</title>

</head>

<body>

    <!-- =========Button trigger modal============ -->
    <!-- <button type="button" class="btn btn-primary edit" data-bs-toggle="modal" data-bs-target="#EditModalLabel">
        Edit modal
    </button> -->

    <!-- Modal -->
    <div class="modal fade" id="EditModalLabel" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="EditModalLabel">Update Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- from -->
                    <form class="p-5" action="CURD-oparations.php" method="post">
                        <input type="hidden" name="slnoEdit" id="slnoEdit">
                        <h2 class=""> Edits Note</h2>
                        <div class="mb-3 my-4">
                            <label for="exampleInputEmail1" class="form-label">Note Title</label>
                            <input type="text" class="form-control" name="titleEdit" id="titleEdit" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Note Description</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                        </div>

                        <button type="submitEdit" class="btn btn-primary">Update notes</button>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- ==============Notes============== -->

    <nav class="navbar navbar-expand-lg bg-warning">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PHP CURD nots</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>

                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" id="mybtn" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- =======Notifications======= -->
    <?php
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your nots has been inseted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

    <?php
    if ($update) {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>Your note has been updated successfully</strong> 
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'></span>
        </button>
         </div>";
    }

    ?>
    <?php

    if ($delete) {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
         <strong>Your notes has been deleted successfully</strong> 
         <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'></span>
         </button>
         </div>";
    }
    ?>

    <!-- ==================================================================== -->
    <form class="p-5" action="CURD-oparations.php" method="post">
        <h2> Add Note</h2>
        <div class="mb-3 my-4">
            <label for="exampleInputEmail1" class="form-label">Note Title</label>
            <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Note Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <!-- ============================ start php ======================================================= -->
    <div class="container">

        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.no</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $sql = "SELECT * FROM `notestable`";
                $result = mysqli_query($conn, $sql);
                $numofrow = mysqli_num_rows($result);
                $slno = 0;

                for ($i = 0; $i < $numofrow; $i++) {
                    $slno = $slno + 1;
                    $row = mysqli_fetch_assoc($result);
                    echo "
                     <tr>
                         <th scope='row'>" . $slno . "</th>
                        <td>" . $row['title'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td><button class='btn btn-success edit' id=" . $row['slno'] . ">Edit</button> <button class='btn btn-danger delete' id=" . $row['slno'] . ">Delete</button> </td>
                    </tr>";
                }


                ?>


            </tbody>
        </table>



    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script defer>
        let table = new DataTable('#myTable');
    </script>

    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, description);
                titleEdit.value = title;
                descriptionEdit.value = description;
                slnoEdit.value = e.target.id;
                console.log(e.target.id)
                $('#EditModalLabel').modal('toggle');
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {

            element.addEventListener("click", (e) => {
                console.log("edit ", );
                slno = e.target.id.substr(0, );

                if (confirm("Are you sure you want to Delete!")) {
                    console.log("Yes");
                    window.location = `/learn_php/CURD-oparations.php?delete=${slno}`;
                    // /crud/index.php?delete=${sno}
                    
                } else {
                    console.log("no");
                }
                
            })
        })
    </script>
</body>

</html>
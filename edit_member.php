<?php
$servername="localhost";
$username="root";
$password="1234567";
$database="php_dev_udari";
//create connection
$connection=new mysqli($servername, $username, $password, $database);

$id="";
$firstname="";
$lastname="";
$summary="";
$dsdivision="";
$dateofbirth="";

$errorMessage="";
$successMessage="";

if($_SERVER['REQUEST_METHOD']=='GET'){
    //get method: show the data of the client
    if(!isset($_GET["id"])){
        header("location: /udari/index.php");
        exit;
    }

    $id=$_GET["id"];

    //read the row of the selected client from database table
    $sql="SELECT * FROM members WHERE id=$id";
    $result=$connection->query($sql);

    $row= $result -> fetch_assoc();

    if(!$row){
        header("location:/myshop/index.php");
        exit;
    }
    
    $firstname=$row["firstname"];
    $lastname=$row["lastname"];
    $summary=$row["summary"];
    $dsdivision=$row["dsdivision"];
    $dateofbirth=$row["dateofbirth"];

}
else{
//POST method:update the data of the client
    $id=$_POST["id"];
    $firstname=$_POST["firstname"];
    $lastname=$_POST["lastname"];
    $summary=$_POST["summary"];
    $dsdivision=$_POST["dsdivision"];
    $dateofbirth=$_POST["dateofbirth"];

do{
    if(empty($firstname)||empty($lastname)||empty($summary)||empty($dsdivision)||empty($dateofbirth)){
        $errorMessage="All the field are reuired";
        break;
    }

 
    $sql= "UPDATE members SET firstname='$firstname', lastname='$lastname', summary='$summary', dsdivision='$dsdivision', dateofbirth='$dateofbirth' WHERE id=$id";

    $result=$connection->query($sql);

    if(!$result){
        $errorMessage="Invalid query: ".$connection->error;
        break;
    }

    $successMessage="Client updated correclty. ";

    header("location:/udari/index.php");
    exit;

}while(true);
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IF=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"
        <title><h1 style="text-align:center; color:powderblue;"> <?php echo str_repeat('&nbsp;', 5);?>Accura Company</h1></title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>    
    </head>
    <body style="background-image: url('image.svg'); background-repeat: no-repeat;background-size: cover;">
        <div class="container my-5">
        <h2>Edit Accura Member </h2>
        <?php 
        if(!empty($errorMessage)){
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            ";
        }
        ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="firstname" value="<?php echo $firstname; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>">
                </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Summary</label>
                <div class="col-sm-6">
                <textarea type="text" class="form-control" rows="4" name="summary" id="<?php echo $summary; ?>" placeholder="<?php echo $summary; ?>"><?php echo $summary; ?></textarea>
                </div>
            </div>
            
            <div class="row mb-3">  
                <label class="col-sm-3 col-form-label" for="dsdivision">DS Division</label>
                <div class="col-sm-6">
                    <select class="col-sm-12 form-control" name="dsdivision" id="dsdivision">
	                <option value=""><?php echo $dsdivision; ?></option>
	                <option value="Colombo 1">Colombo 1</option>
	                <option value="Colombo 2">Colombo 2</option>
	                <option value="Colombo 3">Colombo 3</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Date of Birth</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="dateofbirth" value="<?php echo $dateofbirth; ?>">
                </div>
            </div>

            <?php
            if(!empty($successMessage)){
                echo "
                <div class='row mb-3'>
                <div class='offset-sm-3 col-sm-6'>
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>$successMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                </div>
                </div>
                ";
            }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                 
                    <button type="submit" class="btn btn-primary">Submit</button>
                   
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/udari/index.php" role="button">Cancel</a>
                </div>
            </div>

        </form>
        </div>

    </body>
</html>
<?php 
$search='';
;?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IF=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"
    <title><h1 style="text-align:center; color:powderblue;"> <?php echo str_repeat('&nbsp;', 5);?>Accura Company</h1></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="jquery-3.6.3.min.js"></script>
    <script src="sweetalert2.all.min.js"></script>
    
    </head>

    <body style="background-image: url('image.svg'); background-repeat: no-repeat;background-size: cover;">
        <div class="container my-5" >
            <h2> List of Members</h2>
            <br>
            <div class="row">
            <div class="search col">
                <form action="index.php" method="get">
                    <p>
                        <input class="form-control" type="text" name="search" id="" placeholder="Search By Last Name" value="<?php echo $search; ?>">  
                    </p>
                </form>
            </div>
            <div class="col">
            <a class="btn btn-outline-info" href="index.php" role="button">Refresh</a>
            </div>
            <div class="col">
                <a class="btn btn-primary" href="/udari/create_member.php" role="button">New Member</a>
                </div>
            </div>

            <br>
            <table class="table">
                <thead>
                    <tr>
                       
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of Birth</th>
                        <th>DS Division</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $servername="localhost";
                    $username="root";
                    $password="1234567";
                    $database="php_dev_udari";
                    //create connection
                    $connection=new mysqli($servername, $username, $password, $database);

                    //check connection
                    if($connection->connect_error){
                        die("Connection failed: ".$connection->connect_error);
                    }

                    $search='';
                    if(isset($_GET['search'])){
                        $search=mysqli_real_escape_string($connection, $_GET['search']);
                        $sql="SELECT * FROM members WHERE (lastname LIKE '%{$search}%') ORDER BY firstname ";
                    }else{
                    //read all row from database table
                    $sql="SELECT *FROM members ORDER BY firstname";
                    }

                  
                    $result=$connection->query($sql);

                    if(!$result){
                        die("Invalid query: ".$connection->error);
                    }

                    //read data of each row
                    while($row = $result->fetch_assoc()){
                        echo "
                    <tr>
                       
                        <td>$row[firstname]</td>
                        <td>$row[lastname] $row[summary]</td>
                        <td>$row[dateofbirth]</td>
                        <td>$row[dsdivision]</td>
                        
                        <td>
                            <a class='btn btn-primary btn-sm' href='/udari/edit_member.php?id=$row[id]'>Edit</a>
                            <a href='/udari/delete_member.php?id=$row[id]' class='delete-btn btn btn-danger btn-sm'>Detele</a>
                        </td>
                    </tr>
                        ";
                    }
                    ?>

                    
                </tbody>
            </table>
          
            <?php if (isset($_GET['m'])):?>
                <div class="flash-data" data-flashdata="<?=$_GET['m']; ?>"></div>
            <?php endif; ?>
            <script>
                $('.delete-btn').on('click',function(e){
                    e.preventDefault();
                    const href=$(this).attr('href')

                 Swal.fire({
                 type:'warning',
                 title:'Are You Sure?',
                 text:'Record will be deleted?',
                 showCancelButton:true,
                 confirmButtonColor:'#3085d6',
                 cancelButtonColor:'#d33',
                 confirmButtonText:'Delete Record',
                }).then((result)=>{
                    if(result.value){
                        document.location.href=href;
                    }
                })
            })

         

             const flashdata=$('.flash-data').data('flashdata')
             if(flashdata){
                Swal.fire({
                 type:'success',
                 title:'Succcess',
                 text:'Record has been deleted!'
                })
             }

            </script>
        </div>

    </body>
</html>



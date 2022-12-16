<?php
if(isset($_GET['date'])){
    $date = $_GET['date'];
}
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email =$_POST['email'];
    $mysqli = new mysqli('localhost','root','','bookingcalendar');
    $stmt = $mysqli->prepare("INSERT INTO bookings (name,timeslot,email,date)VALUES(?,?,?,?)");
    $stmt->bind_param('ssss',$name,$timeslot,$email,$date);
    $stmt->execute();
    $msg="<div class'alert alert-success'>Booking Successfull</div>";
    $stmt->close();
    $mysqli->close(); 
}

$duration = 30;
$cleanup = 5;
$start = "09:00";
$end = "15:00";

function timeslots($duration, $cleanup, $start, $end){
$start = new DateTime($start);
$end = new DateTime($end);
$interval = new DateInterval("PT".$duration."M");
$cleanupInterval = new DateInterval("PT".$cleanup."M");
$slots = array();

for($intStart = $start; $intStart<$end; $intStart->add($interval)->add($cleanupInterval)){
    $endPeriod = clone $intStart;
    $endPeriod->add($interval);
    if($endPeriod>$end){
        break;
    }
    $slots[]=$intStart->format("H:iA")."-".$endPeriod->format("H:iA");
}
return $slots;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="description" content="SEO info">
     <!-- fonts -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative&family=Nanum+Gothic&family=Petit+Formal+Script&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="icon" type="image/x-icon" href="assets/branding/favicon.ico">
    <link rel="stylesheet" href="assets/workings/style.css">
    <title>Yfke</title>
</head>
<body>
    <header>
        <h2 class="center">Booking Form</h2>
    </header>
    <main>
       <div class="container">
            <h4 class="h4-header">Book for Date: 
            <?php echo date('d-m-Y',strtotime($date)); 
            ?></h4>
            <div class="row">
            <!-- <div class="col-md-6 col-md-offset-3">
            <?php echo isset($msg)?$msg:";" ?>
                <form action="" method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form> -->
            <?php 
                $timeslots = timeslots($duration, $cleanup, $start, $end);
                foreach($timeslots as $ts){
            ?>
           
                <!-- <div class="col-md-2">
                    <div class="form-group">
                        <button class="btn btn-success book">
                        <!-- data-timeslot="
            <?php echo $ts; ?>" -->
            
            <?php echo $ts; ?>
                        </button>
                    </div>
                </div>
            <?php } ?>
            </div> -->
        </div>



        <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
         <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Booking: <span id="slot"></span>
        </h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form action="post">
                <div class="form-group">
                    <label for="">Timeslot</label>
                    <input required type="text" readonly name="timeslot" id="timeslot" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Name</label>
                    <input required type="text" readonly name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input required type="email" readonly name="email" class="form-control">
                </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    </main>
    <footer>
        <p>&copy;
            <img src="./assets/branding/simple-fav-small.jpg" alt="Yfkes logo" style="width: 70px">
            <script src="./assets/workings/script.js"></script>
            <script>
                $(".book").click(function(){
                    var timeslot = $(this).attr('data-timeslot');
                $("#slot").html(timeslot);
                $("#timeslot").val(timeslot);
                $("myModal").modal("show");
                })
            </script>
        </p>
    </footer>
</body>
</html>
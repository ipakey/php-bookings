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
$end = "14:30";

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
    <main>
        <div class="container">
        <div class="col-form-container ">
        <h2 class="text-center">Book for Date: <?php echo date('d/m/Y',strtotime($date)); ?></h2><hr>
        <?php $timeslots = timeslots($duration, $cleanup, $start,$end);
        foreach($timeslots as $ts){
        ?>
        <div class="col-md-2">
            <button class="btn btn-success book" data-target="modalBkTs" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?>
            </button>
        </div>

        <?php }  ?>

        </div>
    </main>

    <!-- The Modal -->
<div class="modal fade" role="dialog" id="modalBkTs">
  <div class="modal-dialog">
   
  <!-- Modal Content -->
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Bookings: <span id="slot"></span> </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Timeslot</label> 
                        <input required type="text" readonly name="timeslot" id='timeslot' class="form-group">
                    </div> 
                    <div class="form-group">
                        <label for="">Name</label> 
                        <input required type="text" name="name" id='name' class="form-group">
                    </div> 
                    <div class="form-group">
                        <label for="">Email</label> 
                        <input required type="text" name="email" id='email' class="form-group">
                    </div> 
                </form>
            </div>
        </div> 
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script>
    $appendTo('.book').click(function(){
    var timeslots = $(this).attr('data-timeslot');
    $("#slot").html(timeslots);
    $("#timeslot").val(timeslots);
    $("#modalBkTs").modal("show");
    });

</script> 

    <footer>
        <p>&copy;
            <img src="./assets/branding/simple-fav-small.jpg" alt="Yfkes logo" style="width: 70px">
            <script src="./assets/workings/script.js"></script>
        </p>
    </footer>
</body>
</html>
<?php
function build_calendar($month,$year){
    //create array for days of week
    $daysOfWeek = array('Monday','Tuesday','Wednesday','Thusday','Friday','Saturday','Sunday');
    //get the month information from argument
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
    $numberDays = date('t',$firstDayOfMonth);
    $dateComponenets = getdate($firstDayOfMonth);
    $monthName = $dateComponenets['month'];
    $dayOfWeek = $dateComponenets['wday'];
    $dateToday = date('Y-m-d');
    $calendar = "<table class='table table-bordered'>";
    $calendar.= "<center><h2 class='header'>$monthName $year</h2></center>";
    $calendar.= "<tr>";

    foreach($daysOfWeek as $day){
        $calendar.="<th class='day-header'>$day</th>";
    }; 

    // !  semi colon after a for loop ????

    $calendar.="</th><tr>";

if($dayOfWeek >0){
    for($k=0;$k<$dayOfWeek;$k++){
        $calendar.="<td></td>";
    }
}

$currentDay = 1;
$month=str_pad($month,2,"0",STR_PAD_LEFT);

while($currentDay <= $numberDays){

    // if seventh col (Saturday) reached start a new row
    if($dayOfWeek == 7){
        $dayOfWeek = 0;
        $calendar.="</tr><tr>";
    }

    $currentDayRel = str_pad($currentDay,2,"0",STR_PAD_LEFT);
    $date = "$year-$month-$currentDayRel";
   
    if($dateToday==$date){
        $calendar.="<td class='today'><h4>$currentDay</h4>";
       

    }else{
        $calendar.="<td><h4>$currentDay</h4>";
    }
    $calendar.="</td>";

    //  increment the counters
    $currentDay++;
    $dayOfWeek++;
}

// complete the row of the last week of the month if necessary

if($dayOfWeek != 7){
    $remainingDays = 7-$dayOfWeek;
    for($i=0;$i<$remainingDays;$i++){
        $calendar.="<td></td>";
    }
}

$calendar.="</tr>";
$calendar.="</table>";

echo $calendar;
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
    <link rel="stylesheet" href="assets/workings/style.css">
    

    <title>Yfke</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php   
                $dateComponenets = getdate();
                $month = $dateComponenets['mon'];
                $year = $dateComponenets['year'];
                echo build_calendar($month, $year);
            ?>
        </div>
    </div>
</div>
    <footer>
        <p>&copy;
            <img src="./assets/branding/simple-fav-small.jpg" alt="Yfkes logo" style="width: 70px">
            <script src="./assets/workings/script.js"></script>
        </p>
    </footer>
</body>
</html>
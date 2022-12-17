<?php
function build_calendar($month,$year){
    $mysqli = new mysqli('localhost','root','','bookingcalendar');
    // $stmt = $mysqli->prepare("select * from bookings where MONTH(date)=? AND YEAR(date)=?");
    // $stmt->bind_param('ss',$month,$year);
    // $bookings = array();
    // if($stmt->execute()){
    //     $result = $stmt->get_result();
    //     if($result->num_rows>0){
    //         while($row = $result->fetch_assoc()){
    //             $bookings[] = $row['date'];
    
    //         }
    //         $stmt->close();
    //     }
    // }

    //create array for days of week
    $daysOfWeek = array('Monday','Tuesday','Wednesday','Thusday','Friday','Saturday','Sunday');
    //get the month information from argument
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
    $numberDays = date('t',$firstDayOfMonth);
    $dateComponenets = getdate($firstDayOfMonth);
    $monthName = $dateComponenets['month'];
    $dayOfWeek = $dateComponenets['wday'];
    $dateToday = date('Y-m-d');

    $prev_month = date('m',mktime(0,0,0,$month-1,1,$year));
    $prev_year = date('Y',mktime(0,0,0,$month-1,1,$year));
    $next_month = date('m',mktime(0,0,0,$month+1,1,$year));
    $next_year = date('Y',mktime(0,0,0,$month+1,1,$year));
    
    // Calendar Headings
    $calendar = "<center><h2 class='header'>$monthName $year</h2>";
    $calendar.= "<a class='btn btn-primary btn-xs' href='?month=".$prev_month."&year=".$prev_year."'>Prev Month</a>";
    $calendar.=" <a class='btn btn-xs btn-primary' href='?month=".date('m')."&year=".date('Y')."'>Current Month</a> ";

// Calendar Table
    $calendar.= "<a class='btn btn-primary btn-xs' href='?month=".$next_month."&year=".$next_year."'>Next Month</a></center>";
    $calendar.="</br><table class='table'>";
    $calendar.= "<tr>";

    foreach($daysOfWeek as $day){
        $calendar.="<th class='day-header'>$day</th>";
    }; 

    $calendar.="</tr><tr>";
    $currentDay = 1;

if($dayOfWeek >0){
    for($k=0;$k<$dayOfWeek;$k++){
        $calendar.="<td class='empty'></td>";
    }
}

$month=str_pad($month,2,"0",STR_PAD_LEFT);
while($currentDay <= $numberDays){

    // if seventh col (Saturday) reached start a new row
    if($dayOfWeek == 7){
        $dayOfWeek = 0;
        $calendar.="</tr><tr>";
    }

    $currentDayRel = str_pad($currentDay,2,"0",STR_PAD_LEFT);
    $date = "$year-$month-$currentDayRel";

    $dayName = strtolower(date('l',strtotime($date)));
    // $eventNum=0;

    $today=$date==date('Y-m-d')?'today':'';
    if($date<date('Y-m-d')){
        $calendar.="<td class='past'><h4>$currentDayRel </h4><a class='btn btn-optionGone btn-xs'>N/a</a>";
    }else{
        $calendar.="<td class='$today'><h4>$currentDayRel</h4>
        <a href='book.php?date=".$date."' class='btn btn-success btn-xs'>Book</a></td>";
    }

    //  increment the counters
    $currentDay++;
    $dayOfWeek++;

   
    $calendar.="</td>";
}

// complete the row of the last week of the month if necessary

if($dayOfWeek < 7){
    $remainingDays = 7-$dayOfWeek;
    for($i=0;$i<$remainingDays;$i++){
        $calendar.="<td class='empty'></td>";
    }
}

$calendar.="</tr>";
$calendar.="</table>";

return $calendar;
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
    <title>Yfke Diary</title>
</head>
<body>

            <?php   
                $dateComponenets = getdate();
                if(isset($_GET['month']) && isset($_GET['year'])){
                    $month = $_GET['month'];
                    $year = $_GET['year'];
                    
                }
                else{
                $month = $dateComponenets['mon'];
                $year = $dateComponenets['year'];
               
                }
                echo build_calendar($month, $year);
            ?>
        </div>
    </div>
</div>
    <footer>
        <p>&copy;
            <img class="footer" src="./assets/branding/simple-fav-small.jpg" alt="Yfkes logo" style="width: 70px">
            <script src="./assets/workings/script.js"></script>
        </p>
    </footer>
</body>
</html>
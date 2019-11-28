<?php 

// Function to get all the dates in given range 
function getDatesFromRange($start, $end, $format = 'Y-m-d') { 
    
    // Declare an empty array 
    $array = array(); 
    $string='';
    
    // Variable that store the date interval 
    // of period 1 day 
    $interval = new DateInterval('P1D'); 

    $realEnd = new DateTime($end); 
    $realEnd->add($interval); 

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 

    // Use loop to store date into array 
    foreach($period as $date) {              
        $array[] = $date->format($format); 
        $string .='("'.$date->format($format).'") ,';
    } 
    echo $string;die();
    // Return the array elements 
    //return $array; 
} 

// Function call with passing the start date and end date 
$Date = getDatesFromRange('2019-01-01', '2019-12-31'); 

var_dump($Date); 

?> 
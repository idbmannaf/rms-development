<?php

use Carbon\Carbon;
use App\Models\Holiday;

function getSecondToHours($seconds, $format = '%02d:%02d:%02d')
{
    if ($seconds < 1) {
        return '00:00:00';
    }
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $remainingSeconds = $seconds % 60; // Calculate the remaining seconds
//    $timeFormatted = gmdate('H:i:s', mktime(0, 0, $remainingSeconds, 0, 0, 0));
    return sprintf($format, $hours, $minutes,$remainingSeconds);

}

    function calculateBMSCurrentForDhamrai2($current){
        
        if($current == 'n')
        {
            return $current;
        }
        
            $decimal = $current;
            // 653.22
            $strlen= explode('.',$current);
            
            $decimal = str_replace('.', '', $decimal);
            
            // dump(strlen($rr[0]));
            //        return $decimal;
            // $hexNumber = dechex($decimal);
            if(strlen($strlen[0])>2){
                // Step 1: Determine the binary representation of the decimal number
                $binary = decbin(abs($decimal));
    
                // Step 2: If the decimal number is negative, convert its absolute value to binary
                $binary = ($decimal < 0) ? $binary : $binary;
    
                // Step 3: Pad the binary number with leading zeros to the desired length
                $desiredLength = 8; // Desired length of the binary number
                $binary = str_pad($binary, $desiredLength, '0', STR_PAD_LEFT);
    
                // Step 4: Invert all the bits of the binary number
                $invertedBinary = strtr($binary, '01', '10');
    
                // Step 5: Add 1 to the inverted binary number
                $twosComplementBinary = bindec($invertedBinary) + 1;
    
                // Step 6: Determine the sign of the decimal number
                $sign = ($binary[0] === '1') ? -1 : 1;
    
                // Step 7: Convert the binary number to its decimal representation, considering its sign
                $twosComplementDecimal = $sign * $twosComplementBinary;
                return $twosComplementDecimal / 100;
            }else{
                return $current;
            }
    }


function diffTime($date1, $date2){
    $date1 = new DateTime($date1);
    $date2 = new DateTime($date2);

    $diff = $date2->diff($date1);

    $hours = $diff->h + ($diff->days * 24);
    $minutes = $diff->i;
    $seconds = $diff->s;
    return $hours .":". $minutes . ":". $seconds;

}

/**
 * Return sizes readable by humans
 */
function human_filesize($bytes, $decimals = 2)
{
  $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
  $factor = floor((strlen($bytes) - 1) / 3);

  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .
      @$size[$factor];
}


function haversine($lat, $lng)
{
    return "(6371 * acos(cos(radians(" . $lat . "))
    * cos(radians(`lat`))
    * cos(radians(`lng`)
    - radians(" . $lng . "))
    + sin(radians(" . $lat . "))
    * sin(radians(`lat`))))";
}

/**
 * Is the mime type an image
 */
function is_image($mimeType)
{
    return starts_with($mimeType, 'image/');
}

// function human_time()
// {
//     $time = ['seconds', 'minutes', 'hours', 'days', 'months', 'years'];
//     $factor = floor()
// }

function custom_slug($text)
{
    $date = date('ynjGis');
    $string = str_slug($text);
    $rand = strtolower(str_random(8));
    $string = substr($string, 0,100);
    return $date.'-'.$rand.'-'.$string;
}

function custom_name($text, $limit)
{
  if(strlen($text) > $limit)
  {
      return str_pad(substr($text, 0, ($limit - 2)), ($limit +1),'.');
  }
  else
  {
    return $text;
  }

}
function activityLogCreate($details, $logable_id = null,$logable_type = null)
{
    request()->user()->logCreate($details,$logable_id,$logable_type);
    return true;
}

function custom_title($text, $limit)
{
  if(strlen($text) > $limit)
  {
      return substr($text, 0, $limit);
  }
  else
  {
    return $text;
  }

}


function menuSubmenu($menu, $submenu)
{
  $request = request();
  $request->session()->forget(['lsbm','lsbsm']);
  $request->session()->put(['lsbm'=>$menu,'lsbsm'=>$submenu]);
  return true;
}


function bdMobile($mobile)
{
    $number = trim($mobile);
    $c_code = '880';
    $cc_count = strlen($c_code);

    if(substr($number, 0, 2) == '00')
    {
        $number = ltrim($number, '0');
    }
    if(substr($number, 0, 1) == '0')
    {
        $number = ltrim($number, '0');
    }
    if(substr($number, 0, 1) == '+')
    {
        $number = ltrim($number, '+');
    }
    if(substr($number, 0, $cc_count) == $c_code)
    {
        $number = substr($number, $cc_count);
    }
    if(substr($c_code, -1) == 0)
    {
        $number = ltrim($number, '0');
    }
    $finalNumber = $c_code.$number;

    return $finalNumber;
}


function intMobile($cc,$mobile)
{
    $number = trim($mobile);
    $c_code = $cc;
    $cc_count = strlen($c_code);

    if(substr($number, 0, 2) == '00')
    {
        $number = ltrim($number, '0');
    }
    if(substr($number, 0, 1) == '0')
    {
        $number = ltrim($number, '0');
    }
    if(substr($number, 0, 1) == '+')
    {
        $number = ltrim($number, '+');
    }
    if(substr($number, 0, $cc_count) == $c_code)
    {
        $number = substr($number, $cc_count);
    }
    if(substr($c_code, -1) == 0)
    {
        $number = ltrim($number, '0');
    }
    $finalNumber = $c_code.$number;

    return $finalNumber;
}
function timestamToTimeDiffarece($star_date, $end_date)
{

    $start =  Carbon::create($star_date);
    $end =  Carbon::create($end_date);
    $minutes = $end->diffInMinutes($start, true);
    $hours = floor($minutes / 60);
    $min = $minutes - ($hours * 60);

    $hourMunite = $hours . "h " . $min . "m ";
    return $hourMunite;
}
function timeDuration($star_time, $end_time)
{

    $start =  Carbon::create($star_time);
    $end =  Carbon::create($end_time);
    $minutes = $end->diffInMinutes($start, true);
    $hours = floor($minutes / 60);
    $min = $minutes - ($hours * 60);

    $hourMunite = $hours.'.'.$min;
    return $hourMunite;
}

//----timeformat---
/*
$logged_in_t = explode(' ',$empTodayAttendance->logged_in_at);
$logged_in_time = date('H:i', strtotime($logged_in_t[1]));
$in_time=date('g:i a', strtotime($logged_in_time));

$logged_out_t = explode(' ',$empTodayAttendance->logged_out_at);
$logged_out_time = date('H:i', strtotime($logged_out_t[1]));
$out_time=date('g:i a', strtotime($logged_out_time));

$start = Carbon::parse($empTodayAttendance->logged_in_at);
$end = Carbon::parse($empTodayAttendance->logged_out_at);
$duration = $start->diff($end)->format('%H:%I:%S');
*/
//--------

function timeFormat($time){
    $getTime = explode(' ', $time);
    $timeFormat=date('g:i a', strtotime($getTime[1]));
    return $timeFormat;

}
function IsHoliday($date , $compId){
//    dd($date);
//dump(Holiday::where(['company_id'=>$compId,'date'=>$date])->first());
    return (bool) Holiday::where(['date'=>$date, 'company_id'=> $compId])->first();
}
function IsTodayLeave($empId){
    return (bool) \App\Models\LeaveItem::where(['employee_id'=>$empId,'date'=>date('Y-m-d')])->first();
}
function IsHolidayAndSaturday($date , $compId){
    if(Holiday::where(['date'=>$date, 'company_id'=> $compId])->first()){
       if(strtolower(date("l", strtotime($date)))=="saturday"){
           return true;
       }
       else{
           return false;
       }
    }else{
        return false;
    }

}
function IsHolidayAndSaturdayChecked($date , $compId){
    return (bool) Holiday::where(['date'=>$date, 'company_id'=> $compId,'home_office'=>1])->first();

}


    //for custom package
    //https://github.com/gocanto/gocanto-pkg
    //https://laravel.com/docs/5.2/packages
    //http://stackoverflow.com/questions/19133020/using-models-on-packages
    //http://kaltencoder.com/2015/07/laravel-5-package-creation-tutorial-part-1/
    //http://laravel-recipes.com/recipes/50/creating-a-helpers-file

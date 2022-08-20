<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//For member status.
if ( ! function_exists('memberStatus')) {
    function memberStatus($key = null)
    {
        $array = [1=>'Active', 2=>'Dead', 3=>'Stuck off'];
        if ($key) {
            return $array[$key];
        }
        return $array;
    }
}

//For member status.
if ( ! function_exists('bankNames')) {
    function bankNames($key = null)
    {
        $array = [1=>'Sonali', 2=>'AB'];
        if ($key) {
            return $array[$key];
        }
        return $array;
    }
}

//For month period.
if ( ! function_exists('monthPeriod')) {
    function monthPeriod($key = null)
    {
        $array = [3, 6, 9, 12];
        return $array;
    }
}

//For month period.
if ( ! function_exists('benevolentFund')) {
    function benevolentFund($fundStatus, $fundDate)
    {
        if ($fundStatus==1) {
            $fundDate = date('Ymd', strtotime($fundDate));
            $diff = date('Ymd') - $fundDate;
            $year = substr($diff, 0, -4);
            $month = substr($diff, 2, -2);
            $period =  $year.'.'.$month;
            if ($period<=10) {
                return 1500;
            } elseif ($period>10 && $period<=20) {
                return 1550;
            } elseif ($period>20 && $period<=25) {
                return 1650;
            } elseif ($period>25 && $period<=30) {
                return 1725;
            } elseif ($period>30) {
                return 1850;
            }
        } else {
            return '';
        }
    }
}

//Get a list of months names between two dates
if ( ! function_exists('monthsBetweenDates')) {
    function monthsBetweenDates($dateStart, $dateFinish)
    {
        $startDate = new DateTime($dateStart);
        $endDate = new DateTime($dateFinish);

        $dateInterval = new DateInterval('P1M');
        $datePeriod   = new DatePeriod($startDate, $dateInterval, $endDate);

        $month = [];
        foreach ($datePeriod as $date) {
            $month[] = $date->format('m');
        }
        return $month;
    }
}

//For year...
if ( ! function_exists('yearArr')) {
    function yearArr()
    {
        $array = [];
        for ($i = (date('Y')+1); $i > 2016; $i--) {
            $array[] = $i;
        }
        return $array;
    }
}

//For month array...
if ( ! function_exists('monthArr')) {
    function monthArr($key = null)
    {
        $array = ['01'=>'January', '02'=>'February', '03'=>'March', '04'=>'April', '05'=>'May', '06'=>'June', '07'=>'July', '08'=>'August', '09'=>'September', '10'=>'October', '11'=>'November', '12'=>'December'];
        if ($key) {
            return $array[$key];
        }
        return $array;
    }
}

//For month show...
/*if ( ! function_exists('month')) {
    function month($date)
    {
        return date('F-Y', strtotime($date));
    }
}*/

//For account role array.
if ( ! function_exists('accountRole')) {
    function accountRole($key = null)
    {
        $array = [ '2'=>'Administrator', '3'=>'Accounts', '4'=>'Receipt'];
        if ($key) {
            return $array[$key];
        }
        return $array;
    }
}

//Showing Amount 2 digit format.
if ( ! function_exists('numberFormat')) {
    function numberFormat($amount, $coma=null)
    {
        $amount = ($amount=='')?0:$amount;
        if ($coma) {
            if ($amount==0) {
                return '-';
            }
            return number_format($amount, 2);
        } else {
            return number_format($amount, 2, '.', '');
        }        
    }
}

//Showing Amount 2 digit format.
if ( ! function_exists('intFormat')) {
    function intFormat($amount)
    {
        if ($amount>0) {
            return number_format($amount, 0);
        }
        return '';
    }
}

if ( ! function_exists('dateFormat')) {
    function dateFormat($date)
    {
        if ($date>0) {
            return date('d/M/Y', strtotime($date));
        }
    }
}

if ( ! function_exists('dumpvar')) {
    function dumpvar($array)
    {
        echo '<pre>';
        print_r($array);
    }
}

//For directory create if directory not exists.
if ( ! function_exists('makedir')) {
    function makedir($path)
    {
        if (!is_dir($path)) {
            if (mkdir($path,0755,TRUE)) {
                return true;
            } else {
                echo 'Path not created!';
                exit;
            }
        }
    }
}

//Search string get and set an url
if ( ! function_exists('qString')) {
    function qString($query=null)
    {
        if ($_SERVER['QUERY_STRING']) {
            return '?'.$_SERVER['QUERY_STRING'].$query;
        } else {
            if ($query!='') {
                return '?'.$query;
            }            
        }
    }
}
//Default Text: (If Data not Found)
if ( ! function_exists('notFoundText')) {
    function notFoundText($text=null)
    {
        $text = ($text)?$text:'Data Not Found.';
        return '<div class="row">
          <div class="col-md-12 text-center"><strong><h3>'.$text.'</h3></strong></div>
        </div>';
    }
}

if ( ! function_exists('viewImg')) {
    function viewImg($path, $name, $property=null )
    {
        $path = UPLOADS.$path;
        if ($name!= '' && file_exists(FCPATH.$path.'/'.$name)) {
            $path = base_url($path).'/';
            return '<img src="'.$path.$name.'" '.$property.'>';
        } else {
            return '';
        }
    }
}

if ( ! function_exists('viewFile')) {
    function viewFile($path, $name)
    {
        $path = UPLOADS.$path;
        if ($name!= '' && file_exists(FCPATH.$path.'/'.$name)) {
            $path = base_url($path).'/';
            return '<a href="'.$path.$name.'" target="_blank">'.$name.'</a>';
        } else {
            return '';
        }
    }
}

//For image view if image exists.
if ( ! function_exists('convertNumber')) {
    function convertNumber($number) {
        if (($number < 0) || ($number > 999999999)) {
            throw new Exception("Number is out of range");
        }
        $Gn = floor($number / 1000000);
        /* Millions (giga) */
        $number -= $Gn * 1000000;
        $kn = floor($number / 1000);
        /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100);
        /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10);
        /* Tens (deca) */
        $n = $number % 10;
        /* Ones */
        $res = "";
        if ($Gn) {
            $res .= convertNumber($Gn) .  "Million";
        }
        if ($kn) {
            $res .= (empty($res) ? "" : " ") .convertNumber($kn) . " Thousand";
        }
        if ($Hn) {
            $res .= (empty($res) ? "" : " ") .convertNumber($Hn) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= " and ";
            }
            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            } else {
                $res .= $tens[$Dn];
                if ($n) {
                    $res .= "-" . $ones[$n];
                }
            }
        }
        if (empty($res)) {
            $res = "zero";
        }
        return $res;
    }
}
?>
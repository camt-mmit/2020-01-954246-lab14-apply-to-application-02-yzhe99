<?php 
/*ID: 612110264
Name: Zhe Yin  */
require_once "vendor/autoload.php";

$converter = new CurrencyConverter\CurrencyConverter;

$input = $_SERVER['argv'];
$optind = NULL;
$shortopts  = "ht::s:";
$longopts  = array('help','step:','to::');
$opts = getopt($shortopts, $longopts,$optind );
$args = array_slice($_SERVER['argv'], $optind); 
$type = "C";
$convertTHB = $converter->convert('THB', 'CNY');
$step = 1;
$checkerr=0;

if(array_key_exists('help', $opts) || array_key_exists('h', $opts))
{
    echo "\nUsage: ".$input[0]." [options] [--] [start] [end]\n";
    echo "Options:\n   -s|--step=increasing  specific increasing value.\n";
    echo "\t\t\t if not specified increase by 1.\n";
    echo "   -t|--to=currency   \t convert to currency, case-insensitive:\n";
    echo "\t\t\t CNY for Chinese Yuan.\n\t\t\t USD for United States dollar.\n\t\t\t EUR for Euro.\n";
    echo "\t\t\t if not specified convert to Chinese Yuan.\n";
    echo "   -h|--help\t\t print this manual.\n";
    echo "Arguments:\n";
    echo "   start\t\t specific starting.\n";
    echo "   end\t\t\t specific maximum (show value <= end).\n";
    echo "\t\t\t invalid if start > end.\n";
}

if(array_key_exists('step', $opts) || array_key_exists('s', $opts))
{
    if(!isset($opts['step']))
    {
        $opts['step'] = $opts['s']; 
    }
    else
    {
        $opts['s'] = $opts['step']; 
    }
    if(is_numeric($opts['s']))
    {
        $step=$opts['s'];
    }
    else
    {
        $checkerr++;
    }
}

if(array_key_exists('to', $opts) || array_key_exists('t', $opts))
{

    if(!isset($opts['to']))
    {
        $opts['to'] = $opts['t']; 
    }
    else
    {
        $opts['t'] = $opts['to']; 
    }
    if(strtoupper($opts['t'])=='CNY')
    {
        $convertTHB = $converter->convert('THB', 'CNY');
        $type="C";
    }
    elseif(strtoupper($opts['t'])=='USD')
    {
        $convertTHB = $converter->convert('THB', 'USD');
        $type="U";
    }
    elseif(strtoupper($opts['t'])=='EUR')
    {
        $convertTHB = $converter->convert('THB', 'EUR');
        $type="E";
    }
    else
    {
        $checkerr++;
    }
}

if(empty($args)||$opts == false) {
    $checkerr++;
}


if($args!=NULL&&count($args)==2&&$checkerr==0)
{
    $start=$args[0];
    $end=$args[1];
    if($start > $end){ error($input[0]); }
    else
    {
        if($type=="C")
        {
            echo "\n\t    THB    \t  CNY";
        }
        elseif($type=="U")
        {
            echo "\n\t    THB       \t  USD";
        }
        elseif($type=="E")
        {
            echo "\n\t    THB        \t  EUR";
        }
        for($i=$start;$i<=$end;$i+=$step)
        {
            printf("\n\t%7s       %7s",number_format($i,2),number_format($i*$convertTHB,2));

        }
    }
}
elseif($checkerr>0){
    error($input[0]);
}


function error($filename)
{
    echo "\nInvalid arguments!!!\n";
    echo "Usage the following command for help.\n";
    echo $filename." -h \n";
}

?>
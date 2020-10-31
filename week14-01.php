<?php 
/*ID: 612110264
Name:   Zhe Yin */
require_once "vendor/autoload.php";

$converter = new CurrencyConverter\CurrencyConverter;

$input=$_SERVER['argv'];
$opts = getopt("h", ['help'],$optind );
$args = array_slice($_SERVER['argv'], $optind); 

if(array_key_exists('help', $opts) || array_key_exists('h', $opts))
{
    echo "\nUsage: ".$input[0]." [options] [--] file_name\n";
    echo "Options:\n   -h|--help\t\t print this manual.\n";
    echo "Arguments:\n   file_name\t\t specific file name with following format.\n";
    echo "\t\t\t number_of_data\n\t\t\t data1\n\t\t\t data2\n\t\t\t ...\n";
}
else if($args!=NULL)
{
    $filename=implode($args);
    if(file_exists($filename)) {
        $text=file_get_contents($filename);
        $data=explode("\n",$text);
        echo "\n\tTHB \t   CNY";
        for($i=1;$i<=$data[0];$i++)
        {
            $convertTtoC = $converter->convert('THB', 'CNY');
            $THB=(float)$data[$i];
            $CNY=(float)$data[$i]*$convertTtoC;
            printf("\n %10s %10s",number_format($THB,2,'.',','),number_format($CNY,2));
        }
    } 
    else 
    {
        echo "\nCannot open file '$filename'.";
    }
}
else
{
    echo "\nInvalid arguments!!!\n";
    echo "Usage the following command for help.\n";
    echo $input[0]." -h \n";
}

?>
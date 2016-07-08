<?php namespace Pckg\Tempus\Controller;

use Pckg\Collection;
use Pckg\Framework\Controller;
use Pckg\Maestro\Helper\Maestro;
use Pckg\Tempus\Entity\Items;

class Tempus extends Controller
{

    use Maestro;

    public function getHomeAction(Items $items) {
        $allItems = $items->orderBy('created_at DESC')
                          ->where('finished_at')
            /*->where(
                (new Raw())->where('items.name', '%gnp%', 'LIKE')
                           ->orWhere('items.name', '%gonparty%', 'LIKE')
                           ->orWhere('items.name', '%gremonaparty%', 'LIKE')
                           ->orWhere('items.name', '%schtr4jh@bob%', 'LIKE')
                           ->orWhere('items.name', '%schtr4jh@gonparty%', 'LIKE')
                           ->orWhere('items.name', '%hard island%', 'LIKE')
                           ->orWhere('items.name', '%hardisland%', 'LIKE')
                           ->orWhere('items.name', '%.pckg.%', 'LIKE')
                           ->orWhere('items.name', '%.foobar.si%', 'LIKE')
                           ->orWhere('items.name', '%dev.php%', 'LIKE')
            )*/
                          ->all();

        return view(
            'home',
            [
                'items'    => $allItems,
            ]
        );
    }

}

function get_date_diff($time1, $time2, $precision = 2) {
    // If not numeric then convert timestamps
    if (!is_int($time1)) {
        $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
        $time2 = strtotime($time2);
    }
    // If time1 > time2 then swap the 2 values
    if ($time1 > $time2) {
        list($time1, $time2) = [$time2, $time1];
    }
    // Set up intervals and diffs arrays
    $intervals = ['year', 'month', 'day', 'hour', 'minute', 'second'];
    $diffs = [];
    foreach ($intervals as $interval) {
        // Create temp time from time1 and interval
        $ttime = strtotime('+1 ' . $interval, $time1);
        // Set initial values
        $add = 1;
        $looped = 0;
        // Loop until temp time is smaller than time2
        while ($time2 >= $ttime) {
            // Create new temp time from time1 and interval
            $add++;
            $ttime = strtotime("+" . $add . " " . $interval, $time1);
            $looped++;
        }
        $time1 = strtotime("+" . $looped . " " . $interval, $time1);
        $diffs[$interval] = $looped;
    }
    $count = 0;
    $times = [];
    foreach ($diffs as $interval => $value) {
        // Break if we have needed precission
        if ($count >= $precision) {
            break;
        }
        // Add value and interval if value is bigger than 0
        if ($value > 0) {
            if ($value != 1) {
                $interval .= "s";
            }
            // Add value and interval to times array
            $times[] = $value . " " . $interval;
            $count++;
        }
    }

    // Return string with times
    return implode(", ", $times);
}
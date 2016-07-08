<?php namespace Pckg\Tempus\Controller;

use Pckg\Collection;
use Pckg\Framework\Controller;
use Pckg\Maestro\Helper\Maestro;
use Pckg\Tempus\Entity\Items;

class Tempus extends Controller
{

    use Maestro;

    public function getHomeAction(Items $items)
    {
        $allItems = $items->orderBy('created_at DESC')
                          ->where('created_at', date('Y-m-d H:i:s', strtotime('-1day -1hour')), '>=')
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
                'items' => $allItems,
            ]
        );
    }

}
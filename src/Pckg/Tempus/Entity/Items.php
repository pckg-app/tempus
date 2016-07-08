<?php namespace Pckg\Tempus\Entity;

use Pckg\Database\Entity;
use Pckg\Database\Query\Raw;
use Pckg\Tempus\Record\Item;

class Items extends Entity
{

    protected $record = Item::class;

    public function prevItem() {
        return $this->hasOne(Items::class, 'prev_item')
                    ->where(new Raw('prev_item.id = items.id - 1'))
                    ->leftJoin();
    }

    public function nextItem() {
        return $this->hasOne(Items::class, 'next_item')
                    ->where(new Raw('next_item.id = items.id + 1'))
                    ->leftJoin();
    }

    public function nextSameItem() {
        return $this->hasOne(Items::class, 'next_same_item')
                    ->addSelect(
                        [
                            'next_finished_at' => 'next_same_item.finished_at',
                            'next_created_at' => 'next_same_item.created_at',
                            'next_duration'   => 'next_same_item.duration',
                            'next_id'         => 'next_same_item.id',
                        ]
                    )
                    ->where(
                        new Raw(
                            'next_same_item.id = (SELECT MIN(sub_next.id) FROM items sub_next WHERE sub_next.id > items.id AND sub_next.program = items.program)
                    AND next_same_item.finished_at AND next_same_item.idle < 2 * 60 * 60 AND UNIX_TIMESTAMP(next_same_item.created_at) - UNIX_TIMESTAMP(items.finished_at) < 2 * 60'
                        )
                    )
                    ->leftJoin();
    }

    public function active() {
        return $this->where('idle', 2 * 60 * 1000, '<');
    }

}
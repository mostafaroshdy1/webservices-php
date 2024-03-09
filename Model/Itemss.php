<?php

class Item
{
    private static $items = [
        [
            "id" => "100",
            "name" => "new_glass very new1 ",
            "price" => "14.00",
            "units_in_stock" => "4",
        ]
    ];

    public function get_Item(int $id)
    {
        foreach (self::$items as $item) {
            if ($item["id"] == $id) {
                $this->$item = $item;
                return $item;
            }
        }
        return null;
    }

}
<?php

namespace App\Core;

class ListAccountTypes {
    static public function get() : array {
        return [
            [
                'id' => 1,
                'system_name' => 'admin',
                'nice_name' => 'Администратор',
            ],
            [
                'id' => 2,
                'system_name' => 'teacher',
                'nice_name' => 'Преподаватель',
            ],
            [
                'id' => 3,
                'system_name' => 'curator',
                'nice_name' => 'Куратор',
            ],
            [
                'id' => 4,
                'system_name' => 'user',
                'nice_name' => 'Учащийся',
            ],
        ];

    }
}

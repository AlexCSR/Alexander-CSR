<?php

return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Гость',
        'bizRule' => null,
        'data' => null
    ),
    'administrator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Администратор',
        'children' => array(
            'guest',         // позволим админу всё, что позволено модератору
        ),
        'bizRule' => null,
        'data' => null
    ),
    'root' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Разработчик',
        'children' => array(
            'administrator', 
        ),
        'bizRule' => null,
        'data' => null
    ),
);
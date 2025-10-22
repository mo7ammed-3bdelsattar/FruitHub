<?php
return [
    'storage' => Darryldecode\Cart\CartCollection::class,
    'events' => [
        'item.adding' => [],
        'item.added' => [],
        'item.updating' => [],
        'item.updated' => [],
        'item.removing' => [],
        'item.removed' => [],
        'cart.created' => [],
        'cart.creating' => [],
    ],
    'format_numbers' => false,
    'decimals' => 2,
    'dec_point' => '.',
    'thousands_sep' => ',',
];
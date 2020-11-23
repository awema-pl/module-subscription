<?php

return [
    'membership'=>[
        'attributes' => [
            'user_id' => 'użytkownik',
            'option_id' => 'opcja',
            'comment' =>'komentarz',
            'expiration_date' => 'data wygaśnięcia',
        ],
        'messages'=>[
            'user_has_membership' => 'Ten użytkownik już ma członkostwo.'
        ]
    ],
    'option' =>[
        'attributes' =>[
            'name' =>'nazwa',
            'price'=>'cena',
        ],
        'messages' =>[
            'invalid_price_format' =>'Nieprawidłowy format ceny.'
        ]
    ]
];

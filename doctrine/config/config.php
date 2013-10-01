<?php

return [
    'areas' => [
        'Test' => [
            'entities' => [
                'Product' => [
                    'name' => 'Product',
                    'area' => 'Test',
                    'fields' => [
                        'sku' => [
                            'type' => 'string'
                        ],
                        'name' => [
                            'type' => 'string',
                            'scopes' => ['store', 'lang']
                        ],
                        'price' => [
                            'type' => 'integer',
                            'scopes' => ['store', 'customerGroup']
                        ]

                    ]
                ]
            ]
        ]
    ]
];


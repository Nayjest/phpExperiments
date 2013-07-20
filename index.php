<?php
$loader = require 'vendor/autoload.php';

//class Post extends S\Object {
//
//}


$postConfig = [
    'instanceClass' => 'Post',
    'fields' => [
        'name' => [
            'type' => 'String',
            'scopes' => ['language']
        ],
        'text' => [
            'type' => 'Text',
            'scopes' => ['language']
        ],
        'image' => [
            'scopes' => ['size']
        ],
        'created' => [
            'type' => 'Date',
            'display' => false,
//            'scopes' => [
//                'action.create' => [
//                    'defaultValue' => function(){
//                        return now();
//                    }
//                ],
//                'role.admin' => [
//                    'visible' => true,
//                    'presenter' => 'text'
//                ]
//            ]
        ]
    ],
    'dataSource' => [
        'type' => 'dbTable',
        'tableName' => 'tbl_post',
        'connection' => 'standard'
    ]
];

$all = [
    'areas' => [
        'Shop' => [
            'structures' => [
                'Product' => [
                    'fields' => [
                        'sku' => [
                            'type' => 'String'
                        ],
                        'name' => [
                            'type' => 'String',
                            'scopes' => ['store', 'lang']
                        ],
                        'price' => [
                            'type' => 'Int',
                            'scopes' => ['store', 'customerGroup']
                        ]

                    ],
                ],
                'CustomerGroup' => [
                    'fields' => [
                        'name' => [
                            'type' => 'String',
                            'scopes' => ['language']
                        ],
                        'users' => [
                            'type' => 'Users' # by default -- unique users, @todo what about weighted tags
                            // @todo create separate table or extend users table -- question from dataProvider!!
                        ]
                    ],
                ],
//                '/User' => [
//                    'fields' => [
//                        'group' => [
//                            ''
//                        ]
//                    ]
//                ]
            ]
        ],
        'Blog' => [
            'structures' => [
                'Post' => [
                    'fields' => [
                        'name' => [
                            'type' => 'String',
                            'scopes' => ['language'],
                        ],
                        'text' => [
                            'type' => 'Text',
                            'scopes' => ['language']
                        ],
                        'image' => [
                            'type' => 'Image'
                        ],
                        'created' => [
                            'type' => 'Date',
                        ],
                        'author' => [
                            'type' => 'User' // by default user will have getPosts
                        ]
                    ]
                ],
                // default, can be skipped
                'actions' => [
                    'create',
                    'remove',
                    'edit',
                    'view' => [
                        'access' => ['*']
                    ],
                    'hide' => [
                        'access' => function($post, $user) { // Concept of ownership !!! Excluzive privelegies
                            $user->roles ??
                            return $user.role == 'admin' or $post.author.id == $user.id;
                        }
                    ]
                ]
            ]
        ],
    ],
    'structures' => [
        'User' => [
            'fields' => [
                'userName' => ['type' => 'String'],
                'passwordHash' => ['type' => 'String'],
                'created' => ['type' => 'Date'],
                'roles' => [
                    'type' => '[Role]'
                ],
            ]
        ],
        'Role' => [
            'fields' => [
                'id' => [
                    'type' => 'pk String'
                ],
                'name' => [
                    'type' => 'String',
                    'scopes' => ['language']
                ]
            ]
        ],
        'UserGroup' => [
        ]
    ]
];
$productConfig = [
    'fields' => [
        'id' => [
            'type' => 'Int',
        ],
        'sku' => [
            'type' => 'String'
        ],
        'name' => [
            'type' => 'String',
            'scopes' => ['store', 'lang']
        ],
        'price' => [
            'type' => 'Int',
            'scopes' => ['store', 'customerGroup']
        ]

    ]
];


class Post extends \S\Object
{

}

$meta = new \S\Meta\Object($postConfig);
$p = $meta->createInstance();
$p->setData([
    'name' => 'test'
]);

var_export($p->getData());
echo "finish";
die();
$tPost = getType('Post');
$post = $tPost->load($condition, $scope = []);
$post = $tPost->get($condition, $scope = []); // same with caching
$posts = $tPost->loadAll($condition, $scope);
$post->save();
$post = $tPost->create();
$tPost->save($post);


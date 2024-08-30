<?php

return [
    'rules' => [
        '' => 'site/index',
        '<_a:(login|signup)>' => 'site/<_a>',
        '<_c>/<id:\d+>' => '<_c>/view',
        '<_c>/<id:\d+>/<_a>' => '<_c>/<_a>',
        'books' => 'book/index',
        'statistic' => 'statistic/index',
        'writers' => 'writer/index',
    ]
];

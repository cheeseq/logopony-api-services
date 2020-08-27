<?php
/**
 * Created by PhpStorm.
 * User: stepan
 * Date: 14.05.20
 * Time: 18:41
 */

return [
    'outputDir' => __DIR__ . '/../../../output',
    'templates' => [
        [
            'path' => '/home/stepan/Front',
            'type' => 'SVG', //type also should be resolvable by extension of file
            'elements' => [
                'name' => [ //the key is request key from user
                    'type' => 'text',
                    'id' => 'name',
                ],
                'last_name' => [
                    'type' => 'text',
                    'id' => 'surname',
                ],
                'logo' => [
                    'type' => 'logo',
                    'id' => 'logo',
                ],
                'bg-color' => [
                    'type' => 'color',
                    'id' => 'bg-color',
                ]
            ]
        ]
    ],
];

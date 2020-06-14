<?php 

return [
    'modal_title' => [
        'new' => 'New',
        'edit' => 'Edit',
        'view' => 'View'
    ],
    'fields' => [
        'name' => 'Name',
        'code' => 'Code',
        'address' => 'Address',
        'description' => 'Description'
    ],
    'errors' => [
        'name' => [
            'min' => 'Name must have > 1 character',
            'max' => 'Name must have < 15 characters',
            'invalid' => 'Name invalid !'
        ],
        'code' => [
            'min' => 'Code must have > 1 character',
            'max' => 'Code must have < 15 characters',
            'invalid' => 'Code invalid !'
        ],
        'error_all' => 'Check red fields !',
        'required' => 'Check required fields !'
    ]
];
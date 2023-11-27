<?php

    $table_columns_mapping = [
        'products' => [
            'ProductName', 'adminId', 'Price', 'image',
        ],
        'users' => [
            'email', 'password', 'created_at', 'updated_at', 'emp'
        ],
        'suppliers' => [
            'supplier_name', 'supplier_location', 'email', 'adminId'
        ],
        'productsuppliers' => [
            'supplier', 'product', 'updated_at', 'created_at'
        ],
        'tbempinfo' => [
            'lastname', 'firstname', 'department'
        ]
    ];

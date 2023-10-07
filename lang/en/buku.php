<?php

return [
    'title' => [
        'index' => 'Books',
        'create' => 'New Book',
        'edit' => 'Edit Book'
    ],
    'form' => [
        'title' => 'Title',
        'category_id' => 'Category',
        'author' => 'Author',
        'publish_year' => 'Published Year',
        'description' => 'Summary',
        'isbn' => [
            'title' => 'ISBN',
            'description' => 'This will be filled automatically if empty.'
        ]
    ],
    'flash' => [
        'store' => 'The book has been saved successfully',
        'update' => 'The book has been updated successfully',
        'destroy' => 'The book has been deleted successfully'
    ]
];

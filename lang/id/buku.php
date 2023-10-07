<?php

return [
    'title' => [
        'index' => 'Data Buku',
        'create' => 'Tambah Buku',
        'edit' => 'Ubah Buku'
    ],
    'form' => [
        'title' => 'Judul Buku',
        'category_id' => 'Kategori',
        'author' => 'Penulis',
        'publish_year' => 'Tahun Terbit',
        'description' => 'Sinopsis',
        'isbn' => [
            'title' => 'ISBN',
            'description' => 'Jika dikosongkan, akan diisi otomatis oleh sistem.'
        ]
    ],
    'flash' => [
        'store' => 'Buku berhasil disimpan',
        'update' => 'Buku berhasil diubah',
        'destroy' => 'Buku berhasil dihapus'
    ]
];
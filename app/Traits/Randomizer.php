<?php

namespace App\Traits;

trait Randomizer
{
    public function createISBN(\App\Models\Book $book): void
    {
        $isbn = 'P' . str(\App\Models\Book::max('id'))->padLeft(5, 0);

        $book->update([
            'isbn' => $isbn
        ]);
    }
}

<?php

namespace App\Traits;

trait Randomizer
{
    public function createISBN(int $type = 13): string
    {
        $state = true;
        while ($state) {
            $isbn = ($type == 13) ? fake()->isbn13() : fake()->isbn10();
            $book = \App\Models\Book::firstWhere('isbn', $isbn);
            if (!$book) $state = false;
        }

        return $isbn;
    }
}

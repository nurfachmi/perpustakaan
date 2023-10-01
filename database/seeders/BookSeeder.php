<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ["isbn"=>"978-0062315007","title"=>"The Alchemist ","author"=>"Paulo Coelho","category_id" => 1 , "created_at" => now(),"updated_at" => now()],
            ["isbn"=>"978-0062315007","title"=>" The Hobbit","author"=>"J.R.R. Tolkien","category_id" => 1 , "created_at" => now(),"updated_at" => now()],
            ["isbn"=>"978-0062315007","title"=>"The Great Gatsby","author"=>"F. Scott Fitz","category_id" => 1 , "created_at" => now(),"updated_at" => now()],
            ["isbn"=>"978-0062315007","title"=>"Pride and Prejudice ","author"=>"Jane Austen","category_id" => 1 , "created_at" => now(),"updated_at" => now()],
        ];


        DB::table("books")->insert($categories);

    }
}

<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = [
            ["category_name"=>"computer","created_at" => now(),"updated_at" => now()],
            ["category_name"=>"math","created_at" => now(),"updated_at" => now()],
            ["category_name"=>"chemicals","created_at" => now(),"updated_at" => now()],
            ["category_name"=>"linguistic","created_at" => now(),"updated_at" => now()],
            ["category_name"=>"history","created_at" => now(),"updated_at" => now()],
            ["category_name"=>"DIY","created_at" => now(),"updated_at" => now()],
        ];


        DB::table("categories")->insert($categories);

    }
}

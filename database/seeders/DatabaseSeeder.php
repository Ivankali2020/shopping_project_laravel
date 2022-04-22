<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'ivanphyo',
            'email' => 'ivanphyo2015@gmail.com',
            'email_verified_at' => now(),
            'role' => '1',
            'password' => Hash::make('ivan2020'), // password
            'remember_token' => Str::random(10),
        ]);

        \App\Models\User::factory(10)->create();


        $categories = ['sport','clothes','phone','laptop','food','earphone','book','pen','bike','car'];

        foreach ($categories as $c){
            DB::table('categories')->insert([
                'name' => $c,
            ]);
        };


        $brands = ['nike','adidas','purma','lenovo','acer','msi','hp','iphone','cicci','ubran'];

        foreach ($brands as $b){
            DB::table('brands')->insert([
                'name' => $b,
            ]);
        };

        for ($i=1;$i<10;$i++){
            $name = 'example'.$i;
            DB::table('products')->insert([
                'name' => $name,
                'stock' => rand(10,95),
                'price' => rand(100,1542),
                'detail' => "How can I check if the query failed because of an error or because the row was not affected? In the below code, if values are the same, it will return and won't run the next set of code in the controller",
                'slug' => Str::slug($name),

                'category_id' => Category::all()->random()->id,
                'brand_id' => Brand::all()->random()->id,
                'product_code' => uniqid()

            ]);
        }


    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories =[
          ['catlink'=>'soc','catname'=>'Общение'],
          ['catlink'=>'admin','catname'=>'Администрация'],
          ['catlink'=>'news','catname'=>'Новости'],
          ['catlink'=>'am','catname'=>'Аниме и манга'],
          ['catlink'=>'pr','catname'=>'Программирование'],
          ['catlink'=>'vg','catname'=>'Video Games'],
          ['catlink'=>'hw','catname'=>'Компьютерное железо'],
          ['catlink'=>'rt','catname'=>'Радиотехника'],
          ['catlink'=>'art','catname'=>'Рисование'],
          ['catlink'=>'mus','catname'=>'Музыканты']
        ];
        Category::insert($categories);
    }
}

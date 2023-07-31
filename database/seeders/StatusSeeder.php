<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nameArr = ['Başvuru Alındı', 'Şirket Onaylandı', 'Staj Evrakları Gönderildi', 'Staj Evrakları Onaylandı', 'Defter Teslim Oğrenci Tarafından Onaylandı', 'Defter Teslim Akademisyen Tarafından Onaylandı', 'Staj Bitti'];
        foreach ($nameArr as $item) {
            $status = new Status();
            $status->title = $item;
            $status->description = $item;
            $status->slug = Str::slug($item);
            $status->created_at = now();
            $status->save();
        }
    }
}

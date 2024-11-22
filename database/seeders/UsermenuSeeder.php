<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\usermenu;
use App\Models\usersubmenu;
class UsermenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menu= usermenu::create(
		['name'=>'profile','url'=>'','icon'=>'icon-User']);
		$menu->usersubmenu()->createMany([
		'name'=>'ubah password','url'=>'profile/password', 'is_active'=>'1']);
        $menu->usersubmenu()->createMany([
            'name'=>'ubah profile','url'=>'profile/ubah', 'is_active'=>'1']);
		
		 $menu2= usermenu::create(
		['name'=>'Pengisian Form Asset','url'=>'aset/lihat' , 'icon'=>'icon-Book-open']);
		
        $menu3= usermenu::create(
        ['name'=>'Master Barang','url'=>'barang/lihat','icon'=>'icon-Box']);

        $menu4= usermenu::create(
        ['name'=>'Master Gedung','url'=>'gedung/lihat','icon'=>'icon-Building']);

        $menu5= usermenu::create(
        ['name'=>'Dokumen Sapras','url'=>'sop/lihat','icon'=>'icon-Mailbox']);

        $menu6= usermenu::create(
        ['name'=>'Master Unit','url'=>'unit/lihat','icon'=>'icon-Key']);

    }
}

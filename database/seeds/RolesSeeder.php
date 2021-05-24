<?php

use Illuminate\Database\Seeder;
use App\Role;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['akademik','kepegawaian','dekan','korprodi','perpustakaan','pusdatin'];

        for($i = 0; $i < count($roles); $i++){
            Role::create([
                'role' => $roles[$i]
            ]);
        }
    }
}

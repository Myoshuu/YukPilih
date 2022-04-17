<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use function PHPUnit\Framework\isNull;

class DataSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        dirname(__DIR__);
        User::truncate();
        Division::truncate();

        $csv = fopen(__DIR__ . '/users.csv', 'r');
        $first = true;

        while (($data = fgetcsv($csv)) !== false) {
            if (!$first) {
                [
                    $id,
                    $username,
                    $password,
                    $role,
                    $division,
                ] = $data;

                $divisionRec = Division::firstOrCreate([
                    'name' => $division
                ]);

                User::create([
                    'id' => $id,
                    'username' => $username,
                    'password' => Hash::make($password),
                    'role' => $role,
                    'division_id' => $divisionRec->id,
                ]);
            }

            $first = false;
        }

        fclose($csv);
    }
}

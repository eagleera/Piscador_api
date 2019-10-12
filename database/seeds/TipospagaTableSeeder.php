<?php

use Illuminate\Database\Seeder;

class TipospagaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_paga')->insert([
            [
                'nombre' => 'Diario',
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'nombre' => 'Semanal',
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'nombre' => 'Mensual',
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'nombre' => 'Por kg/arpilla',
                'created_at' => date("Y-m-d H:i:s")
            ],
        ]);
    }
}

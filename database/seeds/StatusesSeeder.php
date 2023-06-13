<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Aguardando Coleta', 'group' => 'order', 'letter' => 'W'],
            ['name' => 'Aguardando Liberação', 'group' => 'order', 'letter' => 'F'],
            ['name' => 'Coleta Efetuada', 'group' => 'order', 'letter' => 'G'],
            ['name' => 'Em transito', 'group' => 'order', 'letter' => 'T'],
            ['name' => 'Entrega efetuada', 'group' => 'order', 'letter' => 'D'],
            ['name' => 'Saiu para coleta', 'group' => 'order', 'letter' => 'S'],
            ['name' => 'Saiu para entrega', 'group' => 'order', 'letter' => 'E'],
            ['name' => 'Faturada', 'group' => 'order', 'letter' => 'F'],
            ['name' => 'PAGO', 'group' => 'invoice', 'letter' => 'PG'],
            ['name' => 'Pendente', 'group' => 'invoice', 'letter' => 'PE'],

        ];

        foreach ($data as $status) {
            Status::query()->firstOrCreate($status);
        }
    }
}

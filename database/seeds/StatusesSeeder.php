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
            ['name' => 'Aguardando Coleta', 'group' => 'order'],
            ['name' => 'Aguardando Liberação', 'group' => 'order'],
            ['name' => 'Coleta Efetuada', 'group' => 'order'],
            ['name' => 'Em transito', 'group' => 'order'],
            ['name' => 'Entrega efetuada', 'group' => 'order'],

        ];

        foreach ($data as $status) {
            Status::query()->firstOrCreate($status);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Funnel;

class AddDefaultStagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $funnels = Funnel::all();

        foreach ($funnels as $funnel) {
            $stages = [
                ['name' => 'sem etapa', 'order' => 1],
                ['name' => 'prospecção', 'order' => 2],
                ['name' => 'contato', 'order' => 3],
                ['name' => 'proposta', 'order' => 4],
            ];

            foreach ($stages as $stage) {
                if (!DB::table('stages')
                    ->where('funnel_id', $funnel->id)
                    ->where('name', $stage['name'])
                    ->exists()) {
                    DB::table('stages')->insert([
                        'funnel_id' => $funnel->id,
                        'name' => $stage['name'],
                        'order' => $stage['order'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IntegrationService;

class IntegrationServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IntegrationService::create([
            'service_name' => 'smtp',
            'logo_location' => 'integration_services_logo/smtp.png',
            'status' => 1,
            'field_json' => '[{"label":"Mail Integration Name","name":"MAIL_INTEGRATION_NAME","placeholder":"Mail Integration Name...","type":"text"},
            {"label":"Mail From","name":"MAIL_FROM","placeholder":"Mail From...","type":"email"},
            {"label":"Mail Host","name":"MAIL_HOST","placeholder":"Mail Host...","type":"text"},
            {"label":"Mail Port","name":"MAIL_PORT","placeholder":"Mail Port...","type":"number"},
            {"label":"Mail Username","name":"MAIL_USERNAME","placeholder":"Mail Username...","type":"text"},
            {"label":"Mail Password","name":"MAIL_PASSWORD","placeholder":"Mail Password...","type":"password"}]',
            'token' => md5(1),

        ]);
    }
}

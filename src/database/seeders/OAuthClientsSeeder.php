<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OAuthClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'id' => 'frontend-client',
                'name' => 'Frontend Application',
                'secret' => 'frontend-secret-change-in-production',
                'redirect_uris' => json_encode([
                    'https://portfolio.kube/oauth/callback',
                ]),
                'grant_types' => json_encode([
                    'authorization_code',
                    'refresh_token',
                ]),
                'revoked' => false,
            ],
            [
                'id' => 'admin-client',
                'name' => 'Admin Application',
                'secret' => 'admin-secret-change-in-production',
                'redirect_uris' => json_encode([
                    'https://admin.portfolio.kube/oauth/callback',
                ]),
                'grant_types' => json_encode([
                    'authorization_code',
                    'refresh_token',
                ]),
                'revoked' => false,
            ],
        ];

        foreach ($clients as $client) {
            DB::table('oauth_clients')->updateOrInsert(
                ['id' => $client['id']],
                array_merge($client, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );

            echo "✓ OAuth client created: {$client['name']} (ID: {$client['id']})\n";
        }
    }
}

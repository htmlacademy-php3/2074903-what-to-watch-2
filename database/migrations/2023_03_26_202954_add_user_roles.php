<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $roles = [
            'usual',
            'moderator',
            'admin'
        ];

        foreach ($roles as $role) {
            DB::table('user_roles')->insert([
                'role' => $role
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('user_roles')->truncate();
        DB::statement("SET foreign_key_checks=1");

    }
};

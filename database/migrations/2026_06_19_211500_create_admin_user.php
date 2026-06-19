<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        // Insert default admin if it doesn't exist
        $exists = DB::table('users')->where('email', 'team.818x@gmail.com')->exists();

        if (!$exists) {
            DB::table('users')->insert([
                'name' => 'Admin Team',
                'email' => 'team.818x@gmail.com',
                'password' => Hash::make('Team@818'),
                'user_type' => 'admin',
                'is_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('users')->where('email', 'team.818x@gmail.com')->delete();
    }
};

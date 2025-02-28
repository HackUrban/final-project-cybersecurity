<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Esegui le migrazioni.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_admin')->nullable()->default(false)->after('email');
            }
            if (!Schema::hasColumn('users', 'is_revisor')) {
                $table->boolean('is_revisor')->nullable()->default(false)->after('is_admin');
            }
            if (!Schema::hasColumn('users', 'is_writer')) {
                $table->boolean('is_writer')->nullable()->default(false)->after('is_revisor');
            }
        });

        if (!User::where('email', 'admin@theaulabpost.it')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@theaulabpost.it',
                'password' => bcrypt('12345678'),
                'is_admin' => true,
            ]);
        }
    }

    /**
     * Reverti le migrazioni.
     */
    public function down(): void
    {
        if ($user = User::where('email', 'admin@theaulabpost.it')->first()) {
            $user->delete();
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_admin')) {
                $table->dropColumn('is_admin');
            }
            if (Schema::hasColumn('users', 'is_revisor')) {
                $table->dropColumn('is_revisor');
            }
            if (Schema::hasColumn('users', 'is_writer')) {
                $table->dropColumn('is_writer');
            }
        });
    }
};
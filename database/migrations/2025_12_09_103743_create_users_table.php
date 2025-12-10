<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
           
            $table->dropColumn('name'); 
            $table->string('firstname')->after('id');
            $table->string('middlename')->nullable()->after('firstname');
            $table->string('lastname')->after('middlename');
            $table->foreignId('role_id')->default(1)->after('password')->constrained('roles')->onDelete('restrict');
          
        });
     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

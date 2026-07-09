<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::connection('mongodb')->getCollection('users')->createIndex(['code' => 1], ['unique' => true]);
        DB::connection('mongodb')->getCollection('users')->createIndex(['email' => 1], ['unique' => true]);
        DB::connection('mongodb')->getCollection('users')->createIndex(['name' => 1]);
        DB::connection('mongodb')->getCollection('users')->createIndex(['status' => 1]);
        DB::connection('mongodb')->getCollection('users')->createIndex(['deleted_at' => 1]);
    }

    public function down(): void
    {
        DB::connection('mongodb')->getCollection('users')->dropIndex('code_1');
        DB::connection('mongodb')->getCollection('users')->dropIndex('email_1');
        DB::connection('mongodb')->getCollection('users')->dropIndex('name_1');
        DB::connection('mongodb')->getCollection('users')->dropIndex('status_1');
        DB::connection('mongodb')->getCollection('users')->dropIndex('deleted_at_1');
    }
};

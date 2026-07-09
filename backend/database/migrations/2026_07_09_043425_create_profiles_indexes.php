<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::connection('mongodb')->getCollection('profiles')->createIndex(['code' => 1], ['unique' => true]);
        DB::connection('mongodb')->getCollection('profiles')->createIndex(['name' => 1]);
        DB::connection('mongodb')->getCollection('profiles')->createIndex(['status' => 1]);
        DB::connection('mongodb')->getCollection('profiles')->createIndex(['deleted_at' => 1]);
    }

    public function down(): void
    {
        DB::connection('mongodb')->getCollection('profiles')->dropIndex('code_1');
        DB::connection('mongodb')->getCollection('profiles')->dropIndex('name_1');
        DB::connection('mongodb')->getCollection('profiles')->dropIndex('status_1');
        DB::connection('mongodb')->getCollection('profiles')->dropIndex('deleted_at_1');
    }
};

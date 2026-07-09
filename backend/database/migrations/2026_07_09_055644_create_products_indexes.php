<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::connection('mongodb')->getCollection('products')->createIndex(['code' => 1], ['unique' => true]);
        DB::connection('mongodb')->getCollection('products')->createIndex(['name' => 1]);
        DB::connection('mongodb')->getCollection('products')->createIndex(['brand' => 1]);
        DB::connection('mongodb')->getCollection('products')->createIndex(['status' => 1]);
        DB::connection('mongodb')->getCollection('products')->createIndex(['deleted_at' => 1]);
    }

    public function down(): void
    {
        DB::connection('mongodb')->getCollection('products')->dropIndex('code_1');
        DB::connection('mongodb')->getCollection('products')->dropIndex('name_1');
        DB::connection('mongodb')->getCollection('products')->dropIndex('brand_1');
        DB::connection('mongodb')->getCollection('products')->dropIndex('status_1');
        DB::connection('mongodb')->getCollection('products')->dropIndex('deleted_at_1');
    }
};

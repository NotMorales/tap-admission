<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::connection('mongodb')
            ->getCollection('sections')
            ->createIndex(['code' => 1], ['unique' => true]);

        DB::connection('mongodb')
            ->getCollection('sections')
            ->createIndex(['route' => 1], ['unique' => true]);

        DB::connection('mongodb')
            ->getCollection('sections')
            ->createIndex(['status' => 1]);

        DB::connection('mongodb')
            ->getCollection('sections')
            ->createIndex(['deleted_at' => 1]);

        DB::connection('mongodb')
            ->getCollection('sections')
            ->createIndex(['order' => 1]);
    }

    public function down(): void
    {
        DB::connection('mongodb')
            ->getCollection('sections')
            ->dropIndex('code_1');

        DB::connection('mongodb')
            ->getCollection('sections')
            ->dropIndex('route_1');

        DB::connection('mongodb')
            ->getCollection('sections')
            ->dropIndex('status_1');

        DB::connection('mongodb')
            ->getCollection('sections')
            ->dropIndex('deleted_at_1');

        DB::connection('mongodb')
            ->getCollection('sections')
            ->dropIndex('order_1');
    }
};

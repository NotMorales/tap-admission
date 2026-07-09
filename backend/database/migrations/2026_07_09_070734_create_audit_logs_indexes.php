<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::connection('mongodb')->getCollection('audit_logs')->createIndex(['module' => 1]);
        DB::connection('mongodb')->getCollection('audit_logs')->createIndex(['action' => 1]);
        DB::connection('mongodb')->getCollection('audit_logs')->createIndex(['record_code' => 1]);
        DB::connection('mongodb')->getCollection('audit_logs')->createIndex(['performed_by.user_id' => 1]);
        DB::connection('mongodb')->getCollection('audit_logs')->createIndex(['created_at' => -1]);
    }

    public function down(): void
    {
        DB::connection('mongodb')->getCollection('audit_logs')->dropIndex('module_1');
        DB::connection('mongodb')->getCollection('audit_logs')->dropIndex('action_1');
        DB::connection('mongodb')->getCollection('audit_logs')->dropIndex('record_code_1');
        DB::connection('mongodb')->getCollection('audit_logs')->dropIndex('performed_by.user_id_1');
        DB::connection('mongodb')->getCollection('audit_logs')->dropIndex('created_at_-1');
    }
};

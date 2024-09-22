<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class CreateDatabase extends Command
{
    protected $signature = 'migrate:with-db';
    protected $description = 'Drop database if exists, create it, and run migrations';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $schemaName = Config::get('database.connections.mysql.database');

        // Temporarily set the database to null to run DROP and CREATE DATABASE
        Config::set('database.connections.mysql.database', null);
        DB::purge('mysql'); // Purge the current connection

        // Check if the database exists
        $query = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$schemaName]);

        // Drop the database if it exists
        if (!empty($query)) {
            DB::statement('DROP DATABASE ' . $schemaName);
            $this->info('Database ' . $schemaName . ' dropped.');
        }

        // Create the database
        DB::statement('CREATE DATABASE IF NOT EXISTS ' . $schemaName);
        $this->info('Database ' . $schemaName . ' created.');

        // Reset the database configuration
        Config::set('database.connections.mysql.database', $schemaName);
        DB::purge('mysql'); // Purge the old connection again to force Laravel to reconnect with the correct database

        // Run migrations
        $this->call('migrate');
    }
}

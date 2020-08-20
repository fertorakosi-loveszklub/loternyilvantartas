<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\DbDumper\Databases\MySql;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings');
    }

    public function backup()
    {
        $path = Str::random(16) . '.sql';

        MySql::create()
            ->setDbName(config('database.connections.mysql.database'))
            ->setUserName(config('database.connections.mysql.username'))
            ->setPassword(config('database.connections.mysql.password'))
            ->dumpToFile(storage_path($path));

        return response()
            ->download(storage_path($path), 'flk_backup_' . date('YmdHis') . '.sql')
            ->deleteFileAfterSend();
    }
}

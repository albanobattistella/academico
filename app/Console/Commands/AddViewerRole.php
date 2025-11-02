<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AddViewerRole extends Command
{
    protected $signature = 'app:add-viewer-role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $role = Role::create(['name' => 'viewer']);
        $role->givePermissionTo('calendars.view');
        $role->givePermissionTo('enrollments.view');
        $role->givePermissionTo('courses.view');
        $role->givePermissionTo('reports.view');
    }
}

<?php

namespace Modules\Filemanager\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FilemanagerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        //Seed Status
        DB::table('filemanager__filestatuses')->delete();
        DB::table('filemanager__filetypes')->delete();
        DB::table('filemanager__filetypecategories')->delete();

        $adminUser = DB::table('role_users')->where('role_id', '=', 1)->first();

        $status = [
            ['id'=>1,'status' => 'Draft', 'sequence' => 1, 'created_by' => $adminUser->user_id],
            ['id'=>2,'status' => 'Pending Approval', 'sequence' => 2, 'created_by' => $adminUser->user_id],
            ['id'=>3,'status' => 'Approved', 'sequence' => 3, 'created_by' => $adminUser->user_id],
            ['id'=>4,'status' => 'Rejected', 'sequence' => 4, 'created_by' => $adminUser->user_id],
            ['id'=>5,'status' => 'Published', 'sequence' => 5, 'created_by' => $adminUser->user_id],
        ];

        DB::table('filemanager__filestatuses')->insert($status);




        //Seed filetype category
        $filTypecatagory =[
            ['id'=>'1','name'=>'User Files','folder'=>'user_files'],
            ['id'=>'2','name'=>'Project Files','folder'=>'project_files'],
            ['id'=>'3','name'=>'Client Files','folder'=>'client_files'],
            ['id'=>'4','name'=>'Lead Files','folder'=>'lead_files'],
            ['id'=>'5','name'=>'Emails','folder'=>'emails'],
            ['id'=>'6','name'=>'Accounting Attachments' ,'folder' => 'accounting_attachments' ]
        ];


        DB::table('filemanager__filetypecategories')->insert($filTypecatagory);


        //Seed filetypes
        $filTypes =[
            ['id'=> '1','type'=>'Profile Photo','folder'=>'profile-photo','category_id'=>'1'],
            ['id'=> '2', 'type'=>'Attachment' , 'folder' => 'attachments' , 'category_id'=> '6']

        ];

        DB::table('filemanager__filetypes')->insert($filTypes);
    }
}

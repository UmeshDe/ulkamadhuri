<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FileManagerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('filemanager__filestatuses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('status');
            $table->float('sequence');

            $table->string('record_status')->nullable()->default("A");
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

	Schema::create('filemanager__filetypecategories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('folder');
            $table->string('record_status')->nullable()->default("A");
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->unique(['name']);
            $table->softDeletes();
            $table->timestamps();
        });

	Schema::create('filemanager__filetypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('folder')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('filemanager__filetypecategories');
            $table->string('record_status')->nullable()->default("A");
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

	 Schema::create('filemanager__files', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('filename');
            $table->string('path',1000);
            $table->string('extension');
            $table->string('mimetype');
            $table->string('filesize');
            $table->integer('folder_id')->unsigned();

            $table->string('file_md5');
            $table->integer('version_no')->nullable();
            $table->string('description', 1000);
            $table->string('key')->nullable();
            $table->unsignedInteger('file_type_id');
            $table->foreign('file_type_id')->references('id')->on('filemanager__filetypes');
            $table->boolean('is_public')->default(false);

            $table->unsignedInteger('file_status_id')->default(0)->references('id')->on('filemanager__filestatuses');

         
            $table->unsignedInteger('uploaded_by')->references('id')->on('users');

            $table->dateTime('uploaded_date')->useCurrent();
            $table->string('record_status')->nullable()->default("A");

            $table->unsignedInteger('assined_to')->references('id')->on('users');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

	 Schema::create('filemanager__fileversions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('file_id')->refrences('id')->on('filemanager__files');
            $table->unsignedInteger('version_no')->default(1);
            $table->string('filename');
            $table->string('description', 1000);
            $table->string('path',1000);
            $table->string('file_md5');
            $table->string('extension');
            $table->string('mimetype');
            $table->string('filesize');
            $table->integer('folder_id')->unsigned();
            $table->string('key')->nullable();
            $table->unsignedInteger('file_type_id')->references('id')->on('filemanager__filetypes');
            $table->boolean('is_public')->default(false);

            $table->unsignedInteger('file_status_id')->default(0)->references('id')->on('filemanager__filestatuses');
         
            $table->unsignedInteger('uploaded_by')->references('id')->on('users');
            $table->string('record_status')->nullable()->default("A");

            $table->unsignedInteger('assined_to')->references('id')->on('users');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

	Schema::create('filemanager__filegroups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('file_id')->references('id')->on('filemanager__files');
            $table->unsignedInteger('group_id')->nullable();
            $table->boolean('can_edit')->default(false);
            $table->boolean('delete')->default(false);
            $table->string('record_status')->nullable()->default("A");
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

	Schema::create('filemanager__fileusers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('file_id')->references('id')->on('filemanager__files');
            $table->unsignedInteger('user_id')->references('id')->on('users');

            $table->boolean('can_edit')->default(false);
            $table->boolean('can_delete')->default(false);

            $table->string('record_status')->nullable()->default("A");
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	Schema::dropIfExists('filemanager__filestatuses');
	Schema::dropIfExists('filemanager__filetypecategories');
	Schema::dropIfExists('filemanager__filetypes');
	Schema::dropIfExists('filemanager__files');
	Schema::dropIfExists('filemanager__fileversions');
	Schema::dropIfExists('filemanager__filegroups');
	Schema::dropIfExists('filemanager__fileusers');
    }
}

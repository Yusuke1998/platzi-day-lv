<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user = factory(User::class)->create([
            'name'      => 'admin',
            'email'     => 'admin@admin.app',
            'password'  => bcrypt('admin@admin.app')
        ]);
        
        Schema::table('products', function (Blueprint $table) use($user) {
            $table->unsignedBigInteger('created_by')->default($user->id);
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            //string = varchar
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->Increments('id');
            $table->string('first_name',60);
            $table->string('last_name',60);
            $table->string('profile_name',60)->unique();
            $table->string('email',320)->unique();
            //$table->string('password',20);// String data, right truncated: 1406 Data too long for column 'password' at row 1 (SQL: insert into `users` (`first_name`, `email`, `password`) values (ab, alaa.almarawi@stu.fsm.edu.tr, $2y$10$.vbCJG4MOy4WgsqV0288Pu0uoWJ6Ar1A07gE6ofVC804xJCnZgSFG))
            $table->string('password',255);

            //$table->integer('transaction_type_id')->unsigned();
            //$table->foreign('transaction_type_id')->references('id')->on('transactions_types');
            //$table->decimal('amount');
            // b date
            //$table->string('bio',1000);
            //frnd no
            //folowwers no
            //following no
            //profile_photo
            //user_photo
            //current_book_id
            //preferred_book_id
            //is_writer
            //open_to_follow
            //is_active
            //$table->timestamp('email_verified_at')->nullable();
            $table->rememberToken(); //remember me
            //$table->timestamps(); //2 columns : created,updated at

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() //drop table when rollback
    {
        Schema::dropIfExists('users');
    }
}

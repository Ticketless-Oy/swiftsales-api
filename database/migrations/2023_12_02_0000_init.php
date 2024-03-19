<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Lumen table, required for DB job queue
         */
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('accountID');
            $table->string('accountName', 100)->default('');
            $table->string('licenseType', 100)->default('basic');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('userID');
            $table->unsignedInteger('accountID');
            $table->string('firstName', 100)->default('');
            $table->string('lastName', 100)->default('');
            $table->string('email', 100)->unique();
            $table->string('timeZone', 100)->default('Europe/Helsinki');
            $table->string('userType', 20)->default('user');
            $table->string('password', 200);
            $table->timestamps();

            $table->foreign('accountID')->references('accountID')->on('accounts')->onDelete('cascade');
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->increments('companyID');
            $table->unsignedInteger('userID');
            $table->string('companyName', 100)->default('');
            $table->string('businessID', 100)->default('');
            $table->timestamps();

            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade');
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('contactID');
            $table->unsignedInteger('userID');
            $table->unsignedInteger('companyID')->nullable();
            $table->string('firstName', 100)->default('');
            $table->string('lastName', 100)->default('');
            $table->string('email', 100)->default('');
            $table->string('phone', 20)->default('');
            $table->timestamps();

            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade');
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->increments('leadID');
            $table->unsignedInteger('userID');
            $table->unsignedInteger('companyID');
            $table->string('name', 100)->default('');
            $table->string('description', 1000)->default('');
            $table->timestamps();

            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade');
        });

        Schema::create('salesAppointments', function (Blueprint $table) {
            $table->increments('salesAppointmentID');
            $table->unsignedInteger('userID');
            $table->unsignedInteger('leadID');
            $table->string('notes', 1000)->default('');
            $table->string('meetingUrl', 1000)->default('');
            $table->timestamp('meetingExpiryTime')->nullable();
            $table->boolean('isCustomerAllowedToShareFiles')->default(false);
            $table->timestamps();

            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade');
            $table->foreign('leadID')->references('leadID')->on('leads')->onDelete('cascade');
        });

        Schema::create('files', function (Blueprint $table) {
            $table->increments('fileID');
            $table->string('fileName');
            $table->string('filePath');
            $table->timestamps();
        });

        Schema::create('salesAppointmentFiles', function (Blueprint $table) {
            $table->increments('salesAppointmentFileID');
            $table->unsignedInteger('fileID');
            $table->unsignedInteger('salesAppointmentID');
            $table->timestamps();

            $table->foreign('fileID')->references('fileID')->on('files')->onDelete('cascade');
            $table->foreign('salesAppointmentID')->references('salesAppointmentID')->on('salesAppointments')->onDelete('cascade');

            $table->unique(['fileID', 'salesAppointmentID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // First migration. No down migration.

    }
}

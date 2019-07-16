<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;
    
    class CreateLikesTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create('likes', function (Blueprint $table) {
                $table->bigInteger('user');
                $table->bigInteger('liked');
                $table->timestamp('date');;
            });
        }
    
        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists('likes');
        }
    }

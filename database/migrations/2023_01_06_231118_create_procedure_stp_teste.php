<?php

use App\Classes\ImportacaoSql;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $type = 'create';
    public function up()
    {
        $procedure = "$this->type " . ImportacaoSql::getConteudo('procedure', 'stpTeste.sql');
        DB::statement($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $procedure = "drop procedure if exists stpTeste";
        DB::statement($procedure);
    }
};

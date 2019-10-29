<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceivableView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        create view receivable_view as
        select
               `receivable`.`id` as `id`,
               `receivable`.`due_date` as `due_date`,
               `receivable`.`payment_date` as `payment_date`,
               `receivable`.`description` as `description`,
               `income_category`.`name` as `category`,
               `account`.`name` as `account`,
               `receivable`.`amount` as `amount`,
               coalesce(`companies`.`company_name`, `companies`.`company_fantasy`) as `customer`,
               `companies`.`company_manager` as `manager`,
               `companies`.`company_id` as `company_id`,
               `receivable`.`sequence_number` as `sequence_number`,
               `receivable`.`sequence_count` as `sequence_count`
        from `receivable`
            inner join `income_category` on `receivable`.`income_category_id` = `income_category`.`id`
            inner join `account` on `receivable`.`account_id` = `account`.`id`
            left join `companies` on `receivable`.`company_id` = `companies`.`company_id`;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("drop view receivable_view");
    }
}

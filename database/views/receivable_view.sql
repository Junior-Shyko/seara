select
    `receivable`.`id` as `id`,
    `receivable`.`due_date` as `due_date`,
    (select date(`payment_date`) from `payment_part` where `receivable_id` = `receivable`.`id` order by `payment_date` desc limit 1) as `payment_date`,
    `receivable`.`description` as `description`,
    `income_category`.`name` as `category`,
    `account`.`name` as `account`,
    coalesce((select sum(`amount`) from `payment_part` where `receivable_id` = `receivable`.`id`), 0) as `paid_amount`,
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


         -- seara.receivable_view source

CREATE OR REPLACE
ALGORITHM = UNDEFINED VIEW `seara`.`receivable_view` AS
select
    `seara`.`receivable`.`id` AS `id`,
    `seara`.`receivable`.`due_date` AS `due_date`,
    (
    select
        cast(`seara`.`payment_part`.`payment_date` as date)
    from
        `seara`.`payment_part`
    where
        (`seara`.`payment_part`.`receivable_id` = `seara`.`receivable`.`id`)
    order by
        `seara`.`payment_part`.`payment_date` desc
    limit 1) AS `payment_date`,
    `seara`.`receivable`.`description` AS `description`,
    `seara`.`income_category`.`name` AS `category`,
    `seara`.`account`.`name` AS `account`,
    coalesce((select sum(`seara`.`payment_part`.`amount`) from `seara`.`payment_part` where (`seara`.`payment_part`.`receivable_id` = `seara`.`receivable`.`id`)), 0) AS `paid_amount`,
    `seara`.`receivable`.`amount` AS `amount`,
    coalesce(`seara`.`companies`.`company_name`, `seara`.`companies`.`company_fantasy`) AS `customer`,
    `seara`.`companies`.`company_manager` AS `manager`,
    `seara`.`companies`.`company_id` AS `company_id`,
    `seara`.`receivable`.`sequence_number` AS `sequence_number`,
    `seara`.`receivable`.`sequence_count` AS `sequence_count`
from
    (((`seara`.`receivable`
join `seara`.`income_category` on
    ((`seara`.`receivable`.`income_category_id` = `seara`.`income_category`.`id`)))
join `seara`.`account` on
    ((`seara`.`receivable`.`account_id` = `seara`.`account`.`id`)))
left join `seara`.`companies` on
    ((`seara`.`receivable`.`company_id` = `seara`.`companies`.`company_id`)));

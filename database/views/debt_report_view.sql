select
    payment.amount as amount,
    payment.payment_date as effective_date,
    "PAGAMENTO" as description,
    receivable.company_id as company_id,
    payment.id as id
from payment_part
         left join receivable on payment_part.receivable_id = receivable.id
         left join payment on payment_part.payment_id = payment.id
union all
select
    - amount as amount,
    due_date as effective_date,
    description as description,
    company_id as company_id,
    id as id
from receivable;

CREATE OR REPLACE
ALGORITHM = UNDEFINED VIEW `seara`.`debt_report_view` AS
select
    `seara`.`payment`.`amount` AS `amount`,
    `seara`.`payment`.`payment_date` AS `effective_date`,
    'PAGAMENTO' AS `description`,
    `seara`.`receivable`.`company_id` AS `company_id`,
    `seara`.`payment`.`id` AS `id`
from
    ((`seara`.`payment_part`
left join `seara`.`receivable` on
    ((`seara`.`payment_part`.`receivable_id` = `seara`.`receivable`.`id`)))
left join `seara`.`payment` on
    ((`seara`.`payment_part`.`payment_id` = `seara`.`payment`.`id`)))
union all
select
    -(`seara`.`receivable`.`amount`) AS `amount`,
    `seara`.`receivable`.`due_date` AS `effective_date`,
    `seara`.`receivable`.`description` AS `description`,
    `seara`.`receivable`.`company_id` AS `company_id`,
    `seara`.`receivable`.`id` AS `id`
from
    `seara`.`receivable`;

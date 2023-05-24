select
    payment.*,
    coalesce(companies.company_name, companies.company_fantasy) as customer,
    companies.company_manager,
    companies.company_id
from payment_part
    left join receivable on payment_part.receivable_id = receivable.id
    left join payment on payment_part.payment_id = payment.id
    left join companies on receivable.company_id = companies.company_id
group by payment_part.payment_id;

-- seara.payment_view source

CREATE OR REPLACE
ALGORITHM = UNDEFINED VIEW `seara`.`payment_view` AS
select
    `seara`.`payment`.`id` AS `id`,
    `seara`.`payment`.`amount` AS `amount`,
    `seara`.`payment`.`payment_date` AS `payment_date`,
    `seara`.`payment`.`created_at` AS `created_at`,
    `seara`.`payment`.`updated_at` AS `updated_at`,
    coalesce(`seara`.`companies`.`company_name`, `seara`.`companies`.`company_fantasy`) AS `customer`,
    `seara`.`companies`.`company_manager` AS `company_manager`,
    `seara`.`companies`.`company_id` AS `company_id`
from
    (((`seara`.`payment_part`
left join `seara`.`receivable` on
    ((`seara`.`payment_part`.`receivable_id` = `seara`.`receivable`.`id`)))
left join `seara`.`payment` on
    ((`seara`.`payment_part`.`payment_id` = `seara`.`payment`.`id`)))
left join `seara`.`companies` on
    ((`seara`.`receivable`.`company_id` = `seara`.`companies`.`company_id`)))
group by
    `seara`.`payment_part`.`payment_id`;

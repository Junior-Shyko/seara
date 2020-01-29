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

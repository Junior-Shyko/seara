select
    payment.*,
    coalesce(companies.company_name, companies.company_fantasy) as customer,
    companies.company_manager,
    companies.company_id
from payment_part
    left join receivable on payment_part.receivable_id = receivable.id
    left join payment on payment_part.payment_id = payment.id
    left join companies on receivable.company_id = companies.company_id;

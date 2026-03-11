select
`id`, `client_number`, `name`, `last_name`,
`second_last_name`, `email`, `mobile_number`, `created_at`,
(select name from branches b where b.id =  c.branch_id ) as  branch ,
 `gender`, `phone`, `birthday`,  `street`, `colonia`,
 `postal_code`, `education`,
 ( select name from states where id = c.state_id) as estado,
 ( select name from cities where id = c.city_id) as ciudad,
 `str_branch`
from customers c

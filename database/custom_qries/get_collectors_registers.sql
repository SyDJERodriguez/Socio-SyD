SELECT cc.id, co.name, c.name, c.last_name ,c.email, c.phone_mobile FROM `customer_collectors` cc
INNER JOIN customers c ON c.id = cc.customer_id
INNER JOIN collectors co ON co.id = cc.collector_id

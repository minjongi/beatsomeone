alter table cb_cmall_order
    add cor_total_money_d decimal(20,2) default 0.0 null;

alter table cb_cmall_order_detail
    add cod_price int default 0 null;

alter table cb_cmall_order_detail
    add cod_price_d decimal(20,2) default 0.0 null;

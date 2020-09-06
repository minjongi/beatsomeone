create table cb_cmall_settlement_history
(
    csh_id bigint auto_increment
        primary key,
    cod_id bigint null,
    csh_datetime datetime null,
    csh_settle_money decimal(10,2) default 0.00 null,
    csh_settle_money_d decimal(10,2) default 0.00 null,
    csh_status int default 0 null
);

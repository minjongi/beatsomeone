create table cb_member_group
(
    mgr_id int unsigned auto_increment
        primary key,
    mgr_title varchar(255) default '' not null,
    mgr_is_default tinyint unsigned default '0' not null,
    mgr_datetime datetime null,
    mgr_order int default 0 not null,
    mgr_description text null,
    mgr_monthly_cost_d decimal(10,2) default 0.00 null,
    mgr_monthly_cost_w decimal(10,2) default 0.00 null,
    mgr_year_cost_d decimal(10,2) default 0.00 null,
    mgr_year_cost_w decimal(10,2) default 0.00 null,
    mgr_monthly_discount int default 0 null,
    mgr_year_discount int default 0 null,
    mgr_commission int default 0 null
)
    collate=utf8mb4_general_ci;

create index mgr_order
    on cb_member_group (mgr_order);


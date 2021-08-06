<?php
namespace Config;
/*
 * main table names go in here.
 *
 *  use $MAIN_TABLES array to get table names .
 * */
class tables{
public $MAIN_TABLES = [
'news' => 'news_tbl',
'user' => 'user_tbl',
'permissions' => 'user_permissions',
'menu' => 'menu_tbl',
'site' => 'site_tbl',
'comments' => 'messages_tbl',
'information' => 'informations',
    'news_categories' => 'news_categories',
    'logs_ips' => 'logs_ips',
    'logs_ssid' => 'logs_session_id',
    'Competition_tbl' => 'competition_tbl',
    'Competition_Attributes_tbl' => 'competition_attributes',
    'Winners_tbl' => 'winners_tbl',
    'Notice_Competition' => 'notice_competition_tbl',
    'Tickets_tbl' => 'ticket_tbl',
    'Messages_clients' => 'messages_tbl',
    'Payment_categories' => 'payment_categories',
    'Wallet_tbl' => 'wallets_tbl',
    'Transactions' => 'transactions_tbl',
    'Roles' => 'role_categories',
    'payment_factors' => 'payment_factors',
    'Interfaces' => [
        'Sliders' => 'slider_tbl'
    ],
    'server_info' => 'informations',
    'withdrawal_requests' => 'withdrawals_tbl'
];
}

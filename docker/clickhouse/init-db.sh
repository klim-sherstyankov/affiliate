#!/bin/bash
set -e

echo '##########'
echo 'Database configuration script'
env
echo '##########'

clickhouse client -n <<-EOSQL
    CREATE USER IF NOT EXISTS $CLICKHOUSE_MANUAL_USER IDENTIFIED BY '$CLICKHOUSE_MANUAL_PASSWORD';
    CREATE DATABASE IF NOT EXISTS $CLICKHOUSE_DATABASE;
    SET allow_introspection_functions=1;
    GRANT ALL PRIVILEGES ON *.* TO $CLICKHOUSE_MANUAL_USER WITH GRANT OPTION;
    SET allow_introspection_functions=0;
EOSQL

#!/usr/bin/env bash

mysql -u root -p$MYSQL_ROOT_PASSWORD -e "CREATE DATABASE IF NOT EXISTS \`$MYSQL_EMP_DIR_DB_NAME\`;"
mysql -u root -p$MYSQL_ROOT_PASSWORD -e "CREATE USER IF NOT EXISTS \`$MYSQL_EMP_DIR_DB_USER\`@'%';"
mysql -u root -p$MYSQL_ROOT_PASSWORD -e "GRANT ALL ON \`$MYSQL_EMP_DIR_DB_NAME\`.* TO \`$MYSQL_EMP_DIR_DB_USER\`@'%' IDENTIFIED BY '$MYSQL_EMP_DIR_DB_PASS';"

mysql -u root -p$MYSQL_ROOT_PASSWORD -e "CREATE DATABASE IF NOT EXISTS \`$MYSQL_VACATION_SCHED_DB_NAME\`;"
mysql -u root -p$MYSQL_ROOT_PASSWORD -e "CREATE USER IF NOT EXISTS \`$MYSQL_VACATION_SCHED_DB_USER\`@'%';"
mysql -u root -p$MYSQL_ROOT_PASSWORD -e "GRANT ALL ON \`$MYSQL_VACATION_SCHED_DB_NAME\`.* TO \`$MYSQL_VACATION_SCHED_DB_USER\`@'%' IDENTIFIED BY '$MYSQL_VACATION_SCHED_DB_PASS';"

SOURCE="${BASH_SOURCE[0]}"
DIR="$( dirname "$SOURCE" )"
mysql -u root -p$MYSQL_ROOT_PASSWORD $MYSQL_EMP_DIR_DB_NAME < $DIR/init_emp_dir
mysql -u root -p$MYSQL_ROOT_PASSWORD $MYSQL_VACATION_SCHED_DB_NAME < $DIR/init_vacation_sched
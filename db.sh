#!/bin/sh
#
# Shell script to access your database. Requires access to
# mysql_db_info, assumed to be in your /webdev/user/$USER file.
#USER=`nepranger`
#DBNAME=`db_nepranger`
#DBPASSWD=`tQgYpgzasPYP`
#DBHOST=`dbdev.cs.uiowa.edu`
#DBPORT=`3306`

# Access MySQL
mysql --user='nepranger' --password='tQgYpgzasPYP' --host='dbdev.cs.uiowa.edu' --port='3306' 'db_nepranger'

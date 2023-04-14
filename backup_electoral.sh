#!/bin/bash

USER="cartas_db"
PASSWORD="c0ntr4s3n42018*"
DATABASE="electoral"

FINAL_OUTPUT=/var/www/html/BD/`date +%Y%m%d`_`date +%H%M`_electoral.sql
mysqldump -u cartas_db -p'c0ntr4s3n42018*' electoral > /var/www/html/BD/`date +%Y%m%d`_`date +%H%M`_electoral.sql
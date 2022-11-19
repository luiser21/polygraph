#!/bin/bash

USER="cartas_db"
PASSWORD="c0ntr4s3n42018*"
DATABASE="polygraph"

FINAL_OUTPUT=/var/www/html/BD/`date +%Y%m%d`_`date +%H%M`_polygraph.sql
mysqldump -u cartas_db -p'c0ntr4s3n42018*' polygraph > /var/www/html/BD/`date +%Y%m%d`_`date +%H%M`_polygraph.sql
#!/bin/bash
ROOT_PATH=/opt/bokee/www/CMS/web/root/cms_www
BACKUP_PATH=${ROOT_PATH}/backup
DIR_NAME=${BACKUP_PATH}/`date +\%Y-\%m-\%d`
FILE_NAME=index_`date +\%H`.shtml
if [ ! -d $DIR_NAME ] 
then
  mkdir $DIR_NAME
fi
cp ${ROOT_PATH}/index.shtml ${DIR_NAME}/$FILE_NAME

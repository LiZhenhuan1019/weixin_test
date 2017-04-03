#!/bin/bash

files='wx_interface.php get_access_token.php'
for file in $files
do
	scp $file $qcloud0:/var/www/html
done


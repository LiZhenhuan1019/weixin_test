#!/bin/bash

files='wx_interface.php get_access_token.php get_user_information.php create_menu.php user_defined_page.php buttons.json'
for file in $files
do
	scp $file $qcloud0:/var/www/html
done


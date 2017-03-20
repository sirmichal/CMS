#!/bin/bash

if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root" 1>&2
   exit 1
fi

chown -R www-data:www-data /var/www/html
chmod -R 660 /var/www/html
find /var/www/html -type d -exec chmod 2770 {} +
rm -rf /var/www/html/cms/tests
rm -rf /var/www/html/cms/var/*
HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX /var/www/html/cms/var
setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX /var/www/html/cms/var
php /var/www/html/cms/bin/console cache:warmup -e=prod --no-debug

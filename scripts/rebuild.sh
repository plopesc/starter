#!/usr/bin/env bash

# Ensure this script uses drupal and drush packaged with the codebase.
PATH=`pwd`/vendor/bin:$PATH

# The script can configure an environment. By default is local.
MODE=${1:-quick}

# Avoid drop and reinstall the site everytime we deploy
#INSTALL_FRESH_SITE=${INSTALL_FRESH_SITE:-FALSE}
INSTALL_FRESH_SITE="TRUE"

DATE=$( date +%s )

which drupal
if [[ $(drush --version) != *8.1.7* ]]; then
    echo "WARNING: Not using recommended Drush version"
fi

if [ ! -f "composer.json" ]; then
    exit "You must run this from the project root."
fi

if [[ $INSTALL_FRESH_SITE =~ "TRUE" ]]; then
    echo ""
    echo "installing a FRESH site"

    if [ "$MODE" == "full" ]; then
        # Configure permissions required to reinstall dependencies.
        chmod 775 web web/core
        chmod 664 composer.lock

        composer install
#        composer update
    fi

    cd ./web

    echo ""
    echo "-- Setting up directories for the environment."
    chmod 775 sites/default
    chmod 664 sites/default/settings.php

    echo ""
    echo "-- Creating a backup in ../databases/drupal-$DATE.sql."
    drush sql-dump -y > "../databases/drupal-$DATE.sql"

    echo ""
    echo "-- Dropping database."
    drush sql-drop -y

    echo ""
    echo "-- Installing environment."
    drush site-install standard -y --account-pass=admin

else
    echo "We do not drop and reinstall the site, only deploy code"
    cd ./web

    echo ""
    echo "-- Creating a backup in ../databases/drupal-$DATE.sql."
    drush sql-dump -y > "../databases/drupal-$DATE.sql"

    echo ""
    echo "-- Importing configuration to environment."
    drush cim -y
fi

echo ""
echo "-- Clear caches."
drush cr

echo ""
echo "-- Here is the ULI for admin:"
drush uli admin

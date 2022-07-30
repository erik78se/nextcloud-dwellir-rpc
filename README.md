# Dwellir RPC nextcloud app (practice)

### Setup development with juju

    juju add-model nextcloud-app-dev
    juju deploy nextcloud --channel edge
    juju deploy postgresql
    juju config nextcloud debug=true
    
    # Get the admin password for the site:
    juju run-action nextcloud/0 get-admin-password --wait


### Develop the app

   edit drpc/...


### Copy the drcp app to nextcloud

Simply copy the app to the "apps" directory of nextcloud.

    cp -r /home/ubuntu/drpc/ /var/www/nextcloud/apps/
    chown -R www-data.www-data /var/www/nextcloud/apps/drpc


### Check database

Login to the postgresql instance and become the postgresql user.

    juju ssh postgresql
    sudo su - postgres

Check the database
    
    psql 
    
    \c nextcloud

    \dt+

    \d oc_rpc


# The "PHP Project"

Built with [Lumen PHP Framework](https://lumen.laravel.com/)!

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.


 ## Local Environment
 Make sure docker is installed.

 With your favorite terminal, search for the Docker Image:

``docker pull mattrayner/lamp``

Enter this project's folder and then run the following commands:
 
 ``docker run -p "80:80" -v ${PWD}:/app mattrayner/lamp:latest-1804``

  
 ## Configurations inside container
 We'll need to do some configurations inside container, so follow these steps in a new command line:
 - Please run `docker ps` and check your container name;
 - Run `docker exec -it {CONTAINER_NAME} /bin/bash` to enter inside it;
 - `cd /app && composer install` to install project's dependencies.
 
 ### Creating V-Hosts at Apache
 To avoid using `localhost/public` at this project, I prefer using vhosts.
 
 - Start creating a new file for your domain: `cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/test.local.conf`;
 - Enter this file and start editing it: `vim /etc/apache2/sites-available/test.local.conf`;
 - Save your file with this content:
 ```
<VirtualHost *:80>
        ServerAdmin webmaster@localhost

        ServerName test.local
        ServerAlias test.local
        DocumentRoot /app/public/
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
        SetEnvIf x-forwarded-proto https HTTPS=on

        <Directory />
            Options FollowSymLinks
            AllowOverride all
            Require all granted
        </Directory>

</VirtualHost>
```
- Before saving the conf file, activate your domain with `a2ensite test.local.conf` ;
- Enter your hosts file using `vim /etc/hosts` and add a new line with `127.0.0.1 test.local` and save it;
- Restart apache typing `service apache2 restart`.

And then your [test.local domain](http://test.local/) is up!
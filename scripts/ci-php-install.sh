#!/bin/bash 

# Nous devons installer les dépendances uniquement pour Docker
 [[ ! -e /.dockerenv ]] && exit 0 

set -xe 

apt-get update \ 
&& apt-get install -y \ 
&& apt-get autoremove -y \ 
&& docker-php-ext-install mysqli pdo pdo_mysql \ 
&& apt-get install curl -y \ 
&& apt-get install git -y\ 
&& apt-get install zip -y\ 
&& curl -sS https://get.symfony.com/cli/installer | bash \ 
&& mv /root/.symfony/bin/symfony /usr/local/bin/symfony \ 
&& curl -sS https://getcomposer.org/installer | php
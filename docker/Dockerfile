#FROM php:7.3-apache
FROM php:5.6.6-apache

# Make sure apt is up to date
RUN apt-get update --fix-missing

# Install curl
RUN apt-get install -y --force-yes curl

# Install required libraries for gd
RUN apt-get install -y --force-yes build-essential libssl-dev zlib1g-dev libpng-dev libjpeg-dev libgif-dev libfreetype6-dev

RUN apt-get install -y zip libzip-dev
RUN apt-get install -y libxml2-dev
RUN apt-get install -y libjpeg-dev

RUN a2enmod rewrite

#RUN apt-get install -y php5-gd php5-ldap php5-mysql php5-pgsql php-gettext php5-curl php5-mcrypt
RUN apt-get install -y php5-gd php5-ldap php5-mysql php5-curl php5-mcrypt
#RUN apt-get install -y gettext 
RUN docker-php-ext-install gettext mysqli

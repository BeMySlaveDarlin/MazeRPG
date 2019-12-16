# Manual installation

## Steps
 - Preinstall
    ```
    apt -y update
    apt install --no-install-recommends --no-install-suggests -yq curl gcc g++ make autoconf \
    libc-dev zlib1g-dev pkg-config gnupg2 dirmngr wget apt-transport-https lsb-release \
    ca-certificates software-properties-common apt-utils jq mc nano zip unzip git openssl \
    re2c libmemcached-dev libmemcached11 libmagickwand-dev
    
    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
    
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
    apt -y update
    ```
 - **Redis Server 5.0+** `apt install redis-server`
 - **Memcached Server 1.5+** `apt install memcached`
 - [NGINX 1.17+](https://docs.nginx.com/nginx/admin-guide/installing-nginx/installing-nginx-open-source/)
 - [MySQL 5.7+](https://tecadmin.net/install-mysql-on-debian-10-buster/)
 - [Composer 1.9+](https://getcomposer.org/doc/00-intro.md)
 - [PHP 7.3+](https://www.php.net/manual/en/install.php) with ext:
    - [Phalcon 3.4+](https://phalconphp.com/)
    - **Memcached** `pecl install memcached`
    - **Imagick** `pecl install imagick`
    - **Redis** `pecl install redis`
    - [DS](https://github.com/php-ds/ext-ds) `pecl install ds`
    - other `apt install`
      - php-pear
      - php-amqp
      - php-igbinary
      - php-yaml
      - php7.3-bcmath
      - php7.3-curl
      - php7.3-gd
      - php7.3-json
      - php7.3-opcache
      - php7.3-readline
      - php7.3-mbstring
      - php7.3-msgpack
      - php7.3-mongodb
      - php7.3-mysql
      - php7.3-pspell
      - php7.3-recode
      - php7.3-soap
      - php7.3-tidy
      - php7.3-intl
      - php7.3-xml
      - php7.3-zip
 - Postinstall
    ```
    composer global require hirak/prestissimo
   
    cd "/path/to/root/of/project/src/backend"
   
    composer install --no-scripts --no-autoloader
    composer dump-autoload --optimize
    ```

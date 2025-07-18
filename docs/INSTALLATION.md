# Installation Guide for Omega Monero Marketplace Script

This comprehensive guide will walk you through the installation process of the Omega Monero Marketplace script on your system.

## Operating System Requirements
This guide is based on Ubuntu 22.04 LTS (Jammy Jellyfish). We strongly recommend using a Linux distribution for optimal performance and security. Windows is not recommended for this setup.

## System Preparation
Begin by updating your system to ensure all packages are current:
```bash
sudo apt update
sudo apt upgrade -y
```

## Installing Required Dependencies
### PHP 8.3 Installation
First, we'll install PHP 8.3 along with essential extensions required for the marketplace:
```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.3-fpm php8.3-mysql php8.3-curl php8.3-gd php8.3-mbstring \
php8.3-xml php8.3-zip php8.3-bcmath php8.3-gnupg php8.3-intl php8.3-readline \
php8.3-common php8.3-cli php8.3-gmp
```
We also need to install unzip because composer will use it to extract packages:
```bash
sudo apt install -y unzip
```

### Composer Installation
Install Composer 2, which we'll need for managing Laravel dependencies:
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
HASH="$(wget -q -O - https://composer.github.io/installer.sig)"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
php -r "unlink('composer-setup.php');"
```

### Additional Dependencies
Install Git for version control:
```bash
sudo apt install -y git
```

### Database Server
Install and configure MySQL server:
```bash
sudo apt install -y mysql-server
sudo systemctl start mysql
sudo systemctl enable mysql
```

### Web Server
Install and enable Nginx:
```bash
sudo apt install -y nginx
sudo systemctl start nginx
sudo systemctl enable nginx
```

## Optional: Frontend Development Tools

Our marketplace includes frontend development configuration files that are not currently being used. These files are set up for modern web development tools, but the marketplace works perfectly without them. However, if you think you might want to enhance your marketplace with modern frontend features in the future, you can install Node.js and npm now:

```bash
# Install Node.js and npm
sudo apt install -y nodejs npm
```

After we clone the repository in the next section, you can optionally run this command to install the development tools:
```bash
cd /var/www/omega
npm install
```

This will install development dependencies that you can use later if needed. **This step does not affect how your marketplace works** and is only useful if you plan to use these development tools.

You might want to install these tools if you plan to:
- Add custom JavaScript functionality to your marketplace
- Use modern CSS preprocessing tools like SCSS or SASS
- Set up automatic asset minification and optimization
- Add modern frontend frameworks like Alpine.js or Vue.js components

**Most users can skip this section entirely.**

## Verification Steps
Verify all installations by checking their versions:
```bash
php -v
composer -V
git --version
mysql --version
nginx -v
```

Expected output (versions may vary):
```
Composer version 2.8.4 2024-12-11 11:57:47
PHP version 8.3.15 (/usr/bin/php8.3)
git version 2.34.1
mysql  Ver 8.0.40-0ubuntu0.22.04.1 for Linux on x86_64 ((Ubuntu))
nginx version: nginx/1.18.0 (Ubuntu)
```

## Database Configuration
### Secure MySQL Setup
Run the MySQL secure installation script:
```bash
sudo mysql_secure_installation
```

When prompted:
1. Enable the VALIDATE PASSWORD COMPONENT (select 'y')
2. Choose password validation level 1
3. Answer 'y' to all subsequent security questions

### Database and User Creation
Access the MySQL prompt:
```bash
sudo mysql
```

Create a new database user (replace the placeholder values with your own):
```sql
CREATE USER 'your_user'@'localhost' IDENTIFIED BY 'Y0ur_P@ssw0rd!23';
```

Create the database:
```sql
CREATE DATABASE your_database_name;
```

Grant necessary privileges:
```sql
GRANT ALL PRIVILEGES ON your_database_name.* TO 'your_user'@'localhost';
FLUSH PRIVILEGES;
```

Exit the MySQL prompt:
```sql
exit;
```

### Verify Database Access
Test your new database user credentials:
```bash
mysql -u your_user -p
```

After entering your password, verify database creation:
```sql
SHOW DATABASES;
```

Your database name should appear in the list. Make sure to securely store your database credentials, as they'll be required for the application's .env configuration file.

## Repository Setup and Laravel Configuration

Let's start by navigating to your Downloads folder:
```bash
cd Downloads
```

Now, we will download our repository from GitHub. This command will create a folder named "omega" in your Downloads folder:
```bash
git clone https://github.com/sukunetsiz/omega.git
```

We need to move our "omega" repository to /var/www/ directory, as this will be the location Nginx uses to serve our application:
```bash
sudo mv omega /var/www/
```

Open a new terminal and navigate to our project directory:
```bash
cd /var/www/omega
```

First, let's create our environment configuration file by copying the example file:
```bash
cp .env.example .env
```

Now, we'll edit our .env file using nano text editor:
```bash
sudo nano .env
```

In this file, you'll find various configuration settings. You need to update the database settings with the credentials we created earlier. Look for these lines and modify them:
```
DB_DATABASE=your_database_name
DB_USERNAME=your_user
DB_PASSWORD=Y0ur_P@ssw0rd!23
```

To save the changes and exit the text editor, press CTRL+X, then 'y' to confirm, and finally press Enter.

Next, let's install all required packages using Composer:
```bash
composer install
```

Generate the application encryption key:
```bash
php artisan key:generate
```

Now, let's create our database tables by running migrations:
```bash
php artisan migrate
```

If you want to create some test users and products to play around with, you can run this command:

```bash
php artisan db:seed
```

Finally, we need to set proper file permissions for security. Run these commands in sequence:
```bash
sudo chown -R www-data:www-data /var/www/omega
sudo find /var/www/omega -type f -exec chmod 644 {} \;
sudo find /var/www/omega -type d -exec chmod 755 {} \;
sudo chmod -R 775 /var/www/omega/storage
sudo chmod -R 775 /var/www/omega/bootstrap/cache
sudo chmod 640 /var/www/omega/.env
```

## Secure Nginx Configuration

Now we need to configure Nginx to serve our marketplace. Let's create a new server block configuration file:
```bash
sudo nano /etc/nginx/sites-available/omega
```

Copy and paste the following configuration into the file. This is a simple Nginx configuration:
```nginx
server {
    listen 80;
    listen [::]:80;

    root /var/www/omega/public;
    index index.php;

    error_page 503 /maintenance.php;

    location / {
        if (-f $document_root/../storage/framework/down) {
            return 503;
        }
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

After pasting the configuration, save and exit the editor by pressing CTRL+X, then 'y', and finally Enter.

Now, we need to enable our site by creating a symbolic link:
```bash
sudo ln -s /etc/nginx/sites-available/omega /etc/nginx/sites-enabled/
```

Let's remove the default Nginx configuration to avoid any conflicts:
```bash
sudo rm /etc/nginx/sites-enabled/default
```

Before we restart Nginx, let's test our configuration to make sure everything is correct:
```bash
sudo nginx -t
```

If you see a message saying the test is successful, we can safely restart Nginx:
```bash
sudo systemctl restart nginx
```

Now our Nginx server is configured and is ready to serve our marketplace application.
You can visit localhost in your browser to test if your marketplace is working properly. 

**Important:** Your marketplace requires Tor to function properly. The XMR price fetching feature uses Tor's SOCKS proxy to anonymously retrieve cryptocurrency prices from external APIs. Without Tor configured, your marketplace will display 'UNAVAILABLE' for XMR prices instead of live market data.

The following section will guide you through installing and configuring Tor to enable both the price fetching functionality and publish your marketplace as a hidden service on the Tor network.

## Installing and Configuring Tor Hidden Service

Install Tor to set up the hidden service functionality:
```bash
sudo apt install -y tor
```

Edit the Tor configuration file to specify our hidden service settings and enable SOCKS proxy:
```bash
sudo nano /etc/tor/torrc
```

Add the following configuration lines at the beginning of the file. The SocksPort enables anonymous XMR price fetching, while the HiddenService settings make your marketplace accessible via .onion address:
```bash
SocksPort 9050
HiddenServiceDir /var/lib/tor/omega_hidden_service/
HiddenServicePort 80 127.0.0.1:80
```

Save the configuration file by pressing CTRL+X, then 'y' to confirm, and finally press Enter.

Open a new terminal and restart both the Nginx and Tor services to apply the changes:
```bash
sudo systemctl restart tor
sudo systemctl restart nginx
```

Let's check if the SOCKS proxy port is listening correctly:
```bash
netstat -tlnp | grep 9050
```

You should see output similar to:
```
tcp        0      0 127.0.0.1:9050          0.0.0.0:*               LISTEN
```

This confirms that Tor's SOCKS proxy is running on port 9050 and ready to handle your marketplace's XMR price requests.

You can now retrieve your hidden service's onion address from the hostname file:
```bash
sudo cat /var/lib/tor/omega_hidden_service/hostname
```

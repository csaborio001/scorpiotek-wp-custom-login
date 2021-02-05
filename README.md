# ScorpioTek WP Custom Login

A simple plugin to replace the default logon screen in WordPress with a cleaner, more modern looking one without too much fuzz.

# To Test

1. Install Mutagen

2. Run:

```
docker-compose build
docker-compose up -d
```

3. Install Mutagen

4. Run the following mutagen command to sync the plugin (inside the plugin folder)

```
mutagen sync create --sync-mode=one-way-safe --default-owner-beta=www-data \
--name=scorpiotek-wp-custom-login-sync \
/. docker://scorpiotek-wp-custom-login/var/www/html/wp-content/plugins/scorpiotek-wp-custom-login
```

# Version History

## 0.1.4

* Restructed the whole site for easier development.
* Renamed all assets folders, moved dist process to root
* Composer 2 upgrade

## 0.1.3

* Fixed layout of password reset screen

## 0.1.2

* Fixed issue that causes white text on white background when viewing backup codes.

## 0.1.1

* Changed from CSS to SASS

## 0.1

* Initial Version
* Allows an image to be placed inside /assets/images 


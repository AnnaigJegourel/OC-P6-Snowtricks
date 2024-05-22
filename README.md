# OC-P6-Snowtricks

Training program "Back-end Developer: PHP/Symfony" (OpenClassrooms)

Project 6:  Collaborative blog about snowboard tricks using PHP & Symfony (study project)

✅ Validated on March 13, 2023

[![CodeClimate Badge](https://api.codeclimate.com/v1/badges/589aae61309fe342df5d/maintainability)](https://codeclimate.com/github/AnnaigJegourel/OC-P6-Snowtricks/maintainability)

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/078705714170477ebbc49cc9c0bc58a3)](https://www.codacy.com/gh/AnnaigJegourel/OC-P6-Snowtricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=AnnaigJegourel/OC-P6-Snowtricks&amp;utm_campaign=Badge_Grade)

## Original Configuration / Technologies 🛠

xamppserver

10.4.21-MariaDB

PHP 8.1

Composer 2.3.0

Symfony 6.1

## Installation 🚧

1. Clone the repository
2. Upload & install xamppserver: [https://www.wampserver.com/en/download-wampserver-64bits/](https://www.apachefriends.org)
3. Launch xamppserver, configure your php version to 8.1.6 or above
4. Go to localhost/phpmyadmin/
5. Create a new database & name it "p6-blog"
6. Launch a terminal at the root of the project & run the command "composer intall"
7. Launch the Symfony server running "symfony server:start"

You can load the fixtures as initial data, running "php bin/console doctrine:fixtures:load"

## Upgrading to Symfony 6.4

<https://symfonycasts.com/screencast/symfony7-upgrade>

1. Run the app & open a development server (symfony serve -d)
2. Update composer.json

   - Ugrade php 8.1 to 8.2 (in config > platform, l.63) & run "composer up"
   - Upgrade Symfony (from main repo only) changing every "6.1.*" to "6.4.*" & run "composer up"

3. Update the Flex recipes

    - See the list of available updates running "composer recipes:update"
    - Update one by one, checking every change (some are note necessary, read doc)
    - Delete deprecated (& unused) bundle running "composer remove sensio/framework-extra-bundle"
    - Update webpack-encore-bundle to version ^2.0 in composer.json & run "composer up"
    - Update the new recipe but keep only symfony.lock changes (don't remove files & customized code)

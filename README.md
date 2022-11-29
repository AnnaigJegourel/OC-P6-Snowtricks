# OC-P6-Snowtricks
Training program "Back-end Developer: PHP/Symfony" (OpenClassrooms)<br>
Project 6:  Collaborative blog about snowboard tricks using PHP & Symfony (study project)<br>
🚧 Work in progress

<a href="https://codeclimate.com/github/AnnaigJegourel/OC-P6-Snowtricks/maintainability"><img src="https://api.codeclimate.com/v1/badges/589aae61309fe342df5d/maintainability" /></a>
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/078705714170477ebbc49cc9c0bc58a3)](https://www.codacy.com/gh/AnnaigJegourel/OC-P6-Snowtricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=AnnaigJegourel/OC-P6-Snowtricks&amp;utm_campaign=Badge_Grade)

## Configuration / Technologies 🚧

xamppserver<br>
10.4.21-MariaDB<br>
PHP 8.1<br>
Composer 2.3.0<br>
Symfony 6.1

## Installation 🚧

1.  Clone the repository
2.  Upload & install xamppserver: [https://www.wampserver.com/en/download-wampserver-64bits/](https://www.apachefriends.org)
3.  Launch xamppserver, configure your php version to 8.1.6
4.  Go to localhost/phpmyadmin/
5.  Create a new database & name it "p6-blog"
6.  Import the database using db.sql (file at the root of this project)
7.  Launch a terminal at the root of the project & run the command "composer intall"

Your project is ready!

## Contexte

🏂 Jimmy Sweat est un entrepreneur ambitieux passionné de snowboard. Son objectif est la création d'un site collaboratif pour faire connaître ce sport auprès du grand public et aider à l'apprentissage des figures (tricks).
<br>👨‍💼Il souhaite capitaliser sur du contenu apporté par les internautes afin de développer un contenu riche et suscitant l’intérêt des utilisateurs du site. Par la suite, Jimmy souhaite développer un business de mise en relation avec les marques de snowboard grâce au trafic que le contenu aura généré.

### Description
Vous êtes chargée de développer le site répondant aux besoins de Jimmy, en vous concentrant sur la création technique du site.

Vous devez ainsi implémenter les fonctionnalités suivantes : 
<br>🛠 un annuaire des figures de snowboard ;
<br>🛠 la gestion des figures (création, modification, consultation) ;
<br>🛠 un espace de discussion commun à toutes les figures.

Pour implémenter ces fonctionnalités, vous devez créer les pages suivantes :
<br>📄 la page d’accueil où figurera la liste des figures ; 
<br>📄 la page de création d'une nouvelle figure ;
<br>📄 la page de modification d'une figure ;
<br>📄 la page de présentation d’une figure (contenant l’espace de discussion commun autour d’une figure).

### Contraintes

➡️ En premier lieu, il vous faudra écrire l’ensemble des issues/tickets afin de découper votre travail méthodiquement et de vous assurer que l’ensemble du besoin client soit bien compris avec votre mentor. Les tickets/issues seront écrits dans un repository GitHub que vous aurez créé au préalable.
<br>
➡️ Il faut que les URL de page permettent une compréhension rapide de ce que la page représente et que le référencement naturel soit facilité.
<br>
➡️ L’utilisation de bundles tiers est interdite sauf pour les données initiales.
<br>
➡️ L’ensemble des figures de snowboard doivent être présentes à l’initialisation de l’application web. Vous utiliserez un bundle externe pour charger ces données.
<br>
➡️ Le design du site web est laissé complètement libre, attention cependant à respecter les wireframes fournis pour le gabarit de vos pages. Néanmoins, il faudra que le site soit consultable aussi bien sur un ordinateur que sur mobile (téléphone mobile, tablette, phablette…).

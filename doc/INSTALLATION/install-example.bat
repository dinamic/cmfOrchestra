@echo off
echo installation...
pause
cd C:\xampp\htdocs\symf_orchestra
echo creation de la base de donnes...
pause
php app/console doctrine:database:create
echo creation schema de la base de donnes...
php app/console doctrine:schema:create
echo mise a jour de la base de donnes...
php app/console doctrine:schema:update
echo chargement des fixtures dans la base de donnes...
php app/console doctrine:fixtures:load
echo installation terminee...
pause
php artisan down
git add .
git commit --m commit_from_server
git pull --rebase
git push
composer install
php artisan cache:clear
php artisan config:clear
php artisan migrate --force
php artisan up
echo 'Deploy staging finished.'
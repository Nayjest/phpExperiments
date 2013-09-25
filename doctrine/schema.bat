rmdir /s /q runtime
mkdir runtime
mkdir runtime\config
php -f test_doctrine_generator.php
php -f ..\vendor\doctrine\orm\bin\doctrine.php orm:generate:entities runtime
php -f ..\vendor\doctrine\orm\bin\doctrine.php orm:schema-tool:drop --force
php -f ..\vendor\doctrine\orm\bin\doctrine.php orm:schema-tool:create

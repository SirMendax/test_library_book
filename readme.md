## Тестовое задание на позицию PHP-разработчика

### Запуск приложения
1. composer install
2. sudo chmod a+x start.sh
3. ./start.sh
4. docker ps (скопировать id fpm-контейнера)
5. sudo docker exec -it <id fpm-контейнера> /bin/bash
6. php bin/console make:migration
7. php bin/console doctrine:migrations:migrate
8. php bin/console doctrine:fixtures:load
9. Открыть http://localhost:8080 и:
   - Либо ввести данные админа login: admin, password: qwerty;
   - Либо зарегистрироваться и зайти под своим логином (функции добавления/удаления/редактирование не будут доступны)
   

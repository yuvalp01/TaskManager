# TaskManager


In the tasks_API folder:
1. Run composer update 
2. Then in -> .env, change the following to fit your db
       * DB_CONNECTION=XXX
       * DB_DATABASE=XXX
    * the username for the db stayed root and password is empty
3. Run php artisan migrate
4. Run php artisan passport:install
5. Run php artisan passport:keys
6. Run php artisan db:seed



In the tasks_client folder
1. In config -> environment.js under APP change the API_URL to point your web server
2. Run npm install
3. Run php artisan db:seed
4. Run the rest API with php artisan serve
5. Run ember with ember serve

- Pre-inserted with seeding the following user names:
elon@mask.com
bill@gates.com
donald@trump.com
mohamad@ali.com

- The user name elon@mask.com has already a few tasks by the seeding
- All have password 1234




# TaskManager


1. In the tasks_API folder -> .env, change the following to fit your db
    DB_CONNECTION=XXX
    DB_DATABASE=XXX
    * the username for the db stayed root and password is empty
2. In the tasks_client folder-> config -> environment.js under APP change the API_URL to point your web server
3. Run npm install
4. Run php artisan db:seed
5. Run the rest API with php artisan serve
6. Run ember with ember serve

- Pre-inserted with seeding the following user names:
elon@mask.com
bill@gates.com
donald@trump.com
mohamad@ali.com

- The user name elon@mask.com has already a few tasks by the seeding
- All have password 1234




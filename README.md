# Aurora
This project focuses on email marketing. Users can add email addresses, input SMTP credentials, create email templates, and schedule their emails. and this project is made on laravel framework
and frontend design used in this project # [Soft UI Dashboard Laravel](https://www.creative-tim.com/product/soft-ui-dashboard-laravel)

## Installation
* First download the project and open the aurora folder in your favourite ide like vs-code
* Start the xampp server
* Now open the terminal in your ide or cmd in your project
* Type this command "php artisan migrate" this create all tables in your database
* Then type this command "php artisan db:seed"
* Type command "php artisan serve"
* Open new tab in your terminal or new cmd in your project type this command "php artisan schedule:work" this will start the cron job in this project
* Now open the browser and type this url "http://127.0.0.1:8000/" now use it
* If you want to go on admin panel just sign up your account and go to users table in tasky database and change the value 0 to 1 of is_admin column in users table * Note: admin panel is not fully completed

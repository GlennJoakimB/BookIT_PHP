# BookIT-PHP
This is a student-project in PHP for the course IS-115 at UiA.
The project is a booking system where students can book appointments for guidance with teaching assistants.


## Development Launch with XAMPP

### Local Install Requirements:

* Xampp installed.
* Setup commandline path to xampp php and mysql. Guide [How to setup windows ENV variables](https://stackoverflow.com/a/46408671)
* Install [compser](https://getcomposer.org/doc/00-intro.md#introduction) for your system.

Project location path:
Location **/xampp/htdocs/< repo folder name >

### Running the project

1. Run xampp, start apache and mysql from xampp controll panel.
2. Open mySQL admin from controll panel, create new db with neame `bookitdb`. 
3. Open terminal, navigate to `htdocs/<projectRoot>/BookITweb`.
4. Create a file named `.env` in the same location as example `.env.example` and adjust the database parameters and the database name.
5. Run `composer install` or `composer up` within the directory of `/BookITweb` to install project dependencies.
6. Run migrations by executing `php migrations.php` within the same directory.
7. Change directory to `htdocs/<projectRoot>/BookITweb/Public`.
8. Start a php server by running the command `php -S localhost:8080`. 

The project should now be available at [localhost:8080](localhost:8080).
The project is live edit, so whenever there is a file change saved, relode the page in browser and it will appear.
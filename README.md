# BookIT-PHP
A project in PHP for the course IS-115 at UiA


## Development Launch with XAMPP

### Local Install Requirements:

Xampp installed.

Setup commandline path to xampp php and mysql. Guide [How to setup windows ENV variables](https://stackoverflow.com/a/46408671)

Not using Visual studio:

- Install [compser](https://getcomposer.org/doc/00-intro.md#introduction) for your system.

Project location path:
Location **/xampp/htdocs/< repo folder name >

### Running the project

1. Run xampp, start apache and mysql from xampp controll panel.
2. Open mySQL admin from controll panel, create new db with neame `bookitdb`. 
3. Open terminal, navigate to `htdocs/<projectRoot>/BookITweb`.
4. Run from terminal `composer up`, to install project dependencies.
5. Create `.env` file in the same location as example `.env.example`.
Copy from example to new file, and set user and pass.
6. Run from terminal `php ./migrations.php`. Migrations should be applied
7. Path to `htdocs/<projectRoot>/BookITweb/Public`.
8. Run command `php -S localhost:8080`.

The project should now be available at [localhost:8080](localhost:8080).
The project is live edit, so whenever there is a file change saved, relode the page in browser and it will appear.
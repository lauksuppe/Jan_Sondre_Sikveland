#Jan Sondre Sikveland | jan.s.sikveland@gmail.com

#Exercise 02

##Simple Blog System
* In this project i made a simple blog system using php and a mysql database running on xampp

###Install
1. Extract the contents of the htdocs folder to your server htdocs folder (If you want to extract it to a subfolder of your htdocs directory, 
   you will have to edit the filepath.ini file accordingly; just add another ../)
2. Extract the private folder to the parent folder of your server htdocs folder
3. Run the sql_script.sql script in the sql folder

###PHPUnit
1. Go to the folder where you extracted the project in whatever command line tool you use
2. Execute the "composer update" command (make sure the blog_post table is empty and that AUTO_INCREMENT = 1 before running the tests)
3. Execute the "phpunit" command
4. If you do not have composer or phpunit and want to run the tests, install them using this guide https://phpunit.de/manual/current/en/installation.html

###Additional notes
* You can change the login credentials to anything you want, just make sure to change it on the database AND in the .ini files
* If you are connecting to a remote database to do this, please change the servername values in the .ini files
* If you want to you could create a table to store admin user(s) as well and verify the login by querying this table instead of verifying it by trying to connect with the database
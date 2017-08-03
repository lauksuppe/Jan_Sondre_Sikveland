#Jan Sondre Sikveland @ jan.s.sikveland@gmail.com

#Login Project

Tried making a template for a webpage login connected to a database

#Getting Started

Download xampp if you don't already have it and put the project folder in the htdocs folder of your xampp directory. 
Either change the port to use when running the server to 1234 or change the port in the project files to what you 
want to use. Then simply run apache server and mysql using the xampp control panel and go to 
http://localhost:1234/phpmyadmin and create a new database called "loginproject" with a table called "user" with 3 
rows: username(VARCHAR 20), password(VARCHAR 255) and email(VARCHAR 31). Once this is done grant the user "loginquery" 
with password "password" privileges to at least SELECT and INSERT(UPDATE and DELETE will be needed for future functionality).
Then simply go to http://localhost:1234/(project_folder_name) and it should work. If you have an actual server running 
with MySQL you can just put the files there and go through the same process of making the database and granting privileges.
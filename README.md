# JobMatch

## How to run the web app

- Prerequisites & Notes:
    - Make sure XAMPP is installed on your system
    - Works both on Mac and Window OS

<p>&nbsp;</p>

### Run the App locally on Window OS

1. Copy the project and place it under this directory
    ```
    xampp/htdocs/
    ```
2. Open XAMPP and Turn on both Apache and MySQL

3. Time to config the database. On your browser, go to
    ```
    https://localhost/phpmyadmin
    ```
4. Go to directory `mysql/jobmatch.sql`
    ```
    Open and copy the script in the sql file
    ```
5. On the `phpmyadmin` page
    ```
    Click on SQL, paste the script, and click 'Go'
    ```
6. Now time to see the application. On your browser, go to 
    ```
    https://localhost/<project name>
    ```
7. You should be able to see the app running

<p>&nbsp;</p>

### Run the App locally on Mac OS

1. Open XAMPP and click Start, Go to Services and click Start All, Go to Network and enable a server, and Go to Volumes and mount the disk.

2. Copy the project, go to the disk you just mounted and place it under this directory
    ```
    iampp/htdocs/
    ```
3. Time to config the database. On your browser, go to
    ```
    https://localhost:<port>/phpmyadmin
    ```
4. Go to directory `mysql/jobmatch.sql`
    ```
    Open and copy the script in the sql file
    ```
5. On the `phpmyadmin` page
    ```
    Click on SQL, paste the script, and click 'Go'
    ```
6. Now time to see the application. On your browser, go to
    ```
    https://localhost:<port>/<project name>
    ```
7. You should be able to see the app running

<p>&nbsp;</p>

## To clean up

1. Quit the browser
2. Turn off all services on XAMPP
3. Then you should be good to go

<p>&nbsp;</p>

## Heroku Deployment Link
```
https://jobmatchdemo.herokuapp.com
```

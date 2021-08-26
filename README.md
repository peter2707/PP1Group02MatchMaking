# JobMatch

## How to run the web app

- Prerequisites:
    - Make sure you are running on Window OS
    - Make sure XAMPP is installed on your system

- Run the App on local machine

1. Copy the project and place it under this directory
    ```
    xampp/htdocs/
    ```
2. Open XAMPP and Turn on both Apache and MySQL

3. Time to config the database
    ```
    On your browser, go to https://localhost/phpmyadmin
    ```
4. Go to directory `mysql/jobmatch.sql`
    ```
    Open and copy the script in the sql file
    ```
5. On the `phpmyadmin` page
    ```
    Click on SQL, paste the script, and click 'Go'
    ```
6. Now time to see the application
    ```
    On your browser, go to https://localhost/<project name>
    ```
7. You should be able to see the app running

## To clean up

1. Just quit the browser and turn off both `Apache` and `MySQL` on `XAMPP`
# JobMatch

## How to run the web app

- Prerequisites & Notes:
    - Ensure that you have XAMPP installed on your system
    - Works both on Mac and Window OS
<p>&nbsp;</p>

- Admin Credentials:
    - Username: admin
    - Password: admin

<p>&nbsp;</p>

### Run the App locally on Window OS

1. Copy the project and place it in your `XAMPP` folder under this directory
    ```
    xampp/htdocs/
    ```
2. Open XAMPP and Turn on both Apache and MySQL
3. In JobMatch directory, go to `model/db_connection.php` and replace the content with the code below
    ```
    <?php
        try {
            $dbAddress = 'localhost';
            $dbUser = 'root';
            $dbPass = '';
            $dbName = 'jobmatch';
            $db = mysqli_connect($dbAddress, $dbUser, $dbPass, $dbName);
        
            // Check connection
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                exit();
            }
        }catch(Exception $e) {
            echo $e->getMessage();
        }
    ?>
    ```

4. Time to config the database. On your browser, go to
    ```
    https://localhost/phpmyadmin
    ```
5. Go to jobmatch directory `mysql/jobmatch.sql`
    ```
    Open and copy the script in the sql file
    ```
6. On the `phpmyadmin` page in your browser
    ```
    Click on 'SQL' tab, create an empty database name "jobmatch", paste the script, and click 'Go'
    ```
7. Now time to see the application. On your browser, go to 
    ```
    https://localhost/<project name>
    ```
8. You should be able to see the app running

<p>&nbsp;</p>

### Run the App locally on Mac OS

1. Open XAMPP and click Start, Go to Services and click Start All, Go to Network and enable a server, and Go to Volumes and mount the disk.

2. Copy the project, go to the disk you just mounted and place it under this directory
    ```
    iampp/htdocs/
    ```
3. In JobMatch directory, go to `model/db_connection.php` and replace the content with the code below
    ```
    <?php
        try {
            $dbAddress = 'localhost';
            $dbUser = 'root';
            $dbPass = '';
            $dbName = 'jobmatch';
            $db = mysqli_connect($dbAddress, $dbUser, $dbPass, $dbName);
        
            // Check connection
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                exit();
            }
        }catch(Exception $e) {
            echo $e->getMessage();
        }
    ?>
    ```
4. On your browser, go to
    ```
    https://localhost:<port>/phpmyadmin
    ```
5. In JobMatch directory, go to `mysql/jobmatch.sql`
    ```
    Open and copy the script in the sql file
    ```
6. On the `phpmyadmin` page in your browser
    ```
    Click on 'SQL' tab, create an empty database name "jobmatch", paste the script, and click 'Go'
    ```
7. Now time to see the application. On your browser, go to
    ```
    https://localhost:<port>/<project name>
    ```
8. You should be able to see the app running

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

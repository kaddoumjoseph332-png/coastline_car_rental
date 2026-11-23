# Coastline Car Rental

## Run on Windows with XAMPP, MySQL Community Server, and phpMyAdmin

1. Install [MySQL Community Server 8.4 LTS](https://dev.mysql.com/downloads/mysql/8.4.html) using the Windows MSI. In MySQL Configurator, choose TCP port **3307**, set an administrator password, and run MySQL as a Windows service. Start **Apache** in XAMPP. The XAMPP control panel's MySQL button starts its bundled MariaDB service. With separate ports, each database service can run independently.
2. Put the entire `car_rental` folder in `C:\xampp\projects\`. In `C:\xampp\apache\conf\httpd.conf`, add the block below and restart Apache. The alias serves the project’s `public` directory. The `private` directory stays outside the web root.

   ```apache
   Alias "/car_rental/public" "C:/xampp/projects/car_rental/public"
   <Directory "C:/xampp/projects/car_rental/public">
       Require all granted
       DirectoryIndex index.php
   </Directory>
   ```

3. Back up `C:\xampp\phpMyAdmin\config.inc.php`. In the server block you want to point at MySQL, set these options. Remove any existing duplicate assignments for those same options from that block, and leave a valid `blowfish_secret` in place for cookie authentication.

   ```php
   $cfg['Servers'][$i]['auth_type'] = 'cookie';
   $cfg['Servers'][$i]['host'] = '127.0.0.1';
   $cfg['Servers'][$i]['port'] = '3307';
   $cfg['Servers'][$i]['AllowNoPassword'] = false;
   ```

4. Open [phpMyAdmin](http://localhost/phpmyadmin/), log in with the MySQL administrator account, and run `SELECT VERSION();` in the **SQL** tab. Check the version and server information for **MySQL Community Server**. Create an empty database named `car_rental`, select it, and use **Import** to load the included `database.sql` for a fresh demo.
5. In phpMyAdmin's **SQL** tab, create a local application account. Change the sample password in this statement and put the same value in `private/db_credentials.php`.

   ```sql
   CREATE USER 'car_rental_app'@'127.0.0.1' IDENTIFIED BY 'SetYourLocalAppPassword';
   GRANT SELECT, INSERT, UPDATE, DELETE ON car_rental.* TO 'car_rental_app'@'127.0.0.1';
   ```

6. Open [the public site](http://localhost/car_rental/public/) and [the staff login](http://localhost/car_rental/public/login.php). With the included sample database, sign in as **admin** with **RideDemo2026!**. These are local demo credentials. If you use a different MySQL port, set it in both phpMyAdmin and `private/db_credentials.php`.

## Keep records from your existing MariaDB database

1. Connect phpMyAdmin to the existing MariaDB server. Select the project database and export its **structure and data** to a separate SQL backup. Keep this backup and the old database until you verify the switch.
2. Connect phpMyAdmin to MySQL port 3307. When you want your existing records, import **your backup** into a fresh MySQL database instead of importing the sample `database.sql`. Keep the existing admin credentials for a migrated database. If you import with another database name, update `DB_NAME` and the application account's grant.
3. If MySQL rejects a MariaDB-only collation, find the affected `COLLATE` clause in a copy of your export and choose an equivalent collation supported by MySQL (for example `utf8mb4_unicode_ci` for an ordinary `utf8mb4` project table). Import the corrected copy into an empty schema.
4. Verify that your branches, cars and staff login appear. If the older export has no foreign key on `cars.branch_id`, fix any cars without a matching branch, then add the relationship. Skip this step if the key already exists.

   ```sql
   ALTER TABLE cars
     ADD CONSTRAINT cars_branch_fk
       FOREIGN KEY (branch_id) REFERENCES branches(id) ON DELETE RESTRICT;
   ```

## What to demonstrate

- Use the database-driven public branch menu. Open a branch, view a car, and check the daily rate and call link.
- Open a staff page while signed out. Sign in and show both resource lists.
- Submit a new-car form with missing required fields. The server lists errors and keeps the values you entered.
- Create a branch and a car assigned to it. Edit the car and hide it. The car stays in staff and disappears from the public catalog.
- Delete the car through the confirmation form, then remove the empty branch. Staff can delete a branch once its cars have been moved or deleted.
- Sign out and check that the staff pages ask for a login again.

## Source map

| Location | Purpose |
|---|---|
| `public/index.php` | Home, branch catalog and car detail views |
| `public/login.php`, `public/logout.php` | Staff session entry and exit |
| `public/staff/branches/`, `public/staff/cars/` | Staff list, show, new, edit and delete pages |
| `private/shared/` | Headers, footers, form fields and error display |
| `private/query_functions.php` | MySQLi queries and resource validation |
| `public/stylesheets/` | Public and staff CSS |

The course demo uses the assignment's MD5 password format. Review the code before the oral defense and fill in your student ID and any partner details on the first PowerPoint slide.

- [MySQL installation on Windows](https://dev.mysql.com/doc/refman/8.4/en/windows-installation.html)
- [phpMyAdmin server configuration](https://docs.phpmyadmin.net/en/latest/config.html)

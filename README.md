# Space Merchant

**Galactic Commerce Management System**

"Space Merchant" is a Galactic Commerce Management System developed as part of the IF3E Introduction to Databases course at the Université de Technologie de Belfort-Montbéliard (UTBM). This project enabled me to design and implement the features of a web-based strategy game, allowing me to apply my programming knowledge and enhance my technical skills.

---

## Installation Guide

Welcome to the "Space Merchant" installation guide! This README will guide you through the steps required to set up and run "Space Merchant" on your local machine.

### Requirements
- XAMPP (Apache, MySQL)

---

### Step-by-Step Installation

#### 1. Install XAMPP
- Download and install XAMPP from [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html).
- Follow the installation instructions for your operating system.

#### 2. Setting up the Project
- After installing XAMPP, navigate to the `htdocs` directory in your XAMPP installation folder. This is typically found at `C:\xampp\htdocs` on Windows.
- Copy or move the "spacemerchant" project folder into the `htdocs` directory.

#### 3. Start XAMPP Services
- Launch the XAMPP Control Panel.
- Start the **Apache** and **MySQL** services. You should see their status turn green in the control panel once they are running.

#### 4. Configure the Database
1. Open your web browser and go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin) to access the phpMyAdmin interface.
2. Create a new database named **spacemerchant**:
   - Click on the **Databases** tab.
   - Enter `"spacemerchant"` in the **Database name** field.
   - Click the **Create** button.
3. Import the SQL file to set up your database structure and initial data:
   - Inside phpMyAdmin, click on the `"spacemerchant"` database you just created.
   - Navigate to the **Import** tab.
   - Click on **Choose File** and select the SQL file located in your "spacemerchant" project folder.
   - Press the **Go** button at the bottom of the page to import the database structure.

---

### Accessing the Application

- Open your web browser and visit [http://localhost/spacemerchant/Connexion.php](http://localhost/spacemerchant/Connexion.php).
- You should now see the login page for the "Space Merchant" application.

You are all set! Start exploring "Space Merchant." If you encounter any issues during installation, ensure that all steps have been correctly followed, especially the database setup in phpMyAdmin.

---

### Note
To test all functionalities without playing the game, you can modify the `"money"` value in the **user** table within the database. Enjoy managing your intergalactic commerce!

![image](https://user-images.githubusercontent.com/54909696/144947502-ef90f2a8-efcb-415d-b30d-5eba9d56fa65.png)
# <p align="center">🟣 Project 5 : Create your first blog using PHP 🟣</p>
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=ledukilian_LeduKilian_P5_10052021&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=ledukilian_LeduKilian_P5_10052021)
[![Maintainability](https://api.codeclimate.com/v1/badges/706fe8c458f4273b5932/maintainability)](https://codeclimate.com/github/ledukilian/LeduKilian_P5_10052021/maintainability)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=ledukilian_LeduKilian_P5_10052021&metric=security_rating)](https://sonarcloud.io/dashboard?id=ledukilian_LeduKilian_P5_10052021)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/17e69317ec4042099804ca93d28f9840)](https://www.codacy.com/gh/ledukilian/LeduKilian_P5_10052021/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ledukilian/LeduKilian_P5_10052021&amp;utm_campaign=Badge_Grade)
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=ledukilian_LeduKilian_P5_10052021&metric=ncloc)](https://sonarcloud.io/dashboard?id=ledukilian_LeduKilian_P5_10052021)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=ledukilian_LeduKilian_P5_10052021&metric=bugs)](https://sonarcloud.io/dashboard?id=ledukilian_LeduKilian_P5_10052021)

## 🧱 Project install
### 🧩 Prerequisites
First you need to use `composer install` command to install required packages

List of the package used :
- [ ] Twig
- [ ] Slugify
- [ ] PHPMailer

Once it's done you need to make sure you have the YAML Package installed with your PHP version (can be found here : https://pecl.php.net/package/yaml)
- [ ] Yaml extension (PHP 7.4 at least)

> **NOTE** : Depending of your configuration, you might need to install the Yaml extension to your PHP version

### ⚙️ Database
The second step is to create your database, name it as you will as long as it is **UTF-8**.
You just need to import the database structure named `database.sql` that can be found inside the main folder of the project `/`.
> **NOTE** : The database contains several samples for demonstration, you can remove them as you like

**IMPORTANT :** Do not delete the admin user located inside the `admin` table with the 1 id and the id_user rattached to him in `user` table.
<br />
### ✏️ Initial configuration
There is 2 important configurations files located in the `config/` folder, you can use the `.example` and add your own configuration for each of one.
- [ ] `db-config.yml` : Configure link to database, you need to input your own.
- [ ] `mail.yml` : Configure mail, you need to input, please note :
    >
    - [ ] `from` : Registration mail will be sent with those.
    - [ ] `contact-to` : Contact mail will be sent to this one.

### 🔐 First login
You can use the default account for the first login :
- [ ] **Email** : `admin@admin.dev`
- [ ] **Password** : `admin12345`

> **NOTE** : All account parameters (name, email, password etc..) are editable inside the admin panel

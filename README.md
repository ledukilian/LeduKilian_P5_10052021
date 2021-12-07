![image](https://user-images.githubusercontent.com/54909696/144947502-ef90f2a8-efcb-415d-b30d-5eba9d56fa65.png)
# <p align="center">🟣 Project 5 : Create your first blog using PHP 🟣</p>
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=ledukilian_LeduKilian_P5_10052021&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=ledukilian_LeduKilian_P5_10052021)
[![Maintainability](https://api.codeclimate.com/v1/badges/706fe8c458f4273b5932/maintainability)](https://codeclimate.com/github/ledukilian/LeduKilian_P5_10052021/maintainability)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=ledukilian_LeduKilian_P5_10052021&metric=bugs)](https://sonarcloud.io/dashboard?id=ledukilian_LeduKilian_P5_10052021)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=ledukilian_LeduKilian_P5_10052021&metric=security_rating)](https://sonarcloud.io/dashboard?id=ledukilian_LeduKilian_P5_10052021)
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=ledukilian_LeduKilian_P5_10052021&metric=ncloc)](https://sonarcloud.io/dashboard?id=ledukilian_LeduKilian_P5_10052021)


## 🧱 Project install
### 📌 Prerequisites
First you need to use `composer install` command to install required packages

List of the package used :
- Twig
- Slugify
- PHPMailer
- Yaml extension


### 📌 Initial configuration
There is 2 important configurations files located in the `config/` folder, you can use the .example and add your own configuration for each of one.
- `db-config.yml` : Configure link to database, you need to input your own.
- `mail.yml` : Configure mail, you need to input, please note :
    >
    - `from` : Registration mail will be sent with those.
    - `contact-to` : Contact mail will be sent to this one.


### 📌 Database import

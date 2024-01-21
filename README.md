<div align="center">
  
  ![GitHub repo size](https://img.shields.io/github/repo-size/pawantech12/library-management-system)
  ![GitHub stars](https://img.shields.io/github/stars/pawantech12/library-management-system?style=social)
  ![GitHub forks](https://img.shields.io/github/forks/pawantech12/library-management-system?style=social)

  <br />

  <h2 align="center">Responsive Library Management System</h2>

  Library Management System made using HTML, CSS,JavaScript,PHP,MySQL.

</div>

<br />


### Prerequisites

Before you begin, ensure you have met the following requirements:

* You Should Know Basic or Intermediate of HTML ,CSS,JavaScript,PHP and MySQL

Fontawesome Icon :
```html
<!-- fontawesome icon link  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
```

### Project Configuration and changes

#### What you want to run this Project?

1. An Editor i.e visual studio code or you can use any other editor.(its only required when you want to customize the code i.e its optional).
2. Xampp server(as it establish a server to run php code) or you can use any other server like wampp.
3. Configure some settings below to run the project accurately.
4. Import the 'librarydb.sql' file in phpmyadmin with database name 'librarydb.sql'.the file is located in `assets\Database\librarydb.sql`.

#### Librarian Login Credentials

E-mail: librarymanagementwebsite@gmail.com
Password: librarian

#### Configuring XAMPP to send email from localhost in php:

1. Go to the (C:xampp\php) and open the PHP configuration setting file(php.ini) then find the '[mail function]' by scrolling down or simply press ctrl+f to search it directly then find the following lines and pass these values. Remember, there may be a semicolon ; at the start of each line, simply remove the semicolon from each line which is given below.

#edit the following lines:

```
[mail function]
SMTP=smtp.gmail.com
smtp_port=587
sendmail_from = codewithpawanofficial@gmail.com(enter your email address that wiil be used for sending email from localhost as sender email.)
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"
```
Now Save this file and close it and follow next step.

2. Now, go the (C:\xampp\sendmail) and open the sendmail configuration setting file(sendmail.ini) then find sendmail by scrolling down or press ctrl+f to search it directly then find the following lines and pass these values. Remember, there may be a semicolon ; at the start of each line, simply remove the semicolon from each line which is given below.

edit the following lines:
```
smtp_server=smtp.gmail.com
smtp_port=587
error_logfile=error.log
debug_logfile=debug.log
auth_username=codewithpawanofficial@gmail.com(same email address that you enter in php.ini file)
auth_password=ghihcljrufojsngj
```
Now save the file and close it here you have end up with configuration now stop the apache server and mysql server if you have started and close it and restart xampp server and start it.


#### How to change size of file to be uploaded and it post size?

1. Go to the (C:xampp\php) and open the PHP configuration setting file(php.ini) then find the 'post_max_size' by scrolling down or simply press ctrl+f to search it directly then find the following lines and pass these values.

```
post_max_size = 100M
```

and then find 'upload_max_filesize' and pass the below value:

```
upload_max_filesize=100M
```

and now save the file and close it.

Finally Now you can run this project on xampp server without any error or issues.

### Project Contain

* Responsive Navigation Bar with Hamburger Menu
* Hero Section
* Student  Librarian Login page
* contact Section
* Librarian Signup page
* Student Admin page
* Book request page
* Book issue page
* Book return page
* Add Book page
* Add Student page
* Issue ID card page
* View all Book page
* Librarian Admin page
* Footer Section,etc

### Font Family
 
 * I have Used Google Fonts - `Poppins`.For Using this font copy below code and paste it in your project :
 
 ```html
 <!-- google font link  -->
 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
 ```

### Icons

```html
<!-- boxicon link -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<!-- fontawesome icon link -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
```

### Run Locally

To run **Library Management System** locally, run this command on your git bash:

Linux and macOS:

```bash
sudo git clone https://github.com/pawantech12/library-management-system.git
```

Windows:

```bash
git clone https://github.com/pawantech12/library-management-system.git
```

### Contact

If you want to contact with me you can reach me at [Instagram](https://www.instagram.com/codewithpawan/).

### License

This project is **Free To Use** and does not contains any license.

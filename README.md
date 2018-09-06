# GPControl
> Software for controlling and managing module controls of one or more systems.

## [ENGLISH]
GP-Control, or Project Manager, is intended to be software for controlling modules to be developed or corrected in a system.

When we work on one or more projects, we need to control what needs to be done, and what needs to be adjusted, so GP Control was born with this purpose, to organize and control the maintenance of these modules.

## [PORTUGUÊS]
O GP-Control, ou Gerenciador de projeto, visa ser um software para o controle de módulos a serem desenvolvidos ou corrigidos de um sistema. 

Quando trabalhamos em um ou mais projetos, precisamos controlar o que precisa ser feito, e o que precisa ser ajustado, então, o GP Control nasceu com esse propósito, de organizar e controlar a manutenção desses módulos.
Para o manual em português, consulte o arquivo Instalação.pdf

## Installation

### Pages
index.php - Page for the user to authenticate.
panel.php - Protected page, all other pages and application features here.

### Database
Before starting the application, it is necessary to specify the connection information with the MariaDB database, so access the following file **App\DB\Banco.php**.
Change the values of the variables according to the specifications of your data server.

**debug** = True or False = Informs whether or not to display errors when display  
**server** = Database server path  
**user** = Database user  
**password** = Database password  
**database** = Name of database  

### Email Server
It is possible to send an email to all those involved in the discussion of a module, so just change the **$sendMailNotification** variable, which is in the **View\ModuloView\ModModulo.php** file **line 8**. This variable receives two values, which are true and false, by default the value is true.
To send the messages, you need to configure the **App\Util\MailSend.php** file, but first you must have an e-mail server and **SMTP protocol access**.
Change the following constants according to your server.  

**host**  = Email server address  
**port** = Server output port (587, 865, 25 ...)  
**user** = E-mail / User that will send  
**pass** = Password of the email / sending user
**From** = E-mail that will appear as rementente  
**applicationName** = Sender's name  

### Default user and password
After all the settings, it is necessary to run the following SQL in PHPMyAdmin:  
> INSERT INTO 'user' (' cod', 'name',' email', 'password',' status', 'allow'',' data') VALUES (NULL, 'A dmin', 'admin@admin.com' , 'F6ba855ff45ea7c2734cd54d62d8bb02', '1', '1', '2018-09-06 00:00:00');

**E-mail access:** admin@admin.com  
**Password:** a12345z, in lowercase  
**Status:** = Active  
**Permission:** - Administrator  



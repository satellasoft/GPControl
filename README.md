# GPControl
> Software for controlling and managing module controls of one or more systems.

## [ENGLISH]
GP-Control, or Project Manager, is intended to be software for controlling modules to be developed or corrected in a system.

When we work on one or more projects, we need to control what needs to be done, and what needs to be adjusted, so GP Control was born with this purpose, to organize and control the maintenance of these modules.

## [PORTUGUÊS]
O GP-Control, ou Gerenciador de projeto, visa ser um software para o controle de módulos a serem desenvolvidos ou corrigidos de um sistema. 

Quando trabalhamos em um ou mais projetos, precisamos controlar o que precisa ser feito, e o que precisa ser ajustado, então, o GP Control nasceu com esse propósito, de organizar e controlar a manutenção desses módulos.


## Instalação
Para o manual em português, consulte o arquivo Instalação..pdf

## Installation

## Pages
index.php - Page for the user to authenticate.
panel.php - Protected page, all other pages and application features here.

## Database
Before starting the application, it is necessary to specify the connection information with the MariaDB database, so access the following file **App\DB\Banco.php**.
Change the values of the variables according to the specifications of your data server.

debug = True or False = Informs whether or not to display errors when display
server = Database server path
user = Database user
password = Database password
database = Name of database

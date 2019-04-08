# Setup

## Environment

**PHP**: 7.2.1+  
**Apache2**: 2.4.2+

*Note*: *If project is not in same directory as document root, you will need to modify the .htaccess file*

ex:

If your document root is `var/www/`  
and your site directory is `var/www/CamProject`  

Then modify the following lines in the *.htaccess*:  
`#SetEnv APP_ROOT_PATH /`  
`RewriteEngine On`  
`RewriteBase /`  

to

`SetEnv APP_ROOT_PATH /CamProject`  
`RewriteEngine On`  
`RewriteBase /CamProject/`  

## Accounts

To generate accounts you can execute **setup.sh** in the **Utilities** directory.

The script will generate a file named *data.json* with a list of username and passwordHash pairs

In order to use the data.json file, you must place it in the **DAL** directory. 

The existing file should have one entry with the following info:

**Username:** `Test`

**Password:** `password`

Here's an example of what you will see in the console when executing the script (including input):

`Do you wish to clear data (y/n)y`

`Username (Enter nothing to exit):Test`

`Password:`

`Password (Confirm):`

`Username (Enter nothing to exit):`

password input is hidden while typing. 

## Settings  
Modify the **config.json** to set the *max login attempts* and the *lockout time* if that number is exceeded. 

 
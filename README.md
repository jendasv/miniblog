# Miniblog
miniblog project - good start for bigger one

Before use study PHPAuth package!

External technology
-------------------
* PHPAuth


Info
-----
* open project, take it and do whatever you want
* roles working but default role is 'user', change role is possible in database (table phpauth_users)
* admin email is 'terminator@gmail' and password is '1234', you can change password in user settings if you are logged in app
* email activation - off (you can change it in config.php but you need smpt server), true (activation by email and reset password)

Features
-------------
1. register, login, logout
2. write, edit, delete post 
3. comment post
4. set your email, username, change password
5. for admin - delete user
6. for admin and editor - delete and edit all posts; create, edit and delete all tags
7. for user - delete, edit and create own post

## how to get this blog working?
1. in folder _inc unzip vendor.zip inside (folder vendor must be inside)
2. import miniblog.sql to you db server
3. in file _inc/config.php set your base url or localhost adress (for example http://localhost/miniblog)
4. .htaccess set the root folder (for example /miniblog/) 
5. in file _inc/config.php check database settings array with yours data
6. NEVER EVER EXECUTE COMPOSER UPDATE!!!!! I have made changes PHPAuth, if you want to use another technology make backup of it!!!!

Enjoy it!

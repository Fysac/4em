# 4em

### Features

* Create, view, and reply to threads
* Upload profile picture
* Change username and password

### Security

~~* Passwords hashed and salted using standard PHP functions~~
~~* User input sanitized against XSS and SQL injection~~

### Setting up

4em was developed and tested on a LAMP stack, but any environment with PHP and MySQL support should work.

1. Execute `create_database.sql` to build the database and necessary structures

2. Edit `inc/config.php` with your database settings

### Disclaimer

This is not secure.

~~The bulk of this code was written when I was much younger and less experienced. While I've done my best to patch the obvious holes, there are likely to be other flaws ranging in severity.~~

~~Although it's a decent codebase to learn from, ~~

I would highly advise against using 4em for anything serious.~~

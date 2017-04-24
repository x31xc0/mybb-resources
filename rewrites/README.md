
# Rewrites

The URL rewrites provided are to make the URLs on a forum look more appealing. They are very time consuming to setup, having to change a lot of parts of a theme to make them work properly, so they shouldn't be used by anyone not dedicated enough for the work.

Provided is the Apache and NGINX versions of the rewrites.

# Apache

If you're using apache, you can add the rewrites to your .htaccess file or configuration file. .htaccess slows down the webserver quite a bit, so if you can, try to use the apache config file (location of this file may vary between operating systems).

If you need to use .htaccess, and one hasn't been created otherwise, then just rename "apache-rewrites.txt" to ".htaccess" in your MyBB root folder. Otherwise, just copy and paste the contents of the file into the bottom of your existing .htaccess file.

Configuration files can be a little bit more tricky, but simple copy them into the <Directory> entry in your configuration file.

# NGINX

NGINX is a bit more limited in that you only have the option to use the configuration file for the site in question. Simply add the lines in "nginx-rewrites.txt" into your configuration file. More skilled webmasters should know where their configuration file is, and because NGINX is a bit more flexible in where the config file for any given site can be, that's up to you to find out. Put it in the server block.

# Broken pages

If you have broken pages, which is very likely that you will, the easiest and quickest way to fix a broken page is to use the BBURL variable in a theme template. Be sure that any and all forms have their location set to use the BBURL variable as well, as these rewrites can be pretty nasty to forms that aren't written to accomodate for rewrites such as these. If you bought a theme from a business or company, or person even, you could try asking them to help you (we don't and can't guarantee that they will, or will free of charge even).

Example:

`<a href="/index.php">Example</a>`

`<a href="{$mybb->settings['bburl']}/index/">Example</a>`


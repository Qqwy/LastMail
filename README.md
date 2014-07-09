Last Mail
=========


LastMail is the world's first passive post-mortem message system. It lets you send a good-bye to your friends and contacts, and pass on your (digital) belongings.

It can be found at https://last-mail.org

**Why is this important?**

I see two important uses for LastMail

1. To send a final message to your digital contacts.
	In this 21st century age, we have lots of contacts through the internet. Often, our family does not have a clear picture of who these people are. 
	So that's why it might be a better idea to send such a message yourself. 
	
	Of course, this also means that you can leave a final kind wish for them. (or, if you really really want to, an evil sneer)

2. To have a secure way to pass on your digital belongings.
	This is where Bitcoin comes in.
	Current systems of passing on belongings rely on a human to actually pass on these things.
	This works well with physical objects, as there always is very clear evidence when they disappear.
	
	With Bitcoin wallets, this is not the case. It is extremely easy for someone to copy over some of your coins to another wallet before presenting your next of kin your inheritance.
	
	Thus, why not eliminate this human factor all-together?
	
	
	When using last-mail.org, the only human you need to trust is me, the site owner.
	
	Don't trust me? Not a problem, you can instead grab the source from GitHub, and host a version of the site for yourself.
	(The source can be found at 
	
	
**How does LastMail check if users are still alive?**

LastMail checks if its users are still active by sending them an email regularly.
Included in this email is an image. When users open the mail and the image is loaded, this lets the server know that you still are alive.

Thus, activity checking is passive: all the user needs to do is to read their mail.
(For mail programs that don't like HTML content, there's also a link to use instead of the image, of course. )


When a user does not check their mail for a very long amount of time, (The exact amount is configurable by the user) the system decides that the user, or at least this identity of the user, is not alive anymore.
LastMail then goes ahead and sends out the Last Mails that the user wrote before.











**Setting up the LastMail source for yourself**

1. Download the latest source from GitHub
2. Upload this source to your own web host, using FTP.
	Things LastMail needs on this host:
		-PHP 5.3 or higher.
		-MySQL or a similar SQL database.
		-The ability to send mails from this server, using the PHP mail() command.
		-The ability to set up a Cron job to run a PHP script every few hours.
		
3. Change the settings in config.php to your liking.
4. Change the sender address and root url in mailfunctions.php to be correct for your host.
5. Go to your Cron jobs, and make a new job that runs every hour:
	The exact code to provide is this:

		Time:  0 * * * *
		
		Command: cd /path_from/server_root/to_lastmail_folder/cron/ && /usr/local/bin/php cronmail.php
		
			(Note that the second part, "/usr/local/bin/php"  should be the place where your PHP installation is stored. For most servers, the given location is correct)

		
6. Re-style the pages as you want.
7. Note that the site is much safer using an SSL (https) connection. If you can get hold of a SSL certificate and install it on the server, that would be great for security.
	When using SSL/HTTPS
	-Make sure that updaterimage.php is located in the public_html folder, e.g. can be visited over normal http.
	-Make sure that the $ROOT_URL_UNSAFE is set properly in mailfunctions.php for the image to work.
	-Make sure that in updaterimage.php, $relloc is set to point to the folder which all other code is in.

You're now ready to rock and roll!



**Version History**

1.2 	- Move Cron scripts out of the public folder.
	- Pages don't show content anymore after displaying a relocation header when user needs to log in.

1.1 	- Many fixes to work with properly under SSL.

1.0 	- First released version.

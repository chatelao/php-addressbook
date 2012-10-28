* EXCERPT from Wikipedia

An Identicon is a visual representation of a hash value, usually of the
IP address, serving to identify a user of a computer system. The
original Identicon is a 9-block graphic, which has been extended to
other graphic forms by third parties some of whom have used MD5 instead
of the IP address as the identifier. In summary, an Identicon is a
privacy protecting derivative of each user's IP address built into a
9-block image and displayed next the user's name. A visual
representation is thought to be easier to compare than one which uses
only numbers and more importantly, it maintains the person's privacy.
The Identicon graphic is unique since it's based on the users IP, but
it is not possible to recover the IP by looking at the Identicon.


* ABOUT PHP-Identicons

PHP-Identicons is a lightweight PHP implementation of Don Park's
original identicon code for visual representation of MD5 hash values.
The program uses the PHP GD library for image processing.

The code can be used to generate unique identicons, avatars, and
system-assigned images based on a user's e-mail address, user ID, etc.


* INSTALLATION

Simply save identicon.php somewhere accessible thru a Web URL.


* USAGE

PHP-Identicons requires the size (in pixels) and an MD5 hash of
anything that will uniquely identify a user - usually an e-mail address
or a user ID. You can also use MD5 hashes of IP addresses, but bear in
mind that NATed endpoints will usually have the same IP.

Insert the URL in your HTML image tag that looks something like:

<img src="path/to/identicon.php?size=48&hash=e4d909c290d0fb1ca068ffaddf22cbd0" />

And that's all there is to it!

If you're not satisfied with the millions of image variations that the
program generates, additional variation in final image can be done by
image rotation. Simply uncomment the following line in the program:
// $identicon=imagerotate($identicon,$angle,$bg);


* DONATIONS

If you find this program useful, please pass it along to your friends
or donate any amount you feel will motivate the contributor/s to make
the program better. Send your donations by following this link:

https://sourceforge.net/donate/index.php?group_id=271757#blurb


* RELEASE HISTORY

1.0.1
* Fixed bug where some hash values did not generate any sprites

1.0.0
* First production release

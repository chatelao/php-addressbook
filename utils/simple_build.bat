

set /P version="Enter the version: "
echo %version%

svn export svn://svn.code.sf.net/p/php-addressbook/code/trunk ../../addressbook
cscript simple_build_zip.vbs C:\Users\BLACKY\Desktop\all-in-one\addressbook C:\Users\BLACKY\Desktop\all-in-one\addressbookv%verson%.zip

pause


set abs_zips=C:\Users\BLACKY\Desktop\all-in-one\addressbook
set abs_temp=%abs_zips%\addressbook

set /P version="Enter the version: "
echo %version%

rmdir %abs_zips% /s /q
mkdir %abs_zips%

REM svn export svn://svn.code.sf.net/p/php-addressbook/code/trunk %abs_temp%
svn export http://svn.github.com/chatelao/php-addressbook.git %abs_temp%

cscript simple_build_zip.vbs %abs_temp%\hybridauth %abs_temp%\hybridauth.zip
cscript simple_build_zip.vbs %abs_temp%\z-push     %abs_temp%\z-push.zip

rmdir %abs_temp%\jscalendar /s /q
rmdir %abs_temp%\utils      /s /q
rmdir %abs_temp%\test       /s /q

rmdir %abs_temp%\hybridauth /s /q
rmdir %abs_temp%\z-push /s /q

del %abs_temp%v%verson%.zip
cscript simple_build_zip.vbs %abs_temp%            %abs_zips%v%version%.zip

pause
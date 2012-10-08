

set abs_zips=C:\Users\BLACKY\Desktop\all-in-one\addressbook
set abs_temp=%abs_zipsabs_zips%\addressbook

set /P version="Enter the version: "
echo %version%

rmdir %abs_temp%

svn export svn://svn.code.sf.net/p/php-addressbook/code/trunk %abs_temp%

cscript simple_build_zip.vbs %abs_temp%\hybridauth %abs_temp%\hybridauth.zip
rmdir %abs_temp%\hybridauth /s /q

cscript simple_build_zip.vbs %abs_temp%\z-push     %abs_temp%\z-push.zip
rmdir %abs_temp%\z-push /s /q

rmdir %abs_temp%\jscalendar /s /q
rmdir %abs_temp%\test /s /q

del %abs_temp%v%verson%.zip
cscript simple_build_zip.vbs %abs_temp%            %abs_zips%v%version%.zip

pause
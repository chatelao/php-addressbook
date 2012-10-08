

set abs_zips=C:\Users\BLACKY\Desktop\all-in-one\addressbook
set abs_temp=%abs_zips%\addressbook

set /P version="Enter the version: "
echo %version%

rmdir %abs_zips% /s /q
mkdir %abs_zips%

REM
REM get the newest sources from subversion
REM 
svn export http://svn.github.com/chatelao/php-addressbook.git %abs_temp%

REM
REM zip and remove advanced featuers
REM 
cscript simple_build_zip.vbs %abs_temp%\hybridauth %abs_temp%\hybridauth.zip
cscript simple_build_zip.vbs %abs_temp%\z-push     %abs_temp%\z-push.zip

rmdir %abs_temp%\hybridauth /s /q
rmdir %abs_temp%\z-push /s /q

REM
REM remove all development folders
REM 
rmdir %abs_temp%\utils      /s /q
rmdir %abs_temp%\test       /s /q
rmdir %abs_temp%\jscalendar /s /q
del %abs_temp%\index.json.php
del %abs_temp%\doodle.php
del %abs_temp%\preferencs.php

del %abs_temp%v%verson%.zip
cscript simple_build_zip.vbs %abs_temp% addressbookv%version%.zip

pause
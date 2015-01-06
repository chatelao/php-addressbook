
set php=C:\xampp\php\php.exe 
set abs_zips=C:\Users\Olivier\Desktop\padr_build\php-addressbook

set /P version="Enter the version: "
echo %version%

rmdir %abs_zips% /s /q

REM
REM Get the newest sources from subversion
REM - See: http://stackoverflow.com/questions/1625406/using-tortoisesvn-via-the-command-line
REM - See: https://github.com/blog/966-improved-subversion-client-support
REM 
svn export https://github.com/chatelao/php-addressbook/trunk %abs_zips%

REM
REM Add the newest mobile configuration sample
REM 
copy .htaccess_mobile_sample %abs_zips%

REM
REM zip and remove advanced featuers
REM 
cscript simple_build_zip.vbs %abs_zips%\hybridauth %abs_zips%\hybridauth.zip
rmdir %abs_zips%\hybridauth /s /q
REM cscript simple_build_zip.vbs %abs_zips%\z-push     %abs_zips%\z-push.zip
REM rmdir %abs_zips%\z-push /s /q

REM
REM remove all development folders
REM 
rmdir %abs_zips%\utils      /s /q
rmdir %abs_zips%\test       /s /q
rmdir %abs_zips%\jscalendar /s /q
rmdir %abs_zips%\identicons /s /q
del %abs_zips%\index.json.php
del %abs_zips%\doodle.php
del %abs_zips%\preferencs.php
del %abs_zips%\translate.php
del %abs_zips%\translate_inc_to_po.php

echo ^<?php $version = '%version%'; ?^>>> %abs_zips%\include\version.inc.php

REM
REM Zip all files
REM
del %abs_zips%.zip
cscript zip.vbs %abs_zips%.zip %abs_zips%

REM
REM Create selfextracting installer
REM
del                          %abs_zips%_install.php
copy selfextractor.php       %abs_zips%_install.php
base64.exe %abs_zips%.zip >> %abs_zips%_install.php

REM
REM Create the final .zip package
REM
del %abs_zips%v%version%.zip
cscript zip.vbs %abs_zips%v%version%.zip %abs_zips%.zip %abs_zips%_install.php %~dp0install.txt

pause

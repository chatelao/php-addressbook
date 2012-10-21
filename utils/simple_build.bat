
set abs_zips=C:\Users\BLACKY\Desktop\all-in-one\addressbook

set /P version="Enter the version: "
echo %version%

rmdir %abs_zips% /s /q

REM
REM get the newest sources from subversion
REM 
svn export http://svn.github.com/chatelao/php-addressbook.git %abs_zips%

REM
REM zip and remove advanced featuers
REM 
cscript simple_build_zip.vbs %abs_zips%\hybridauth %abs_zips%\hybridauth.zip
cscript simple_build_zip.vbs %abs_zips%\z-push     %abs_zips%\z-push.zip

rmdir %abs_zips%\hybridauth /s /q
rmdir %abs_zips%\z-push /s /q

REM
REM remove all development folders
REM 
rmdir %abs_zips%\utils      /s /q
rmdir %abs_zips%\test       /s /q
rmdir %abs_zips%\jscalendar /s /q
del %abs_zips%\index.json.php
del %abs_zips%\doodle.php
del %abs_zips%\preferencs.php

echo ^<?php $version = '%version%'; ?^> >> %abs_zips%\include\version.inc.php

del %abs_zips%v%verson%.zip
cscript simple_build_zip.vbs %abs_zips% %abs_zips%v%version%.zip

pause
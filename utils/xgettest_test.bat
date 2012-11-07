
pushd C:\xampp\htdocs\php-addressbook\translations

%~dp0gettext\bin\msgfmt.exe php-addressbook-no.po -o LOCALES\no\LC_MESSAGES\php-addressbook.mo
%~dp0gettext\bin\msgfmt.exe php-addressbook-ua.po -o LOCALES\ua\LC_MESSAGES\php-addressbook.mo

popd

pause
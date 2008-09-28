<?php

$default_lang   = 'en';
$supported_langs[] = 'en';
$supported_langs[] = 'de';

$messages['JANUARY']['en'] = 'January';
$messages['JANUARY']['de'] = 'Januar';

$messages['FEBRUARY']['en'] = 'February';
$messages['FEBRUARY']['de'] = 'Februar';

$messages['MARCH']['en'] = 'March';
$messages['MARCH']['de'] = 'März';

$messages['APRIL']['en'] = 'April';
$messages['APRIL']['de'] = 'April';

$messages['MAY']['en'] = 'May';
$messages['MAY']['de'] = 'Mai';

$messages['JULY']['en'] = 'July';
$messages['JULY']['de'] = 'Juli';

$messages['JUNE']['en'] = 'June';
$messages['JUNE']['de'] = 'Juni';

$messages['AUGUST']['en'] = 'August';
$messages['AUGUST']['de'] = 'August';

$messages['SEPTEMBER']['en'] = 'September';
$messages['SEPTEMBER']['de'] = 'September';

$messages['OCTOBER']['en'] = 'October';
$messages['OCTOBER']['de'] = 'Oktober';

$messages['NOVEMBER']['en'] = 'November';
$messages['NOVEMBER']['de'] = 'November';

$messages['DECEMBER']['en'] = 'December';
$messages['DECEMBER']['de'] = 'Dezember';



$messages['ADDRESS_BOOK']['en'] = 'address book';
$messages['ADDRESS_BOOK']['de'] = 'Addressbuch';

$messages['ADDRESS_BOOK']['en'] = 'address book';
$messages['ADDRESS_BOOK']['de'] = 'Addressbuch';

$messages['ADDRESS_BOOK']['en'] = 'address book';
$messages['ADDRESS_BOOK']['de'] = 'Addressbuch';

$messages['ADDRESS_BOOK']['en'] = 'address book';
$messages['ADDRESS_BOOK']['de'] = 'Addressbuch';



$messages['ADDRESS_BOOK']['en'] = 'address book';
$messages['ADDRESS_BOOK']['de'] = 'Addressbuch';

$messages['SEARCH']['en'] = 'search';
$messages['SEARCH']['de'] = 'suchen';

$messages['HOME']['en'] = 'home';
$messages['HOME']['de'] = 'Hauptseite';

$messages['NEXT_BIRTHDAYS']['en'] = 'next birthdays';
$messages['NEXT_BIRTHDAYS']['de'] = 'Geburtstage';

$messages['ADD_NEW']['en'] = 'add new';
$messages['ADD_NEW']['de'] = 'Neuer Eintrag';

$messages['PRINT_ALL']['en'] = 'print all';
$messages['PRINT_ALL']['de'] = 'Alle drucken';

$messages['PRINT_PHONES']['en'] = 'print phones';
$messages['PRINT_PHONES']['de'] = 'Telefonliste';

$messages['EXPORT_CSV']['en'] = 'export csv';
$messages['EXPORT_CSV']['de'] = 'CSV exportieren';

$messages['MANAGE_GROUPS']['en'] = 'manage groups';
$messages['MANAGE_GROUPS']['de'] = 'Gruppen';

$messages['SEARCH_FOR_ANY_TEXT']['en'] = 'search for any text';
$messages['SEARCH_FOR_ANY_TEXT']['de'] = 'Freitextsuche';

$messages['NUMBER_OF_RESULTS']['en'] = 'Number of results';
$messages['NUMBER_OF_RESULTS']['de'] = 'Suchtreffer';

$messages['ALL']['en'] = 'all';
$messages['ALL']['de'] = 'Alle';

$messages['NONE']['en'] = 'none';
$messages['NONE']['de'] = 'Keine';

$messages['NUMBER_OF_RESULTS']['en'] = 'Number of results';
$messages['NUMBER_OF_RESULTS']['de'] = 'Anzahl Treffer';

$messages['SELECT_ALL']['en'] = 'select all';
$messages['SELECT_ALL']['de'] = 'alles';

$messages['REMOVE_FROM']['en'] = 'remove from';
$messages['REMOVE_FROM']['de'] = 'entfernen aus';

$messages['REMOVE_FROM']['en'] = 'remove from';
$messages['REMOVE_FROM']['de'] = 'entfernen aus';

$messages['SEND_EMAIL']['en'] = 'Send e-Mail';
$messages['SEND_EMAIL']['de'] = 'E-Mail senden';

$messages['ADD_TO']['en'] = 'add to';
$messages['ADD_TO']['de'] = 'Hinzufügen zu';

$messages['DETAILS']['en'] = 'details';
$messages['DETAILS']['de'] = 'Details';

$messages['EDIT']['en'] = 'edit';
$messages['EDIT']['de'] = 'ändern';

$messages['MODIFY']['en'] = 'modify';
$messages['MODIFY']['de'] = 'anpassen';

$messages['PRINT']['en'] = 'print';
$messages['PRINT']['de'] = 'drucken';

$messages['EDIT_ADD_ENTRY']['en'] = 'Edit / add address book entry';
$messages['EDIT_ADD_ENTRY']['de'] = 'Eintrag erstellen / ändern';

$messages['GUESSED_HOMEPAGE']['en'] = 'Guessed homepage';
$messages['GUESSED_HOMEPAGE']['de'] = 'Mögliche Homepage';

$messages['FIRSTNAME']['en'] = 'firstname';
$messages['FIRSTNAME']['de'] = 'Vorname';

$messages['LASTNAME']['en'] = 'lastname';
$messages['LASTNAME']['de'] = 'Nachname';

$messages['ADDRESS']['en'] = 'address';
$messages['ADDRESS']['de'] = 'Adresse';

$messages['TELEPHONE']['en'] = 'telephone';
$messages['TELEPHONE']['de'] = 'Telefonnr.';

$messages['PHONE_HOME']['en'] = 'home';
$messages['PHONE_HOME']['de'] = 'Privat';

$messages['PHONE_MOBILE']['en'] = 'mobile';
$messages['PHONE_MOBILE']['de'] = 'Mobil';

$messages['PHONE_WORK']['en'] = 'work';
$messages['PHONE_WORK']['de'] = 'Geschäft';

$messages['EMAIL']['en'] = 'e-mail';
$messages['EMAIL']['de'] = 'e-Mail';

$messages['BIRTHDAY']['en'] = 'birthday';
$messages['BIRTHDAY']['de'] = 'Geburtstag';

$messages['UPDATE']['en'] = 'update';
$messages['UPDATE']['de'] = 'aktualisieren';

$messages['DELETE']['en'] = 'delete';
$messages['DELETE']['de'] = 'löschen';

$messages['ENTER']['en'] = 'enter';
$messages['ENTER']['de'] = 'speichern';

$messages['MEMBER_OF']['en'] = 'member of';
$messages['MEMBER_OF']['de'] = 'Mitglied';

$messages['SECONDARY']['en'] = 'Secondary';
$messages['SECONDARY']['de'] = 'Zweitadresse';

$messages['H:']['en'] = 'H:';
$messages['H:']['de'] = 'P:';

$messages['M:']['en'] = 'M:';
$messages['M:']['de'] = 'M:';

$messages['W:']['en'] = 'W:';
$messages['W:']['de'] = 'G:';

//
// Auto-Detect best possible language
//
if($lang == 'auto') {

  // Try to use the browser's wish
  $lang_variable = strtolower( $_SERVER['HTTP_ACCEPT_LANGUAGE'] );
  $accepted_languages = split('[,:=-]', $lang_variable);
  
  foreach($accepted_languages as $curr_lang)
  {
    if( array_search($curr_lang, $supported_langs) !== FALSE ) {
    	$select_lang = $curr_lang;
      break;
    }
    if(!isset($select_lang))
      $select_lang = $default_lang;
  }
  $lang = $select_lang;
}


function msg($value)
{
	global $lang, $messages;
		
	if(isset($messages[$value][$lang])) {
	  return $messages[$value][$lang];
	} else {
	  return $value;
	}
}

function ucfmsg($value) {
	
	$msg = msg($value);
	return mb_strtoupper($msg[0]).substr($msg, 1);
	
}
?>
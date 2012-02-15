<?php

require_once('simpletest/autorun.php');

$address_parse = array();
$new_address   = array();

$new_address['text'] =
"Lenkerhof alpine resort

Badstrasse 20
3775 Lenk im Simmental
Tel.: +41 (0) 33 736 3636
Fax.: +41 (0) 33 736 3637
welcome@lenkerhof.ch
http://www.lenkerhof.ch ";

$new_address['addr'] = array(
  "firstname" => "Lenkerhof"
, "lastname"  => "alpine resort"
, "address"   => "Badstrasse 20\n3775 Lenk im Simmental"
, "email"     => "welcome@lenkerhof.ch"
, "work"      => "+41 (0) 33 736 3636"
, "fax"       => "+41 (0) 33 736 3637"
, "homepage"  => "www.lenkerhof.ch"
);
$address_parse[] = $new_address;


$new_address['text'] =
"HOTEL & RESORT FÜNFJAHRESZEITEN
Auf dem Köpfle 1-6
D-79682 Todtmoos im Schwarzwald
Tel. 0049 (0)7674 924 0
Fax 0049 (0)7674 924 100
E-Mail: info@hotel-fuenfjahreszeiten.de ";
$new_address['addr'] = array(
  "company"   => "HOTEL & RESORT FÜNFJAHRESZEITEN"
, "address"   => "Auf dem Köpfle 1-6
D-79682 Todtmoos im Schwarzwald"
, "email"     => "info@hotel-fuenfjahreszeiten.de"
, "work"      => "0049 (0)7674 924 0"
, "fax"       => "0049 (0)7674 924 100"
);
$address_parse[] = $new_address;

$new_address['text'] =
"SCHLOSS SCHADAU
Seestrasse 45 * CH-3600 Thun
Tel: +41(0)33 222 25 00
Fax: +41(0)33 222 15 80
info@schloss-schadau.ch";
$new_address['addr'] = array(
  "firstname" => "SCHLOSS"
, "lastname"  => "SCHADAU"
, "address"   => "Seestrasse 45
CH-3600 Thun"
, "email"     => "info@schloss-schadau.ch"
, "work"      => "+41(0)33 222 25 00"
, "fax"       => "+41(0)33 222 15 80"
);
$address_parse[] = $new_address;


$new_address['text'] =
"Max Muster-Sample
A Job
A Title

The-Corp (Schweiz) GmbH
Some Location Hinterfultigen
Telefon +41 (0)58 792 12 00 | Fax +41 (0)58 792 12 25
Telefon +41 (0)58 792 12 23 | max.muster@corp.ch
Sommestrasse 160 | 3089 Hinterfultigen | Switzerland  | 
www.corp.com";

$new_address['addr'] = array(
  "firstname" => "Max"
, "lastname"  => "Muster-Sample"
, "company"   => "The-Corp (Schweiz) GmbH"
, "address"   => "A Job
A Title
Some Location Hinterfultigen
Sommestrasse 160
3089 Hinterfultigen
Switzerland"
, "work"   => "+41 (0)58 792 12 00"
, "fax"    => "+41 (0)58 792 12 25"
, "phone2" => "+41 (0)58 792 12 23"
, "email"     => "max.muster@corp.ch"
);
$address_parse[] = $new_address;


$new_address['text'] =
"Max Muster
One and Another, Senior Manager
MyCompany AG
Sommestr. 160
CH-3089 Hinterfultigen

Direct phone: +41 58 792 12 23
Main phone: +41 58 792 12 00
Mobile phone: +41 79 112 12 23
Facsimile: +41 58 792 12 25

mailto:max.muster@ch.corp.com
Visit us at www.corp.ch/div";
$new_address['addr'] = array(
  "firstname" => "Max"
, "lastname"  => "Muster"
, "company"   => "MyCompany AG"
, "address"   => "Sommestrasse 160a
3089 Hinterfultigen"
, "email"     => "max.muster@ch.corp.com"
, "work"   => "+41 58 792 12 23"
, "mobile" => "+41 79 112 12 23"
, "fax"    => "+41 58 792 12 25"
, "phone2" => "+41 58 792 12 00"
);
$address_parse[] = $new_address;

$new_address['text'] =
"My Company
Sommestrasse 160a
3089 Hinterfultigen
Natel: 079 112 12 23
Mail: info@comp.ch";
$new_address['addr'] = array(
  "firstname" => "My"
, "lastname"  => "Company"
, "address"   => "Sommestrasse 160a
3089 Hinterfultigen"
, "email"     => "info@comp.ch"
, "mobile"    => "079 112 12 23"
);
$address_parse[] = $new_address;

$new_address['text'] =
"----------------------------------------------------------
   Max Muster Sample
   Sommestrasse 160, 3089 Hinterfultigen, Switzerland
   Home: +41 (0) 31 371 86 69
   Office: +41 (0) 31 666 52 45
   Mailto:m.muster@organization.org
----------------------------------------------------------";
$new_address['addr'] = array(
  "firstname" => "Max"
, "lastname"  => "Muster Sample"
, "address"   => "Sommestrasse 160
3089 Hinterfultigen
Switzerland"
, "home"  => "+41 (0) 58 792 12 22"
, "work"  => "+41 (0) 58 792 12 23"
, "email" => "m.muster@organization.org"
);
$address_parse[] = $new_address;

$new_address['text'] =
"Max Muster 
 
Max Muster, lic. iur., Advokat
Stv. Leiter
Abteilung Sonstiges und Diverses
________________________________________________
Spezialdepartement
Sommestrasse 160a | CH-3089 Hinterfultigen
fon +41 58 792 12 23  | fax +41 58 792 12 25
max.muster@area.ch | www.department.area.ch ";
$new_address['addr'] = array(
  "company"   => "STIT.CH GmbH"
, "address"   => "Gaselweidstrasse 37
3144 Gasel"
, "work"  => "+41 58 792 12 23"
, "fax"   => "+41 58 792 12 25"
);
$address_parse[] = $new_address;

$new_address['text'] =
"STIT.CH GmbH
Gaselweidstrasse 37
3144 Gasel
Telefon +41 31 972 40 45
Fax      +41 31 972 94 27";
$new_address['addr'] = array(
  "company"   => "STIT.CH GmbH"
, "address"   => "Gaselweidstrasse 37
3144 Gasel"
, "home"  => "+41 31 972 40 45"
, "work"  => "+41 31 972 94 27"
);
$address_parse[] = $new_address;

$new_address['text'] =
"Restaurant Dählhölzli - Tierparkweg 2 - 3005 Bern - Telefon 031 351 18 94 - Telefax 031 351 71 41 - info@daehlhoelzli.ch - www.daehlhoelzli.ch";
$new_address['addr'] = array(
  "company"   => "Restaurant Dählhölzli"
, "address"   => "Tierparkweg 2
3005 Bern"
, "work"     => "031 351 18 94"
, "fax"      => "031 351 71 41"
, "email"    => "info@daehlhoelzli.ch"
, "homepage" => "www.daehlhoelzli.ch"
);
$address_parse[] = $new_address;

$new_address['text'] =
"Muster Max

Sommestrasse 160a, 3089 Hinterfultigen
Tel p 058 792 12 22
Tel g 058 792 12 23
Tel m 079 792 12 23
Fax 058 792 12 25
info@mycorp.com";
$new_address['addr'] = array(
  "firstname" => "Neuenschwander"
, "lastname"  => "Andrea"
, "address"   => "Bielstrasse 45
3270 Aarberg"
, "home"     => "032 392 64 65"
, "work"     => "031 632 11 82"
, "cell"     => "079 453 25 35"
, "fax"      => "032 392 64 65"
, "email"    => "anad@bluewin.ch"
);
$address_parse[] = $new_address;

$new_address['text'] =
"Bremgartenfriedhof
Murtenstrasse 51
3008 Bern

 058 792 12 23
 058 792 12 25
department.division@area.ch";
$new_address['addr'] = array(
  "firstname" => "Neuenschwander"
, "lastname"  => "Andrea"
, "address"   => "Bielstrasse 45
3270 Aarberg"
, "home"     => "032 392 64 65"
, "work"     => "031 632 11 82"
, "cell"     => "079 453 25 35"
, "fax"      => "032 392 64 65"
, "email"    => "department.division@area.ch"
);
$address_parse[] = $new_address;

include "include/guess.inc.php";

class TestOfAddressParse extends UnitTestCase {
	
	 function testAddressParsing() {
	 	
	 	global $address_parse;
     
     // print_r($address_parse);

     foreach($address_parse as $address_parse_element) {
     	 $expected =                    $address_parse_element['addr'];
     	 $result   = guessAddressFields($address_parse_element['text']);
     	 
     	 // ksort($expected);
     	 // ksort($result);

     	 $diff = array_merge( array_diff($expected, $result)
     	                    , array_diff($result, $expected));
     
       if(count($diff) != 0) {
     	   print_r($expected);
     	   print_r($result);

     	   print_r($diff);
       }

       // $this->assert($expected, $result, "gaga");
       $this->assertTrue(count($diff) == 0);
     }
   }
}
?>
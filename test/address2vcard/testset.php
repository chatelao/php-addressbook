<?php
$tests[0] = array( "input" => "Mayweg 17\n3007 Bern"
                 , "output" => array( "pbox"      => ""
                                    , "street"    => "Mayweg"
                                    , "street_nr" => "17"
                                    , "addr"      => "Mayweg 17"
                                    , "exta"      => ""
                                    , "zip"       => "3007"
                                    , "city"      => "Bern"
                                    , "region"    => ""
                                    , "country"   => ""
                                    )
                 );
      
$tests[1] = array( "input" => "Mayweg 17\nBern"
                 , "output" => array( "pbox"      => ""
                                    , "street"    => "Mayweg"
                                    , "street_nr" => "17"
                                    , "addr"      => "Mayweg 17"
                                    , "exta"      => ""
                                    , "zip"       => ""
                                    , "city"      => "Bern"
                                    , "region"    => ""
                                    , "country"   => ""
                                    )
                 );

$tests[2] = array( "input" => "Mayweg\n3007 Bern"
                 , "output" => array( "pbox"      => ""
                                    , "street"    => "Mayweg"
                                    , "street_nr" => ""
                                    , "addr"      => "Mayweg"
                                    , "exta"      => ""
                                    , "zip"       => "3007"
                                    , "city"      => "Bern"
                                    , "region"    => ""
                                    , "country"   => ""
                                    )
                 );

$tests[3] = array( "input" => "Mayweg\n3007 Bern\nSchweiz"
                 , "output" => array( "pbox"    => ""
                                    , "street"  => "Mayweg"
                                    , "exta"    => ""
                                    , "zip"     => "3007"
                                    , "city"    => "Bern"
                                    , "region"  => ""
                                    , "country" => "Schweiz"
                                    )
                 );

$tests[4] = array( "input" => "c/o bei Gugus\nMayweg 17\n3007 Bern\nSchweiz"
                 , "output" => array( "pbox"    => ""
                                    , "street"    => "Mayweg"
                                    , "street_nr" => "17"
                                    , "addr"      => "Mayweg 17"
                                    , "exta"    => "c/o bei Gugus"
                                    , "zip"     => "3007"
                                    , "city"    => "Bern"
                                    , "region"  => ""
                                    , "country" => "Schweiz"
                                    )
                 );

$tests[5] = array( "input" => ""
                 , "output" => array( "pbox"      => ""
                                    , "street"    => ""
                                    , "street_nr" => ""
                                    , "addr"      => ""
                                    , "exta"      => ""
                                    , "zip"       => ""
                                    , "city"      => ""
                                    , "region"    => ""
                                    , "country"   => ""
                                    )
                 );
$tests[6] = array( "input" => "Holzweg 2\n6652 Marbach"
                 , "output" => array( "pbox"      => ""
                                    , "street"    => "Holzweg"
                                    , "street_nr" => "2"
                                    , "addr"      => "Holzweg 2"
                                    , "exta"      => ""
                                    , "zip"       => "6652"
                                    , "city"      => "Marbach"
                                    , "region"    => ""
                                    , "country"   => ""
                                    )
                 );
$tests[7] = array( "input" => "3 rue du test\n43632 St. Experience"
                 , "output" => array( "pbox"      => ""
                                    , "street"    => "rue du test"
                                    , "street_nr" => "3"
                                    , "addr"      => "3 rue du test"
                                    , "exta"      => ""
                                    , "zip"       => "43632"
                                    , "city"      => "St. Experience"
                                    , "region"    => ""
                                    , "country"   => ""
                                    )
                 );
                 
$tests[8] = array( "input" => "75 Ninth Avenue 2nd and 4th Floors\nNew York, NY 10011"
                 , "output" => array( "pbox"      => ""
                                    , "street"    => "Ninth Avenue 2nd and 4th Floors"
                                    , "street_nr" => "75"
                                    , "addr"      => "75 Ninth Avenue 2nd and 4th Floors"
                                    , "exta"      => ""
                                    , "zip"       => "10011"
                                    , "city"      => "New York, NY"
                                    , "region"    => ""
                                    , "country"   => ""
                                    )
                 );
?>
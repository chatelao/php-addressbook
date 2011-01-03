<?php
$tests[0] = array( "input" => "utf-16_sample.vcf"
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
$tests[1] = array( "input" => "Sample_Person-Apple_Address_Book.vcf"
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
?>
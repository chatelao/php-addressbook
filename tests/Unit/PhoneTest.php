<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Address;

require_once __DIR__ . '/../../include/address.class.php';

class PhoneTest extends TestCase
{
    public function testUnifyPhoneNumber(): void
    {
        $test_prefix = '+39';

        $addr_data = [
            ['home' => '0385239233'],
            ['home' => '038 523 92 33'],
            ['home' => '038-523-92-33'],
            ['home' => '0039 38 523 92 33'],
            ['home' => '0039 38 523 92 33'],
            ['home' => '+39385239233'],
            ['home' => '+39 38 523 92 33'],
            ['home' => '+39 (0) 38 523 92 33'],
            ['home' => '+39 0 38 523 92 33'],
        ];

        $addresses = [];
        foreach ($addr_data as $data) {
            $addresses[] = new Address($data);
        }

        // Test the unification of the phone numbers with extension
        foreach ($addresses as $i => $address) {
            $this->assertEquals(
                $addr_data[5]['home'],
                $address->unifyPhone($test_prefix),
                'Full unification failed for index ' . $i
            );
        }

        // Test the unification of the phone numbers without extension
        foreach ($addresses as $i => $address) {
            $this->assertEquals(
                $addr_data[0]['home'],
                $address->unifyPhone($test_prefix, true),
                'Short unification failed for index ' . $i
            );
        }

        // Test the shortification of the phone numbers
        for ($i = 0; $i <= 3; $i++) {
            $this->assertEquals(
                $addr_data[0]['home'],
                $addresses[$i]->shortPhone(),
                'Short number 0 failed for index ' . $i
            );
        }
        for ($i = 4; $i <= 8; $i++) {
            $this->assertEquals(
                $addr_data[4]['home'],
                $addresses[$i]->shortPhone(),
                'Short number 3 failed for index ' . $i
            );
        }
    }
}

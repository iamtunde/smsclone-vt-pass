<?php

namespace App\Helpers;

class Common {
    private function validate_with_dialcode($number) : bool {
        $valid_prefix_with_dialcode = ['23470', '23481', '23490', '23491', '23480'];

        if(str_contains($number, '+') == true) {
            $phone_number_string = ltrim($number, '+');
        } else {
            $phone_number_string = $number;
        }
        
        $prefix = substr($phone_number_string, 0, 5);
        
        if(in_array($prefix, $valid_prefix_with_dialcode) == true) {
            return true;
        } else {
            return false;
        }
    }
    
    private function validate_without_dialcode($number) : bool {
        $valid_prefix = ['070', '080', '081', '090', '091'];

        $prefix = substr($number, 0, 3);

        if(in_array($prefix, $valid_prefix) == true) {
            return true;
        } else {
            return false;
        }
    }

    public function normalise_phone_numbers($input) : array {
        $input = preg_replace('/\r\n|\r|\n/', ',', $input);
        $input2 = str_replace(' ', ',', $input);

        $array = explode(',', $input2);
    
        return $array;
    }

    public function validate_phone_numbers($numbers) {

        $valid_numbers = [];
        
        foreach ($numbers as $key => $number) {
            $first_character = substr($number, 0, 1);

            $validation = $first_character == '0' ? $this->validate_without_dialcode($number) : $this->validate_with_dialcode($number);
            
            if($validation) {
                array_push($valid_numbers, $number);
            }
        }

        return $valid_numbers;
    }

    public function adjust_phone_number($phone_number_string)
    {
        $first_character = substr($phone_number_string, 0, 1);

        switch ($first_character) {
            case '0':
                $phone_number = ltrim($phone_number_string, "0");
                break;
            case '+':
                $phone_number = ltrim($phone_number_string, "+");
                break;
            default:
                $phone_number = $phone_number_string;
                break;
        }

        if(str_contains($phone_number, "234") === true) {
            $phone = $phone_number;
        } else {
            $phone = "234".$phone_number;
        }
        
        return $phone;
    }

    public function get_prices() : object {
        if(file_exists(storage_path('app/price-list.txt'))) {
            $pricing = file_get_contents(storage_path(('app/price-list.txt')));

            $array = explode(PHP_EOL, $pricing);

            $pricing = array_filter($array);
            
            $prices = [];

            foreach($pricing as $key => $item) {
                $element = explode('=', $item);
                
                $prices[$element[0]] = $element[1];
            }
            
            return (object)$prices;
        } else {
            return null;
        }
    }

    public function get_prefix_price($needle, $list) {
        foreach($list as $key => $item) {
            if($key == $needle) {
                return $item;
            }
        }
    }
}
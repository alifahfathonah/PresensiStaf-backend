<?php
namespace App\Helpers;

class MyHelper{
    public static function getDayIndo($dayname){
        switch ($dayname) {
            case 'Monday':
                return 'Senin';
                break;
            
            case 'Tuesday':
                return 'Selasa';
                break;
            
            case 'Wednesday':
                return 'Rabu';
                break;
            
            case 'Thursday':
                return 'Kamis';
                break;
            
            case 'Friday':
                return 'Jumat';
                break;
            
            case 'Saturday':
                return 'Sabtu';
                break;
            
            default:
                return 'Senin';
                break;
        }
    }
}
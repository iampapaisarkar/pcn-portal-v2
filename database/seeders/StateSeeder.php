<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = array(
        array('id' => '2','name' => 'ABIA','state_code' => 'AB'),
        array('id' => '3','name' => 'ADAMAWA','state_code' => 'AD'),
        array('id' => '4','name' => 'ANAMBRA','state_code' => 'AN'),
        array('id' => '5','name' => 'AKWA IBOM','state_code' => 'AI'),
        array('id' => '6','name' => 'BAUCHI','state_code' => 'BA'),
        array('id' => '7','name' => 'BAYELSA','state_code' => 'BA'),
        array('id' => '8','name' => 'BENUE','state_code' => 'BE'),
        array('id' => '9','name' => 'BORNO','state_code' => 'BO'),
        array('id' => '10','name' => 'CROSS RIVER','state_code' => 'CR'),
        array('id' => '11','name' => 'DELTA','state_code' => 'DE'),
        array('id' => '12','name' => 'EBONYI','state_code' => 'EB'),
        array('id' => '13','name' => 'ENUGU','state_code' => 'EN'),
        array('id' => '14','name' => 'EDO','state_code' => 'ED'),
        array('id' => '15','name' => 'EKITI','state_code' => 'EK'),
        array('id' => '16','name' => 'GOMBE','state_code' => 'GO'),
        array('id' => '17','name' => 'IMO','state_code' => 'IM'),
        array('id' => '18','name' => 'JIGAWA','state_code' => 'JI'),
        array('id' => '19','name' => 'KADUNA','state_code' => 'KA'),
        array('id' => '20','name' => 'KANO','state_code' => 'KA'),
        array('id' => '21','name' => 'KATSINA','state_code' => 'KA'),
        array('id' => '22','name' => 'KEBBI','state_code' => 'KE'),
        array('id' => '23','name' => 'KOGI','state_code' => 'KO'),
        array('id' => '24','name' => 'KWARA','state_code' => 'KW'),
        array('id' => '25','name' => 'LAGOS','state_code' => 'LA'),
        array('id' => '26','name' => 'NASARAWA','state_code' => 'NA'),
        array('id' => '27','name' => 'NIGER','state_code' => 'NI'),
        array('id' => '28','name' => 'OGUN','state_code' => 'OG'),
        array('id' => '29','name' => 'ONDO','state_code' => 'ON'),
        array('id' => '30','name' => 'OSUN','state_code' => 'OS'),
        array('id' => '31','name' => 'OYO','state_code' => 'OY'),
        array('id' => '32','name' => 'PLATEAU','state_code' => 'PL'),
        array('id' => '33','name' => 'RIVERS','state_code' => 'RI'),
        array('id' => '34','name' => 'SOKOTO','state_code' => 'SO'),
        array('id' => '35','name' => 'TARABA','state_code' => 'TA'),
        array('id' => '36','name' => 'YOBE','state_code' => 'YO'),
        array('id' => '37','name' => 'ZAMFARA','state_code' => 'ZA'),
        array('id' => '38','name' => 'FEDERAL CAPITAL TERRITORY (FCT)','state_code' => 'FCT')
        );

        State::insert($states);
    }
}

<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$this->call('HolidayTableSeeder');
		$this->call('UserTableSeeder');
	}

}

class UserTableSeeder extends Seeder{
	public function run(){
		DB::table('users')->delete();
		$user = new User();
		$user->name = "Dave Deepak";
		$user->email = "deepak.s@rubicoit.com";
		$user->password = Hash::make("admin");
		$user->employeeType = "ADMIN";
		$user->save();
	}
}

class HolidayTableSeeder extends Seeder{
	public function run(){
		DB::table('holidays')->delete();
		$monthCount = array(1 => 0,2 => 0,3 => 0,4 => 0,5 => 0,6 => 0,7 => 0,8 => 0,9 => 0,10 => 0,11 => 0,12 => 0);
		$monthNeeded = false;
		for($i=1;$i<=8;$i++){
			$holiday = new Holiday();
			$holiday->holidayDescription = "Test Holiday " . $i;
			$holiday->holidayType = "OPTIONAL";
			$year = date("Y");

			while(!$monthNeeded){
				$month = rand(1,12);
				if($monthCount[$month] < 2){
					$monthCount[$month] += 1;
					$monthNeeded = true;
					break;
				}
			}
			$monthNeeded = false;
			if($month != 2){
				$day = rand(1,30);
			}
			else{
				$day = rand(1,28);	
			}
			$holiday->holidayDate = date("Y-m-d",mktime(0,0,0,$month, $day, $year));
			$holiday->save();
		}
		
	}
}

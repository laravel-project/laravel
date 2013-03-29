<?php

class Seed_User_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//seed for user
    $now = date('Y-m-d H:i:s');
    $names = array('deden', 'ari', 'januar','firmanto');
    foreach( $names as $name ){
      DB::table('users')->insert(    
        array(
          'key_id'             => rand(268435456, 4294967295),
          'name'               => $name,
          'email'              => $name.'@laravel.com',
          'password'           => Hash::make('password'),
          'confirmated_at'     => $now,
          'can_reset_password' => false,
          'created_at'         => $now,
          'updated_at'         => $now
        )
      );
    }
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('users')->delete();
	}

}

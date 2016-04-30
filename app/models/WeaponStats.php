<?php

class WeaponStats extends Eloquent{

    protected $table = 'WEAPON_STATS';

    protected $timestamp = false;

    protected $fillable = [];

    public $timestamps = false;
   
	public static $supportedWeaponId = [
		// Ensure image for each id

		// Disabled: 17, 18
		1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 14, 15, 16, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 41, 42
	];

	public static $adminWeapons = [
		35, 36, 37, 38
	];

	public static $weaponNames = [
		"Fist", "Knuckle Duster", "Golf Club", "Baton", "Knife", "Baseball Bat", "Spade", "Pool Cue", "Katana", "Chainsaw", "Dildo", "Vibrator", "Dildo", "Dildo", 
		"Flowers", "Cane", "Grenade", "Teargas", "Molotov", "n/a", "n/a", "n/a", "9mm Pistol", "Silenced Pistol", "Desert Eagle", "Shotgun", "Sawn-off Shotgun",
		"Spas 12", "Mac 10", "MP5", "AK-47", "M4", "Tec 9", "Rifle", "Sniper", "RPG", "Heatseeker", "Flamer", "Minigun", "Remote Bomb", "Detonator", "Spray Paint", 
		"Extinguisher", "Camera", "Night Vision", "Thermal Vision", "Parachute", "Vehicle Gun", "Vehicle Bomb", "Vehicle"
	];

	public function scopeWhereValidWeapon($query) {
		return $query->whereIn('WEAPON_ID', self::$supportedWeaponId);
	}

	public function image() {
		return URL::asset("assets/img/weapons/{$this->WEAPON_ID}.png");
	}

	public function name() {
		return self::$weaponNames[$this->WEAPON_ID];
	}

	public function tops() {
		return $this->hasMany('WeaponStats', 'WEAPON_ID', 'WEAPON_ID')->has('user')->orderBy('KILLS', 'desc')->limit(3);
	}

	public function user() {
    	return $this->belongsTo('User', 'USER_ID', 'ID');
	}

}

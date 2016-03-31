<?php

class RankS1 extends Eloquent{

    protected $table = 'RANKS_S1';

    protected $timestamp = false;

    protected $fillable = [];

    public $timestamps = false;

    private static $rankData = [
        [ 5497.0, "Elite V" ],
        [ 3435.0, "Elite IV" ],
        [ 2147.0, "Elite III" ],
        [ 1342.0, "Elite II" ],
        [ 838.0, "Elite I" ],
        [ 524.0, "Silver V" ],
        [ 328.0, "Silver IV" ],
        [ 205.0, "Silver III" ],
        [ 128.0, "Silver II" ],
        [ 50.0, "Silver I" ],
        [ 0.0, "unranked" ]
    ];

    // Get irresistible rank
    public static function getIrresistibleRank($points) {
        for ($rank = 0; $rank < sizeof(self::$rankData); $rank++) {
            if ($points >= self::$rankData[$rank][0]) {
                break;
            }
        }

        return self::$rankData[$rank][1];
    }
}

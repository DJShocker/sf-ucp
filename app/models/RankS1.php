<?php

class RankS1 extends Eloquent{

    protected $table = 'RANKS_PREVIOUS';

    protected $timestamp = false;

    protected $fillable = [];

    public $timestamps = false;

    private static $oldRankData = [
        [ 9497.20, "Elite V" ],
        [ 5301.70, "Elite IV" ],
        [ 2959.61, "Elite III" ],
        [ 1652.17, "Elite II" ],
        [ 922.303, "Elite I" ],
        [ 514.865, "Silver V" ],
        [ 287.417, "Silver IV" ],
        [ 160.45, "Silver III" ],
        [ 89.56, "Silver II" ],
        [ 50.0, "Silver I" ],
        [ 0.0, "unranked" ]
    ];

    private static $rankData = [
        [ 11871.5, "Elite V" ],
        [ 6627.13, "Elite IV" ],
        [ 3699.51, "Elite III" ],
        [ 2065.21, "Elite II" ],
        [ 1152.88, "Elite I" ],
        [ 643.581, "Silver V" ],
        [ 359.271, "Silver IV" ],
        [ 200.563, "Silver III" ],
        [ 111.95, "Silver II" ],
        [ 62.5, "Silver I" ],
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

    // Get old irresistible rank
    public static function getOldIrresistibleRank($points) {
        for ($rank = 0; $rank < sizeof(self::$oldRankData); $rank++) {
            if ($points >= self::$oldRankData[$rank][0]) {
                break;
            }
        }

        return self::$oldRankData[$rank][1];
    }
}

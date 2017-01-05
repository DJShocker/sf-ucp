<?php

class RankS1 extends Eloquent{

    protected $table = 'RANKS_S3';

    protected $timestamp = false;

    protected $fillable = [];

    public $timestamps = false;

    private static $oldRankData = [
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

    private static $rankData = [
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

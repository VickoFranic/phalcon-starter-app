<?php

namespace app\repositories;

use app\models\UserStats;

class UserStatsRepository extends Repository
{
    protected $modelClass = UserStats::class;
	const DATE_FORMAT 	= 'Y-m-d';

    public function update()
    {
    	$today = date(self::DATE_FORMAT);
    	$todayStat = $this->findFirstBy(['date' => $today]);

    	if (! $todayStat) {
    		$todayStat = new UserStats;
    		$todayStat->counter = 0;
    		$todayStat->date = $today;
    	}

    	$todayStat->counter = $todayStat->counter + 1;
    	$todayStat->save();
    }

    public function getStats()
    {
    	$stats = UserStats::find();

    	$filtered = $stats->filter(function($stat) {

    		$currentMonth = date('m-Y');
    		$statMonth = date('m-Y', strtotime($stat->date));

    		if ($statMonth == $currentMonth) {
    			return $stat;
    		}
    	});

    	return $this->prepareForGraph($filtered);
    }

    /**
     * Prepare response for Chartist
     * Example:
     * 
     * [
			{
			day: "Wed, 07/09/2016",
			visits: "10"
			},
			{
			day: "Thu, 08/09/2016",
			visits: "25"
			}
		]
	*/
    public function prepareForGraph($stats)
    {
    	$res = [];
    	foreach ($stats as $stat) {

			$day = date('D, d/m/Y', strtotime($stat->date));
    		
    		$tmp = [
    			'day'		=> $day,
    			'visits'	=> $stat->counter
    		];

    		$res[] = $tmp;
    	}

    	return $res;
    }

}
<?php namespace app\locker\data\dashboards;

use BibleExperience\Repository\Lrs\EloquentRepository as LrsRepo;
use Carbon\Carbon as Carbon;

abstract class BaseDashboard extends \app\locker\data\BaseData {
  protected $lrs_repo;
  protected $has_lrs = false;

  public function __construct( LrsRepo $lrs_repo=null ) {

    $this->lrs_repo  = $lrs_repo ?: new LrsRepo; 
  }

  /**
   * Set all stats array.
   *
   **/
  public function getStats(){
    return array(
      'statement_count' => $this->statementCount(),
      'statement_avg'   => $this->statementAvgCount()
    );
  }


  public function getGraphData(\DateTime $startDate = null, \DateTime $endDate = null) {
    return [
      'statement_graph' => $this->getStatementNumbersByDate($startDate, $endDate)
    ];
  }


  /**
   * Count all statements in Learning Locker
   *
   * @return count
   *
   **/
  public function statementCount(){
    $lrs_id = $this->has_lrs ? $this->lrs : null;

    return $this->lrs_repo->getStatementCount($lrs_id);
  }

  /**
   * Get a count of all the days from the first day a statement was submitted to Lrs.
   *
   * @return $days number
   *
   **/
  protected function statementDays(){

    if( $this->has_lrs ){
      $firstStatement = $this->lrs()->first();
    }else{
	  $firstStatement = \Statement::first();
	}
      
    if($firstStatement) {
      $firstDay = date_create(gmdate(
        "Y-m-d",
        strtotime($firstStatement['statement']['timestamp'])
      ));
      $today = date_create(gmdate("Y-m-d", time()));
      $interval = date_diff($firstDay, $today);
      $days = $interval->days + 1;
      return $days;
    } else {
      return '';
    }
  }

  /**
   * Using the number of days the LRS has been running with statements
   * work out the average number of statements per day.
   *
   * @return $avg
   *
   **/
  public function statementAvgCount(){
    $count = $this->statementCount();
    $days  = $this->statementDays();
    $avg   = 0;
    if( $count && $days ){
      $avg = round( $count / $days );
    }
    return $avg;
  }


  /**
   * Count the number of distinct actors within LRS statements.
   * @todo use more than just mbox
   *
   * @return count.
   *
   **/
  public function actorCount(){
    $base_match = [];
    if( $this->has_lrs ){
      $base_match['lrs_id'] = $this->lrs->id;
    }

    $count_array = ['mbox' => '', 'openid' => '', 'mbox_sha1sum' => '', 'account' => ''];
    
    $count_array['mbox'] = $this->db->statements->aggregate([
      ['$match' => array_merge($base_match, ['statement.actor.mbox' => ['$exists' => true]])],
      ['$group' => ['_id' => '$statement.actor.mbox']],
      ['$group' => ['_id' => 1, 'count' => ['$sum' => 1]]]
    ]);
    
    $count_array['openid'] = $this->db->statements->aggregate([
      ['$match' => array_merge($base_match, ['statement.actor.openid' => ['$exists' => true]])],
      ['$group' => ['_id' => '$statement.actor.openid']],
      ['$group' => ['_id' => 1, 'count' => ['$sum' => 1]]]
    ]);
    
    $count_array['mbox_sha1sum'] = $this->db->statements->aggregate([
      ['$match' => array_merge($base_match, ['statement.actor.mbox_sha1sum' => ['$exists' => true]])],
      ['$group' => ['_id' => '$statement.actor.mbox_sha1sum']],
      ['$group' => ['_id' => 1, 'count' => ['$sum' => 1]]]
    ]);
    
    $count_array['account'] = $this->db->statements->aggregate([
      ['$match' => array_merge($base_match, ['statement.actor.account' => ['$exists' => true]])],
      ['$group' => ['_id' => ['accountName' => '$statement.actor.account.name', 'accountHomePage' => '$statement.actor.account.homePage']]],
      ['$group' => ['_id' => 1, 'count' => ['$sum' => 1]]]
    ]);

    $summary = 0;
    foreach ($count_array as $key => $val) {
        if( isset($val['result'][0]) ){
          $summary += $val['result'][0]['count'];
        }
    }

    return $summary;
  }

  /**
   * Get a count of statements on each day the lrs has been active.
   *
   * @return $data json feed.
   *
   **/
  public function getStatementNumbersByDate(\DateTime $startDate = null, \DateTime $endDate = null) {
        // If neither of the dates are set, default to the last week
        $startDate = $startDate ? Carbon::instance($startDate) : Carbon::now()->subWeek();
        $endDate   = $endDate   ? Carbon::instance($endDate)   : Carbon::now();


        // Create the timestamp filter.
        $timestamp = [];
        if ($startDate !== null) $timestamp['$gte'] = $startDate->timestamp .' '.$startDate->micro;
        if ($endDate !== null) $timestamp['$lte'] = $endDate->timestamp .' '.$endDate->micro;

        $match = [
          'timestamp'=> $timestamp
        ];

        if( $this->has_lrs ){
          $match['lrs_id'] = $this->lrs->id;
        }
		
		$lrs = \Auth::user()->lrs;
		$statements = [];
		foreach($lrs AS $l){
			$statements[] = $l;
		}
         

        //set statements for graphing
        $data = [];

          foreach( $statements as $s ){
            $data[$s['y']] = json_encode( $s );
          }

        // Add empty point in data (fixes issue #265).
        $dates = array_keys($data);

        if( count($dates) > 0 ){
          sort($dates);
          $start = strtotime(reset($dates));
          $end = strtotime(end($dates));

          for($i=$start; $i<=$end; $i+=24*60*60) { 
            $date = date("Y-m-d", $i);
            if(!isset($data[$date])) {
              $data[$date] = json_encode( array( "y" => $date, "a" => 0, 'b' => 0 ) );
            }
          }
        }

        return trim( implode(" ", $data) );

      }
}

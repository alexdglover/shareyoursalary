<?php

class PageGenerator {

	var $surveyName;
	var $currency;
	var $period;
	var $minentries;
	private $db;

	public function __construct(){
		$this->db = new Database();
	}


	public function thanks($f3,$args){
		$surveys = $this->db->get_collection('surveys');
		$query = array('name' => $args['name']);
                $cursor = $surveys->find($query);
                foreach ($cursor as $doc){
			$f3->set('survey',$doc);                	
                }
		$f3->set('content','thanks.htm');
		echo View::instance()->render('layout.htm');
	}

	public function addResponse($f3,$args){
		$surveys = $this->db->get_collection('surveys');
		$query = array('name' => $args['name']);
                $cursor = $surveys->find($query);
                foreach ($cursor as $doc){
			$f3->set('survey',$doc);                	
                }
		$f3->set('content','addResponse.htm');
		echo View::instance()->render('layout.htm');
	}

	public function report($f3,$args){
		$surveys = $this->db->get_collection('surveys');
		$query = array('name' => $args['name']);
                $cursor = $surveys->find($query);
		foreach ($cursor as $doc)
		{
                	if (count($doc['responses']) < $doc['minEntries'])
			{
				$f3->set('minEntriesMet', false);
			}
			else
			{
				asort($doc['responses']);
				$f3->set('minEntriesMet', true);
				$averageSalary = round((array_sum($doc['responses']))/(count($doc['responses'])),2);
				$f3->set('averageSalary',$averageSalary);
				$percentDeltas = [];
				foreach($doc['responses'] as $response)
				{
					array_push($percentDeltas, (round((($response-$averageSalary)/$averageSalary),2) ) );
				}
				asort($percentDeltas);
				$f3->set('percentDeltas',$percentDeltas);


				// Median code borrowed from http://www.mdj.us/web-development/php-programming/calculating-the-median-average-values-of-an-array-with-php/			
				sort($doc['responses']);
				$count = count($doc['responses']); //total numbers in array
				$middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
				if($count % 2) { // odd number, middle is the median
					$median = $doc['responses'][$middleval];
				} else { // even number, calculate avg of 2 medians
					$low = $doc['responses'][$middleval];
					$high = $doc['responses'][$middleval+1];
					$median = (($low+$high)/2);
				}
				$f3->set('median',$median);


			} //End of minEntriesMet==true block
			$f3->set('survey',$doc);			
		}
		$f3->set('content','report.htm');
		echo View::instance()->render('layout.htm');
	}
}
?>

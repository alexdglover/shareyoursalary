<?php

class Survey {

	var $surveyName;
	var $currency;
	var $period;
	var $minentries;
	private $db;

	public function __construct(){
		$this->db = new Database();
	}

	public function get_name(){
		return $this->surveyName;
	}

        public function get_currency(){
                return $this->currency;
        }

        public function get_period(){
                return $this->period;
        }

        public function get_minentries(){
                return $this->minentries;
        }

	public function getByName($f3,$args) { 
		$surveys = $this->db->get_collection('surveys');
		$query = array('name' => $args['name']);
                $cursor = $surveys->find($query);
                foreach ($cursor as $doc){
                	if(count($doc['responses']) < $doc['minEntries'])
			{
				for($i=0; $i < (count($doc['responses'])); $i++)
				{
					//unset($doc['responses'][$i]);
					$doc['responses'][$i] = '0';
				}
				echo json_encode($doc);
			}
			else {echo json_encode($doc);}
                }
	}

	public function addSurvey($f3,$args) {
		// Get surveys collection		
		$surveys	= $this->db->get_collection('surveys');
		$surveyName 	= $_REQUEST['surveyName'];
		$currency	= $_REQUEST['currency'];
		$period		= $_REQUEST['period'];
		$minEntries 	= $_REQUEST['minEntries'];

		// Insert new data sent via API call
		$surveys->insert(array('name' => $surveyName,'currency' => $currency, 'period'=>$period, 'minEntries'=>$minEntries, 'responses'=>(array())));
		// Build a query object, basically a single item array with the name of the new survey input value
		$query = array('name' => $surveyName);
		// Attempt to find the survey we just created
                $cursor = $surveys->find($query);
		// For each object that matches the query, echo the data as JSON
                foreach ($cursor as $doc){
                        echo json_encode($doc);
                }
	}

	public function addResponse($f3,$args) {
		$surveys = $this->db->get_collection('surveys');
		$response = $_REQUEST["response"];
		$surveys->update(array('name' => $args['name']),array('$push' => array('responses' => $response)));
		$query = array('name' => $args['name']);
                $cursor = $surveys->find($query);
                foreach ($cursor as $doc){
                       echo json_encode($doc);
                }

	}

	public function post() {}
	public function put() {}
	public function delete() {}

}

?>

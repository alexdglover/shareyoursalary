<html>
	<head>
		<title>Share your salary info!</title>
	</head>
	<body>

		<h1>Share your salary info!</h1>
		<?php
 //               include 'common.php';
                        $surveyName     = $_POST['surveyName'];
			if($surveyName===null){
				echo "surveyName is null";
			}
                        $currency       = $_POST['currency'];
                        $period         = $_POST['period'];
                        $minentries     = $_POST['minentries'];
                        add_survey($surveyName,$currency,$period,$minentries);
			//$surveys = get_collection('surveys');
			//echo "debugging...\n";
			//echo "found object" . $surveys;
			//$cursor = $surveys->find();
			//foreach ($cursor as $doc){
			//	echo "test - " . $doc['period'];
			//}
			//$array = iterator_to_array($cursor);
			//foreach ($array['name'] as $name) {
			//	echo "$name\n";
			//}
                ?>
		<p>Successfully created survey <?php echo $surveyName; ?>! Now send your colleagues this link:<br />
<a href="http://shareyoursalary-alexdglover.rhcloud.com/surveys/<?php echo $surveyName; ?>">http://shareyoursalary-alexdglover.rhcloud.com/surveys/<?php echo $surveyName; ?></a>


	</body>
</html>

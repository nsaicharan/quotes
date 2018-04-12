<?php 

if (isset($_POST['type'])) {

	if ($_POST['type'] == 'makes') {

		$data = json_decode(file_get_contents("https://www.carqueryapi.com/api/0.3/?cmd=getMakes&sold_in_us=1"));

		$makes = $data->Makes;
		$makeDisplay = array_column($makes, 'make_display');

		$options = "";
		foreach ($makeDisplay as $key => $value) {
			$options .= "<option value='$value'>$value</option>";
		}
		echo $options;
	}

	if ($_POST['type'] == 'models') {

		$make = str_replace(' ', '-', $_POST['make']);
		$data = json_decode(file_get_contents("https://www.carqueryapi.com/api/0.3/?cmd=getModels&make=$make&sold_in_us=1"));

		$models = $data->Models;
		$modelName = array_column($models, 'model_name');

		$options = "";
		foreach ($modelName as $key => $value) {
			$options .= "<option value='$value'>$value</option>";
		}
		echo $options;
	}

}

?>
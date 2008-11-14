<?

/* class formdisplay {{{ */
/**
 *Form input display functions
 *Functions for retrieving and manipulating data to be used in forms.
 * The line blurs here between display and style so some HTML is acceptable but should be avoided where possible.	
 * @author		Joseph Wilk 
 * @copyright	(c) 2004 by 
 * @package forminputs
 */
/* }}} */


class formdisplay{
  
//Select box display functions
//Presenting data for select boxes

	
	/**
	* @return String
	* @param unknown $selectdata
	* @param unknown $style
	* @desc pass the data and the style and a select box is produced
	*/
	function display_select($selectdata,$style){
		
		if($selectdata){
			$style= "select_" . $style;
			$setupdata = array_pop($selectdata); // remove setup information from end

			$class_function = array('formstyle',$style);
			if(is_callable($class_function,false)){ // the style function exists
				
				echo '<select name="' . $setupdata['optionname'] . '">';
					
				foreach($selectdata as $selectbar){
					@formstyle::$style($selectbar); // call style function (hide errors)
				}
				echo '</select>';
			}else{
				// exception
				formstyle::input_emptyparameter();		
			}
		}else{
			formstyle::input_emptyparameter();		
		}
	}


	

	/**
	* @return String
	* @param Array $selectdata
	* @param unknown $style
	* @param unknown $extra
	* @desc pass data and style for a dynamic sized select box
	*/
	function display_select_extra($selectdata,$style,$extra){
	
		if($selectdata){
			$chars = 0;
			// calculate the largest number of characters in the display values
			foreach($selectdata as $selectwidth){
				$charsnew = strlen($selectwidth['displayvalue']);
				if($charsnew > $chars){
					$chars = $charsnew;
				}
			}

			// set the width of the select box depending on the number of characters
			if($chars == 0 || $chars < 40){
				$width = 300;
			}elseif($chars > 40 && $chars < 75){
				$width = $chars * 7;
			}else{
				$width = 520;
			}
		
			$setupdata = array_pop($selectdata); // Remove setup information from end
			$style= "select_" . $style;
			
			$class_function = array('formstyle',$style);
			if(is_callable($class_function,false)){ // the style function exists
				echo '<select style="width: ' . $width . 'px" name="' . $setupdata['optionname'] . '" ' . $extra . '>';

				foreach($selectdata as $selectbar){
					@formstyle::$style($selectbar); //Call style function (hide errors)
				}
				echo '</select>';
			}else{
				// exception
				formstyle::input_emptyparameter();		
			}
		}else{
			formstyle::input_emptyparameter();		
		}
	}


	//Text box data functions
	//Presenting data for text boxes and text areas

	

	/**
	* @return String
	* @param Array $textdata
	* @param unknown $style
	* @desc display a text input field
	*/
	function display_text($textdata, $style){
		
		if($textdata){		
			$style= "text_" . $style;
			$class_function = array('formstyle',$style);
			if(is_callable($class_function,false)){ // the style function exists				
				@formstyle::$style($textdata); // call style function (hide errors)
			}else{
				formstyle::input_emptyparameter();		
			}
		}else{
			formstyle::input_emptyparameter();		
		}
	}

	

	/**
	* @return String
	* @param Array $textdata
	* @param unknown $style
	* @param unknown $class
	* @param unknown $extra
	* @desc display a text input field with a dynamic size
	*/
	function display_text_extra($textdata, $style, $class, $extra){
	
		
		if($textdata){
			$chars = strlen($textdata['value']);
			if($chars == 0 || $chars < 40){
				$width = 300;
			}elseif($chars > 40 && $chars < 75){
				$width = $chars * 7;
			}else{
				if(is_int($extra)){
					$width = $extra;
				}else{
					$width = 520;
				}
			}
		
			$style= "text_extra_" . $style;
		
			$class_function = array('formstyle',$style);
			if(is_callable($class_function,false)){ // the style function exists
				@formstyle::$style($textdata,$class,$width,$extra); // call style function (hide errors)
			}else{
				input_emptyparameter();		
			}
		}else{
			formstyle::input_emptyparameter();		
		}
	}


	

	/**
	* @return String
	* @param Array $textareadata
	* @param unknown $style
	* @desc display a textarea
	*/
	function display_textarea($textareadata,$style){
	
		if($textareadata){
			$style= "textarea_" . $style;
			$class_function = array('formstyle',$style);
			if(is_callable($class_function,false)){ // the style function exists
				@formstyle::$style($textareadata); // call style function (hide errors)
			}else{
				formstyle::input_emptyparameter();		
			}
		}else{
			formstyle::input_emptyparameter();		
		}
	}


	// 

	/**
	* @param Array $textareadata
	* @param unknown $style
	* @param unknown $rows
	* @param unknown $width
	* @desc display a textarea with rows, width, etc.
	*/
	function display_textarea_extra($textareadata,$style,$rows,$width){
	
		if($textareadata){
			$style= "textarea_" . $style;
			$class_function = array('formstyle',$style);
			if(is_callable($class_function,false)){ // the style function exists
				@formstyle::$style($textareadata,$rows,$width); // call style function (hide errors)
			}else{
				formstyle::input_emptyparameter();		
			}
		}else{
			formstyle::input_emptyparameter();		
		}
	}
	

	/**
	* @return String
	* @param unknown $checkboxdata
	* @param unknown $style
	* @desc display a single checkbox
	*/
	function display_checkbox($checkboxdata,$style){
	
		if($checkboxdata){
			$style= "checkbox_" . $style;
			$class_function = array('formstyle',$style);
			if(is_callable($class_function,false)){ // the style function exists
				@formstyle::$style($checkboxdata); // call style function (hide errors)
			}else{
				formstyle::input_emptyparameter();		
			}
		}else{
			formstyle::input_emptyparameter();		
		}
	}


	

	/**
	* @return String
	* @param Array $checkboxdata
	* @param unknown $style
	* @desc display multiple checkboxes
	*/
	function display_checkboxs($checkboxdata, $style){
	
		if($checkboxdata){
			$style_check = "checkbox_" . $style;
			$class_function = array('formstyle',$style_check);
			if(is_callable($class_function,false)){ // the style function exists
				// now produce a single checkbox for each of the items in the checkboxdata array
				for($index=0; $index < sizeof($checkboxdata); $index++){
					formdisplay::display_checkbox($checkboxdata[$index]['checkbox'], $style);
				}

			}else{
				formstyle::input_emptyparameter();	
			}
		}else{
			formstyle::input_emptyparameter();	
		}	
	}



	//Radio button display functions
	//Presenting data for radio buttons
	


	/**
	* @return void
	* @param Array $radiobtndata
	* @param unknown $style
	* @desc display a single radio button
	*/
	function display_radiobtn($radiobtndata,$style){
		
		if($radiobtndata){
			$style= "radiobtn_" . $style;
			$class_function = array('formstyle',$style);
			if(is_callable($class_function,false)){ // the style function exists
				@formstyle::$style($radiobtndata); // call style function (hide errors)
			}else{
				formstyle::input_emptyparameter();	
			}
		}else{
			formstyle::input_emptyparameter();	
		}
	}


	/**
	* @return String
	* @param Array $radiobtndata
	* @param unknown $style
	* @param unknown $extra
	* @desc  display radio button with extra details
	*/
	function display_radiobtn_extra($radiobtndata,$style,$extra){
	
		if($radiobtndata){
			$style= "radiobtn_" . $style."_extra";
		
			$class_function = array('formstyle',$style);
			if(is_callable($class_function,false)){ // the style function exists
				@formstyle::$style($radiobtndata,$extra); // call style function (hide errors)
			}else{
				formstyle::input_emptyparameter();	
			}
		}else{
			formstyle::input_emptyparameter();	
		}
	}


	/**
	* @return String
	* @param Array $radiobtndata
	* @param unknown $style
	* @desc display multiple radio buttons
	*/
	function display_radiobtns($radiobtndata, $style){
	
		if($radiobtndata){
			$style_check = "radiobtn_" . $style;		
			$class_function = array('formstyle',$style_check);
			if(is_callable($class_function,false)){ // the style function exists
				for($index=0; $index < sizeof($radiobtndata); $index++){	
					formdisplay::display_radiobtn($radiobtndata[$index]['radiobtn'],$style);
				}

			}else{
				formstyle::input_emptyparameter();	
			}
		}else{
			formstyle::input_emptyparameter();	
		}	
	}




//	Button display functions
//	Presenting data for input buttons

	


	/**
	* @return String
	* @param Array $btndata
	* @param unknown $style
	* @desc display a form button
	*/
	function display_btn($btndata,$style){
	
		if($btndata){
			$style= "btn_" . $style;
			$class_function = array('formstyle',$style);
			if(is_callable($class_function,false)){ // the style function exists
				@formstyle::$style($btndata); // call style function (hide errors)
			}else{
				formstyle::input_emptyparameter();	
			}	
		}else{
			formstyle::input_emptyparameter();	
		}	
	}



	//Miscallaneous data display functions
	//Specific/complex data display input structures

	/**
	* @return void
	* @param unknown $datedata
	* @param unknown $style
	* @desc  display a set of date boxes
	*/
	function display_date($datedata,$style){
		
		if($datedata){
			for($index=0; $index < sizeof($datedata); $index++){
				formdisplay::display_select($datedata[$index]['day'],$style);
				formdisplay::display_select($datedata[$index]['month'],$style);
				formdisplay::display_select($datedata[$index]['year'],$style);
			}
		}else{
			formstyle::input_emptyparameter();	
		}	
	}


}

?>
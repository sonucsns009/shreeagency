<?php 
class Common extends CI_Model
{
    public function __construct()
    {
    }

	public function jsonencode($params)
    {
        $result = json_encode($params);
        return $result;
    }
    public function jsondecode($params)
    {
        // decode the JSON data
        $result = json_decode($params, true);
        // switch and check possible JSON errors
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $error = ''; // JSON is valid // No error has occurred
                break;
            case JSON_ERROR_DEPTH:
                $error = 'The maximum stack depth has been exceeded.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Invalid or malformed JSON.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Control character error, possibly incorrectly encoded.';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON.';
                break;
            // PHP >= 5.3.3
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_RECURSION:
                $error = 'One or more recursive references in the value to be encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_INF_OR_NAN:
                $error = 'One or more NAN or INF values in the value to be encoded.';
                break;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                $error = 'A value of a type that cannot be encoded was given.';
                break;
            default:
                $error = 'Unknown JSON error occured.';
                break;
        }
        if ($error !== '') {
            // throw the Exception or exit // or whatever :)
            return $error;
        }
        // everything is OK
        return $result;
    }
	
	public function mysql_safe_string($value)
    {
        /*error_reporting(E_ALL);
        if (function_exists('mysql_real_escape_string')) {
        echo "Function is available.<br />\n";
        } else {
        echo "Function is not available.<br />\n";
        }    */
        //$value=$this->input->xss_clean($value);
        $value = isset($value) ? $value : '';
        $value = trim($value);
        $value = strip_image_tags($value);
        $value = encode_php_tags($value);
        //$value  =    htmlspecialchars($value);
        $value = filter_var($value, FILTER_SANITIZE_STRING);
        //$value=mysql_real_escape_string($value);
        return $value;
    }
	
	#function for uploading and resizing image
    #$fileField    : file filed name
    #$path            : path where file is to be uploaded e.g. images/hotel
    #$isResize     : flag whether to resize image
    #$height_thumb : Thumnail Height
    #$width_thumb  : Thumnail Width
    #$image_name   : image to remamed to e.g. tajhotel (do not include extesion)
    #$tempDir      : temparary folder whare image to be uploaded while resizing
    public function UploadImage($fileField, $path, $image_name = '')
    {
        $errors = 0;
        if (!is_dir($path)) {
            return array("uploaded" => "false", "uploadMsg" => "Destination Directory Does Not Found", "imageFile" => "");
        }
        $filename = $_FILES[$fileField]['name'];
        if ($filename != '') {
            $extension = $this->getExtension($filename);
            $extension = strtolower($extension);
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
                $errors = 1;
                $returnArray = array("uploaded" => "false", "uploadMsg" => "Invalid File Extension!", "imageFile" => "");
            } else {
                if ($image_name == '') {
                    $image_name = time() . '.' . $extension;
                } else {
                    $image_name .= '.' . $extension;
                }
                $newname = $path . '/' . $image_name;
                $copied = copy($_FILES[$fileField]['tmp_name'], $newname);
                if (!$copied && $errors == 1) {
                    $errors = 1;
                    $returnArray = array("uploaded" => "false", "uploadMsg" => "Copy Unsuccessfull!", "imageFile" => "");
                }
            } //else
        } else {
            $returnArray = array("uploaded" => "false", "uploadMsg" => "Image is Required", "imageFile" => "");
            return $returnArray;
        }
        if ($errors != 1) {
            $returnArray = array("uploaded" => "true", "uploadMsg" => "Image is uploadded successfully....", "imageFile" => $image_name);
        }
        return $returnArray;
    }
	
	public function getExtension($str)
    {
        $i = strrpos($str, ".");
        if (!$i) {return "";}
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }
	
	function Calculatedistance($lat1, $lon1, $lat2, $lon2, $unit) 
	{
	
	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  $miles = $dist * 60 * 1.1515;
	  $unit = strtoupper($unit);

	  if ($unit == "K") {
		  return ($miles * 1.609344);
	  } else if ($unit == "N") {
		  return ($miles * 0.8684);
	  } else if ($unit == "nmi") {
		  return ($miles * 59.97662);
	  }else {
		  return $miles;
	  }
	}
	
	function CalculateTime($distance,$speed= 30) 
	{
		#return $distance;
		$hours="00";
		$minutes="00";
		$seconds="00";

		#$time=($hours*3600)+($minutes*60)+$seconds;
		#return $time = ($speed * $distance)/60;
		$time=($distance/$speed);
		//$time = $time*(18/5);
		return $time*60;
		#return $formated=date('i:s', $time);
	}
}
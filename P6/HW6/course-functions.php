<?php 
    require 'exceptions.php';
    //Validation Functions
    function clean_input_base($d) {
        $d = trim($d);
        $d = stripslashes($d);
        $d = htmlspecialchars($d);
        return $d;
    }

    function clean_input($data) {
        if (gettype($data) == 'array') {
            foreach ($data as &$val) {
                $val = clean_input_base($val);
            }
            return ($data);
        } else {
            return clean_input_base($data);
        }
    }

    function validate_get($name, &$value, $rawData) {
        if (empty($rawData)) {
            throw new ValidationEmptyException($name);
        } else {
            $value = clean_input($rawData[$name]);
        }
        return;
    }

    function validate_time($time,  $params) {
    // function validate_time($time,  $params = ['timeMin'=>$timeMin='00:00 AM','timeMax'=>$timeMax = '23:59 PM', 'dtFormat' => $dtFormat = 'H:i']) {
        $timeMin = $params[0];
        $timeMax = $params[1];
        $dtFormat = $params[2];
        $dt = DateTime::createFromFormat($dtFormat, $time);
        $dtMin = DateTime::createFromFormat($dtFormat, $timeMin);
        $dtMax = DateTime::createFromFormat($dtFormat, $timeMax);
        if ($dt === false) {
            // \"{$time}\" is not of 'HH:mm XM' format. "
            throw new ValidationDatetimeCreateException($time);
        } elseif ($dtMin === false) {
            throw new ValidationDatetimeCreateException($timeMin);
        } elseif ($dtMax === false) {
            throw new ValidationDatetimeCreateException($timeMax);
        } else if ($dt < $dtMin) {
            throw new ValidationDatetimeOobMinException($time, $timeMin);
        } else if ($dt > $dtMax) {
            throw new ValidationDatetimeOobMaxException($time, $timeMax);
        } else { /* Nothing, good work */}
        return;
    }

    function validate_num($num, $params) {
    // function validate_num($num, $params = ['min'=>$min = '0', 'max'=> $max = '999999']) {
        $min = $params[0];
        $max = $params[1];
        if (!is_numeric($num)) {
            throw new ValidationNumberNotnumericException($num);
        } else if (!is_numeric($min)) {
            throw new ValidationNumberNotnumericException($min);
        } else if (!is_numeric($max)) {
            throw new ValidationNumberNotnumericException($max);
        } else if ($num < $min) {
            throw new ValidationNumberOobMinException($num, $min);
        } else if ($num > $max) {
            throw new ValidationNumberOobMaxException($num, $max);
        } else {return 1;}
        return;
    }

    function validate_select($value, $params) {
    // function validate_select($value, $params = ['options'=>$options, 'bMultiselect'=>$bMultiselect = false]) {
        $options = $params[0];
        $bMultiselect = $params[1];
        $value = array_unique($value);
        if ( (!$bMultiselect) && (count($value) !== 1) ) {
            throw new ValidationSelectionNonmultiException($value);
        }

        foreach ($value as $val) {
            $bValid = false;
            foreach ($options as $option) {
                if ( $val == $option ) {
                    $bValid = true;
                }
            }

            if ($bValid == false) {
                throw new ValidationSelectionNonoptionException($val, $options);
                // $errorMsg .= "ERROR - Selection: Invalid option \"{$semester}\", requires one of the following -";
                // foreach($options as $option) {
                //     $errorMsg .= " \"{$option}\" |";
                // }
                // return $errorMsg;
            } 
        }
        if($bValid) {return 1;}
        
    }

    function validate_alphanum($value, $params = NULL) {
        if( preg_match("/^[a-zA-Z0-9 ]*$/",$value) ) {
            //done
        } else {
            throw new ValidateAlphanumException($value);
        }
    }

    function validate_apply($dataRow) {
            $method = 'validate_'.$dataRow[1];
            if(is_callable($method)) {
                call_user_func($method, $dataRow[0], $dataRow[2]);
            } else {
                throw new UnknownMethodException("Method ($method) does not exist.");
            }
    }


    //INPUT_VALIDATION - https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete

    function validateCourse(array $rawData) {
        //Raw Data is an associative array
        $data = [
            'semester'      =>  ['',  'select',         [['sp', 'su', 'fa'], false]                  ],
            'course'        =>  ['',  'alphanum',       []                                           ],
            'title'         =>  ['',  'alphanum',       []                                           ],
            'days'          =>  ['',  'select',         [['m', 't', 'w', 'r', 'f', 's', 'u'], true]  ],
            'timeStart'     =>  ['',  'time',           ['00:00', '23:59', 'H:i a']                           ],
            'timeEnd'       =>  ['',  'time',           ['00:00', '23:59', 'H:i a']                           ],
            'instructor'    =>  ['',  'alphanum',       []                                           ],
            'location'      =>  ['',  'alphanum',       []                                           ], 
            'enrolledAct'   =>  ['',  'num',            [0, 99999]                                   ],
            'enrolledMax'   =>  ['',  'num',            [0, 99999]                                   ]
        ];

        foreach ($data as $name => $row) {
            validate_get($name, $row[0], $rawData);
            validate_apply($row);
        }
    }


    function postCourse($data) {
        require 'db_connect.php';
        //restartCourses();
        $db = 'test';
        $table = 'courses';
        //Checks if table exists and creates if not, then inserts data
        //db_createTable( $db, $table, array_keys($data) );  assume it's created
        db_insertData('test','courses', $data);
        return;
    }


    function createCourse($data) {
        try {
            validateCourse($data);
            postCourse($data);
            log::info("Successfully validated and posted course data.", 'success');
            displayTable($data);
        } catch (Exception $e) {
            log::info("Data entry unsuccessful... ". 'error');
        } catch (DatabaseDuplicateException $e) {
            log::info("Data already exists in database.", 'error');
        } catch (DatabaseException $e) {
            log::info("Database problem, try again later or contact elirose@uab.edu.", 'error');
        } catch (ValidationException $e) {
            log::info("Data is invalid: ");
        } catch (FileUploadTypeException $e) {
            //Invalid type
        } catch (FileUploadException $e) {
            //Could not upload
        } catch (FileException $e) {
            //Server-side, our problem, couldnt open
        }
        return;
    }

    function restartCourses () {
        //DEBUG:
        $courseNames = [
            'semester',
            'course',
            'title',
            'days',
            'timeStart',
            'timeEnd',
            'instructor',
            'location',
            'enrolledAct',
            'enrolledMax'
        ];
        db_dropTable('test', 'courses');
        db_createTable('test', 'courses', $courseNames);
    }
/*
    $semester = ''
    $course = ''
    $title = ''
    $days = ''
    $timeStart = ''
    $timeEnd = ''
    $instructor = ''
    $location = ''
    $enrolledAct = ''
    $enrolledMax = ''*/

            // switch ($method) {
        //     case 'alphanum':
        //         $result = validate_alphanum($value);
        //         break;
        //     case 'select':
        //         $result = validate_select($value, $arrInputs[0], $arrInputs[1]);
        //         break;
        //     case 'num':
        //         $result = validate_num($value, $arrInputs[0], $arrInputs[1]);
        //         break;
        //     case 'time':
        //         $result = validate_time($value, $arrInputs[0], $arrInputs[1]);
        //         break;
        //     default:
        //         $result = "ERROR: Unknown function method to apply.";
        // }
        // return $result;

        
        // function validate_time($time, $timeMin = '00:00 AM', $timeMax = '23:59 PM', $dtFormat = 'H:i') {
        //     $dt = DateTime::createFromFormat($dtFormat, $time);
        //     $dtMin = DateTime::createFromFormat($dtFormat, $timeMin);
        //     $dtMax = DateTime::createFromFormat($dtFormat, $timeMax);
        //     $errorMsg = '';
        //     if ($dt === false) {
        //         $errorMsg .= "<br>ERROR - Invalid Datetime: Time \"{$time}\" is not of 'HH:mm XM' format. ";
        //     } elseif ($dtMin === false) {
        //         $errorMsg .= "<br>ERROR - Invalid Datetime: Time Minimum \"{$timeMin}\" is not of 'HH:mm XM' format. ";
        //     } elseif ($dtMax === false) {
        //         $errorMsg .= "<br>ERROR - Invalid Datetime: Time Maximum \"{$timeMax}\" is not of 'HH:mm XM' format. ";
        //     } else if ($dt < $dtMin) {
        //         $errorMsg .= "<br>ERROR - Invalid Datetime: \"{$time}\" cannot be less than the minimum \"{$timeMin}\". ";
        //     } else if ($dt > $dtMax) {
        //         $errorMsg .= "<br>ERROR - Invalid Datetime: \"{$time}\" cannot be more than the maximum \"{$timeMax}\". ";
        //     } else {return 1;}
        //     return $errorMsg;
        // }
    
        // function validate_num($num, $min = '0', $max = '999999') {
        //     $errorMsg = '';
        //     if (!is_numeric($num)) {
        //         throw new NumberNotnumericException($num);
        //     } else if (!is_numeric($min)) {
        //         throw new NumberNotnumericException($min);
        //     } else if (!is_numeric($max)) {
        //         throw new NumberNotnumericException($max);
        //     } else if ($num < $min) {
        //         throw new NumberOobMinException($num, $min);
        //     } else if ($num > $max) {
        //         throw new NumberOobMaxException($num, $max);
        //     } else {return 1;}
        //     return $errorMsg;
        // }
?>
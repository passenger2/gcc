<?php
#---- dynamic root path function ----
function set_approot_dir($folder="")
    # Author: Rodolfo Villaruz
{
    preg_match('#' . $_SERVER['DOCUMENT_ROOT'] . '(.*)#', $folder, $matches);
    if ($matches) {
        define('ROOT', $matches[1] . '/');
    } else {
        define('ROOT', '/');
    }
}
#---- dynamic root path function end ----

function echoRoot()
{
    echo(ROOT);
}

#---- include functions ----
function includeCore()
{
    include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/actions/global.check.credentials.php");
    include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/global.dbcontrollerPDO.php");
}

function includeCommonJS()
{
    include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/include.common.js.php");
}

function includeDataTables($mode = '')
{
    if($mode == 'advanced')
    {
        include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/include.datatables.advanced.php");
    } else
    {
        include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/include.datatables.php");
    }
}

function includeNav()
{
    include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/global.navigation.php");
}

function includeDashboardFunctions()
{
     include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/dashboard.functions.php");
}

function includeMapFunctions()
{
     include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/maps.functions.php");
}

function includeHead($pageTitle)
{
    include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/include.common.head.php");
}

function includeLayoutGenerator()
{
    include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/assessment.layout.generator.php");
}
#---- include functions end ----

#---- db fetch functions ----
function getStudentDetails($id = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-08-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT * FROM `students`
         WHERE StudentID = :studentID");
    
    $db_handle->bindVar(':studentID', $id, PDO::PARAM_INT,0);
    $studentInfo = $db_handle->runFetch();

    return $studentInfo;
}

function getStudentExtensiveDetails($id = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 01-04-18
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT
            StudentID,
            GccCode,
            CONCAT(Lname, ', ', Fname, ' ', Mname) AS StudentName,
            students.Lname,
            students.Fname,
            students.Mname,
            students.Nickname,
            students.Bdate,
            students.Age,
            students.Gender,
            students.PhoneNum,
            students.Email,
            students.PlaceOfBirth,
            students.Citizenship,
            students.DepartmentID,
            students.CourseYear,
            students.Religion,
            students.DateEnrolled,
            students.ActiveUserID,
            students.PrevGPA,
            students.OrdinalPosition,
            students.FathersName,
            students.FathersStatus,
            students.FathersOccupation,
            students.MothersName,
            students.MothersStatus,
            students.MothersOccupation,
            students.ParentsMaritalStatus,
            students.ParentsContactNo,
            students.CurrentlyLivingWith,
            students.CurrentAddress,
            students.CurrentSpecificAddress,
            students.ScholarshipStatus,
            students.ScholarshipType,
            students.FamilyMonthlyNetIncome,
            students.SchoolLastAttended,
            students.SchoolLastAttendedAddress,
            students.Remarks,
            students.Status
         FROM students
         WHERE students.StudentID = :studentID");

    $db_handle->bindVar(':studentID', $id, PDO::PARAM_INT, 0);
    $studentInfo = $db_handle->runFetch();

    return $studentInfo;
}

function getUserInfo($userID = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT
            user.Lname,
            user.Fname,
            user.Mname,
            user.Birthdate,
            user.Sex,
            user.PhoneNum,
            user.AgencyID,
            user.Position,
            account.Username
         FROM user
         LEFT JOIN account
            ON account.USER_UserID = user.UserID
         WHERE user.UserID = :userID");

    $db_handle->bindVar(':userID', $userID, PDO::PARAM_INT, 0);
    $userInfo = $db_handle->runFetch();

    return $userInfo;
}

function calculateAge($birthDate = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $today = date("Y-m-d");
    $diff = date_diff(date_create($birthDate), date_create($today));
    
    if($birthDate != '')
    {
        return $diff->format('%y');
    } else
    {
        return 'N/A';
    }
}

function translateDate($date = '', $time = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    if($time == 'time')
    {
        $translatedDate = date('M d, Y <\b\r> h:i a', strtotime($date));
    } else
    {
        $translatedDate = date('M d, Y', strtotime($date));
    }
    
    if(!empty($date))
    {
        return $translatedDate;
    } else
    {
        return 'unspecified';
    }
}

function getGender($genderID = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $gender = array(
        1 => 'Male',
        2 => 'Female'
    );
    
    if($genderID != '')
    {
        return $gender[$genderID];
    } else
    {
        return 'unspecified';
    }
}

function getProvinces()
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT * FROM `province`
         ORDER BY ProvinceName
         LIMIT 10");
    
    $provinces = $db_handle->runFetch();

    return $provinces;
}

function getCities()
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT * FROM city_mun
        JOIN province
            ON city_mun.PROVINCE_ProvinceID = province.ProvinceID
        ORDER BY `City_Mun_Name`
        LIMIT 10");
    
    $cities = $db_handle->runFetch();

    return $cities;
}

function getBarangays()
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT * FROM `barangay`
        JOIN city_mun
            ON barangay.City_CityID = city_mun.City_Mun_ID
        ORDER BY `BarangayName`
        LIMIT 10");
    
    $barangays = $db_handle->runFetch();

    return $barangays;
}

function getFullAddress($barangayID='', $idpID='')
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $result = [];
    if(isset($idpID) && ($idpID != '' || $idpID != 0))
    {
        $db_handle->prepareStatement(
            "SELECT
                CONCAT(
                    (CASE
                        WHEN idp.SpecificAddress = '' THEN ''
                        ELSE CONCAT(idp.SpecificAddress, ', ')
                     END),
                barangay.BarangayName, ', ', city_mun.City_Mun_Name, ', ', province.ProvinceName
                ) AS Address
             FROM barangay
             LEFT JOIN idp
                ON barangay.BarangayID = idp.Origin_Barangay
             LEFT JOIN city_mun
                ON barangay.City_CityID = city_mun.City_Mun_ID
             LEFT JOIN province
                ON city_mun.PROVINCE_ProvinceID = province.ProvinceID
             WHERE barangay.BarangayID = :barangay
               AND idp.IDP_ID = :idpID");
        
        $db_handle->bindVar(':barangay', $barangayID, PDO::PARAM_INT,0);
        $db_handle->bindVar(':idpID', $idpID, PDO::PARAM_INT,0);
        
        $result = $db_handle->runFetch();
    } else {
        $db_handle->prepareStatement(
            "SELECT
                CONCAT(barangay.BarangayName, ', ', city_mun.City_Mun_Name,', ', province.ProvinceName) AS Address
             FROM barangay
             LEFT JOIN city_mun
                ON barangay.City_CityID = city_mun.City_Mun_ID
             LEFT JOIN province
                ON city_mun.PROVINCE_ProvinceID = province.ProvinceID
             WHERE barangay.BarangayID = :barangay");
        
        $db_handle->bindVar(':barangay', $barangayID, PDO::PARAM_INT,0);
        
        $result = $db_handle->runFetch();
    }
    
    if($result[0]['Address'] != '')
    {
        return $result[0]['Address'];
    }
    else
    {
        return 'unspecified';
    }
}

function getAddressIDs($barangayID)
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT
            barangay.BarangayID,
            city_mun.City_Mun_ID,
            province.ProvinceID
        FROM barangay
        LEFT JOIN city_mun
            ON city_mun.City_Mun_ID = barangay.City_CityID
        LEFT JOIN province
            ON province.ProvinceID = city_mun.PROVINCE_ProvinceID
        WHERE barangay.BarangayID = :barangayID");
    
    $db_handle->bindVar(':barangayID', $barangayID, PDO::PARAM_INT, 0);
    $addressIDs = $db_handle->runFetch();

    return $addressIDs;
}

function getEvacuationCenters()
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT * FROM evacuation_centers");
    $evac_centers = $db_handle->runFetch();

    return $evac_centers;
}

function getEvacDetails($evacID = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT
            evacuation_centers.EvacuationCentersID,
            CONCAT
                (evacuation_centers.EvacName, ': ', barangay.BarangayName, ', ',
                 city_mun.City_Mun_Name, ', ', province.ProvinceName) AS EvacAndAddress
        FROM evacuation_centers
        LEFT JOIN barangay
            ON evacuation_centers.EvacAddress = barangay.BarangayID
        LEFT JOIN city_mun
            ON city_mun.City_Mun_ID = barangay.City_CityID
        LEFT JOIN province
            ON province.ProvinceID = city_mun.PROVINCE_ProvinceID
        WHERE evacuation_centers.EvacuationCentersID = :evacID");
    
    $db_handle->bindVar(':evacID', $evacID, PDO::PARAM_INT,0);
    $result = $db_handle->runFetch();
    
    return $result[0]['EvacAndAddress'];
}

function getExtensiveEvacDetails($evacID = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT
            evacuation_centers.EvacuationCentersID,
            evacuation_centers.EvacName,
            evacuation_centers.EvacAddress,
            evacuation_centers.EvacType,
            evacuation_centers.EvacManager,
            evacuation_centers.EvacManagerContact,
            evacuation_centers.SpecificAddress,
            city_mun.City_Mun_ID,
            city_mun.City_Mun_Name,
            province.ProvinceID,
            province.ProvinceName
        FROM evacuation_centers
        LEFT JOIN barangay
            ON barangay.BarangayID = evacuation_centers.EvacAddress
        LEFT JOIN city_mun
            ON city_mun.City_Mun_ID = barangay.City_CityID
        LEFT JOIN province
            ON province.ProvinceID = city_mun.PROVINCE_ProvinceID
        WHERE evacuation_centers.EvacuationCentersID = :evacID");
    
    $db_handle->bindVar(':evacID', $evacID, PDO::PARAM_INT,0);
    $result = $db_handle->runFetch();
    
    return $result;
}

function getAgencies()
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT *
         FROM `agency`
         ORDER BY AgencyName");
    
    $agencies = $db_handle->runFetch();

    return $agencies;
}

function getFormID($questionID)
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT FORM_FormID
         FROM `questions`
         WHERE QuestionsID = :qid");
    
    $db_handle->bindVar(":qid", $questionID, PDO::PARAM_INT,0);
    $formID = $db_handle->runFetch();
    
    return($formID[0]['FORM_FormID']);
}

function getAllAssessmentTools()
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-08-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT *
         FROM `assessmenttools`
         ORDER BY AssessmentToolID");
    
    $tools = $db_handle->runFetch();

    return $tools;
}

function getMultipleAssessmentTools($formIDs = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 01-21-18
# Modified by: Laranjo, Sam Paul L.
{
    if(!isset($formIDs)) $formIDs = ['z'];
    sort($formIDs);
    #die(print_r($formIDs));
    $db_handle = new DBController();
    $toolIDs = implode(',',$formIDs);
    $inQuery = implode(',', array_fill(0, count($formIDs), '?'));
    $query =
        "SELECT *
         FROM `assessmenttools`
         WHERE AssessmentToolID IN (".$inQuery.")
         ORDER BY FIELD(AssessmentToolID,".$toolIDs.")";
    #die($query);
    $db_handle->prepareStatement($query);
    
    #$formIDs[] = $toolIDs;
    #die(print_r($formIDs));
    $formInfo = $db_handle->fetchWithIn($formIDs);

    return $formInfo;
}

function getAssessmentTool($toolID)
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-08-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();

    $db_handle->prepareStatement(
        "SELECT *
         FROM `assessmenttools`
         WHERE AssessmentToolID = :id");
    
    $db_handle->bindVar(':id', $toolID, PDO::PARAM_INT,0);
    $formInfo = $db_handle->runFetch();
    
    if(!isset($formInfo))$formInfo = '';
    
    return $formInfo;
}

function getAssessmentQuestions($type = '',$formIDs = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 01-10-18
# Modified by: Laranjo, Sam Paul L.
{
    if(!isset($formIDs)) $formIDs = ['z'];
    $db_handle = new DBController();
    if($type == 'Tool')
    {
        $toolIDs = implode(',',$formIDs);
        $inQuery = implode(',', array_fill(0, count($formIDs), '?'));
        $query =
            "SELECT *
            FROM `questions`
            LEFT JOIN htmlforms
                ON htmlforms.HtmlFormID = questions.HtmlFormID
            WHERE AssessmentToolID IN (".$inQuery.")
            ORDER BY FIELD(AssessmentToolID,?)";
        $db_handle->prepareStatement($query);
        #die($query);
        $formIDs[] = $toolIDs;#die(print_r($formIDs));
        $questionsResult = $db_handle->fetchWithIn($formIDs);
    }
    else if($type == 'Intake')
    {
        $db_handle->prepareStatement(
            "SELECT *
            FROM `questions`
            LEFT JOIN htmlforms
                ON htmlforms.HtmlFormID = questions.HtmlFormID
            WHERE IntakeFormID = :formID");
        
        $db_handle->bindVar(':formID', $qIDs, PDO::PARAM_INT,0);
        $questionsResult = $db_handle->runFetch();
    }
    
    if(!isset($questionsResult))$questionsResult[] = '';
    
    return $questionsResult;
}

function getEditToolQuestions($toolID = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-08-17
# Modified by: Laranjo, Sam Paul L.
{
    if(!isset($toolID)) $toolIDs = ['z'];
    $db_handle = new DBController();

    $db_handle->prepareStatement(
        "SELECT *
         FROM `questions`
         LEFT JOIN htmlforms
            ON htmlforms.HtmlFormID = questions.HtmlFormID
         WHERE AssessmentToolID = :id");
    
    $db_handle->bindVar(':id', $toolID, PDO::PARAM_INT,0);
    $questions = $db_handle->runFetch();

    if(!isset($questions))$questions = '';
    
    return $questions;
}

function getTranslations($type = 'EditAssessmentQuestions', $itemID = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 01-10-18
# Modified by: Laranjo, Sam Paul L.
{
    if(!isset($itemID)) $itemIDs = ['z'];
    $db_handle = new DBController();

    if($type == 'EditAssessmentQuestions')
    {
        $db_handle->prepareStatement(
            "SELECT
                translations.TranslationID,
                translations.QuestionID,
                translations.AssessmentToolID,
                translations.Translation,
                translations.Dialect
             FROM translations
             WHERE translations.AssessmentToolID = :itemID");
        
        
        $db_handle->bindVar(':itemID', $itemID, PDO::PARAM_INT,0);
        $translations = $db_handle->runFetch();
    } else if($type == 'Tool')
    {
        $itemIDs = $itemID;
        $toolIDs = implode(',',$itemIDs);
        $inQuery = implode(',', array_fill(0, count($itemIDs), '?'));
        $query =
            "SELECT
                translations.TranslationID,
                translations.QuestionID,
                translations.AssessmentToolID,
                translations.Translation,
                translations.Dialect
            FROM translations
            WHERE AssessmentToolID IN (".$inQuery.")
            ORDER BY FIELD (AssessmentToolID, ?)";
        #die($query);
        $db_handle->prepareStatement($query);

        $itemID[] = $toolIDs;
        #die(print_r($qIDs));
        $translations = $db_handle->fetchWithIn($itemID);
    }

    if(!isset($translations))$translations = '';
    #die(print_r($translations));
    return $translations;
    
    
}

function getTranslationsArray($type = 'Questions', $itemID = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 01-10-18
# Modified by: Laranjo, Sam Paul L.
{
    if($type == 'Questions')
    {
        $translationsData = getTranslations('EditAssessmentQuestions' ,$itemID);
        $translationsArray = array();

        if(!empty($translationsData))
        {
            foreach($translationsData as $translation)
            {
                if(!isset($translationsArray[$translation['QuestionID']]))
                {
                    $translationsArray[$translation['QuestionID']] = [];
                    $translationsArray[$translation['QuestionID']][$translation['Dialect']] = $translation['Translation'];
                } else
                {
                    if(!isset($translationsArray[$translation['QuestionID']][$translation['Dialect']]))
                    {
                        $translationsArray[$translation['QuestionID']][$translation['Dialect']] = $translation['Translation'];
                    }
                }
            }
            #die(print_r($translationsArray));
            return $translationsArray;
        } else
        {
            return null;
        }
    } else if($type == 'Tool')
    {
        $translationsData = getTranslations('Tool' ,$itemID);
        #die(print_r($translationsData));
        $translationsArray = array();

        if(!empty($translationsData))
        {
            foreach($translationsData as $translation)
            {
                if(!isset($translationsArray[$translation['AssessmentToolID'].'-'.$translation['QuestionID']]))
                {
                    $translationsArray[$translation['AssessmentToolID'].'-'.$translation['QuestionID']] = [];
                    $translationsArray[$translation['AssessmentToolID'].'-'.$translation['QuestionID']][$translation['Dialect']] = $translation['Translation'];
                } else
                {
                    if(!isset($translationsArray[$translation['AssessmentToolID'].'-'.$translation['QuestionID']][$translation['Dialect']]))
                    {
                        $translationsArray[$translation['AssessmentToolID'].'-'.$translation['QuestionID']][$translation['Dialect']] = $translation['Translation'];
                    }
                }
            }
            #die(print_r($translationsArray));
            return $translationsArray;
        } else
        {
            return null;
        }
    } else
    {
        return null;
    }
}

function getLanguages($type='EditAssessmentQuestions', $translationsArray = [])
# Author: Laranjo, Sam Paul L.
# Last Modified: 01-11-18
# Modified by: Laranjo, Sam Paul L.
{
    if($type === 'EditAssessmentQuestions')
    {
        $languages = ['Original'];
        if(!empty($translationsArray))
        {
            foreach($translationsArray as $translationEntry)
            {
                foreach($translationEntry as $language => $translation)
                {
                    if(!in_array($language, $languages))
                    {
                        $languages[] = $language;
                    }
                }
            }
        }
        #die(print_r($languages));
        return $languages;
    } else if ($type === 'Tool')
    {
        #die(print_r($translationsArray));
        $languagesArray = [];
        $languages = [];
        if(!empty($translationsArray))
        {
            foreach($translationsArray as $key => $translationEntry)
            {
                if(!isset($languagesArray[explode('-',$key)[0]]))
                {
                    $languagesArray[explode('-',$key)[0]] = [];
                    
                }
                foreach($translationEntry as $language => $translation)
                {
                    if(!in_array($language, $languages))
                    {
                        $languages[] = $language;
                    }
                }
                if(!in_array($languages, $languagesArray[explode('-',$key)[0]]))
                {
                    $languagesArray[explode('-',$key)[0]] = $languages;
                }
                $languages = [];
            }
        }
        
        #die(print_r($languagesArray));
        return $languagesArray;
    }
}

function getIntakeInfo($id = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT *
        FROM `intakeforms` WHERE IntakeFormID = :id");
    
    $db_handle->bindVar(':id', $id, PDO::PARAM_INT,0);
    $intakeInfo = $db_handle->runFetch();

    return $intakeInfo;
}

function getAgeGroup($id = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT students.Bdate
         FROM students
         WHERE students.StudentID = :id");
    
    $db_handle->bindVar(':id', $id, PDO::PARAM_INT,0);
    $bDate = $db_handle->runFetch()[0]['Bdate'];
    
    $age = calculateAge($bDate);
    
    if($age > 18)
    {
        $ageGroup = 2;
    } else
    {
        $ageGroup = 1;
    }

    return $ageGroup;
}

function getIntakeCount($idpID = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement(
        "SELECT
            COUNT(*) AS Count
        FROM intakeformanswers
        WHERE StudentID = :id");
    
    $db_handle->bindVar(':id', $idpID, PDO::PARAM_INT,0);
    $intakeCount = $db_handle->runFetch();
    
    return $intakeCount;
}

function getAnswerInfo($faID='', $type='')
# Author: Laranjo, Sam Paul L.
# Last Modified: 01-12-18
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    if($type == 'intake')
    {
        $db_handle->prepareStatement(
            "SELECT
                intakeformanswers.IntakeFormAnswerID,
                CONCAT(students.Lname,', ',students.Fname,' ',students.Mname) as StudentName,
                CONCAT(users.Lname,', ', users.Fname, ' ', users.Mname) as UserResponsible,
                intakeformanswers.DateTaken
             FROM intakeformanswers
             JOIN students
                ON intakeformanswers.StudentID = students.StudentID
             JOIN users
                ON intakeformanswers.ActiveUserID = users.UserID
             JOIN intakeforms
                ON intakeforms.IntakeFormID = intakeformanswers.IntakeFormID
             WHERE intakeformanswers.IntakeFormAnswerID = :AssessmentToolAnswerID");
    } else if($type == 'tool')
    {
        $db_handle->prepareStatement(
            "SELECT
                assessmenttoolanswers.AssessmentToolAnswerID,
                assessmenttoolanswers.AssessmentToolID,
                assessmenttools.Name,
                assessmenttools.Instructions,
                assessmenttoolanswers.StudentID,
                CONCAT(students.Lname,', ',students.Fname,' ',students.Mname) AS StudentName,
                CONCAT(users.Lname,', ', users.Fname, ' ', users.Mname) as ActiveUser,
                assessmenttoolanswers.DateTaken
                FROM assessmenttoolanswers
                LEFT JOIN assessmenttools
                    ON assessmenttools.AssessmentToolID = assessmenttoolanswers.AssessmentToolID
                LEFT JOIN students
                    ON students.StudentID = assessmenttoolanswers.StudentID
                LEFT JOIN users
                    ON users.UserID = assessmenttoolanswers.ActiveUserID
                WHERE assessmenttoolanswers.AssessmentToolAnswerID = :AssessmentToolAnswerID");
    }
    
    $db_handle->bindVar(':AssessmentToolAnswerID', $faID, PDO::PARAM_INT,0);
    $answersInfo = $db_handle->runFetch();
    
    return $answersInfo;
}

function getAnswers($faID='', $type='')
# Author: Laranjo, Sam Paul L.
# Last Modified: 01-05-18
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    if($type == 'intake')
    {
        $db_handle->prepareStatement(
            "SELECT
                intakeformanswers.IntakeFormAnswerID,
                questions.QuestionID,
                questions.Question,
                htmlforms.Type AS FormType,
                htmlforms.Range AS AnswerRange,
                AnswersTable.AnswerID,
                AnswersTable.Answer
            FROM intakeformanswers
            LEFT JOIN questions
                ON intakeformanswers.IntakeFormID = questions.IntakeFormID
            LEFT JOIN
                (SELECT
                    quantitativeanswers.IntakeFormAnswerID,
                    quantitativeanswers.QuantitativeAnswerID AS AnswerID,
                    quantitativeanswers.QuestionID,
                    quantitativeanswers.Answer
                 FROM quantitativeanswers
                 UNION
                 SELECT
                    qualitativeanswers.IntakeFormAnswerID,
                    qualitativeanswers.QualitativeAnswerID,
                    qualitativeanswers.QuestionID,
                    qualitativeanswers.Answer
                FROM qualitativeanswers
                ) AnswersTable
                ON
                    questions.QuestionID = AnswersTable.QuestionID
                AND
                    intakeformanswers.IntakeFormAnswerID = AnswersTable.IntakeFormAnswerID
            LEFT JOIN htmlforms 
                ON questions.HtmlFormID = htmlforms.HtmlFormID
            WHERE intakeformanswers.IntakeFormAnswerID = :AssessmentToolAnswerID");   
    } else if($type == 'tool')
    {
        $db_handle->prepareStatement(
            "SELECT
                assessmenttoolanswers.AssessmentToolAnswerID,
                assessmenttoolanswers.AssessmentToolID,
                questions.QuestionID,
                questions.Question,
                questions.AnswerType,
                questions.ItemNumber,
                htmlforms.Type,
                htmlforms.Range,
                AnswersTable.AnswerID,
                AnswersTable.Answer
            FROM assessmenttoolanswers
            LEFT JOIN questions
                ON assessmenttoolanswers.AssessmentToolID = questions.AssessmentToolID
            LEFT JOIN
                (SELECT
                    quantitativeanswers.AssessmentToolAnswerID,
                    quantitativeanswers.QuantitativeAnswerID AS AnswerID,
                    quantitativeanswers.QuestionID,
                    quantitativeanswers.Answer
                FROM quantitativeanswers
                UNION
                SELECT
                    qualitativeanswers.AssessmentToolAnswerID,
                    qualitativeanswers.QualitativeAnswerID,
                    qualitativeanswers.QuestionID,
                    qualitativeanswers.Answer
                FROM qualitativeanswers
                ) AnswersTable
                ON
                    questions.QuestionID = AnswersTable.QuestionID
                AND
                    assessmenttoolanswers.AssessmentToolAnswerID = AnswersTable.AssessmentToolAnswerID
            LEFT JOIN htmlforms
                ON htmlforms.HtmlFormID = questions.HtmlFormID
            WHERE assessmenttoolanswers.AssessmentToolAnswerID = :AssessmentToolAnswerID");
    }
    
    $db_handle->bindVar(':AssessmentToolAnswerID', $faID, PDO::PARAM_INT,0);
    $answers = $db_handle->runFetch();
    
    return $answers;
}

function getIntakeID($ag = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $formID = 0;
    if($ag == 1) {
        //children
        $formID = 1;
    } else if($ag == 2) {
        //adults
        $formID = 2;
    } else {
        $formID = 0;
    }

    return $formID;
}

function getAutoAssessmentItems($assessmentToolID = '')
{
    $db_handle = new DBController();
    
    $query =
        "SELECT
            Items
        FROM `autoassessments`
        WHERE AssessmentToolID = :AssessmentToolID";
    
    $db_handle->prepareStatement($query);
    $db_handle->bindVar(":AssessmentToolID", $assessmentToolID, PDO::PARAM_INT, 0);
    
    $result = $db_handle->runFetch();
    
    return $result[0]['Items'];
}
#---- db fetch functions end ----


#---- db insert functions ----
function updateEditHistory($formID, $message)
# Author: Laranjo, Sam Paul L.
# Last Modified: 12-06-17
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    
    $db_handle->prepareStatement(
        "INSERT INTO `edit_history`
            (`EditHistoryID`,
             `USER_UserID`,
             `LastEdit`,
             `FORM_FormID`,
             `QUESTIONS_QuestionsID`,
             `INTAKE_IntakeID`,
             `Remark`)
          VALUES
            (NULL,
             :usr,
             now(),
             :formID,
             NULL,
             NULL,
             :edit)");
    
    $db_handle->bindVar(':usr', $_SESSION['UserID'], PDO::PARAM_INT, 0);
    $db_handle->bindVar(':formID', $formID, PDO::PARAM_INT, 0);
    $db_handle->bindVar(':edit', $message, PDO::PARAM_STR, 0);
    $db_handle->runUpdate();
}

function insertAnswer($type = 'intake', $answerType = '1', $answer = '', $questionID = '0', $formAnswerID = '0')
# Author: Laranjo, Sam Paul L.
# Last Modified: 01-21-18
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $query = "";
    
    if($answerType == '1')
    {
        $query =
            "INSERT INTO `quantitativeanswers` (
                `QuantitativeAnswerID`,
                `Answer`,
                `QuestionID`,
                `AssessmentToolAnswerID`,
                `IntakeFormAnswerID`)
            VALUES (
                NULL,
                :Answer,
                :QuestionID,";
        if($type == 'intake')
        {
            $query .= 
                "NULL,
                :formAnswerID)";
        } else if($type == 'tool')
        {
            $query .= 
                ":formAnswerID,
                NULL)";
        }
    } else if($answerType == '2')
    {
        $query =
            "INSERT INTO `qualitativeanswers` (
                `QualitativeAnswerID`,
                `Answer`,
                `QuestionID`,
                `AssessmentToolAnswerID`,
                `IntakeFormAnswerID`)
            VALUES (
                NULL,
                :Answer,
                :QuestionID,
                ";
        if($type == 'intake')
        {
            $query .= 
                "NULL,
                :formAnswerID)";
        } else if($type == 'tool')
        {
            $query .= 
                ":formAnswerID,
                NULL)";
        }
    }
    #die($query);
    $db_handle->prepareStatement($query);
    if($answerType == '1')
    {
        $db_handle->bindVar(":Answer", $answer, PDO::PARAM_INT, 0);
    } else if($answerType == '2' && !empty($answer))
    {
        $db_handle->bindVar(":Answer", $answer, PDO::PARAM_STR, 0);
    }
    $db_handle->bindVar(":QuestionID", $questionID, PDO::PARAM_INT, 0);
    $db_handle->bindVar(":formAnswerID", $formAnswerID, PDO::PARAM_INT, 0);
    
    $db_handle->runUpdate();
}
#---- db insert functions end ----

#---- assessment functions ----
function getList($data, $listType = 'Student', $listTarget = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 01-04-18
# Modified by: Laranjo, Sam Paul L.
{
    global $db_handle;
    $keyword = '';
    $order = '';
    $length = '';
    $query = '';
    $output = [];
    $tmp = [];
    $subArray = [];
    $draw = 0;
    $rowCount = 0;
    $recordsFiltered = 0;
    $type = $listType;
    $idpID = $listTarget;

    if(isset($_POST["draw"])) $draw = $data["draw"];
    if(isset($data["search"]["value"])) $keyword = $data["search"]["value"];
    if(isset($data["order"])) $order = $data["order"];
    if(isset($data["length"])) $length = $data["length"];

    if($listType === 'Student')
    {
        $query .=
            "SELECT
                i.Lname,
                i.StudentID,
                colleges.CollegeName,
                Gender,
                Age,
                i.Fname,
                i.Mname,
                i.CourseYear,
                i.GccCode,
                Bdate,
                colleges.CollegeName,
                departments.DepartmentName,
                COALESCE(
                    MIN(j.IntakeFormAnswerID),
                    0
                ) AS NumOfIntakes,
                (CASE
                    WHEN (Age > 18) THEN 2
                    ELSE 1
                    END
                ) AS AgeGroup 
            FROM `students` i 
            LEFT JOIN intakeformanswers j
                ON i.StudentID = j.StudentID
            LEFT JOIN departments
                ON i.DepartmentID = departments.DepartmentID
            LEFT JOIN colleges
                ON colleges.CollegeID = departments.CollegeID ";

        if($keyword != '')
        {
            $query .=
                " WHERE i.Lname LIKE :keyword
                  OR i.Fname LIKE :keyword
                  OR i.Mname LIKE :keyword
                  OR i.Fname LIKE :keyword
                  OR i.StudentID LIKE :keyword ";
        }

        if($order != '')
        {
            if($order['0']['dir'] == 'asc')
            {
                $query .=
                    "GROUP BY
                        i.StudentID,
                        i.Lname
                     ORDER BY :orderColumn ASC ";
            }
            else
            {
                $query .=
                    "GROUP BY
                        i.StudentID,
                        i.Lname
                    ORDER BY :orderColumn DESC ";
            }

        }
        else
        {
            $query .=
                "GROUP BY
                    i.StudentID,
                    i.Lname
                ORDER BY 1 ASC ";
        }
    } else if($listType === 'Users')
    {
        $query .=
            "SELECT account.AccountID, user.UserID,
                CONCAT(user.Lname,', ', user.Fname, ' ', user.Mname) as User,
                user.PhoneNum,
                agency.AgencyName AS Agency,
                user.DateAdded
            FROM account
            JOIN user
                ON account.USER_UserID = user.UserID
            JOIN agency
                ON user.AGENCY_AgencyID = agency.AgencyID ";

        if($keyword != '')
        {
            $query .=
                " WHERE user.Lname LIKE :keyword
                  OR user.Fname LIKE :keyword
                  OR user.Mname LIKE :keyword
                  OR agency.AgencyName LIKE :keyword
                  OR user.PhoneNum LIKE :keyword ";
        }

        if($order != '')
        {
            if($order['0']['dir'] == 'asc')
            {
                $query .= 'ORDER BY :orderColumn ASC ';
            }
            else
            {
                $query .= 'ORDER BY :orderColumn DESC ';
            }

        }
        else
        {
            $query .= 'ORDER BY 1 ASC ';
        }
    }
    else if($listType === 'Evac')
    {
        $query .=
            "SELECT *
             FROM `evacuation_centers`  ";

        if($keyword != '')
        {
            $query .=
                " WHERE EvacuationCentersID LIKE :keyword
                  OR EvacName LIKE :keyword
                  OR EvacAddress LIKE :keyword
                  OR EvacType LIKE :keyword
                  OR EvacManager LIKE :keyword
                  OR SpecificAddress LIKE :keyword ";
        }

        if($order != '')
        {
            if($order['0']['dir'] == 'asc')
            {
                $query .= 'ORDER BY :orderColumn ASC ';
            }
            else
            {
                $query .= 'ORDER BY :orderColumn DESC ';
            }
        }
        else
        {
            $query .= 'ORDER BY 1 ASC ';
        }
    }
    else if($listType === 'Tool')
    {
        $query .=
            "SELECT
                Name,
                AssessmentToolID
             FROM `assessmenttools`  ";

        if($keyword != '')
        {
            $query .=
                " WHERE AssessmentToolID LIKE :keyword
                  OR Name LIKE :keyword ";
        }

        if($order != '')
        {
            if($order['0']['dir'] == 'asc')
            {
                $query .= 'ORDER BY :orderColumn ASC ';
            }
            else
            {
                $query .= 'ORDER BY :orderColumn DESC ';
            }
        }
        else
        {
            $query .= 'ORDER BY 1 ASC ';
        }
    }
    else if($listType === 'AssessmentTaken')
    {
        $query .=
            "SELECT
                assessmenttoolanswers.DateTaken,
                assessmenttools.Name AS ToolName,
                scores.Score,
                assessmenttoolanswers.AssessmentToolAnswerID,
                CONCAT(users.Lname, ', ', users.Fname, ' ', users.Mname) AS ActiveUser,
                assessmenttoolanswers.AssessmentToolID,
                assessmenttoolanswers.StudentID,
                autoassessments.Cutoff,
                autoassessments.Assessment
            FROM assessmenttoolanswers
            LEFT JOIN assessmenttools
                ON assessmenttools.AssessmentToolID = assessmenttoolanswers.AssessmentToolID
            LEFT JOIN scores
                ON scores.AssessmentToolAnswerID = assessmenttoolanswers.AssessmentToolAnswerID
            LEFT JOIN autoassessments
                ON autoassessments.AssessmentToolID = assessmenttoolanswers.AssessmentToolID
            LEFT JOIN users
                ON users.UserID = assessmenttoolanswers.ActiveUserID
            WHERE assessmenttoolanswers.StudentID = :StudentID ";

        if($keyword != '')
        {
            $query .= " AND assessmenttools.Name LIKE :keyword ";
        }

        if($order != '')
        {
            if($order['0']['dir'] == 'asc')
            {
                $query .= 'ORDER BY :orderColumn ASC ';
            }
            else
            {
                $query .= 'ORDER BY :orderColumn DESC ';
            }
        }
        else
        {
            $query .= 'ORDER BY DateTaken DESC, ToolName ASC ';
        }
    }
    else if($listType === 'Intake')
    {
        $query =
            "SELECT
                intakeformanswers.StudentID,
                intakeformanswers.IntakeFormAnswerID,
                intakeforms.IntakeFormName as FormID,
                CONCAT(users.Lname, ', ', users.Fname, ' ', users.Mname) AS User,
                intakeformanswers.DateTaken
             FROM intakeformanswers
             JOIN intakeforms
                ON intakeformanswers.IntakeFormID = intakeforms.IntakeFormID
             JOIN users
                ON users.UserID = intakeformanswers.ActiveUserID
             WHERE intakeformanswers.StudentID = :studentID  ";

        $db_handle->prepareStatement($query);
        $db_handle->bindVar(':studentID', $listTarget, PDO::PARAM_STR,0);
        $firstResult = $db_handle->runFetch();

        $query = '';
        $rowCount = 0;

        if(!empty($firstResult)){
            foreach($firstResult as $forms) {
                if($forms["FormID"] == "Intake for Adults") {
                    $query =
                        "SELECT DateTaken,

                            (SELECT
                                Answer
                             FROM quantitativeanswers
                             WHERE IntakeFormAnswerID = :intakeID
                             AND QuestionID = 220) as Result1,

                            (SELECT
                                Answer
                             FROM quantitativeanswers
                             WHERE IntakeFormAnswerID = :intakeID
                             AND QuestionID = 221) as Result2,

                            (SELECT
                                Answer
                             FROM qualitativeanswers
                             WHERE IntakeFormAnswerID = :intakeID
                             AND QuestionID = 222) as Result3,

                            (SELECT
                                Answer
                             FROM quantitativeanswers
                             WHERE IntakeFormAnswerID = :intakeID
                             AND QuestionID = 223) as Result4,

                            CONCAT(users.Lname, ', ', users.Fname, ' ', users.Mname) AS User,
                            IntakeFormAnswerID

                    FROM intakeformanswers
                    JOIN users
                        ON intakeformanswers.ActiveUserID = users.UserID
                    WHERE IntakeFormAnswerID = :intakeID
                    ORDER BY DateTaken DESC";
                } else {
                    $query =
                        "SELECT DateTaken,

                            (SELECT
                                Answer
                             FROM quantitativeanswers
                             WHERE IntakeFormAnswerID = :intakeID
                             AND QuestionID = 216) as Result1,

                            (SELECT
                                Answer
                             FROM quantitativeanswers
                             WHERE IntakeFormAnswerID = :intakeID
                             AND QuestionID = 217) as Result2,

                            (SELECT
                                Answer
                             FROM qualitativeanswers
                             WHERE IntakeFormAnswerID = :intakeID
                             AND QuestionID = 218) as Result3,

                            (SELECT
                                Answer
                             FROM quantitativeanswers
                             WHERE IntakeFormAnswerID = :intakeID
                             AND QuestionID = 219) as Result4,

                            CONCAT(users.Lname, ', ', users.Fname, ' ', users.Mname) AS User,
                            IntakeFormAnswerID

                    FROM intakeformanswers
                    JOIN users
                        ON intakeformanswers.ActiveUserID = users.UserID
                    WHERE IntakeFormAnswerID = :intakeID
                    ORDER BY DateTaken DESC";
                }
                
                $db_handle->prepareStatement($query);
                
                $db_handle->bindVar(':studentID', $listTarget, PDO::PARAM_INT,0);
                $db_handle->bindVar(':intakeID', $forms["IntakeFormAnswerID"], PDO::PARAM_INT,0);
                
                $result = $db_handle->runFetch();
                $rowCount += $db_handle->getFetchCount();

                if($rowCount != 0)
                {
                    foreach($result as $row)
                    {
                        $recordsFiltered = get_total_all_records('Intake', $listTarget);

                        $subArray["DT_RowId"] = $forms["IntakeFormAnswerID"];
                        $phpdate = strtotime($row['DateTaken']);
                        $subArray[] = date('M d, Y <\b\r> h:i a', $phpdate);
                        if(isset($row['Result1'])) {
                            $subArray[] = ($row['Result1' ]== '1' ? 'Yes' : 'No');
                        } else {
                            $subArray[] = '(blank)';
                        }
                        if(isset($row['Result2'])) {
                            $subArray[] = ($row['Result2' ]== '1' ? 'Yes' : 'No');
                        } else {
                            $subArray[] = '(blank)';
                        }
                        if(isset($row['Result3']) && $row['Result3'] != '') {
                            $subArray[] = $row['Result3'];
                        } else {
                            $subArray[] = '(blank)';
                        }
                        if(isset($row['Result4'])) {
                            if($row['Result4'] == '0') {
                                $subArray[] = 'No changes';
                            } else if($row['Result4'] == '1') {
                                $subArray[] = 'Slightly Improved (less than 20%)';
                            } else if($row['Result4'] == '2') {
                                $subArray[] = 'Moderately Improved (20%-60%)';
                            } else if($row['Result4'] == '3') {
                                $subArray[] = 'Much improved (60%-80%)';
                            } else if($row['Result4'] == '4') {
                                $subArray[] = 'Very much improved (more than 80%)';
                            }
                        } else {
                            $subArray[] = '(blank)';
                        }

                        $subArray[] = $forms["User"];
                    }
                    $tmp[] = $subArray;
                    $subArray = [];
                } 
                else
                {
                    $tmp = [];
                }
            }
        }

        $output = array(
            "draw" => intval($draw),
            "recordsTotal" => $rowCount,
            "recordsFiltered" => $recordsFiltered,
            "data" => $tmp
        );

        return $output;
    }

    if($length != '')
    {
        $query .= 'LIMIT '.$data['start'].', '.$length;
    }

    $statement = $db_handle->prepareStatement($query);

    if($keyword != '')
    {
        $db_handle->bindVar(':keyword', '%'.$keyword.'%', PDO::PARAM_STR,0);
    }

    if($order != '')
    {
        $db_handle->bindVar(':orderColumn', ($order['0']['column'] + 1), PDO::PARAM_INT, 0);
    }

    if($listType === 'AssessmentTaken')
    {
        $db_handle->bindVar(':StudentID', $listTarget, PDO::PARAM_INT,0);
    }

    $result = $db_handle->runFetch();
    $rowCount = $db_handle->getFetchCount();

    if($rowCount != 0)
    {
        foreach($result as $row)
        {
            if($listType === 'Student')
            {
                $recordsFiltered = get_total_all_records('Student', 0);

                $subArray["DT_RowId"] = $row["StudentID"];
                if($_SESSION['account_type'] == '77')
                {
                    $subArray[] = $row["Lname"].", ".$row["Fname"]." ".$row["Mname"];
                } else
                {
                    $subArray[] = $row["GccCode"];
                }
                $subArray[] = $row["StudentID"];
                $subArray[] = $row["CollegeName"]." - ".$row["CourseYear"];
                $subArray[] = $row["Gender"];
                $age = calculateAge($row["Bdate"]);
                if($age == 'N/A')
                {
                    if(isset($row["Age"]))
                    {
                        $subArray[] = $row["Age"];
                    }
                    else
                    {
                        $subArray[] = $age;
                    }
                } else
                {
                    $subArray[] = $age;
                }
                
                $ageGroup = getAgeGroup($row["StudentID"]);
                if($row['NumOfIntakes'] == 0) {
                    $subArray[] = 
                        '<a class="btn btn-info btn-sm btn-block" href="student.assessment.history.php?id='.$row["StudentID"].'">
                            <i class="pe-7s-info"></i>Assessment History
                        </a>
                        <a href="assessment.informed.consent.php?id='.$row["StudentID"].'&ag='.$ageGroup.'&from=intake" class="btn btn-success btn-xs btn-block">
                            <i class="icon_check_alt"></i>Apply Intake
                        </a>';
                } 
                else
                {
                    $subArray[] = 
                        '<a class="btn btn-info btn-sm btn-block" href="student.assessment.history.php?id='.$row["StudentID"].'">
                            <i class="pe-7s-info"></i>Assessment History
                         </a>
                         <a href="assessment.informed.consent.php?id='.$row["StudentID"].'&ag='.$ageGroup.'&from=intake" class="btn btn-success btn-xs btn-block">
                            <i class="icon_check_alt"></i>Apply Intake
                         </a>
                         <a href="assessment.select.tools.php?id='.$row["StudentID"].'" class="btn btn-primary btn-xs btn-block">
                                Apply Assessment Tool
                         </a>';
                }
            } else if($listType === 'Users')
            {
                $recordsFiltered = get_total_all_records('Users', 0);

                $subArray["DT_RowId"] = $row["UserID"];
                $subArray[] = $row["User"];
                $subArray[] = $row["PhoneNum"];
                $subArray[] = $row["Agency"];
                $subArray[] = translateDate($row["DateAdded"]);
                $subArray[] = '<a class="btn btn-info btn-xs center-block" href="user.edit.php?id='.$row["UserID"].'">
                        <i class="fa fa-pencil-square-o"></i>Edit Info
                     </a>';
            }
            else if($listType === 'Tool')
            {
                $recordsFiltered = get_total_all_records('Tool', 0);

                $subArray["DT_RowId"] = $row["AssessmentToolID"];
                $subArray[] = $row["Name"];
                $subArray[] = 
                    '<a class="btn btn-info btn-xs center-block" href="forms.edit.tool.php?id='.$row["AssessmentToolID"].'">
                        <i class="fa fa-pencil-square-o"></i>Edit Tool
                     </a>';
            }
            else if($listType === 'Evac')
            {
                $recordsFiltered = get_total_all_records('Evac', 0);
                $subArray["DT_RowId"] = $row["EvacuationCentersID"];
                $subArray[] = $row["EvacName"];
                //$subArray[] = getFullAddress($row["EvacAddress"]);
                $subArray[] = $row["EvacManager"];
                $subArray[] = $row["EvacManagerContact"];
                if($_SESSION['account_type'] == '77')
                {
                    $subArray[] = '<a class="btn btn-info btn-xs center-block" href="evac.edit.php?evacid='.$row["EvacuationCentersID"].'">
                        <i class="fa fa-pencil-square-o"></i>Edit Info
                     </a>';
                }
            }
            else if($listType === 'AssessmentTaken')
            {
                $recordsFiltered = get_total_all_records('AssessmentTaken', $listTarget);

                $subArray["DT_RowId"] = $row["AssessmentToolAnswerID"];

                $phpdate = strtotime($row['DateTaken']);
                $subArray[] = date('M d, Y <\b\r> h:i a', $phpdate);
                $subArray[] = $row["ToolName"];
                $subArray[] = $row["Score"];

                if(isset($row['Assessment'])) {
                    if($row['Score'] >= $row['Cutoff']) {
                        $subArray[] = $row['Assessment'];
                    } else {
                        $subArray[] = 'Below cutoff';
                    }
                } else {
                    $subArray[] = 'No auto-assessment available for this tool.';
                }
                $subArray[] = $row["ActiveUser"];
            }

            $tmp[] = $subArray;
            $subArray = [];

        }
    } 
    else
    {
        $tmp = [];
    }


    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => $rowCount,
        "recordsFiltered" => $recordsFiltered,
        "data" => $tmp
    );

    return $output;
}

function get_total_all_records($type, $target = '')
{
    $db_handle = new DBController();

    if($type === 'Student')
    {
        $db_handle->prepareStatement("SELECT COUNT(*) AS total FROM `students`");
        $result = $db_handle->runFetch();
    }
    else if($type === 'Users')
    {
        $db_handle->prepareStatement("SELECT COUNT(*) AS total FROM `user`");
        $result = $db_handle->runFetch();
    }
    else if($type === 'Tool')
    {
        $db_handle->prepareStatement("SELECT COUNT(*) AS total FROM `assessmenttools`");
        $result = $db_handle->runFetch();
    }
    else if($type === 'Evac')
    {
        $db_handle->prepareStatement("SELECT COUNT(*) AS total FROM `evacuation_centers`");
        $result = $db_handle->runFetch();
    }
    else if($type === 'Intake')
    {
        $db_handle->prepareStatement("SELECT COUNT(*) AS total FROM intakeformanswers WHERE intakeformanswers.StudentID = :id");
        $db_handle->bindVar(':id', $target, PDO::PARAM_INT, 0);
        $result = $db_handle->runFetch();
    }
    else if($type === 'AssessmentTaken')
    {
        $db_handle->prepareStatement("SELECT COUNT(*) AS total FROM assessmenttoolanswers WHERE assessmenttoolanswers.StudentID = :id");
        $db_handle->bindVar(':id', $target, PDO::PARAM_INT, 0);
        $result = $db_handle->runFetch();
    }


    return $result[0]['total'];
}
?>
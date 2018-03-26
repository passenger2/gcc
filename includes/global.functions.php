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

function includeListFunctions()
{
    include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/global.functions.list.php");
}

function includeVisualizationFunctions()
{
    include($_SERVER['DOCUMENT_ROOT'].ROOT."includes/global.functions.visualization.php");
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

function getColleges()
# Author: Laranjo, Sam Paul L.
# Last Modified: 02-06-18
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT * FROM colleges ORDER BY CollegeName");
    $colleges = $db_handle->runFetch();

    return $colleges;
}

function getDepartments()
# Author: Laranjo, Sam Paul L.
# Last Modified: 02-06-18
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT * FROM departments ORDER BY DepartmentName");
    $departments = $db_handle->runFetch();

    return $departments;
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
                assessmenttools.ItemsStartAt,
                assessmenttoolanswers.StudentID,
                CONCAT(students.Lname,', ',students.Fname,' ',students.Mname) AS StudentName,
                CONCAT(COALESCE(users.Lname, ''),', ', COALESCE(users.Fname, ''), ' ', COALESCE(users.Mname, '')) as ActiveUser,
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
# Last Modified: 01-29-18
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
                questions.ItemNumber,
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
                WHERE quantitativeanswers.AssessmentToolAnswerID = :AssessmentToolAnswerID1
                UNION
                SELECT
                    qualitativeanswers.AssessmentToolAnswerID,
                    qualitativeanswers.QualitativeAnswerID,
                    qualitativeanswers.QuestionID,
                    qualitativeanswers.Answer
                FROM qualitativeanswers
                WHERE qualitativeanswers.AssessmentToolAnswerID = :AssessmentToolAnswerID2
                ) AnswersTable
                ON
                    questions.QuestionID = AnswersTable.QuestionID
                AND
                    assessmenttoolanswers.AssessmentToolAnswerID = AnswersTable.AssessmentToolAnswerID
            LEFT JOIN htmlforms
                ON htmlforms.HtmlFormID = questions.HtmlFormID
            WHERE assessmenttoolanswers.AssessmentToolAnswerID = :AssessmentToolAnswerID3");
    }
    
    $db_handle->bindVar(':AssessmentToolAnswerID1', $faID, PDO::PARAM_INT,0);
    $db_handle->bindVar(':AssessmentToolAnswerID2', $faID, PDO::PARAM_INT,0);
    $db_handle->bindVar(':AssessmentToolAnswerID3', $faID, PDO::PARAM_INT,0);
    #die(print_r($db_handle->runFetch()));
    $answers = processAnswers($db_handle->runFetch());
    
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
    } else if($answerType == '2' && strlen($answer) != 0)
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
        
        
        $db_handle->bindVar(":QuestionID", $questionID, PDO::PARAM_INT, 0);
        $db_handle->bindVar(":formAnswerID", $formAnswerID, PDO::PARAM_INT, 0);

        $db_handle->runUpdate();
    } else if($answerType == '2' && strlen($answer) != 0)
    {
        $db_handle->bindVar(":Answer", $answer, PDO::PARAM_STR, 0);
        
        
        $db_handle->bindVar(":QuestionID", $questionID, PDO::PARAM_INT, 0);
        $db_handle->bindVar(":formAnswerID", $formAnswerID, PDO::PARAM_INT, 0);

        $db_handle->runUpdate();
    }
}
#---- db insert functions end ----

#---- db update functions----
function updateAnswers($answerType = '1', $answer = '', $answerID = '0')
# Author: Laranjo, Sam Paul L.
# Last Modified: 01-29-18
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $query = "";
    if($answerType == '1')
    {
        $query =
            "UPDATE
                `quantitativeanswers`
            SET `Answer` = :answer
            WHERE `quantitativeanswers`.`QuantitativeAnswerID` = :answerID";
        
    } else if($answerType == '2')
    {
        $query =
            "UPDATE
                `qualitativeanswers`
            SET `Answer` = :answer
            WHERE `qualitativeanswers`.`QualitativeAnswerID` = :answerID";
    }
    #die($query);
    $db_handle->prepareStatement($query);
    if($answerType == '1')
    {
        $db_handle->bindVar(":answer", $answer, PDO::PARAM_INT, 0);
        $db_handle->bindVar(":answerID", $answerID, PDO::PARAM_INT, 0);

        $db_handle->runUpdate();
    } else if($answerType == '2' && strlen($answer) != 0)
    {
        $db_handle->bindVar(":answer", $answer, PDO::PARAM_STR, 0);
        $db_handle->bindVar(":answerID", $answerID, PDO::PARAM_INT, 0);

        $db_handle->runUpdate();
    }
}
#---- db update functions end ----

#---- db delete functions----
function deleteAnswers($answerType = '1', $answerID = '0')
# Author: Laranjo, Sam Paul L.
# Last Modified: 01-29-18
# Modified by: Laranjo, Sam Paul L.
{
    $db_handle = new DBController();
    $query = "";
    if($answerType == '1')
    {
        $query =
            "DELETE FROM `quantitativeanswers`
            WHERE `quantitativeanswers`.`QuantitativeAnswerID` = :answerID";
        
    } else if($answerType == '2')
    {
        $query =
            "DELETE FROM `qualitativeanswers` WHERE `qualitativeanswers`.`QualitativeAnswerID` = :answerID";
    }
    #die($query);
    $db_handle->prepareStatement($query);
    if($answerType == '1')
    {
        $db_handle->bindVar(":answerID", $answerID, PDO::PARAM_INT, 0);

        $db_handle->runUpdate();
    } else if($answerType == '2')
    {
        $db_handle->bindVar(":answerID", $answerID, PDO::PARAM_INT, 0);

        $db_handle->runUpdate();
    }
}
#---- db delete functions end ----

#---- assessment functions ----
#DIRI

function getTotalRecords($type, $target = '')
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
    else if($type === 'ReportsOverview')
    {
        $db_handle->prepareStatement("SELECT COUNT(*) AS total FROM `assessmenttoolanswers` LEFT JOIN students ON students.StudentID = assessmenttoolanswers.StudentID LEFT JOIN departments ON departments.DepartmentID = students.DepartmentID JOIN colleges ON colleges.CollegeID = departments.DepartmentID AND colleges.CollegeID = :collegeID");
        $db_handle->bindVar(':collegeID', $target, PDO::PARAM_INT, 0);
        $result = $db_handle->runFetch();
    }

    return $result[0]['total'];
}

function processAnswers($data)
# Author: Laranjo, Sam Paul L.
# Last Modified: 01-29-18
# Modified by: Laranjo, Sam Paul L.
{
    #die(print_r($data));
    $processedData = [];
    $questionIDLog = [];

    foreach($data as $entries)
    {
        #die(print_r($entry));
        $tempArray = [];
        if(!in_array($entries['QuestionID'], $questionIDLog))
        {
            $questionIDLog[] = $entries['QuestionID'];
            foreach($entries as $key => $entry)
            {
                $tempArray[$key] = $entry;
            }

            $processedData[$entries['QuestionID']] = $tempArray;
        } else
        {
            $processedData[$entries['QuestionID']]['Answer'] .= ",".$entries['Answer'];
            $processedData[$entries['QuestionID']]['AnswerID'] .= ",".$entries['AnswerID'];
        }
    }
    
    return $processedData;
}
?>
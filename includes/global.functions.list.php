<?php
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
    $recordsTotal = 0;
    $type = $listType;
    $idpID = $listTarget;

    if(isset($_POST["draw"])) $draw = $data["draw"];
    if(isset($data["search"]["value"])) $keyword = $data["search"]["value"];
    if(isset($data["order"])) $order = $data["order"];
    if(isset($data["length"])) $length = $data["length"];

    if($listType === 'Student')
    {
        if($_SESSION["account_type"] == "77")
        {
            $query .=
                "SELECT SQL_CALC_FOUND_ROWS
                    CONCAT(COALESCE(i.Lname, ''),', ', COALESCE(i.Fname, ''), ' ', COALESCE(i.Mname, '')) AS StudentName,
                    i.GccCode,
                    i.StudentID,
                    colleges.CollegeName,
                    COUNT(scores.ScoreID) AS ProblematicScores,
                    COALESCE(
                        MIN(j.IntakeFormAnswerID),
                        0
                    ) AS NumOfIntakes,
                    Age,
                    i.CourseYear,
                    Gender,
                    Bdate,
                    colleges.CollegeName,
                    departments.DepartmentName
                FROM `students` i 
                LEFT JOIN intakeformanswers j
                    ON i.StudentID = j.StudentID
                LEFT JOIN departments
                    ON i.DepartmentID = departments.DepartmentID
                JOIN colleges
                    ON colleges.CollegeID = departments.CollegeID
                    ";
            if(isset($_SESSION["CollegeID"]))
            {
                $query .= "AND colleges.CollegeID = :collegeID
                    ";
            }
            $query .=
                "LEFT JOIN assessmenttoolanswers
                    ON assessmenttoolanswers.StudentID = i.StudentID
                LEFT JOIN autoassessments
                    ON autoassessments.AssessmentToolID = assessmenttoolanswers.AssessmentToolID
                LEFT JOIN scores
                    ON scores.AssessmentToolAnswerID = assessmenttoolanswers.AssessmentToolAnswerID
                    AND scores.Score >= autoassessments.Cutoff ";
        } else
        {
            $query .=
                "SELECT SQL_CALC_FOUND_ROWS
                    i.GccCode,
                    i.StudentID,
                    colleges.CollegeName,
                    COALESCE(
                        MIN(j.IntakeFormAnswerID),
                        0
                    ) AS NumOfIntakes,
                    i.CourseYear,
                    colleges.CollegeName,
                    departments.DepartmentName
                FROM `students` i 
                LEFT JOIN intakeformanswers j
                    ON i.StudentID = j.StudentID
                LEFT JOIN departments
                    ON i.DepartmentID = departments.DepartmentID
                LEFT JOIN colleges
                    ON colleges.CollegeID = departments.CollegeID ";
        }

        if($keyword != '')
        {
            if($_SESSION["account_type"] == "77")
            {
                $query .=
                    " WHERE CONCAT(COALESCE(i.Lname, ''),', ', COALESCE(i.Fname, ''), ' ', COALESCE(i.Mname, '')) LIKE :keyword
                      OR i.GccCode LIKE :keyword
                      OR i.StudentID LIKE :keyword 
                      OR colleges.CollegeName LIKE :keyword ";
            } else
            {
                $query .=
                    " WHERE i.GccCode LIKE :keyword ";
            }
            
        }

                  /*OR i.Fname LIKE :keyword
                  OR i.Mname LIKE :keyword
                  OR i.Fname LIKE :keyword*/
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
            "SELECT SQL_CALC_FOUND_ROWS account.AccountID, user.UserID,
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
            "SELECT SQL_CALC_FOUND_ROWS *
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
            "SELECT SQL_CALC_FOUND_ROWS
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
            "SELECT SQL_CALC_FOUND_ROWS
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
    else if($listType === 'ReportsOverview')
    {
        $query .=
            "SELECT SQL_CALC_FOUND_ROWS
                CONCAT(COALESCE(students.Lname, ''),', ', COALESCE(students.Fname, ''), ' ', COALESCE(students.Mname, '')) AS StudentName,
                assessmenttoolanswers.StudentID,
                students.GccCode,
                assessmenttools.Name AS ToolName,
                scores.Score,
                assessmenttoolanswers.DateTaken,
                assessmenttoolanswers.AssessmentToolAnswerID,
                assessmenttoolanswers.AssessmentToolID
            FROM `assessmenttoolanswers`
            LEFT JOIN students
                ON students.StudentID = assessmenttoolanswers.StudentID
            LEFT JOIN departments
                ON departments.DepartmentID = students.DepartmentID
            JOIN colleges
                ON colleges.CollegeID = departments.CollegeID
                ";
        if(isset($_SESSION["CollegeID"]))
        {
            $query .= "AND colleges.CollegeID = :collegeID
            ";
        }
        $query .=
            "LEFT JOIN assessmenttools
                ON assessmenttools.AssessmentToolID = assessmenttoolanswers.AssessmentToolID
            LEFT JOIN scores
                ON scores.AssessmentToolAnswerID = assessmenttoolanswers.AssessmentToolAnswerID ";

        if($keyword != '')
        {
            $query .=
                " WHERE CONCAT(COALESCE(students.Lname, ''),', ', COALESCE(students.Fname, ''), ' ', COALESCE(students.Mname, '')) LIKE :keyword
                OR assessmenttools.Name LIKE :keyword 
                OR assessmenttoolanswers.StudentID LIKE :keyword 
                OR students.GccCode LIKE :keyword ";
        }
        if($order != '')
        {
            
            if(!empty($order['1']))
            {
                if($order['0']['dir'] == 'asc')
                {
                    if($order['1']['dir'] == 'asc')
                    {
                        $query .=
                            "GROUP BY
                                assessmenttoolanswers.AssessmentToolAnswerID
                             ORDER BY :orderColumn ASC, :orderColumn2 ASC ";
                    }
                    else
                    {
                        $query .=
                            "GROUP BY
                                assessmenttoolanswers.AssessmentToolAnswerID
                            ORDER BY :orderColumn ASC, :orderColumn2 DESC ";
                    }
                } else
                {
                    if($order['1']['dir'] == 'asc')
                    {
                        $query .=
                            "GROUP BY
                                assessmenttoolanswers.AssessmentToolAnswerID
                             ORDER BY :orderColumn DESC, :orderColumn2 ASC ";
                    }
                    else
                    {
                        $query .=
                            "GROUP BY
                                assessmenttoolanswers.AssessmentToolAnswerID
                            ORDER BY :orderColumn DESC, :orderColumn2 DESC ";
                    }
                }
            } else
            {
                if($order['0']['dir'] == 'asc')
                {
                    $query .=
                        "GROUP BY
                            assessmenttoolanswers.AssessmentToolAnswerID
                         ORDER BY :orderColumn ASC ";
                }
                else
                {
                    $query .=
                        "GROUP BY
                            assessmenttoolanswers.AssessmentToolAnswerID
                        ORDER BY :orderColumn DESC ";
                }
            }

        }
        else
        {
            $query .=
                "GROUP BY
                    assessmenttoolanswers.AssessmentToolAnswerID
                ORDER BY 1 ASC ";
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
                        $recordsTotal = getTotalRecords('Intake', $listTarget);

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
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $rowCount,
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
        if(!empty($order['1']))
        {
            $db_handle->bindVar(':orderColumn', ($order['0']['column'] + 1), PDO::PARAM_INT, 0);
            $db_handle->bindVar(':orderColumn2', ($order['1']['column'] + 1), PDO::PARAM_INT, 0);
            
        } else
        {
            $db_handle->bindVar(':orderColumn', ($order['0']['column'] + 1), PDO::PARAM_INT, 0);
        }
    }

    if($listType === 'AssessmentTaken')
    {
        $db_handle->bindVar(':StudentID', $listTarget, PDO::PARAM_INT,0);
    }
    
    if(($listType === 'Student' || $listType === 'ReportsOverview') && isset($_SESSION["CollegeID"]))
    {
        $db_handle->bindVar(':collegeID', $_SESSION["CollegeID"], PDO::PARAM_INT,0);
    }

    $result = $db_handle->runFetch();
    $rowCount = $db_handle->getUnlimitedRowCount();

    if($rowCount != 0)
    {
        foreach($result as $row)
        {
            if($listType === 'Student')
            {
                $recordsTotal = getTotalRecords('Student', 0);

                $subArray["DT_RowId"] = $row["StudentID"];
                if($_SESSION['account_type'] == '77')
                {
                    $subArray[] = $row["StudentName"];
                    $subArray[] = $row["GccCode"];
                    $subArray[] = $row["StudentID"];
                    $subArray[] = $row["CollegeName"]." - ".$row["CourseYear"];
                    if($row["ProblematicScores"] > 0)
                    {
                        $subArray[] = $row["ProblematicScores"].'<i class="fa fa-warning fa-fw"></i>';
                    } else
                    {
                        $subArray[] = '<i class="fa fa-check fa-fw"></i>';
                    }
                } else
                {
                    $subArray[] = $row["GccCode"];
                    $subArray[] = $row["CollegeName"]." - ".$row["CourseYear"];
                }
                /*$age = calculateAge($row["Bdate"]);
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
                }*/
                
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
                $recordsTotal = getTotalRecords('Users', 0);

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
                $recordsTotal = getTotalRecords('Tool', 0);

                $subArray["DT_RowId"] = $row["AssessmentToolID"];
                $subArray[] = $row["Name"];
                $subArray[] = 
                    '<a class="btn btn-info btn-xs center-block" href="forms.edit.tool.php?id='.$row["AssessmentToolID"].'">
                        <i class="fa fa-pencil-square-o"></i>Edit Tool
                     </a>';
            }
            else if($listType === 'Evac')
            {
                $recordsTotal = getTotalRecords('Evac', 0);
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
                $recordsTotal = getTotalRecords('AssessmentTaken', $listTarget);

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
            else if($listType === 'ReportsOverview')
            {
                $recordsTotal = getTotalRecords('ReportsOverview', $_SESSION["CollegeID"]);

                $subArray["DT_RowId"] = $row["AssessmentToolAnswerID"];
                
                $subArray[] = $row["StudentName"];
                $subArray[] = $row["StudentID"];
                $subArray[] = $row["GccCode"];
                $subArray[] = $row["ToolName"];
                $subArray[] = $row["Score"];
                $phpdate = strtotime($row['DateTaken']);
                $subArray[] = date('M d, Y <\b\r> h:i a', $phpdate);
                
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
        "recordsTotal" => $recordsTotal,
        "recordsFiltered" => $rowCount,
        "data" => $tmp
    );

    return $output;
}
?>
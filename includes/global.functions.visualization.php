<?php
function getData($category = '', $usersCollegeID = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 03-20-18
# Modified by: Laranjo, Sam Paul L.
{
    global $db_handle;
    
    $db_handle->prepareStatement(
        "SELECT
            colleges.CollegeName AS 'College Name',
            colleges.CollegeCode AS 'College Code',
            COUNT(*) AS 'Enrolled Population'
        FROM `students`
        LEFT JOIN departments
            ON departments.DepartmentID = students.DepartmentID
        LEFT JOIN colleges
            ON colleges.CollegeID = departments.DepartmentID
        GROUP BY colleges.CollegeID");
    $result = $db_handle->runFetch();
    
    return $result;
}

function getScores($assessmentToolID = '', $usersCollegeID = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 03-20-18
# Modified by: Laranjo, Sam Paul L.
{
    global $db_handle;
    $isGlobalAdmin = (empty($_SESSION["CollegeID"]) ? true : false);
    
    $query =
        "SELECT
            COUNT(*) AS 'Number of Students',
            scores.Score,
            assessmenttools.Name AS 'Assessment Tool'
        FROM scores
        LEFT JOIN assessmenttoolanswers
            ON assessmenttoolanswers.AssessmentToolAnswerID = scores.AssessmentToolAnswerID
        LEFT JOIN assessmenttools
            ON assessmenttools.AssessmentToolID = assessmenttoolanswers.AssessmentToolID ";
    
    if(!$isGlobalAdmin)
    {
        $query .= "
        LEFT JOIN students
            ON students.StudentID = assessmenttoolanswers.StudentID
        LEFT JOIN departments
            ON departments.DepartmentID = students.DepartmentID ";
    }
    
    $query .= " WHERE assessmenttools.AssessmentToolID = :assessmentToolID ";
    
    if(!$isGlobalAdmin)
    {
        $query .=
            "AND departments.CollegeID = :usersCollegeID ";
    }
    
    $query .= "
            GROUP BY Score ";
    
    $db_handle->prepareStatement($query);
    $db_handle->bindVar(":assessmentToolID", $assessmentToolID, PDO::PARAM_INT, 0);
    if(!$isGlobalAdmin)
    {
        $db_handle->bindVar(":usersCollegeID", $usersCollegeID, PDO::PARAM_INT, 0);
    }
    $result = $db_handle->runFetch();
    
    return $result;
}

function getPassFail($assessmentToolID = '', $usersCollegeID = '')
# Author: Laranjo, Sam Paul L.
# Last Modified: 03-20-18
# Modified by: Laranjo, Sam Paul L.
{
    global $db_handle;
    $isGlobalAdmin = (empty($_SESSION["CollegeID"]) ? true : false);
    
    if(!$isGlobalAdmin)
    {
        $query = 
            "SELECT
                (SELECT
                    COUNT(*)
                FROM `scores`
                LEFT JOIN assessmenttoolanswers
                    ON assessmenttoolanswers.AssessmentToolAnswerID = scores.AssessmentToolAnswerID
                LEFT JOIN autoassessments
                    ON autoassessments.AssessmentToolID = assessmenttoolanswers.AssessmentToolID
                LEFT JOIN students
                    ON students.StudentID = assessmenttoolanswers.StudentID
                LEFT JOIN departments
                    ON departments.DepartmentID = students.DepartmentID
                LEFT JOIN colleges
                    ON colleges.CollegeID = departments.CollegeID
                WHERE
                    scores.Score < autoassessments.Cutoff
                    AND
                    assessmenttoolanswers.AssessmentToolID = :assessmentToolID1
                    AND colleges.CollegeID = :usersCollegeID1) AS 'Number of Students', 'Passed'
            UNION
            SELECT
                (SELECT
                    COUNT(*)
                FROM `scores`
                LEFT JOIN assessmenttoolanswers
                    ON assessmenttoolanswers.AssessmentToolAnswerID = scores.AssessmentToolAnswerID
                LEFT JOIN autoassessments
                    ON autoassessments.AssessmentToolID = assessmenttoolanswers.AssessmentToolID
                LEFT JOIN students
                    ON students.StudentID = assessmenttoolanswers.StudentID
                LEFT JOIN departments
                    ON departments.DepartmentID = students.DepartmentID
                LEFT JOIN colleges
                    ON colleges.CollegeID = departments.CollegeID
                WHERE
                scores.Score >= autoassessments.Cutoff
                    AND
                    assessmenttoolanswers.AssessmentToolID = :assessmentToolID2
                    AND colleges.CollegeID = :usersCollegeID2), 'Failed' ";
    } else
    {
        $query = 
            "SELECT
                (SELECT
                    COUNT(*)
                FROM `scores`
                LEFT JOIN assessmenttoolanswers
                    ON assessmenttoolanswers.AssessmentToolAnswerID = scores.AssessmentToolAnswerID
                LEFT JOIN autoassessments
                    ON autoassessments.AssessmentToolID = assessmenttoolanswers.AssessmentToolID
                WHERE
                    scores.Score < autoassessments.Cutoff
                    AND
                    assessmenttoolanswers.AssessmentToolID = :assessmentToolID1 ) AS 'Number of Students', 'Passed'
            UNION
            SELECT
                (SELECT
                    COUNT(*)
                FROM `scores`
                LEFT JOIN assessmenttoolanswers
                    ON assessmenttoolanswers.AssessmentToolAnswerID = scores.AssessmentToolAnswerID
                LEFT JOIN autoassessments
                    ON autoassessments.AssessmentToolID = assessmenttoolanswers.AssessmentToolID
                WHERE
                    scores.Score >= autoassessments.Cutoff
                    AND
                    assessmenttoolanswers.AssessmentToolID = :assessmentToolID2 ), 'Failed'";
    }
    
    #die($query);
    $db_handle->prepareStatement($query);
    $db_handle->bindVar(":assessmentToolID1", $assessmentToolID, PDO::PARAM_INT, 0);
    $db_handle->bindVar(":assessmentToolID2", $assessmentToolID, PDO::PARAM_INT, 0);
    if(!$isGlobalAdmin)
    {
        $db_handle->bindVar(":usersCollegeID1", $usersCollegeID, PDO::PARAM_INT, 0);
        $db_handle->bindVar(":usersCollegeID2", $usersCollegeID, PDO::PARAM_INT, 0);
    }
    $result = $db_handle->runFetch();
    
    return $result;
}
?>
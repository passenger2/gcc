<?php
include("../initialize.php");
includeCore();

$_SESSION['loc'] = $_SERVER['PHP_SELF'];
$colleges = getColleges();
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("Student Enrollment"); ?>

    </head>

    <body>

        <div id="wrapper">

            <?php includeNav(); ?>

            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/pages/student.list.php">Students</a></li>
                        <li class="breadcrumb-item active">Student Enrollment</li>
                    </ol>
                </div>
                <div class="row">
                    <?php
                    if(isset($_GET['status']) && $_GET['status'] == 'success')
                    {
                    ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        Registration Successful!
                    </div>
                    <?php
                    } else if (isset($_GET['status']) && $_GET['status'] == 'err1')
                    {
                    ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        An error occured during the process. If this issue persists, please contact the system admin.
                    </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="title">&nbsp;Demographic Profile</h4>  
                            </div>
                            <form method="POST" action="/includes/actions/student.process.enrollment.php">
                                <div class="panel-body">
                                    <div class="col-md-12">

                                        <div id="name_div" class="col-md-12">
                                            <h5><b>Student's Name</b></h5>
                                            <div class="form-group col-md-4">
                                                <input class="form-control" id = 'Lname' name='Lname' placeholder="Last name">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <input class="form-control" name='Fname' placeholder="First name">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <input class="form-control" name='Mname' placeholder="Middle Name">
                                            </div>
                                        </div>

                                        <div  id = "personal_info_div" class="col-lg-6">
                                            <h5><b>Personal Information</b></h5>

                                            <div class="form-group col-md-6">
                                                <input class="form-control" name='Nickname' placeholder="Nickname">           
                                            </div>

                                            <div class="form-group col-md-6">
                                                <select name='Gender' class="form-control">
                                                    <option selected disabled>Sex</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>             
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input type="date" name='Bdate' class="form-control">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input class="form-control" name='Age' placeholder="Age" type="number" min="0">
                                            </div>

                                            <div class="form-group col-md-12">
                                                <input class="form-control" id='PlaceOfBirth' placeholder="Place of birth (type barangay first)">
                                                <input name='PlaceOfBirth' type="hidden" value="">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input class="form-control" name='OrdinalPosition' placeholder="Ordinal Position (number)">
                                            </div>

                                            <!--<div class="form-group col-md-6">
<input class="form-control" name='Ethnicity' placeholder="Ethnicity">           
</div>-->

                                            <div class="form-group col-md-6">
                                                <input class="form-control" name='Citizenship' placeholder="Citizenship">           
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input class="form-control" name='Religion' placeholder="Religious Affiliation">        
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input class="form-control" name='PhoneNum' placeholder="Phone Number" id="PhoneNum">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input class="form-control" id='Email' name='Email' placeholder="your@mail.com">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <select name='LivingWith' id='LivingWith' class="form-control">
                                                    <option selected disabled>Currently Living with: </option>
                                                    <option value="Parents">Parents</option>
                                                    <option value="Relatives">Relatives</option>
                                                    <option value="Boarding House">Boarding House</option>
                                                    <option value="Others">Others (specify)</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6" id="SpecLivingWith" style="display:none">
                                                <input class="form-control" name="SpecLivingWith" placeholder="Currently living with">
                                            </div>

                                            <div class="form-group col-md-12">
                                                <input class="form-control" id="Address" placeholder="Address (type barangay first)">
                                                <input name='Address' type="hidden" value="">

                                            </div>

                                            <div class="form-group col-md-12">
                                                <input class="form-control" name="SpecAddress" placeholder="Specific Address">
                                            </div>
                                        </div>

                                        <div id = "school_details_div">
                                            <div class="col-lg-6">
                                                <h5><b>School Details</b></h5>

                                                <div class="form-group col-md-6">
                                                    <input class="form-control" id='GCCCode' name='GCCCode' placeholder="GCC Code" required>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <input class="form-control" id='IDNo' name='IDNo' placeholder="ID Number" required>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <select id='College' class="form-control" onChange="getDept(this.value);">
                                                        <option selected disabled>College</option>
                                                        <?php
                                                        foreach($colleges as $college)
                                                        {
                                                        ?>
                                                        <option value="<?php echo($college['CollegeID']); ?>"><?php echo($college['CollegeName']); ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <select name='Departtment' id='Department' class="form-control">
                                                        <option selected disabled>Department</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <input class="form-control" id='Course' name='Course' placeholder="Course">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <select class="form-control" name='YearLevel' id="YearLevel">
                                                        <option selected disabled>Level</option>
                                                        <option value="1st year">1st year</option>
                                                        <option value="2nd year">2nd year</option>
                                                        <option value="3rd year">3rd year</option>
                                                        <option value="4th year">4th year</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <input class="form-control" id='PrevGPA' name='PrevGPA' placeholder="GPA (Previous Sem)">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <select name='ScholarshipType' id='ScholarshipType' class="form-control">
                                                        <option selected disabled>Scholarship Grant</option>
                                                        <option value="Regular Paying Student">Regular Paying Student</option>
                                                        <option disabled>------------</option>
                                                        <option value="Chancellor's List">Chancellor's List</option>
                                                        <option value="CHED">CHED</option>
                                                        <option value="Dean's List">Dean's List</option>
                                                        <option value="DOST">DOST</option>
                                                        <option value="ESGP-PA">ESGP-PA</option>
                                                        <option value="Tunong Dunong">Tunong Dunong</option>
                                                        <option value="Others">Others (specify)</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6" id="SpecScholarshipType" style="display:none">
                                                    <input class="form-control" name="SpecScholarshipType" placeholder="Scholarship Grant">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <input class="form-control" name="SchoolLastAttended" placeholder="School last attended">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <input class="form-control" id="SchoolLastAttendedAddress" placeholder="Address of school last attended (type barangay first)">
                                                    <input name='SchoolLastAttendedAddress' type="hidden" value="">
                                                </div>

                                            </div>
                                        </div>

                                        <div id="parents_div" class="col-md-12">
                                            <h5><b>Parents/Guardians</b></h5>

                                            <div  id="parents_div" class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" name="FathersName" placeholder="Father's name">

                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" name="FathersStatus" value='Deceased'>
                                                        Deceased
                                                    </label>
                                                </div>

                                                <div class="form-group">
                                                    <input class="form-control" name="FathersOccupation" placeholder="Father's occupation">
                                                </div>

                                                <div class="form-group">
                                                    <input class="form-control" name="MothersName" placeholder="Mother's name">

                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" name="MothersStatus" value='Deceased'>
                                                        Deceased
                                                    </label>
                                                </div>

                                                <div class="form-group">
                                                    <input class="form-control" name="MothersOccupation" placeholder="Mother's occupation">
                                                </div>
                                            </div>

                                            <div  id="parents_details_div" class="col-md-6">
                                                <div class="form-group col-md-6">
                                                    <select name='MaritalStatus' id='MaritalStatus' class="form-control">
                                                        <option selected disabled>Parent's Marital Status</option>
                                                        <option value="Legally married">Legally married</option>
                                                        <option value="Not legally married">Not legally married</option>
                                                        <option value="Legally separated">Legally separated</option>
                                                        <option value="Not legally separated">Not legally separated</option>
                                                        <option value="One parent remarried">One parent remarried</option>
                                                        <option value="Both parent remarried">Both parent remarried</option>
                                                        <option value="Others">Others (specify)</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <select name='NetIncome' class="form-control">
                                                        <option selected disabled>Family's Monthly Income</option>
                                                        <option value="Below 3,000">Below 3,000</option>
                                                        <option value="3,001-5,000">3,001-5,000</option>
                                                        <option value="5,001-8,000">5,001-8,000</option>
                                                        <option value="8,001-10,000">8,001-10,000</option>
                                                        <option value="10,001-15,000">10,001-15,000</option>
                                                        <option value="15,001-20,000">15,001-20,000</option>
                                                        <option value="Above 20,001">Above 20,001</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-12" id="SpecMaritalStatus" style="display:none">
                                                    <input class="form-control" name="SpecMaritalStatus" placeholder="Parent's Marital Status">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <input class="form-control" name="ParentsContact" placeholder="Parent's/Guardian's Contact Number">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div><!-- panel body -->
                                <div class="panel-footer" style="background-color: #fff;">
                                    <input type="submit" class="btn btn-primary btn-fill" value="Submit" style="margin-left: 20px;">
                                </div><!-- panel footer -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php includeCommonJS(); ?>

    </body>

    <script type='text/javascript'>
        $(document).ready(function(){
            $('#LivingWith').change(function(){
                if ($(this).val() == 'Others') {
                    $('#SpecLivingWith').show();
                }
            });
            $('#ScholarshipType').change(function(){
                if ($(this).val() == 'Others') {
                    $('#SpecScholarshipType').show();
                }
            });
            $('#MaritalStatus').change(function(){
                if ($(this).val() == 'Others') {
                    $('#SpecMaritalStatus').show();
                }
            });
        });
        $( function() {
            $( "#PlaceOfBirth" ).autocomplete({
                source: "/includes/actions/student.autocomplete.address.php",
                minLength: 2,
                select: function( event, ui ) {
                    event.preventDefault();
                    $("#PlaceOfBirth").val(ui.item.label);
                    $("input[name=PlaceOfBirth]").val(ui.item.value);
                }
            });
            $( "#Address" ).autocomplete({
                source: "/includes/actions/student.autocomplete.address.php",
                minLength: 2,
                select: function( event, ui ) {
                    event.preventDefault();
                    $("#Address").val(ui.item.label);
                    $("input[name=Address]").val(ui.item.value);
                }
            });
            $( "#SchoolLastAttendedAddress" ).autocomplete({
                source: "/includes/actions/student.autocomplete.address.php",
                minLength: 2,
                select: function( event, ui ) {
                    event.preventDefault();
                    $("#SchoolLastAttendedAddress").val(ui.item.label);
                    $("input[name=SchoolLastAttendedAddress]").val(ui.item.value);
                }
            });
        } );
        function getDept(val) {
            $.ajax({
                type: "POST",
                url: "/includes/actions/student.get.dept.php",
                data:'collegeID='+val,
                success: function(data){
                    $("#Department").html(data);
                }
            });
        }
    </script>

</html>
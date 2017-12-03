<?php
include("../../initialize.php");
includeCore();

$editing = $_GET['editing'];
$id = $_GET['id'];
$db_handle = new DBController();
$idpDetails = getIDPExtensiveDetails($id);
$provinces = getProvinces();
$cities = getCities();
$barangays = getBarangays();
$evac_centers = getEvacuationCenters();
?>
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span style="font-size:20px;">Edit
                    <?php
                    if($editing === "homeAddress") {
                        echo("Home Address");
                    } else if($editing === "gender") {
                        echo("Gender");
                    } else if($editing === "bdate") {
                        echo("Birth Date");
                    } else if($editing === "ethnicity") {
                        echo("Ethnicity");
                    } else if($editing === "religion") {
                        echo("Religion");
                    } else if($editing === "educAttain") {
                        echo("Educational Attainment");
                    } else if($editing === "maritalStat") {
                        echo("Marital Status");
                    } else if($editing === "phoneNum") {
                        echo("Phone Number");
                    } else if($editing === "email") {
                        echo("Email");
                    } else if($editing === "occupation") {
                        echo("Occupation");
                    } else if($editing === "evacuation") {
                        echo("Relocation");
                    } else if($editing === "name") {
                        echo("IDP Name");
                    }
                    ?>
                </span>
            </div>
            <div class="modal-body">
                <form action="/includes/actions/idp.process.edit.php?id=<?php echo($id); ?>&editing=<?php echo($editing); ?>" method="post">
                    <div>
                        <?php
                        if($editing == 'homeAddress')
                        {
                        ?>
                        <div id = "home_address_div">
                            <div>
                                <div class="form-group">
                                    <select name='province' id='province' class="form-control">
                                        <option selected disabled>Province</option>
                                        <?php
                                        foreach ($provinces as $result) {
                                        ?>
                                        <option value="<?= $result['ProvinceID']; ?>"><?= $result['ProvinceName']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select name="city_mun" id="city_mun" class="form-control" style="display:none">
                                        <option selected disabled>City/Municipality</option>
                                        <?php
                                        foreach ($cities as $result) {
                                        ?>
                                        <option value="<?php echo($result['City_Mun_ID']); ?>" name="province-<?php echo($result['ProvinceID']); ?>"><?php echo($result['City_Mun_Name']); ?></option>
                                        <?php } ?>
                                    </select>  
                                </div>

                                <div class="form-group">
                                    <select name="barangay1" id="barangay1" class="form-control" style="display:none">
                                        <option selected disabled>Barangay</option>
                                        <?php
                                        foreach ($barangays as $result) {
                                        ?>
                                        <option value="<?php echo($result['BarangayID']); ?>" name="city-<?php echo($result['City_CityID']) ?>"><?php echo($result['BarangayName']); ?></option>
                                        <?php } ?>
                                    </select> 
                                </div>

                                <div class="form-group">
                                    <input id="specAdd" class="form-control" name="SpecificAddress" placeholder="Specific address (optional)" type="textbox" style="display:none"/>
                                </div>
                            </div>
                        </div>
                        <?php
                        } else if($editing == 'gender')
                        {
                        ?>
                        <div class="form-group">
                            <select name='Gender' class="form-control">
                                <option selected disabled>Gender</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                                <option>Not specified</option>
                            </select>             
                        </div>
                        <?php
                        } else if($editing == 'bdate')
                        {
                        ?>
                        <div class="form-group">
                            <input type="date" name='Bdate' class="form-control">
                        </div>
                        <?php
                        } else if($editing == 'ethnicity')
                        {
                        ?>
                        <div class="form-group">
                            <input class="form-control" name='Ethnicity' placeholder="Enter Ethnicity">           
                        </div>
                        <?php
                        } else if($editing == 'religion')
                        {
                        ?>
                        <div class="form-group">
                            <input class="form-control" name='Religion' placeholder="Enter Religion">        
                        </div>
                        <?php
                        } else if($editing == 'educAttain')
                        {
                        ?>
                        <div class="form-group">
                            <select class="form-control" id="Education" name="Education">
                                <option selected disabled>Educational Attainment</option>
                                <option value="elementary">Elementary</option>
                                <option value="highschool">Highschool</option>
                                <option value="college">College</option>
                                <option>Not Specified</option>
                            </select>
                        </div>
                        <div class="form-group">

                            <select class="form-control" name='education' id="elementary1" style="display: none;">
                                <option selected disabled>Level</option>
                                <option value="1">Grade 1</option>
                                <option value="2">Grade 2</option>
                                <option value="3">Grade 3</option>
                                <option value="4">Grade 4</option>
                                <option value="5">Grade 5</option>
                                <option value="6">Grade 6</option>
                                <option value="7">Elementary Graduate</option>
                            </select>

                            <select class="form-control" name='education' id="highschool1" style="display: none;">
                                <option selected disabled>Level</option>
                                <option value="8">Grade 7</option>
                                <option value="9">Grade 8</option>
                                <option value="10">Grade 9</option>
                                <option value="11">Grade 10</option>
                                <option value="12">Grade 11</option>
                                <option value="13">Grade 12</option>
                                <option value="14">High School Graduate</option>
                            </select>

                            <select class="form-control" name='education' id="college1" style="display: none;">
                                <option selected disabled>Level</option>
                                <option value="15">1st year</option>
                                <option value="16">2nd year</option>
                                <option value="17">3rd year</option>
                                <option value="18">4th year</option>      
                                <option value="19">College Graduate</option>
                            </select>

                        </div>
                        <?php
                        } else if($editing == 'maritalStat')
                        {
                        ?>
                        <div class="form-group">
                            <select name='MaritalStatus' class="form-control">
                                <option selected disabled>Marital Status</option>
                                <option value="1">Single</option>
                                <option value="2">Married</option>
                                <option value="3">Annulled</option>
                                <option value="4">Widowed</option>
                                <option>Not specified</option>

                            </select>             
                        </div>
                        <?php
                        } else if($editing == 'phoneNum')
                        {
                        ?>
                        <div class="form-group">
                            <input class="form-control" name='PhoneNum' placeholder="Enter phone number" id = "PhoneNum">
                        </div>
                        <?php
                        } else if($editing == 'email')
                        {
                        ?>
                        <div class="form-group">
                            <input class="form-control" id='Email' name='Email' placeholder="your@mail.com">
                        </div>
                        <?php
                        } else if($editing == 'occupation')
                        {
                        ?>
                        <div class="form-group">
                            <input class="form-control" name="Occupation" placeholder="Enter occupation">
                        </div>
                        <?php
                        } else if($editing == 'evacuation')
                        {
                        ?>
                        <div id = "relocation_div">
                            <div class="form-group">
                                <select class="form-control" name="EvacType" id="EvacType" >
                                    <option selected disabled>Relocation Type</option>
                                    <option value="1">Evacuation Center</option>
                                    <option value="2">Home-based</option>
                                </select> 
                            </div> 

                            <div id="EvacName" class="form-group" style="display:none">
                                <select name="EvacName" class="form-control">
                                    <option selected disabled>Evacuation Center Name</option>
                                    <?php
                                    foreach ($evac_centers as $result) {
                                    ?>
                                    <option value="<?php echo($result['EvacuationCentersID']); ?>"><?= $result['EvacName']; ?></option>
                                    <?php } ?>
                                </select> 
                            </div>

                            <div id = "home_based_div" style="display:none">

                                <div class="form-group">
                                    <select name='province2' id='province2' class="form-control">
                                        <option selected disabled>Province</option>
                                        <?php
                                        foreach ($provinces as $result) {
                                        ?>
                                        <option value="<?php echo($result['ProvinceID']); ?>"><?= $result['ProvinceName']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select name="city_mun2" id="city_mun2" class="form-control" style="display:none">
                                        <option selected disabled>City/Municipality</option>
                                        <?php
                                        foreach ($cities as $result) {
                                        ?>
                                        <option value="<?php echo($result['City_Mun_ID']); ?>" name="province2-<?php echo($result['ProvinceID']); ?>"><?php echo($result['City_Mun_Name']); ?></option>
                                        <?php } ?>
                                    </select>  
                                </div>

                                <div class="form-group">
                                    <select name="barangay2" id="barangay2" class="form-control" style="display:none">
                                        <option selected disabled>Barangay</option>
                                        <?php
                                        foreach ($barangays as $result) {
                                        ?>
                                        <option value="<?php echo($result['BarangayID']); ?>" name="city2-<?php echo($result['City_CityID']) ?>"><?php echo($result['BarangayName']); ?></option>
                                        <?php } ?>
                                    </select> 
                                </div>

                                <div class="form-group">
                                    <input id="specAdd2" class="form-control" name="SpecificAddress2" placeholder="Specific address (optional)" type="textbox" style="display:none"/>
                                </div>
                            </div>
                        </div>
                        <?php
                        } else if($editing == 'name')
                        {
                        ?>
                        <div class="form-group">
                            <input class="form-control" id = 'Lname' name='Lname' placeholder="Enter Last name">
                        </div>

                        <div class="form-group">
                            <input class="form-control" name='Fname' placeholder="Enter First name">
                        </div>

                        <div class="form-group">
                            <input class="form-control" name='Mname' placeholder="Enter Middle Name">
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary btn-fill btn-sm"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
            </div>
        </div>

    </div>
</div><!-- Modal end -->
<?php includeCommonJS(); ?>
<script type="text/javascript">
    $(document).ready(function(){
            $('#Education').change(function(){
                if ($(this).val() == 'elementary') {
                    $('#elementary1').show();
                    $('#highschool1').hide();
                    $('#college1').hide();
                } else if ($(this).val() == 'highschool') {
                    $('#elementary1').hide();
                    $('#highschool1').show();
                    $('#college1').hide();       
                } else if ($(this).val() == 'college') {
                    $('#elementary1').hide();
                    $('#highschool1').hide();
                    $('#college1').show();       
                } else {
                    $('#elementary1').hide();
                    $('#highschool1').hide();
                    $('#college1').hide(); 
                }
            });
            $('#province').change(function(){
                $("#city_mun").show();
                $("#city_mun option[name*='province-']").hide();
                $("#city_mun option[name='province-"+$(this).val()+"']").show();
            });
            $('#city_mun').change(function(){
                $("#barangay1").show();
                $("#barangay1 option[name*='city-']").hide();
                $("#barangay1 option[name='city-"+$(this).val()+"']").show();
                $("#specAdd").show();
            });
            $('#EvacType').change(function(){
                if ($(this).val() == '1') {
                    $('#EvacName').show();
                    $('#home_based_div').hide();
                } else if ($(this).val() == '2') {
                    $('#EvacName').hide();
                    $('#home_based_div').show();       
                }
            });
            $('#province2').change(function(){
                $("#city_mun2").show();
                $("#city_mun2 option[name*='province2-']").hide();
                $("#city_mun2 option[name='province2-"+$(this).val()+"']").show();
            });
            $('#city_mun2').change(function(){
                $("#barangay2").show();
                $("#barangay2 option[name*='city2-']").hide();
                $("#barangay2 option[name='city2-"+$(this).val()+"']").show();
                $("#specAdd2").show();
            });
        });
</script>
<?php
include("../initialize.php");
includeCore();

$evacID = $_GET['evacid'];

$evacInfo = getExtensiveEvacDetails($evacID);
$Cities = getCities();
$provinces = getProvinces();
$cities = getCities();
$barangays = getBarangays();
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("PSRMS - Edit Evacuation Center"); ?>

    </head>

    <body>

        <div id="wrapper">

            <?php includeNav(); ?>

            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/pages/evac.manage.centers.php">Evacuation Centers</a></li>
                        <li class="breadcrumb-item active">Edit Evacuation Center</li>
                    </ol>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="title">&nbsp;Edit Evacuation Center</h4>  
                            </div>
                            <div class="panel-body">
                                <form method="POST" action="/includes/actions/evac.process.edit.php?evacid=<?php echo($evacID); ?>">
                                    <div  id = "personal_info_div" class="col-lg-12">
                                        <div class="panel">


                                            <div class="form-group col-md-6">
                                                <input type="EvacName" class="form-control" id="EvacName" name="EvacName" placeholder="Evacuation Center Name" value="<?php echo($evacInfo[0]['EvacName']) ?>">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input type="EvacManager" class="form-control" id='EvacManager' name='EvacManager' placeholder="Evacuation Manager" value="<?php echo($evacInfo[0]['EvacManager']) ?>">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input type="EvacContact" class="form-control" id="EvacContact" name="EvacContact" placeholder="Evacuation Center Contact No" value="<?php echo($evacInfo[0]['EvacManagerContact']) ?>">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <select name='province2' id='province2' class="form-control">
                                                    <option selected disabled>Province</option>
                                                    <?php
    foreach ($provinces as $result) {
                                                    ?>
                                                    <option value="<?php echo($result['ProvinceID']); ?>" <?php echo(($result['ProvinceID'] == $evacInfo[0]['ProvinceID'] ? 'selected="selected"' : '')) ?>><?php echo($result['ProvinceName']); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <select name="city_mun2" id="city_mun2" class="form-control">
                                                    <option selected disabled>City/Municipality</option>
                                                    <?php
                                                    foreach ($cities as $result) {
                                                    ?>
                                                    <option value="<?php echo($result['City_Mun_ID']); ?>" name="province2-<?php echo($result['ProvinceID']); ?>"<?php echo(($result['City_Mun_ID'] == $evacInfo[0]['City_Mun_ID'] ? 'selected="selected"' : '')) ?>><?php echo($result['City_Mun_Name']); ?></option>
                                                    <?php } ?>
                                                </select>  
                                            </div>

                                            <div class="form-group col-md-6">
                                                <select name="Barangay" id="Barangay" class="form-control">
                                                    <option selected disabled>Barangay</option>
                                                    <?php
                                                    foreach ($barangays as $result) {
                                                    ?>
                                                    <option value="<?php echo($result['BarangayID']); ?>" name="city2-<?php echo($result['City_CityID']) ?>"<?php echo(($result['BarangayID'] == $evacInfo[0]['EvacAddress'] ? 'selected="selected"' : '')) ?>><?php echo($result['BarangayName']); ?></option>
                                                    <?php } ?>
                                                </select> 
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input id="specAdd" class="form-control" name="SpecificAddress" placeholder="Specific address (optional)" type="textbox">
                                            </div>

                                            <div class="form-group col-md-12">
                                                <input type="submit" class="btn btn-primary btn-fill btn-md">
                                            </div>

                                        </div>
                                    </div>

                                </form> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php includeCommonJS(); ?>

        <script type='text/javascript'>
            $(document).ready(function(){

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
                $('#province2').change(function(){
                    $("#city_mun2").show();
                    $("#city_mun2 option[name*='province2-']").hide();
                    $("#city_mun2 option[name='province2-"+$(this).val()+"']").show();
                });
                $('#city_mun2').change(function(){
                    $("#Barangay").show();
                    $("#Barangay option[name*='city2-']").hide();
                    $("#Barangay option[name='city2-"+$(this).val()+"']").show();
                    $("#specAdd").show();
                });
            });
        </script>

    </body>

</html>
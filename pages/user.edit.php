<?php 
include("../initialize.php");
includeCore();

$id = $_GET['id'];

$agencies = getAgencies();
$userInfo = getUserInfo($id);
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <?php
        includeHead("PSRMS - Edit Account");
        includeDataTables();
        ?>

    </head>

    <body>

        <div id="wrapper">
            
            <?php includeNav(); ?>
            
            <div id="page-wrapper">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="user.enroll.php">Account Management</a></li>
                        <li class="breadcrumb-item active">Edit Account</li>
                    </ol>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="title">&nbsp;Edit Account</h4>
                            </div>
                            <div class="panel-body">
                                <form method="POST" action="/includes/actions/user.process.edit.php?id=<?php echo($id); ?>">
                                    <div  id = "personal_info_div" class="col-lg-12">
                                        <div class="panel">
                                                
                                                <div class="form-group col-md-4">
                                                    <input class="form-control" id = 'Lname' name='Lname' placeholder="Last name" value="<?php echo($userInfo[0]['Lname']); ?>" required>
                                                </div>
                                                
                                                <div class="form-group col-md-4">
                                                    <input class="form-control" id="Fname" name='Fname' placeholder="First name" value="<?php echo($userInfo[0]['Fname']); ?>" required>
                                                </div>
                                                
                                                <div class="form-group col-md-4">
                                                    <input class="form-control" id='Mname' name='Mname' placeholder="Middle Name" value="<?php echo($userInfo[0]['Mname']); ?>" required>
                                                </div>
                                                
                                                <div class="form-group col-md-4">
                                                    <input type="date" id="Bdate" name='Bdate' class="form-control" value="<?php echo(date('Y-m-d',strtotime($userInfo[0]['DateAdded']))); ?>" required>
                                                </div>
                                            
                                                <div class="form-group col-md-4">
                                                    <input class="form-control" id="Age" name='Age' placeholder="Age" type="text" min="0" value="<?php echo('Age: '.calculateAge(date('Y-m-d',strtotime($userInfo[0]['DateAdded']))).' (auto)'); ?>" disabled>
                                                </div>
                                                
                                                <div class="form-group col-md-4">
                                                    <select id="Gender" name='Gender' class="form-control" required>
                                                        <option value="1" <?php if($userInfo[0]['Sex'] == '1') echo("selected=selected") ?>>Male</option>
                                                        <option value="2" <?php if($userInfo[0]['Sex'] == '2') echo("selected=selected") ?>>Female</option>
                                                    </select>             
                                                </div>
                                                
                                                <div class="form-group col-md-6">
                                                    <input class="form-control" id="PhoneNum" name='PhoneNum' placeholder="Phone Number" id = "PhoneNum" value="<?php echo($userInfo[0]['PhoneNum']); ?>">
                                                </div>
                                                
                                                <div class="form-group col-md-6">
                                                    <input type="email" class="form-control" id='Email' name='Email' placeholder="your@mail.com" value="<?php echo($userInfo[0]['Username']); ?>">
                                                </div>
                                                
                                                <div class="form-group col-md-12">
                                                    <input type="password" class="form-control" id="pwd1" name="pwd1" placeholder="Enter old password" pattern="(?=^.{7,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" oninvalid="this.setCustomValidity('Atleast 7 chars with atleast 1 uppercase and 1 special char')" oninput="setCustomValidity('')">
                                                </div>
                                                
                                                <div class="form-group col-md-6">
                                                    <input type="password" class="form-control" id="pwd2" name="pwd2" placeholder="Enter new password" pattern="(?=^.{7,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" oninvalid="this.setCustomValidity('Atleast 7 chars with atleast 1 uppercase and 1 special char')" oninput="setCustomValidity('')">
                                                </div>
                                            
                                                <div class="form-group col-md-6">
                                                    <input type="password" class="form-control" id="pwd3" name="pwd3" placeholder="Verify new password" pattern="(?=^.{7,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" oninvalid="this.setCustomValidity('Atleast 7 chars with atleast 1 uppercase and 1 special char')" oninput="setCustomValidity('')">
                                                </div>
                                                
                                                <div class="form-group col-md-12">
                                                    <label class="text-warning"><sup>Please note: Passwords should be at least 7 characters with atleast one letter and atleast one number or one special character</sup></label>
                                                </div>
                                                
                                                <div class="form-group col-md-4">
                                                    <label for="Agency">Agency<span class="required">*</span></label>
                                                    <select id="Agency" name='Agency' class="form-control" required>
                                                        <?php
                                                        foreach($agencies as $agency) {
                                                        ?>
                                                        <option value="<?php echo($agency["AgencyID"]) ?>" <?php if($userInfo[0]['AGENCY_AgencyID'] == $agency['AgencyID']) echo("selected=selected") ?>><?php echo($agency["AgencyName"]) ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                        <option value="specify">Other(specify)</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group col-md-4" id="specifyAgency" style="display:none">
                                                    <label for="Lname">Specify Agency<span class="required">*</span></label>
                                                    <input class="form-control" id="specAgency" name="specAgency" placeholder="Enter Your Agency">
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
        <!-- /#wrapper -->

        <?php includeCommonJS(); ?>

    </body>
    
    <script type='text/javascript'>
        $(document).ready(function(){
            $('#Agency').change(function(){
                if ($(this).val() == 'specify') {
                    $('#specifyAgency').show();       
                } else {
                    $('#specifyAgency').hide(); 
                }
            });
        });
    </script>
    
</html>
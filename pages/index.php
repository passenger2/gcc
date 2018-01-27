<?php
include("../initialize.php");
includeCore();
#/includes/actions/student.autocomplete.address.php
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <?php includeHead("PSRMS - Dashboard"); ?>

    </head>

    <body>

        <div class="wrapper">

            <?php includeNav(); ?>

            <div id="page-wrapper">
                <!--<div class="ui-widget col-md-6">
                    <label for="birds">Birds: </label>
                    <input id="birds" class="form-control">
                </div>-->
                <?php
                /*for($i = 1; $i <= 50; $i++)
                {
                    echo(password_hash("encoder".$i, PASSWORD_DEFAULT)."<br>");
                }*/
                ?>
            </div>
            <!-- /#wrapper -->

        </div>

    </body>

    <?php includeCommonJS(); ?>
    <script>
        $( function() {
            $( "#birds" ).autocomplete({
                source: "/includes/actions/student.autocomplete.address.php",
                minLength: 2,
                select: function( event, ui ) {
                    event.preventDefault();
                    $("#birds").val(ui.item.label);
                }
            });
        } );
    </script>
</html>
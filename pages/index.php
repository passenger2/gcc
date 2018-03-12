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
                <?php
                /*for($i = 1; $i <= 50; $i++)
                {
                    echo(password_hash("encoder".$i, PASSWORD_DEFAULT)."<br>");
                }*/
                /*echo(password_hash("COE&Tadmin2k17", PASSWORD_DEFAULT));*/
                ?>
            </div>

        </div>

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

    </body>

</html>
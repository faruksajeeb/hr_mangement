<link href='http://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<?php

echo load_css("bootstrap.min.css");
echo load_css("tabs.css");
echo load_css("jquery-ui.css");
echo load_css("jquery.datetimepicker.css");
echo load_css("jquery.dataTables.css");
echo load_css("custom.css");

echo load_js("jquery-1.10.2.min.js");
echo load_js("bootstrap.min.js");
echo load_js("jquery-ui-1.10.4.custom.min.js");
echo load_js("jquery.dataTables.min.js");
echo load_js("jquery.validate.min.js");
echo load_js("additional-methods.min.js");
echo load_js("moment.js");
echo load_js("jquery.datetimepicker.js");
echo load_js("jquery-ui.js");
echo load_js("custom.js");
echo load_js("canvasjs.min.js");
?>
<!--chosen css-->
<link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
<!--Chosen js-->
<script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo base_url(); ?>resources/js/jquery.table2excel.js"></script>
<script src="<?php echo base_url(); ?>resources/plugins/sweet-alert/sweetalert2.all.min.js"></script>

<script>
    <?php
    $userType = $this->session->userdata('user_type');
    if ($userType != 1) {
    ?>
        $(document).ready(function() {

            //Disable cut copy 
            $('body').bind('cut copy', function(e) {
                e.preventDefault();
            });

            //Disable mouse right click
            $("body").on("contextmenu", function(e) {
                return false;
            });
            /*Disable Print Screen button*/
            $(window).keyup(function(e) {
                if (e.keyCode == 44) {
                    copyToClipboard();
                }
            });
        });
        /*Disable Ctrl+P button*/
        $(document).on('keydown', function(e) {
            if (e.ctrlKey && (e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80)) {
                alert("Please use the Print button below for a better rendering on the document");
                e.cancelBubble = true;
                e.preventDefault();

                e.stopImmediatePropagation();
            }
            if (e.ctrlKey && (e.key == "s" || e.keyCode == 83)) {
                alert("Ctrl+s not allow here");
                e.cancelBubble = true;
                e.preventDefault();

                e.stopImmediatePropagation();
            }
            if (e.ctrlKey && (e.key == "u" || e.keyCode == 85)) {
                alert("Ctrl+u not allow here");
                e.cancelBubble = true;
                e.preventDefault();

                e.stopImmediatePropagation();
            }
        });
    <?php } ?>

    function copyToClipboard() {
        // Create a "hidden" input
        var aux = document.createElement("input");
        // Assign it the value of the specified element
        aux.setAttribute("value", "Você não pode mais dar printscreen. Isto faz parte da nova medida de segurança do sistema.");
        // Append it to the body
        document.body.appendChild(aux);
        // Highlight its content
        aux.select();
        // Copy the highlighted text
        document.execCommand("copy");
        // Remove it from the body
        document.body.removeChild(aux);
        alert("Print screen disabled. Don't try to unauthorised attempt");
    }
</script>
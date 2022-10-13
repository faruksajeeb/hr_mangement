
    </body>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
         <script src="<?php echo base_url(); ?>resources/font-end/js/jquery.3.4.1.min.js" ></script>		
        <script src="<?php echo base_url(); ?>resources/font-end/js/popper.min.js" ></script>
        <script src="<?php echo base_url(); ?>resources/font-end/js/bootstrap.min.js" ></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
        <script>
            $(document).ready(function () {
             
                $(".datepicker").datepicker(
                        {
                            // dateFormat: 'dd-mm-yy'
                            dateFormat: 'yy-mm-dd'
                        }
                );
                $('input.timepicker').timepicker({
        //             timeFormat: 'h:mm p',
                        timeFormat: 'H:mm',
                        dynamic: false,
                        dropdown: true,
                        scrollbar: true
                });
               
            });
        </script>
</html>
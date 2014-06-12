            <link rel="icon" type="image/png" href="images/favicon.png" />
            <link rel="stylesheet" type="text/css" href="css/style.css" />  
            <script type="text/javascript" src="javascripts/domtab.js"></script>
            <script type="text/javascript" src="javascripts/jquery-1.4.3.min.js"></script>
<!--            <script type="text/javascript" src="javascripts/external/mootools.js"></script>
            <script type="text/javascript" src="javascripts/demo-js/table.js"></script>
            <script type="text/javascript" src="javascripts/dg-filter.js"></script>
            <script type="text/javascript" src="javascripts/domtab.js"></script>	
            <script type="text/javascript" src="javascripts/jquery.js"></script>
            <script src="javascripts/tooltip/jquery.js" type="text/javascript"></script>
            <script src="javascripts/tooltip/main.js" type="text/javascript"></script>-->
            
            <script type="text/javascript" charset="utf-8">
                  $(document).ready(function(){
                    $(".nav a").each(function(){
                        var urlstr = '/ripd_security/'+$(this).attr('href');
                         if(urlstr ===  window.location.pathname){
                            $(this).addClass('current');
                        }
                    });
                   });
            </script>

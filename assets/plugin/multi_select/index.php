<!DOCTYPE html>
<head>
    <title>jQuery Plugin tagedit - Tageditor</title>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <meta http-equiv="content-language" content="th"/>
        
    <link rel="StyleSheet" href="css/ui-lightness/jquery-ui-1.9.2.custom.min.css" type="text/css" media="all"/>
    <link rel="StyleSheet" href="css/jquery.tagedit.css" type="text/css" media="all"/>
    
    <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="text/javascript" src="js/jquery.autoGrowInput.js"></script>
    <script type="text/javascript" src="js/jquery.tagedit.js"></script>
    
    <script type="text/javascript">
    $(function() {
        
        // Fullexample
        $( "#tagform-full" ).find('input.tag').tagedit({
            autocompleteURL: 'server/autocomplete.php',
            //checkToDeleteURL: 'server/checkToDelete.php'
        });
        
        // Edit only
        $( "#tagform-editonly" ).find('input.tag').tagedit({
            autocompleteURL: 'server/autocomplete.php',
            allowEdit: false,
            allowAdd: false
        });
    });
    </script>
    
    </head>
<body>
   
    
    <h3>Full example</h3>
    <form action="" method="post" id="tagform-full">
        <p>
            <input type="text" name="tag[]" value="" class="tag"/>
        
            <input type="submit" name="save" value="Save"/>
        </p>
    </form>
    
    <h3>Add only - restricted on Autocomplete List</h3>
    <form action="" method="post" id="tagform-editonly">
        <p>
            <input type="text" name="tag[]" value="" class="tag" />
        
            <input type="submit" name="save" value="Save"/>
        </p>
    </form>

</body>
</html>

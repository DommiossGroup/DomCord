<!DOCTYPE html>
<html lang="en">
    <head>

        <link rel="icon" type="image/x-icon" href="themes/uploaded/favicon.ico" />
        
        <!-- SEO -->

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <meta name="keywords" content="<?php echo $_Config_['Metadata']['keywords']; ?>" />
        <meta name="robots" content="<?php echo $_Config_['Metadata']['robots']; ?>" />

        <meta property="og:title" content="<?php echo $_Config_['General']['name']; ?>">
        <meta property="og:image" content="themes/uploaded/favicon.ico">
        <meta property="og:description" content="<?php echo $_Config_['General']['description']; ?>">


        <!-- Includes CSS files -->

        <link href="themes/<?php echo $_Config_['General']['theme']; ?>/css/styles.css" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

        <!-- Includes Scripts files -->
        <script src="assets/ckeditor/ckeditor.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

        <?php if(isset($_ThemeOption_['Personnalisation']['fontawesome']) && $_ThemeOption_['Personnalisation']['fontawesome'] == "true"){ ?><script src="https://kit.fontawesome.com/9effd4ff41.js" crossorigin="anonymous"></script><?php } ?>

    </head>
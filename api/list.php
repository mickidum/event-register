<?php 

if (@!$_GET['foobargetlist'] || $_GET['foobargetlist'] != '1618') {
 exit('NFG PAGE INTRANCE');
}
    $table_titles = fopen('table_content.txt', 'r');
    @$table_titles_list = fread($table_titles, filesize("table_content.txt"));
    @$filename = fopen('temp_file_name.txt', 'r');
    @$filename_title = fread($filename, filesize('temp_file_name.txt'));
	@$file = fopen('html/'.$filename_title.'.html', 'r');
	@$list = fread($file, filesize('html/'.$filename_title.'.html'));
    @fclose($file);
    @fclose($table_titles);
	@fclose($filename);
    $table_titles_list = explode(',', $table_titles_list);
?>

<!doctype html>
<html class="no-js" lang="en" dir="rtl">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow">
    <title>Event Register System</title>

    <link rel="stylesheet" href="styles/foundation.css">    
    <link rel="stylesheet" href="styles/style.css">

  </head>

<body>

<div class="row">
  <div class="large-12 columns">

    <h1>נרשמים לאירוע - <strong style="color: #795548;">"<?php echo array_pop($table_titles_list); ?>"</strong></h1>
    <div class="event-code-name">
      <strong>אירוע</strong><span class="event-code-name"> <?php echo $filename_title; ?></span>
    </div>
    <table>
      
     <?php echo $list ?>
     </tbody>
    </table>

<?php 
    // SCAN DIRECTORIES WITH FILES
    $htmlfiles = array_diff(scandir('html'), array('.', '..')); 
    $csvfiles = array_diff(scandir('csv'), array('.', '..'));
?>


<?php if(count($csvfiles) > 0): ?>
    <div dir="ltr" class="links">
        <h3><span dir="rtl">CSV להורדה</span></h3><br>
        <?php 
            foreach ($csvfiles as $link) {
                if ($link === $filename_title.'.csv') {
                    echo '<a href="csv/'.$link.'">'.$link.'</a><br>';
                }
                
            }
        ?>
    </div>
<?php endif ?>
    
<?php if(count($htmlfiles) > 1): ?>
    <div class="old-lists">
        <h2 class="text-center">קבצים ישנים</h2>
        <div dir="ltr" class="htmllinks links">
            <h3><span dir="rtl">רשימות ישנות</span></h3><br>
            <?php 
                foreach ($htmlfiles as $link) {
                    if ($link !== $filename_title.'.html') {
                        echo '<a id="'.$link.'" href="#">'.str_replace('.html', '', $link).'</a><br>';
                    }
                }
            ?>
        </div>
        
        <div dir="ltr" class="links">
            <h3><span dir="rtl">CSV להורדה</span></h3><br>
            <?php 
                foreach ($csvfiles as $link) {
                    if ($link !== $filename_title.'.csv') {
                        echo '<a href="csv/'.$link.'">'.$link.'</a><br>';
                    }
                    
                }
            ?>
        </div>
    </div>
<?php endif ?>

</div>
</div>

<div id="popup" class="popup">
    <div dir="ltr" class="loading"><span>loading</span></div>
    <div class="hdr">
        <div class="event-code-name">
          <strong>אירוע</strong><span id="event_c_name"></span>
        </div>
        <button class="left closebtn small button">close</button>
    </div>
    <div class="row collapse expanded">
        <div class="large-12 columns">
            <table></table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    jQuery(document).ready(function($) {
        $('.htmllinks').on('click', 'a', function(event) {
            event.preventDefault();
            $('#popup').show();
            $('.loading').show();
            $('#event_c_name').html($(this).attr('id'));
            $.get('html/' + $(this).attr('id'), function(data) {
                setTimeout(function(){
                    $('.loading').fadeOut();
                    $('#popup table').html(data + '</tbody>');
                }, 500);
                
                
            });
        });
        $('body').on('click', '.closebtn', function(event) {
            event.preventDefault();
            $('#popup').hide();
        });
    });
</script>
</body>
</html>




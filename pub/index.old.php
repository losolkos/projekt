<!-- <?php
require('./../scr/config.php')
?>

<form action="" method="post" enctype="multipart/form-data">
        <label for="uploadedFileInput">
            Wybierz plik do wgrania na serwer:
        </label><br>
        <input type="file" name="uploadedFile" id="uploadedFileInput" required><br>
        <input type="submit" value="Wyślij plik" name="submit"><br>
</form>

<?php
    //sprawdź czy został wysłany formularz
    //if(isset($_POST['submit']))  {
       // Post::upload($_FILES['uploadedFile']['tmp_name']);
   // }
?>

//<?php
    // if(isset($_POST['submit'])) {
      //  Post::upload($_FILES['uploadedFile']['tmp_name']);
     //}

//?>
Ostatni post:
<pre>
<?php
var_dump(Post::getLast());
?> -->
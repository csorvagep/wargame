<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
  <p id="megoldas"> Megoldás:
    <input type="file" name="megoldas" />
    <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
    <input type="submit" name="megold" value="Feltöltés" />
  </p>
</form>
<?php 
if(isset($_FILES['biblioPdf'])){
    move_uploaded_file($_FILES['biblioPdf']['tmp_name'], "../uploads/biblio/".$_FILES['biblioPdf']['name']);
    echo "uploads/".$_FILES['biblioPdf']['name'];
}
else {
    echo "Fail";
}
?>
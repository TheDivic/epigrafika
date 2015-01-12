<?php 

function getUniqueFilename($filepath) {
    while(file_exists($filepath)){
        $explode_path = explode('/', $filepath);
        $last = array_pop($explode_path);
        $explode_last = explode('.', $last);
        $explode_last[0] = $explode_last[0].rand();
        $last = implode('.', $explode_last);
        array_push($explode_path, $last);
        $filepath = implode('/', $explode_path);
    }
    return $filepath;
}

if(isset($_FILES['biblioPdf'])){
    $filepath = getUniqueFilename("../uploads/biblio/".$_FILES['biblioPdf']['name']);
    move_uploaded_file($_FILES['biblioPdf']['tmp_name'], $filepath);
    echo $filepath;
}
elseif(isset($_FILES['photo'])){
    $filepath = getUniqueFilename("../uploads/photos/".$_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'], $filepath);
    echo $filepath;
}
else {
    echo "Fail";
}
?>
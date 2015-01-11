<?php

include 'autocomplete.php';

$text = " Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget est sem. 
Proin posuere lobortis rutrum. Interdum et malesuada fames ac ante ipsum primis in faucibus. 
Mauris ac nisi non ante sodales pharetra. Vivamus rhoncus pharetra urna et aliquam. 
Praesent porta, enim eget bibendum sagittis, odio risus sagittis justo, ultrices tincidunt tellus libero vitae elit. 
Quisque lobortis volutpat erat id hendrerit. Cras vel accumsan felis. Phasellus feugiat tempor turpis non tincidunt. Nulla facilisi.
Nullam vel leo nunc. Mauris sed porta odio. Suspendisse rutrum et urna id maximus. Proin vel maximus erat. 
Fusce consequat libero diam, fringilla bibendum velit eleifend consectetur. Vivamus ut dignissim sapien, quis tempor purus.
Vivamus sit amet condimentum augue, sed feugiat purus. Proin a auctor urna. Sed faucibus dapibus molestie. 
Proin malesuada leo et sagittis mollis.

Duis sit amet ultricies felis. In suscipit facilisis nisl, id blandit dolor mattis sed. 
Ut posuere quis arcu posuere aliquam. Sed sed risus varius, fringilla mauris eu, eleifend nulla. 
Donec venenatis fringilla libero sed suscipit. Suspendisse vel dictum massa. Fusce quis nibh vitae lorem luctus vehicula ac eget nulla. 
Integer fringilla pulvinar magna, vestibulum vulputate augue luctus a. Integer malesuada posuere dolor, sed pulvinar nunc hendrerit vel. 
Proin tellus dolor, efficitur nec neque eget, bibendum efficitur risus. ";

$tok = strtok($text, " \n");

while($tok !== false){
    $words[] = $tok;
    $tok = strtok(" \n.!?,");
}

insertWordsIntoDictionary($words);

?>

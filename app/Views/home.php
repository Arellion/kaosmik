<?php
if($logged_user != null ) {
    echo $logged_user->getPlayer()->user_id;
}else{
    echo "Vas te connecter";
}
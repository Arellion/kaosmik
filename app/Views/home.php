<?php
if($user != null ) {
    echo $user->getPlayer()->user_id;
}else{
    echo "Vas te connecter";
}
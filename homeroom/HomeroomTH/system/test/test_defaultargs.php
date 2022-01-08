<?php
function makecoffee($do,$type = "cappuccino")
{
    return $do." a cup of $type.\n";
}
echo makecoffee('make').'<br />';
echo makecoffee(null,null).'<br />';
echo makecoffee("suck","espresso");
?>
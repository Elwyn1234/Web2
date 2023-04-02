<?php

function penceToPounds($pence) {
  $pounds = (int)($pence / 100);
  $remainingPence = $pence % 100;
  return '£'.$pounds.'.'.$remainingPence;
}

?>

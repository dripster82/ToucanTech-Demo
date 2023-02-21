<?php

for($i=1; $i<=100; $i++) {
	$output = '';
	if( $i % 3 == 0)
		$output .= 'toucan';

	if( $i % 5 == 0)
		$output .= 'tech';

	if($output != '')
		echo "{$i} : {$output}".PHP_EOL;

}
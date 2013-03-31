
<?php
$client = new SoapClient('http://10.11.145.91:1342/ServiceCategory.svc/categories/create');
var_dump($client->__getFunctions());
?>

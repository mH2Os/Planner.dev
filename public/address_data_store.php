<?php

require('../inc/filestore.php');

class AddressDataStore extends Filestore 
{

    function open_address_book()
    {
    	return $this->read();
	}

    function save_address_book($address_book)
	{
		$this->write($address_book);
	}


 }
 ?>
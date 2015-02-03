<?php 
// trieda na cache contentu

class cache { 
  private $folder;
  
  public function cache($folder = "images/tmp/") {
  	$this->folder = $folder;
  }
  
  // this is the function you store information with 
  public function set($key, $data, $ttl = 7200) { 
    // opening the file 
    $h = fopen($this->get_file_name($key), 'w');
	
	
    if(!$h) 
	  throw new Exception('could not create file');
	  
    // serializing along with the ttl 
    $data = serialize(array(time() + $ttl, $data)); 
    if(fwrite($h, $data) === false)
      throw new Exception('could not write data');
    
    fclose($h); 

  } 

  // this is the function to fetch data (returns false on failure)
  public function get($key) { 
	//return false;
	$filename = $this->get_file_name($key); 
	
	
	if(!file_exists($filename) || !is_readable($filename))
	  return false; 
	
	$data = @file_get_contents($filename); 
	$data = @unserialize($data); 
	
	if(!$data) { 
	  // unlinking the file when unserializing failed 
	  @unlink($filename); 
	  return false; 
	} 
	
	// checking if the data was expired 
	if(time() > $data[0]) { 
	  // unlinking 
	  unlink($filename); 
	  return false;
	} 
	return $data[1]; 
  } 

  // find the filename for a certain key 
  private function get_file_name($key) { 
    return $this->folder.md5($key); 
  }
  
  // vyhodenie starych suborov
  public function cleanup() {
	
	try {
	  $dh = opendir($this->folder);
	}
	catch(Exception $e) {
	  throw new Exception('cannot read folder');
	}
	
	while(($file = readdir($dh)) !== false) {
	  if($file == '.' or $file == '..')
	    continue;
	  
	  $data = file_get_contents($this->folder.$file); 
	  $data = @unserialize($data); 
	  
	  // checking if the data was expired 
	  if(time() > $data[0])
  	    unlink($this->folder.$file); 
	}
	
	closedir($dh);
  }
  
  public function clear($key) {
  	$filename = $this->get_file_name($key);
	if(unlink($filename))  
  		return true;
  	else
		return false;
  }
  
} 

?>
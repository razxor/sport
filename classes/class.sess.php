<?php
	class sess
	{
		private $save_path;
		
		public function __construct()
		{
			$this->prefix = 'bcs';
			session_set_save_handler(array($this, 'open'), array($this, 'close'), array($this, 'read'), array($this, 'write'), array($this, 'destroy'), array($this, 'gc'));
			register_shutdown_function('session_write_close');
			session_start();
		}
		
		public function open($save_path, $name)
		{
			$this->save_path = $save_path;
			return true;
		}
	    
		public function close()
		{
			return true;
		}
		
		public function read($id)
		{
			$this->data = (string)@file_get_contents("{$this->save_path}/{$this->prefix}_{$id}");
			return $this->data;
		}
		
		public function write($id, $data)
		{
			if (!$data)
				return false;
			if ($data == $this->data)
				return false;
			return file_put_contents("{$this->save_path}/{$this->prefix}_{$id}", $data) === false ? false : true;
		}
		
		public function destroy($id)
		{
			@unlink("{$this->save_path}/{$this->prefix}_{$id}");
		}
		
		public function gc($maxlifetime)
		{
			foreach (glob("{$this->save_path}/{$this->prefix}_*") as $file)
			{
				if (filemtime($file) + $maxlifetime < time() && file_exists($file))
					unlink($file);
			}
			
			return true;
		}
	}
?>
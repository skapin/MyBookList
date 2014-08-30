<?php
require_once ('include.php');

class CSV  
{ 
 
	private $row;

	private $col;
	
	private $header;
	
	private $content="";
	
	private $separator;

   public function __construct( $separator='|' )
   {
		$this->row = 0;
		$this->col = 0;
		$this->separator = $separator;
   }

	public function setHeader()
	{
		$arg_c = func_num_args();
        $this->col = $arg_c;
        $this->header = '';
        for ( $i = 0; $i < $arg_c; $i++ )
        {
            $this->header .= ''.func_get_arg( $i ).$this->separator;
        }
		$this->header .= "\n";
	}
	
	public function addRow( $vals )
	{
	   $nbr_arg = count( $vals );
       if ( $nbr_arg > $this->col )
       {
		   $this->content = "Error too much data";
	   }
	   else
	   {
			foreach ( $vals as $k => $v  )
			{
				$this->content .= $v.$this->separator;
			}
			$this->content .="\n";	
		}
	}
	
	public function output($NomFichier)
	{
 
		header("Content-type: application/vnd.ms-excel");
		header("Content-disposition: attachment; filename=$NomFichier");
		$str = $this->header;
		$str .=$this->content;
		print $str;
		exit;
 
	}
}

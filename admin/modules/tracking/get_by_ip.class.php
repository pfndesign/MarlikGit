<?php
/******* sample *****
$ipdata=new get_by_ip;
echo str_repeat("-=", 10)."<br><br>";
echo $ipdata->msg;
echo str_repeat("-=", 10)."<br><br>";
echo $ipdata->ip."<br>";
echo $ipdata->host."<br>";
echo $ipdata->netname."<br>";
echo $ipdata->country."<br>";
echo $ipdata->person."<br>";
echo $ipdata->address."<br>";
echo $ipdata->phone."<br>";
echo $ipdata->email."<br>";
******* sample *****/

/*******************************************************************************
GET_by_IP� free(BSD) PHP class for gettign required visitor's data by IP-address
It was primery engeneered by Andrew Goncharenko (conception).
Latest development, testing, OOP and publication: Kaurov Eugene (Ukraine).
You may use this class for free, any using.  My copyright link (url) is require.
When you'll develope it you must leave my copyright and point what have you made

														Kaurov Eugene
														http://kaurov.poltav.com
														kaurov@ukr.net
*******************************************************************************/

class get_by_ip
{
    var $ip;
    var $host;
	var $netname;
    var $country;
    var $person;
    var $address;
    var $phone;
    var $email;
    var $msg;
    
    var $server;

	function get_by_ip($addr="194.44.39.135")
	{
	    $this->ip = $addr;
	    $this->host = gethostbyaddr($this->ip);
	    if (!$this->server) $this->server = "whois.arin.net";
	    
	    if (!$this->ip == gethostbyname($this->host))
			$msg .= "Can't IP Whois without an IP address.";
		else
		{
			if (! $sock = fsockopen($this->server, 43, $num, $error, 20))
			{
				unset($sock);
				$msg .= "Timed-out connecting to ".$this->server." (port 43)";
			}else
				{
					fputs($sock, $this->ip."\n");
					while (!feof($sock))
			  		$buffer .= fgets($sock, 10240);
					fclose($sock);
				}

			if (preg_match("/RIPE.NET/i", $buffer)) $nextServer = "whois.ripe.net";
			elseif (preg_match("/whois.apnic.net/i", $buffer))	$nextServer = "whois.apnic.net";
			elseif (preg_match("/nic.ad.jp/i", $buffer))
			{
				$nextServer = "whois.nic.ad.jp";
 				#/e suppresses Japanese character output from JPNIC
 				$extra = "/e";
 			}
			elseif (preg_match("/whois.registro.br/i", $buffer)) $nextServer = "whois.registro.br";
			
			if($nextServer)
			{
				$buffer = "";
				if(! $sock = fsockopen($nextServer, 43, $num, $error, 10))
				{
					unset($sock);
					$msg .= "Timed-out connecting to $nextServer (port 43)";
				}else
					{
						fputs($sock, $this->ip.$extra."\n");
						while (!feof($sock)) $buffer .= fgets($sock, 10240);
						fclose($sock);
					}
			 }
			$msg .= nl2br($buffer);
		}
		$msg .= "</blockquote></p>";
		$this->msg=str_replace(" ", "&nbsp;", $msg);
		
		$tmparr=explode("<br />", $msg);
        foreach ($tmparr as $value)
		{
        	$tmpvalue=explode(":", $value);
            $key=trim($tmpvalue[0]);
            $znach=trim($tmpvalue[1]);
			if ($key=='country') 	$this->country=$znach; else
			if ($key=='netname') 	$this->netname=$znach; else
			if ($key=='person') 	$this->person.=$znach." "; else
			if ($key=='address') 	$this->address.=$znach." "; else
			if ($key=='phone') 		$this->phone=$znach; else
			if ($key=='e-mail') 	$this->email=$znach;
        };
	}
	
	
	function reset()
	{
	    $this->ip="";
	    $this->host="";
		$this->netname="";
	    $this->country="";
	    $this->person="";
	    $this->address="";
	    $this->phone="";
	    $this->email="";
	    $this->msg="";
	    $this->server="";
    }

}
?>

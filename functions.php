<?php

	/*
		SKRIVET AV PETTER RODHELIND
	*/

	// generera en unik tag för varje post
	function generate_tag($arg)
	{
		// $length = 4;
		// $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		// 	    for ($i = 0; $i < $length; $i++) {
		// 	        $str .= $characters[mt_rand(0, strlen($characters)-1)];
		// 	    }
		// return $str;
		
		if (empty($arg))
			$tag = "0000";
		else
			$tag = (string) $arg;
		
		$taglen = strlen($tag);
		
		// loopa igenom alla characters från höger till vänster
		// om resultatet av ökningen inte blir 0, avbryt, annars fortsätt till nästa tecken
		for ($i=$taglen-1; $i >= 0; $i--) {
			$tag[$i] = getNextCharacter($tag[$i]);
			if ($tag[$i] != "0")
				break;
		}
		
		return $tag;
	}
	function getNextCharacter($c) {
		$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$maxchars = strlen($chars);
		$curpos = strpos($chars, $c);
		
		if ($curpos+1 >= $maxchars) {
			return $chars[0];
		}
		else {
			return $chars[$curpos+1];
		}
	}

	
	// skapa hashat lösenord
	function secure_hash($password, $salt) {
		$hash = $password . $salt;
		$hash = md5($hash);

		for ($i=0; $i<1000; $i++) {
			$hash = md5($hash);
		}
		
		return $hash;
	}

	// Funktion som snyggar till datumformatet lite grann
	function datum($datum)
	{		
		if (date("Y-m-d", $datum)==date("Y-m-d", time()))
			$nytt = 'Idag ';
		else
		{
			$nytt = date("d", $datum) . ' ';

			switch (date("m", $datum))
			{
				case 01: $nytt .= "januari"; break;
				case 02: $nytt .= "februari"; break;
				case 03: $nytt .= "mars"; break;
				case 04: $nytt .= "april"; break;
				case 05: $nytt .= "maj"; break;
				case 06: $nytt .= "juni"; break;
				case 07: $nytt .= "juli"; break;
				case 08: $nytt .= "augusti"; break;
				case 09: $nytt .= "september"; break;
				case 10: $nytt .= "oktober"; break;
				case 11: $nytt .= "november"; break;
				case 12: $nytt .= "december"; break;
			}
			$nytt .= ' '.date("Y",$datum).' ';
		}

		$nytt .= date("H:i", $datum);

		return $nytt;
	}

	// visa (och säkra) inklistrad text/kod
	function parse_text($s)
	{
		// gör allt som bryter html visningsvänligt
		$s = htmlspecialchars($s);
	
		// radbrytningar, mellanslag och tabbar
		// $s = nl2br($s);
		$s = str_replace(" ","&nbsp;", $s);
		$s = str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;", $s);
	
		// klar
		return $s;
	}

?>
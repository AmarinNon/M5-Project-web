<?php
class FPDFMY extends FPDF
{
	// CELL FIT
    // Cell with horizontal scaling if text is too wide
	function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
	{
        //Get string width
		$str_width=$this->GetStringWidth($txt);

        //Calculate ratio to fit cell
		if($w==0)
			$w = $this->w-$this->rMargin-$this->x;
		$ratio = ($w-$this->cMargin*2)/$str_width;

		$fit = ($ratio < 1 || ($ratio > 1 && $force));
		if ($fit)
		{
			if ($scale)
			{
                //Calculate horizontal scaling
				$horiz_scale=$ratio*100.0;
                //Set horizontal scaling
				$this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
			}
			else
			{
                //Calculate character spacing in points
				$char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                //Set character spacing
				$this->_out(sprintf('BT %.2F Tc ET',$char_space));
			}
            //Override user alignment (since text will fill up cell)
			$align='';
		}

        //Pass on to Cell method
		$this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
		if ($fit)
			$this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
	}

    //Cell with horizontal scaling only if necessary
	function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	{
		$this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
	}

    //Cell with horizontal scaling always
	function CellFitScaleForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	{
		$this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,true);
	}

    //Cell with character spacing only if necessary
	function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	{
		$this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
	}

    //Cell with character spacing always
	function CellFitSpaceForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	{
        //Same as calling CellFit directly
		$this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,true);
	}

    //Patch to also work with CJK double-byte text
	function MBGetStringLength($s)
	{
		if($this->CurrentFont['type']=='Type0')
		{
			$len = 0;
			$nbbytes = strlen($s);
			for ($i = 0; $i < $nbbytes; $i++)
			{
				if (ord($s[$i])<128)
					$len++;
				else
				{
					$len++;
					$i++;
				}
			}
			return $len;
		}
		else
			return strlen($s);
	}
	// End CELL FIT






	// EAN13 Barcode
	function EAN13($x, $y, $barcode, $h=16, $w=.35)
	{
		$this->Barcode($x,$y,$barcode,$h,$w,13);
	}

	function UPC_A($x, $y, $barcode, $h=16, $w=.35)
	{
		$this->Barcode($x,$y,$barcode,$h,$w,12);
	}

	function GetCheckDigit($barcode)
	{
    	//Compute the check digit
		$sum=0;
		for($i=1;$i<=11;$i+=2)
			$sum+=3*$barcode[$i];
		for($i=0;$i<=10;$i+=2)
			$sum+=$barcode[$i];
		$r=$sum%10;
		if($r>0)
			$r=10-$r;
		return $r;
	}

	function TestCheckDigit($barcode)
	{
    	//Test validity of check digit
		$sum=0;
		for($i=1;$i<=11;$i+=2)
			$sum+=3*$barcode[$i];
		for($i=0;$i<=10;$i+=2)
			$sum+=$barcode[$i];
		return ($sum+$barcode[12])%10==0;
	}

	function Barcode($x, $y, $barcode, $h, $w, $len)
	{
		//Padding
		$barcode=str_pad($barcode,$len-1,'0',STR_PAD_LEFT);
		if($len==12)
			$barcode='0'.$barcode;
    	//Add or control the check digit
		if(strlen($barcode)==12)
			$barcode.=$this->GetCheckDigit($barcode);
		elseif(!$this->TestCheckDigit($barcode))
			$this->Error('Incorrect check digit');
   	 	//Convert digits to bars
		$codes=array(
			'A'=>array(
				'0'=>'0001101','1'=>'0011001','2'=>'0010011','3'=>'0111101','4'=>'0100011',
				'5'=>'0110001','6'=>'0101111','7'=>'0111011','8'=>'0110111','9'=>'0001011'),
			'B'=>array(
				'0'=>'0100111','1'=>'0110011','2'=>'0011011','3'=>'0100001','4'=>'0011101',
				'5'=>'0111001','6'=>'0000101','7'=>'0010001','8'=>'0001001','9'=>'0010111'),
			'C'=>array(
				'0'=>'1110010','1'=>'1100110','2'=>'1101100','3'=>'1000010','4'=>'1011100',
				'5'=>'1001110','6'=>'1010000','7'=>'1000100','8'=>'1001000','9'=>'1110100')
			);
		$parities=array(
			'0'=>array('A','A','A','A','A','A'),
			'1'=>array('A','A','B','A','B','B'),
			'2'=>array('A','A','B','B','A','B'),
			'3'=>array('A','A','B','B','B','A'),
			'4'=>array('A','B','A','A','B','B'),
			'5'=>array('A','B','B','A','A','B'),
			'6'=>array('A','B','B','B','A','A'),
			'7'=>array('A','B','A','B','A','B'),
			'8'=>array('A','B','A','B','B','A'),
			'9'=>array('A','B','B','A','B','A')
			);
		$code='101';
		$p=$parities[$barcode[0]];
		for($i=1;$i<=6;$i++)
			$code.=$codes[$p[$i-1]][$barcode[$i]];
		$code.='01010';
		for($i=7;$i<=12;$i++)
			$code.=$codes['C'][$barcode[$i]];
		$code.='101';
    	//Draw bars
		for($i=0;$i<strlen($code);$i++)
		{
			if($code[$i]=='1')
				$this->Rect($x+$i*$w,$y,$w,$h,'F');
			
		}
		//Print text uder barcode
		$this->SetFont('Arial','',12);
		$this->Text($x,$y+$h+11/$this->k,substr($barcode,-$len));
	}
	// END EAN13 Barcode









	// CODE128 Barcode
	var $T128;                                             // tableau des codes 128
	var $ABCset="";                                        // jeu des caract??res ??ligibles au C128
	var $Aset="";                                          // Set A du jeu des caract??res ??ligibles
	var $Bset="";                                          // Set B du jeu des caract??res ??ligibles
	var $Cset="";                                          // Set C du jeu des caract??res ??ligibles
	var $SetFrom;                                          // Convertisseur source des jeux vers le tableau
	var $SetTo;                                            // Convertisseur destination des jeux vers le tableau
	var $JStart = array("A"=>103, "B"=>104, "C"=>105);     // Caract??res de s??lection de jeu au d??but du C128
	var $JSwap = array("A"=>101, "B"=>100, "C"=>99);       // Caract??res de changement de jeu
	
	function Code128($x, $y, $code, $w, $h) {
		$this->T128[] = array(2, 1, 2, 2, 2, 2);           //0 : [ ]
	    $this->T128[] = array(2, 2, 2, 1, 2, 2);           //1 : [!]
	    $this->T128[] = array(2, 2, 2, 2, 2, 1);           //2 : ["]
	    $this->T128[] = array(1, 2, 1, 2, 2, 3);           //3 : [#]
	    $this->T128[] = array(1, 2, 1, 3, 2, 2);           //4 : [$]
	    $this->T128[] = array(1, 3, 1, 2, 2, 2);           //5 : [%]
	    $this->T128[] = array(1, 2, 2, 2, 1, 3);           //6 : [&]
	    $this->T128[] = array(1, 2, 2, 3, 1, 2);           //7 : [']
	    $this->T128[] = array(1, 3, 2, 2, 1, 2);           //8 : [(]
	    $this->T128[] = array(2, 2, 1, 2, 1, 3);           //9 : [)]
	    $this->T128[] = array(2, 2, 1, 3, 1, 2);           //10 : [*]
	    $this->T128[] = array(2, 3, 1, 2, 1, 2);           //11 : [+]
	    $this->T128[] = array(1, 1, 2, 2, 3, 2);           //12 : [,]
	    $this->T128[] = array(1, 2, 2, 1, 3, 2);           //13 : [-]
	    $this->T128[] = array(1, 2, 2, 2, 3, 1);           //14 : [.]
	    $this->T128[] = array(1, 1, 3, 2, 2, 2);           //15 : [/]
	    $this->T128[] = array(1, 2, 3, 1, 2, 2);           //16 : [0]
	    $this->T128[] = array(1, 2, 3, 2, 2, 1);           //17 : [1]
	    $this->T128[] = array(2, 2, 3, 2, 1, 1);           //18 : [2]
	    $this->T128[] = array(2, 2, 1, 1, 3, 2);           //19 : [3]
	    $this->T128[] = array(2, 2, 1, 2, 3, 1);           //20 : [4]
	    $this->T128[] = array(2, 1, 3, 2, 1, 2);           //21 : [5]
	    $this->T128[] = array(2, 2, 3, 1, 1, 2);           //22 : [6]
	    $this->T128[] = array(3, 1, 2, 1, 3, 1);           //23 : [7]
	    $this->T128[] = array(3, 1, 1, 2, 2, 2);           //24 : [8]
	    $this->T128[] = array(3, 2, 1, 1, 2, 2);           //25 : [9]
	    $this->T128[] = array(3, 2, 1, 2, 2, 1);           //26 : [:]
	    $this->T128[] = array(3, 1, 2, 2, 1, 2);           //27 : [;]
	    $this->T128[] = array(3, 2, 2, 1, 1, 2);           //28 : [<]
	    $this->T128[] = array(3, 2, 2, 2, 1, 1);           //29 : [=]
	    $this->T128[] = array(2, 1, 2, 1, 2, 3);           //30 : [>]
	    $this->T128[] = array(2, 1, 2, 3, 2, 1);           //31 : [?]
	    $this->T128[] = array(2, 3, 2, 1, 2, 1);           //32 : [@]
	    $this->T128[] = array(1, 1, 1, 3, 2, 3);           //33 : [A]
	    $this->T128[] = array(1, 3, 1, 1, 2, 3);           //34 : [B]
	    $this->T128[] = array(1, 3, 1, 3, 2, 1);           //35 : [C]
	    $this->T128[] = array(1, 1, 2, 3, 1, 3);           //36 : [D]
	    $this->T128[] = array(1, 3, 2, 1, 1, 3);           //37 : [E]
	    $this->T128[] = array(1, 3, 2, 3, 1, 1);           //38 : [F]
	    $this->T128[] = array(2, 1, 1, 3, 1, 3);           //39 : [G]
	    $this->T128[] = array(2, 3, 1, 1, 1, 3);           //40 : [H]
	    $this->T128[] = array(2, 3, 1, 3, 1, 1);           //41 : [I]
	    $this->T128[] = array(1, 1, 2, 1, 3, 3);           //42 : [J]
	    $this->T128[] = array(1, 1, 2, 3, 3, 1);           //43 : [K]
	    $this->T128[] = array(1, 3, 2, 1, 3, 1);           //44 : [L]
	    $this->T128[] = array(1, 1, 3, 1, 2, 3);           //45 : [M]
	    $this->T128[] = array(1, 1, 3, 3, 2, 1);           //46 : [N]
	    $this->T128[] = array(1, 3, 3, 1, 2, 1);           //47 : [O]
	    $this->T128[] = array(3, 1, 3, 1, 2, 1);           //48 : [P]
	    $this->T128[] = array(2, 1, 1, 3, 3, 1);           //49 : [Q]
	    $this->T128[] = array(2, 3, 1, 1, 3, 1);           //50 : [R]
	    $this->T128[] = array(2, 1, 3, 1, 1, 3);           //51 : [S]
	    $this->T128[] = array(2, 1, 3, 3, 1, 1);           //52 : [T]
	    $this->T128[] = array(2, 1, 3, 1, 3, 1);           //53 : [U]
	    $this->T128[] = array(3, 1, 1, 1, 2, 3);           //54 : [V]
	    $this->T128[] = array(3, 1, 1, 3, 2, 1);           //55 : [W]
	    $this->T128[] = array(3, 3, 1, 1, 2, 1);           //56 : [X]
	    $this->T128[] = array(3, 1, 2, 1, 1, 3);           //57 : [Y]
	    $this->T128[] = array(3, 1, 2, 3, 1, 1);           //58 : [Z]
	    $this->T128[] = array(3, 3, 2, 1, 1, 1);           //59 : [[]
	    $this->T128[] = array(3, 1, 4, 1, 1, 1);           //60 : [\]
	    $this->T128[] = array(2, 2, 1, 4, 1, 1);           //61 : []]
	    $this->T128[] = array(4, 3, 1, 1, 1, 1);           //62 : [^]
	    $this->T128[] = array(1, 1, 1, 2, 2, 4);           //63 : [_]
	    $this->T128[] = array(1, 1, 1, 4, 2, 2);           //64 : [`]
	    $this->T128[] = array(1, 2, 1, 1, 2, 4);           //65 : [a]
	    $this->T128[] = array(1, 2, 1, 4, 2, 1);           //66 : [b]
	    $this->T128[] = array(1, 4, 1, 1, 2, 2);           //67 : [c]
	    $this->T128[] = array(1, 4, 1, 2, 2, 1);           //68 : [d]
	    $this->T128[] = array(1, 1, 2, 2, 1, 4);           //69 : [e]
	    $this->T128[] = array(1, 1, 2, 4, 1, 2);           //70 : [f]
	    $this->T128[] = array(1, 2, 2, 1, 1, 4);           //71 : [g]
	    $this->T128[] = array(1, 2, 2, 4, 1, 1);           //72 : [h]
	    $this->T128[] = array(1, 4, 2, 1, 1, 2);           //73 : [i]
	    $this->T128[] = array(1, 4, 2, 2, 1, 1);           //74 : [j]
	    $this->T128[] = array(2, 4, 1, 2, 1, 1);           //75 : [k]
	    $this->T128[] = array(2, 2, 1, 1, 1, 4);           //76 : [l]
	    $this->T128[] = array(4, 1, 3, 1, 1, 1);           //77 : [m]
	    $this->T128[] = array(2, 4, 1, 1, 1, 2);           //78 : [n]
	    $this->T128[] = array(1, 3, 4, 1, 1, 1);           //79 : [o]
	    $this->T128[] = array(1, 1, 1, 2, 4, 2);           //80 : [p]
	    $this->T128[] = array(1, 2, 1, 1, 4, 2);           //81 : [q]
	    $this->T128[] = array(1, 2, 1, 2, 4, 1);           //82 : [r]
	    $this->T128[] = array(1, 1, 4, 2, 1, 2);           //83 : [s]
	    $this->T128[] = array(1, 2, 4, 1, 1, 2);           //84 : [t]
	    $this->T128[] = array(1, 2, 4, 2, 1, 1);           //85 : [u]
	    $this->T128[] = array(4, 1, 1, 2, 1, 2);           //86 : [v]
	    $this->T128[] = array(4, 2, 1, 1, 1, 2);           //87 : [w]
	    $this->T128[] = array(4, 2, 1, 2, 1, 1);           //88 : [x]
	    $this->T128[] = array(2, 1, 2, 1, 4, 1);           //89 : [y]
	    $this->T128[] = array(2, 1, 4, 1, 2, 1);           //90 : [z]
	    $this->T128[] = array(4, 1, 2, 1, 2, 1);           //91 : [{]
	    $this->T128[] = array(1, 1, 1, 1, 4, 3);           //92 : [|]
	    $this->T128[] = array(1, 1, 1, 3, 4, 1);           //93 : [}]
	    $this->T128[] = array(1, 3, 1, 1, 4, 1);           //94 : [~]
	    $this->T128[] = array(1, 1, 4, 1, 1, 3);           //95 : [DEL]
	    $this->T128[] = array(1, 1, 4, 3, 1, 1);           //96 : [FNC3]
	    $this->T128[] = array(4, 1, 1, 1, 1, 3);           //97 : [FNC2]
	    $this->T128[] = array(4, 1, 1, 3, 1, 1);           //98 : [SHIFT]
	    $this->T128[] = array(1, 1, 3, 1, 4, 1);           //99 : [Cswap]
	    $this->T128[] = array(1, 1, 4, 1, 3, 1);           //100 : [Bswap]                
	    $this->T128[] = array(3, 1, 1, 1, 4, 1);           //101 : [Aswap]
	    $this->T128[] = array(4, 1, 1, 1, 3, 1);           //102 : [FNC1]
	    $this->T128[] = array(2, 1, 1, 4, 1, 2);           //103 : [Astart]
	    $this->T128[] = array(2, 1, 1, 2, 1, 4);           //104 : [Bstart]
	    $this->T128[] = array(2, 1, 1, 2, 3, 2);           //105 : [Cstart]
	    $this->T128[] = array(2, 3, 3, 1, 1, 1);           //106 : [STOP]
	    $this->T128[] = array(2, 1);                       //107 : [END BAR]

	    for ($i = 32; $i <= 95; $i++) {                                            // jeux de caract??res
	    	$this->ABCset .= chr($i);
	    }
	    $this->Aset = $this->ABCset;
	    $this->Bset = $this->ABCset;
	    
	    for ($i = 0; $i <= 31; $i++) {
	    	$this->ABCset .= chr($i);
	    	$this->Aset .= chr($i);
	    }
	    for ($i = 96; $i <= 127; $i++) {
	    	$this->ABCset .= chr($i);
	    	$this->Bset .= chr($i);
	    }
	    for ($i = 200; $i <= 210; $i++) {                                           // controle 128
	    	$this->ABCset .= chr($i);
	    	$this->Aset .= chr($i);
	    	$this->Bset .= chr($i);
	    }
	    $this->Cset="0123456789".chr(206);

	    for ($i=0; $i<96; $i++) {                                                   // convertisseurs des jeux A & B
	    	@$this->SetFrom["A"] .= chr($i);
	    	@$this->SetFrom["B"] .= chr($i + 32);
	    	@$this->SetTo["A"] .= chr(($i < 32) ? $i+64 : $i-32);
	    	@$this->SetTo["B"] .= chr($i);
	    }
	    for ($i=96; $i<107; $i++) {                                                 // contr??le des jeux A & B
	    	@$this->SetFrom["A"] .= chr($i + 104);
	    	@$this->SetFrom["B"] .= chr($i + 104);
	    	@$this->SetTo["A"] .= chr($i);
	    	@$this->SetTo["B"] .= chr($i);
	    }

	    $Aguid = "";                                                         
	    $Bguid = "";
	    $Cguid = "";
	    for ($i=0; $i < strlen($code); $i++) {
	    	$needle = substr($code,$i,1);
	    	$Aguid .= ((strpos($this->Aset,$needle)===false) ? "N" : "O"); 
	    	$Bguid .= ((strpos($this->Bset,$needle)===false) ? "N" : "O"); 
	    	$Cguid .= ((strpos($this->Cset,$needle)===false) ? "N" : "O");
	    }

	    $SminiC = "OOOO";
	    $IminiC = 4;

	    $crypt = "";
	    while ($code > "") {
	                                                                                    // BOUCLE PRINCIPALE DE CODAGE
	        $i = strpos($Cguid,$SminiC);                                                // for??age du jeu C, si possible
	        if ($i!==false) {
	        	$Aguid [$i] = "N";
	        	$Bguid [$i] = "N";
	        }

	        if (substr($Cguid,0,$IminiC) == $SminiC) {                                  // jeu C
	            $crypt .= chr(($crypt > "") ? $this->JSwap["C"] : $this->JStart["C"]);  // d??but Cstart, sinon Cswap
	            $made = strpos($Cguid,"N");                                             // ??tendu du set C
	            if ($made === false) {
	            	$made = strlen($Cguid);
	            }
	            if (fmod($made,2)==1) {
	                $made--;                                                            // seulement un nombre pair
	            }
	            for ($i=0; $i < $made; $i += 2) {
	                $crypt .= chr(strval(substr($code,$i,2)));                          // conversion 2 par 2
	            }
	            $jeu = "C";
	        } else {
	            $madeA = strpos($Aguid,"N");                                            // ??tendu du set A
	            if ($madeA === false) {
	            	$madeA = strlen($Aguid);
	            }
	            $madeB = strpos($Bguid,"N");                                            // ??tendu du set B
	            if ($madeB === false) {
	            	$madeB = strlen($Bguid);
	            }
	            $made = (($madeA < $madeB) ? $madeB : $madeA );                         // ??tendu trait??e
	            $jeu = (($madeA < $madeB) ? "B" : "A" );                                // Jeu en cours

	            $crypt .= chr(($crypt > "") ? $this->JSwap[$jeu] : $this->JStart[$jeu]); // d??but start, sinon swap

	            $crypt .= strtr(substr($code, 0,$made), $this->SetFrom[$jeu], $this->SetTo[$jeu]); // conversion selon jeu

	        }
	        $code = substr($code,$made);                                           // raccourcir l??gende et guides de la zone trait??e
	        $Aguid = substr($Aguid,$made);
	        $Bguid = substr($Bguid,$made);
	        $Cguid = substr($Cguid,$made);
	    }                                                                          // FIN BOUCLE PRINCIPALE

	    $check = ord($crypt[0]);                                                   // calcul de la somme de contr??le
	    for ($i=0; $i<strlen($crypt); $i++) {
	    	$check += (ord($crypt[$i]) * $i);
	    }
	    $check %= 103;

	    $crypt .= chr($check) . chr(106) . chr(107);                               // Chaine Crypt??e compl??te

	    $i = (strlen($crypt) * 11) - 8;                                            // calcul de la largeur du module
	    $modul = $w/$i;

	    for ($i=0; $i<strlen($crypt); $i++) 
	    {                                     
	    	$c = $this->T128[ord($crypt[$i])];
	    	for ($j=0; $j<count($c); $j++) {
	    		$this->Rect($x,$y,$c[$j]*$modul,$h,"F");
	    		$x += ($c[$j++]+$c[$j])*$modul;
	    	}
	    }
	}
	// END CODE128 Barcode
}
?>

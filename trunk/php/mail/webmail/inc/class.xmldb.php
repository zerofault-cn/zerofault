<?

class CXmlDB 
{
	function CXmlDB() 
	{ 
		$this->SetDoc(NULL); 
	}
	
	// Parse and Navigate
	function SetDoc($szDoc )
	{
		// Reset indexes
		$this->m_iPosFree = 1;
		$this->ResetPos();
	
		// Starting size of position array
		$nBaseSize = 50;
		if ( count($this->m_aPos) < $nBaseSize )
		{
			for ($i = count($this->m_aPos)-1; $i < $nBaseSize; $i++)
			{
				$apos['nStartL'] = 0; 
				$apos['nStartR'] = 0; 
				$apos['nEndL'] = 0; 
				$apos['nEndR'] = 0; 
				$apos['nNext'] = 0;
				$apos['iElemParent'] = 0; 
				$apos['iElemChild'] = 0; 
				$apos['iElemNext'] = 0;
				
				$this->m_aPos[] = $apos;
			}
		}
	
		// Parse document
		$bWellFormed = false;
		unset($this->m_aPos[0]);
		unset($this->m_mapSavedPos);
		
		if ($szDoc != NULL)
		{
			$this->m_strDoc = $szDoc;
			$iPos = $this->x_ParseElem(0);

			$this->m_aPos[0]['iElemChild'] = $iPos;
			if ($iPos)
				$bWellFormed = true;
		}
	
		// Clear document if parse failed
		if (!$bWellFormed)
		{
			unset($this->m_strDoc);
			$this->m_aPos[0]['iElemChild'] = 0;
			$this->m_iPosFree = 1;
		}
	
		$this->ResetPos();
		
		return $bWellFormed;
	}

	function FindElem($szName = NULL)
	{
		// If szName is NULL or empty, go to next sibling element
		// Otherwise go to next sibling element with matching tag name
		// If the current position is valid, start looking from next
		// Change current position only if found
		//
		$iPos = $this->m_iPos;
		if ( !$iPos )
		{
			if ( count($this->m_aPos) )
				$iPos = $this->m_aPos[0]['iElemChild'];
		}
		else
		{
			$iPos = $this->m_aPos[$iPos]['iElemNext'];
		}

		while ( $iPos )
		{
			// Compare tag name unless szName is not specified
			if ( $szName == NULL || !$szName[0] || $this->x_GetTagName($iPos) == $szName )
			{
				// Assign new position
				$this->m_iPos = $iPos;
				$this->m_iPosChild = 0;
				
				return true;
			}
			$iPos = $this->m_aPos[$iPos]['iElemNext'];
		}
		
		return false;
	}

	function FindChildElem($szName = NULL)
	{
		// If szName is NULL or empty, go to next sibling child element
		// Otherwise go to next sibling child element with matching tag name
		// If the current child position is valid, start looking from next
		// Change current child position only if found
		//
		// Shorthand: call this with no current position means under root element
		if ( !$this->m_iPos )
			$this->FindElem();
	
		// Is main position valid and not empty
		if ( !$this->m_iPos 
			|| ($this->m_aPos[$this->m_iPos]['nStartR'] == $this->m_aPos[$this->m_iPos]['nEndL']+1) )
			return false;
	
		// Is current child position valid?
		$iPosChild = $this->m_iPosChild;
		if ( $iPosChild )
			$iPosChild = $this->m_aPos[$iPosChild]['iElemNext'];
		else
			$iPosChild = $this->m_aPos[$this->m_iPos]['iElemChild'];
	
		// Search
		while ( $iPosChild )
		{
			// Compare tag name unless szName is not specified
			if ( $szName == NULL || !$szName[0] 
				|| $this->x_GetTagName($iPosChild) == $szName )
			{
				// Assign new position
				$this->m_iPosChild = $iPosChild;
				
				return true;
			}
			$iPosChild = $this->m_aPos[$iPosChild]['iElemNext'];
		}
		
		return false;
	}
	
	function IntoElem()
	{
		// Find child element unless there is already a child element position
		if ( !$this->m_iPosChild )
			$this->FindChildElem();
	
		if ( $this->m_iPosChild )
		{
			$this->m_iPos = $this->m_iPosChild;
			$this->m_iPosChild = 0;
			++$this->m_nLevel;
			
			return true;
		}
	
		return false;
	}
	
	function OutOfElem()
	{
		if ( $this->m_iPos && $this->m_aPos[$this->m_iPos]['iElemParent'] )
		{
			$this->m_iPosChild = $this->m_iPos;
			$this->m_iPos = $this->m_aPos[$this->m_iPos]['iElemParent'];
			--$this->m_nLevel;
			
			return true;
		}
		return false;
	}

	function ResetChildPos() 
	{ 
		$this->m_iPosChild = 0; 
	}
	
	function ResetPos()
	{
		$this->m_iPos = 0;
		$this->m_iPosChild = 0;
		$this->m_nLevel = 0;
	}

	function GetTagName() 
	{ 
		return $this->x_GetTagName($this->m_iPos); 
	}
	
	function GetChildTagName() 
	{ 
		return $this->x_GetTagName($this->m_iPosChild); 
	}
	
	function GetData() 
	{ 
		return $this->x_GetData($this->m_iPos); 
	}
	
	function GetChildData() 
	{ 
		return $this->x_GetData($this->m_iPosChild); 
	}
	
	function GetAttrib( $szAttrib ) 
	{ 
		return $this->x_GetAttrib($this->m_iPos, $szAttrib); 
	}
	
	function GetChildAttrib( $szAttrib ) 
	{ 
		return $this->x_GetAttrib($this->m_iPosChild, $szAttrib);
	}
	
	function GetAttribName($n)
	{
		$token['nL'] = 0;
		$token['nR'] = -1;
		$token['bIsString'] = false;
		
		$token['nNext'] = $this->m_aPos[$this->m_iPos]['nStartL'] + 1;
		for ( $nAttrib=0; $nAttrib <= $n; ++$nAttrib )
			if ( !$this->x_FindAttrib($token) )
				return "";
	
		// Return substring of document
		return $this->x_GetToken( $token );
	}

	function SavePos( $szPosName = "" )
	{
		if ( $this->m_iPos && $szPosName != NULL )
		{
			$savedpos['iPos'] = $this->m_iPos;
			$savedpos['iPosChild'] = $this->m_iPosChild;
			$savedpos['iLevel'] = $this->m_nLevel;
			
			$this->m_mapSavedPos[$szPosName] = $savedpos;
			
			return true;
		}
		
		return false;
	}

	function RestorePos( $szPosName = "" )
	{
		if ( $szPosName != NULL)
		{
			while (list($key, $val) = each($this->m_mapSavedPos)) 
			{
				if ($key == $szPosName)
				{
					$this->m_iPos = $val['iPos'];
					$this->m_iPosChild = $val['iPosChild'];
					$this->m_nLevel = $val['iLevel'];

					return true;
				}
			}
		}
		return false;
	}

	function GetOffsets( &$nStart, &$nEnd ) 
	{
		if ( $this->m_iPos )
		{
			
			$nStart = $this->m_aPos[$this->m_iPos]['nStartL'];
			$nEnd = $this->m_aPos[$this->m_iPos]['nEndR'];
			
			return true;
		}
		return false;
	}

	// Create
	function AddElem( $szName, $szValue = NULL )
	{
		$iPosParent = $this->m_iPos ? $this->m_aPos[$this->m_iPos]['iElemParent'] : 0;
		$this->m_iPosChild = 0;
		$this->m_iPos = $this->x_Add( $iPosParent, $this->m_iPos, $szName, $szValue );
		
		return true;
	}	
		
	function AddChildElem( $szName, $szValue = NULL )
	{
		// Add a child element under main position, after current child position
		if ( !$this->m_iPos )
			return false;
	
		// If no child position, add after last sibling
		$iPosLast = $this->m_aPos[$this->m_iPos]['iElemChild'];
		if ( !$this->m_iPosChild && $iPosLast )
		{
			$this->m_iPosChild = $iPosLast;
			
			while ( ($iPosLast = $this->m_aPos[$iPosLast]['iElemNext']) != 0 )
				$this->m_iPosChild = $iPosLast;
		}
	
		$this->m_iPosChild = $this->x_Add( $this->m_iPos, $this->m_iPosChild, $szName, $szValue );
		return true;
	}
	
	function InsertChildElem( $szName, $szValue = NULL )
	{
		if ( !$this->m_iPos )
			return false;
	
		// Get first child of parent
		$iPosPrev = $this->m_aPos[$this->m_iPos]['iElemChild'];
	
		// Is current position clear or first sibling?
		if ( !$this->m_iPosChild || $iPosPrev == $this->m_iPosChild )
		{
			// Add as first child under parent
			$this->m_iPosChild = $this->x_Add( $this->m_iPos, 0, $szName, $szValue );
			return true;
		}
	
		// Find position before current position
		while ( $this->m_aPos[$iPosPrev]['iElemNext'] != $this->m_iPosChild )
			$iPosPrev = $this->m_aPos[$iPosPrev]['iElemNext'];
	
		// Add after previous position
		$this->m_iPosChild = $this->x_Add( $this->m_iPos, $iPosPrev, $szName, $szValue );
		
		return true;
	}

	function AddAttrib( $szAttrib, $szValue )
	{
		if ( $this->m_iPos )
		{
			$this->x_AddAttrib( $this->m_iPos, $szAttrib, $szValue );
			return true;
		}
		return false;
	}

	function AddChildAttrib( $szAttrib, $szValue )
	{
		if ( $this->m_iPosChild )
		{
			$this->x_AddAttrib( $this->m_iPosChild, $szAttrib, $szValue );
			return true;
		}
		return false;
	}

	function GetDoc() 
	{ 
		return $this->m_strDoc; 
	}
	
	function AddChildSubDoc( $szSubDoc )
	{
		// Add a subdocument under main position, after current child position
		if ( !$this->m_iPos )
			return false;
	
		// If no child position, add after last sibling
		$iPosLast = $this->m_aPos[$this->m_iPos]['iElemChild'];
		$iPosBefore = $this->m_iPosChild;
		
		if ( !$iPosBefore && $iPosLast )
		{
			$iPosBefore = $iPosLast;
			while ( ($iPosLast = $this->m_aPos[$iPosLast]['iElemNext']) != 0 )
				$iPosBefore = $iPosLast;
		}
	
		$iPosSubDoc = $this->x_AddSubDoc( $this->m_iPos, $iPosBefore, $szSubDoc );
		if ( !$iPosSubDoc )
			return false;
	
		$this->m_iPosChild = $iPosSubDoc;
		return true;
	}

	function InsertChildSubDoc( $szSubDoc )
	{
		// Add a subdocument under main position, after current child position
		if ( !$this->m_iPos )
			return false;
	
		// Get first child of parent
		$iPosPrev = $this->m_aPos[$this->m_iPos]['iElemChild'];
	
		// Is current child position after first child?
		if ( $this->m_iPosChild && $iPosPrev != $this->m_iPosChild )
		{
			// Find position before current position
			while ( $this->m_aPos[$iPosPrev]['iElemNext'] != $this->m_iPosChild )
				$iPosPrev = $this->m_aPos[$iPosPrev]['iElemNext'];
		}
		else
		{
			$iPosPrev = 0;
		}
	
		// Add after previous position
		$iPosSubDoc = $this->x_AddSubDoc( $m_iPos, $iPosPrev, $szSubDoc );
		if ( !$iPosSubDoc )
			return false;
	
		$this->m_iPosChild = $iPosSubDoc;
		return true;
	}

	function GetChildSubDoc()
	{
		if ( $this->m_iPosChild )
		{
			$nL = $this->m_aPos[$this->m_iPosChild]['nStartL'];
			$nR = $this->m_aPos[$this->m_iPosChild]['nNext'];
			return substr($this->m_strDoc, $nL, $nR - $nL );
		}
		return "";
	}

	// Modify
	function RemoveElem()
	{
		// Remove current main position element
		if ( $this->m_iPos )
		{
			$this->m_iPosChild = 0;
			$this->m_iPos = $this->x_Remove( $this->m_iPos );
			return true;
		}
		return false;
	}

	function RemoveChildElem()
	{
		if ( $this->m_iPosChild )
		{
			$this->m_iPosChild = $this->x_Remove( $this->m_iPosChild );
			return true;
		}
		return false;
	}
	
	function SetAttrib( $szAttrib, $szValue )
	{
		if ( $this->m_iPos )
		{
			$this->x_SetAttrib( $this->m_iPos, $szAttrib, $szValue );
			return true;
		}
		return false;
	}

	function SetChildAttrib( $szAttrib, $szValue )
	{
		if ( $this->m_iPosChild )
		{
			$this->x_SetAttrib( $this->m_iPosChild, $szAttrib, $szValue );
			return true;
		}
		return false;
	}
	
	function SetData( $szData ) 
	{ 
		return $this->x_SetData($this->m_iPos, $szData); 
	}
	
	function SetChildData( $szData ) 
	{ 
		return $this->x_SetData($this->m_iPosChild, $szData); 
	}

	// Only to be used for debugging
	function DebugMap() 
	{
		$pszDoc = $this->m_strDoc;
		$nLenDoc = sizeof($this->m_strDoc);
		
		// Loop through positions in document
		$strDump = "";
		for ( $iPos = 0; $iPos < $this->m_iPosFree; ++$iPos )
		{
			// Check chars pointed to by indexes
			// Empty szChars if correct
			$szChars = chr($this->m_aPos[$iPos]['nStartL']);
			$szChars .= chr($this->m_aPos[$iPos]['nStartR']);
			$szChars .= chr($this->m_aPos[$iPos]['nEndL']);
			$szChars .= chr($this->m_aPos[$iPos]['nEndR']);
			$szChars .= chr($this->m_aPos[$iPos]['nNext']);
			$szChars .= chr(0);
			
			if ( $szChars[4] == '<' || $szChars[4] == chr(0) )
			{
				if ($this->m_aPos[$iPos]['nStartR'] == $this->m_aPos[$iPos]['nEndL']+1)
				{
					if ( strncmp("<>/>", $szChars, 4) == 0 )
						$szChars[0] = chr(0);
				}
				else
				{
					if ( strncmp("<><>", $szChars, 4) == 0 )
						$szChars[0] = chr(0);
				}
			}
	
			// Build line of dump
			$szLine = sprintf("Index %d\t%d %d %d %d %d [%s] p=%d n=%d c=%d<br>\n",
				$iPos,
				$this->m_aPos[$iPos]['nStartL'],
				$this->m_aPos[$iPos]['nStartR'],
				$this->m_aPos[$iPos]['nEndL'],
				$this->m_aPos[$iPos]['nEndR'],
				$this->m_aPos[$iPos]['nNext'],
				$szChars[0] ? $szChars : "valid",
				$this->m_aPos[$iPos]['iElemParent'],
				$this->m_aPos[$iPos]['iElemNext'],
				$this->m_aPos[$iPos]['iElemChild']
				);

			$strDump .= $szLine;
		}
		
		return $strDump;
	}


	var $m_strDoc;
	var $m_nLevel;
    var $m_aPos = array();
	var $m_iPos;
	var $m_iPosChild;
	var $m_iPosFree;
	var $m_mapSavedPos = array();

	function x_GetFreePos()
	{
		//
		// This returns the index of the next unused ElemPos in the array
		//
		if ( $this->m_iPosFree == count($this->m_aPos) )
		{
			//for ($i = 0; $i < $this->m_iPosFree/2; $i++)
			for ($i = 0; $i < $nBaseSize; $i++)
			{
				$apos['nStartL'] = 0; 
				$apos['nStartR'] = 0; 
				$apos['nEndL'] = 0; 
				$apos['nEndR'] = 0; 
				$apos['nNext'] = 0;
				$apos['iElemParent'] = 0; 
				$apos['iElemChild'] = 0; 
				$apos['iElemNext'] = 0;
				
				$this->m_aPos[] = $apos;
			}
		}

		++$this->m_iPosFree;
		return $this->m_iPosFree - 1;
	}

	function x_ReleasePos()
	{
		//
		// This decrements the index of the next unused ElemPos in the array
		// allowing the element index returned by GetFreePos() to be reused
		//
		--$this->m_iPosFree;
		return 0;
	}

	function x_ParseElem( $iPosParent )
	{
		// This is either called by SetDoc, x_AddSubDoc, or itself recursively
		// m_aPos[iPosParent].nEndL is where to start parsing for the child element
		// This returns the new position if a tag is found, otherwise zero
		// In all cases we need to get a new ElemPos, but release it if unused
		//
		$iPos = $this->x_GetFreePos();
		$this->m_aPos[$iPos]['nStartL'] = $this->m_aPos[$iPosParent]['nEndL'];
		$this->m_aPos[$iPos]['nNext'] = $this->m_aPos[$iPosParent]['nStartR'] + 1;
		$this->m_aPos[$iPos]['iElemParent'] = $iPosParent;
		$this->m_aPos[$iPos]['iElemChild'] = 0;
		$this->m_aPos[$iPos]['iElemNext'] = 0;

		// Look at the Start Tag
		$token['nL'] = 0;
		$token['nR'] = -1;
		$token['bIsString'] = false;
		
		$bEndMark = false;
	
		// A loop is used to ignore all remarks tags and special tags
		// i.e. < ? xml version="1.0" ? >, and <!-- comment here -->
		// So any tag beginning with ? or ! is ignored
		// Loop past ignoreg tags
		while ( 1 )
		{
			// Look for left angle bracket of opening tag
			if ( !$this->x_FindChar( $this->m_aPos[$iPos]['nStartL'], '<' ) )
				return $this->x_ReleasePos();
	
			// nTagFlag is used to keep track of special tag conditions
			// Since a comment can contain less than and greater than chars etc.
			// And only normal tags cause bEndMark to be set
			// 0 = normal start tag
			// 1 = version
			// 2 = in comment
			// 3 = comment end
			$nTagFlag = 0;
	
			$strName = "";
			$token['nNext'] = $this->m_aPos[$iPos]['nStartL'] + 1;
			$nTokenCount = 0;
			while ( $this->x_FindToken( $token ) )
			{
				++$nTokenCount;
				if ( !$token['bIsString'] )
				{
					// Is it an end slash mark?
					$cEndCheck = $this->m_strDoc[$token['nL']];

					if ( $cEndCheck == '/' )
					{
						if ( $nTokenCount == 1 )
							return $this->x_ReleasePos(); // end mark at beginning
						if ( $nTagFlag == 0 )
							$bEndMark = true; // end of start tag
					}
	
					// Else is it a right angle bracket?
					else if ( $cEndCheck == '>' )
					{
						if ( $nTagFlag != 2 ) // does not mean end if in a comment
							break;
					}
	
					// Else is it the end of a comment
					else if ( $nTagFlag == 2 && $cEndCheck == '-' )
					{
						if ( $m_strDoc[$token['nR']] == '-' && $token['nR'] == $token['nL']+1 )
							$nTagFlag = 3; // end of comment, next token should be >
					}
	
					if ( $nTokenCount == 1 )
					{
						$strName = $this->x_GetToken( $token );
						if ( $strName == "?" )
							$nTagFlag = 1; // version
						else if ( $strName == "!" )
							$nTagFlag = 2; // in comment
					}
				}
			}
	
			// Exit the loop only if it appears to be a normal tag
			if ( $nTagFlag == 0 )
				break;
	
			// Ignore tag
			$this->m_aPos[$iPos]['nStartL'] = $token['nL'];
			$this->m_aPos[$iPos]['nNext'] = $token['nL'] + 1;
		}
	
		// Was a right angle bracket found?
		if ( !($token['nL'] <= $token['nR']) )
			return $this->x_ReleasePos();
		$this->m_aPos[$iPos]['nStartR'] = $token['nL'];
	
		// Is ending mark within opening tag, i.e. empty element?
		if ( $bEndMark )
		{
			// Empty element
			// Close tag left is set to ending mark, and right to open tag right
			$this->m_aPos[$iPos]['nEndL'] = $this->m_aPos[$iPos]['nStartR']-1;
			$this->m_aPos[$iPos]['nEndR'] = $this->m_aPos[$iPos]['nStartR'];
		}
		else // look for end tag
		{
			// Element probably has contents
			// Determine where to start looking for left angle bracket of end tag
			// This is done by recursively parsing the contents of this element
			$iInnerPrev = 0;
			$this->m_aPos[$iPos]['nEndL'] = $this->m_aPos[$iPos]['nStartR'] + 1;
			while ( ($iInner = $this->x_ParseElem($iPos)) != 0 )
			{
				// Set links to iInner
				if ( $iInnerPrev )
					$this->m_aPos[$iInnerPrev]['iElemNext'] = $iInner;
				else
					$this->m_aPos[$iPos]['iElemChild'] = $iInner;
				$iInnerPrev = $iInner;
	
				// Set offset to reflect child
				$this->m_aPos[$iPos]['nEndL'] = $this->m_aPos[$iInner]['nEndR'] + 1;
			}
	
			// Look for left angle bracket of end tag
			if ( !$this->x_FindChar( $this->m_aPos[$iPos]['nEndL'], '<' ) )
				return $this->x_ReleasePos();
	
			// Look through tokens of end tag
			$token['nNext'] = $this->m_aPos[$iPos]['nEndL'] + 1;
			$nTokenCount = 0;
			while ( $this->x_FindToken( $token ) )
			{
				++$nTokenCount;

				if ( !$token['bIsString'] )
				{
					// Is first token not an end slash mark?
					if ( $nTokenCount == 1 && $this->m_strDoc[$token['nL']] != '/' )
						return $this->x_ReleasePos(); // expected end mark
	
					else if ( $nTokenCount == 2 && $strName != $this->x_GetToken( $token ) )
						return $this->x_ReleasePos(); // name does not correspond
	
					// Else is it a right angle bracket?
					else if ( $this->m_strDoc[$token['nL']] == '>' )
						break;
				}
			}
	
			// Was a right angle bracket not found?
			if ( !($token['nL'] <= $token['nR']) || $nTokenCount < 2 )
				return $this->x_ReleasePos();
			$this->m_aPos[$iPos]['nEndR'] = $token['nL'];
		}
	
		// Successfully found positions of angle brackets
		$this->m_aPos[$iPos]['nNext'] = $this->m_aPos[$iPos]['nEndR'];
		$this->x_FindChar( $this->m_aPos[$iPos]['nNext'], '<' );
		
		return $iPos;
	}
	
	function x_FindChar( &$n, $c )
	{
		// Look for char c starting at n, and set n to point to it
		// Return false if not found before end of document
		$nMax = strlen($this->m_strDoc);
		
		while ( $n < $nMax && $this->m_strDoc[$n] != $c )
			++$n;
		if ( $n == $nMax )
			return false;
			
		return true;
	}

	function x_FindToken( &$token )
	{
		// Starting at token.nNext, find the next token
		// upon successful return, token.nNext points after the retrieved token
		$nMax = strlen($this->m_strDoc);
		$n = $token['nNext'];
	
		// Statically defined strings for whitespace and special chars
		static $strWhitespace = " \t\n\r";
		static $strSpecial = "<>=\\/?!";
	
		// By-pass leading whitespace
		while ( $n < $nMax && strpos($strWhitespace, $this->m_strDoc[$n]) !== false )
			++$n;
	
		// Are we still within the document?
		$token['bIsString'] = false;
		if ( $n < $nMax )
		{
			// Is it an opening quote?
			if ( $this->m_strDoc[$n] == '\"' )
			{
				// Move past opening quote
				++$n;
				$token['nL'] = $n;
	
				// Look for closing quote
				$this->x_FindChar( $n, '\"' );
	
				// Set right to before closing quote
				$token['nR'] = $n-1;
	
				// Set n past closing quote unless at end of document
				if ( $n < $nMax )
					++$n;
	
				// Set flag
				$token['bIsString'] = true;
			}
			else
			{
				// Go until special char or whitespace
				$token['nL'] = $n;
				while ( $n < $nMax 
					&& (strpos($strSpecial, $this->m_strDoc[$n]) === false)
					&& (strpos($strWhitespace, $this->m_strDoc[$n]) === false) )
					++$n;
	
				// Adjust end position if it is one special char
				if ( $n == $token['nL'] )
					++$n; // it is a special char
				$token['nR'] = $n-1;
			}
		}
	
		$token['nNext'] = $n;
		if ( $n >= $nMax )
			return false;
	
		// nEnd points to one past last char of token
		return true;
	}
	
	function x_GetToken( &$token )
	{
		// The token contains indexes into the document identifying a small substring
		// Build the substring from those indexes and return it
		if ( !($token['nL'] <= $token['nR']) )
			return "";
		return substr($this->m_strDoc, $token['nL'],
			$token['nR'] - $token['nL'] + (($token['nR'] < strlen($this->m_strDoc)) ? 1 : 0) );
	}
	
	function x_GetTagName( $iPos )
	{
		$token['nL'] = 0;
		$token['nR'] = -1;
		$token['bIsString'] = false;
		
		$token['nNext'] = $this->m_aPos[$iPos]['nStartL'] + 1;
		if ( !$iPos || !$this->x_FindToken( $token ) )
			return "";
	
		// Return substring of document
		return $this->x_GetToken( $token );
	}

	function x_SetData( $iPos, $szData )
	{
		// Set data in iPos element
		$ep = $this->m_aPos[$iPos];
		if ( !$iPos || $ep['iElemChild'] )
			return false;
			
		$strInsert = $this->x_TextToDoc( $szData );
	
		// Decide where to insert
		if ( $ep['nStartR'] == $ep['nEndL'] + 1 )
		{
			$nL = $ep['nEndL'];
			$nReplace = 1;
	
			// Pre-adjust since <NAME/> becomes <NAME>data</NAME>
			$strTagName = $this->x_GetTagName( $iPos );
			$ep['nStartR'] -= 1;
			$ep['nEndL'] -= (1 + strlen($strTagName));

			$strFormat = ">";
			$strFormat .= $strInsert;
			$strFormat .= "</";
			$strFormat .= $strTagName;
			$strInsert = $strFormat;
		}
		else
		{
			$nL = $ep['nStartR']+1;
			$nReplace = $ep['nEndL'] - $ep['nStartR'] - 1;
		}
		
		$this->x_DocChange( $nL, $nReplace, $strInsert );
		$nAdjust = strlen($strInsert) - $nReplace;
		$this->x_Adjust( $iPos, $nAdjust );
		
		$ep['nEndL'] += $nAdjust;
		$ep['nEndR'] += $nAdjust;
		$ep['nNext'] += $nAdjust;
		
		return true;
	}
	
	function x_GetData( $iPos )
	{
		// Return a string representing data between start and end tag
		// Return empty string if there are any children elements
		if ( !$this->m_aPos[$iPos]['iElemChild'] 
			&& !($this->m_aPos[$iPos]['nStartR'] == $this->m_aPos[$iPos]['nEndL'] + 1) )
			return $this->x_TextFromDoc( $this->m_aPos[$iPos]['nStartR']+1, $this->m_aPos[$iPos]['nEndL']-1 );
		
		return "";
	}

	function x_GetAttrib( $iPos, $szAttrib )
	{
		// Return the value of the attrib at specified element
		$token['nL'] = 0;
		$token['nR'] = -1;
		$token['bIsString'] = false;

		$token['nNext'] = $this->m_aPos[$iPos]['nStartL'] + 1;
		if ( $szAttrib && $this->x_FindAttrib( $token, $szAttrib ) )
			return $this->x_TextFromDoc( $token['nL'], $token['nR'] - (($token['nR'] < strlen($this->m_strDoc)) ? 0 : 1) );
		return "";
	}
	
	function x_Add( $iPosParent, $iPosBefore, $szName, $szValue )
	{
		// Create element and modify positions of affected elements
		// if iPosBefore is NULL, insert as first element under parent
		// If no szValue is specified, an empty element is created
		// i.e. either <NAME>value</NAME> or <NAME/>
		//
		$iPos = $this->x_GetFreePos();
		$bEmptyParent = false;
		if ( $iPosBefore )
		{
			// Follow iPosBefore
			$this->m_aPos[$iPos]['nStartL'] = $this->m_aPos[$iPosBefore]['nNext'];
		}
		else if ( $this->m_aPos[$iPosParent]['iElemChild'] )
		{
			// Insert before first child of parent
			$this->m_aPos[$iPos]['nStartL'] = $this->m_aPos[$this->m_aPos[$iPosParent]['iElemChild']]['nStartL'];
		}
		else if ( $this->m_aPos[$iPosParent]['nStartR'] == $this->m_aPos[$iPosParent]['nEndL'] + 1 )
		{
			// Parent has no separate end tag
			$this->m_aPos[$iPos]['nStartL'] = $this->m_aPos[$iPosParent]['nStartR'] + 2;
			$bEmptyParent = true;
		}
		else
		{
			// Parent has content, but no children
			$this->m_aPos[$iPos]['nStartL'] = $this->m_aPos[$iPosParent]['nEndL'];
		}
	
		// Set links
		$this->m_aPos[$iPos]['iElemParent'] = $iPosParent;
		$this->m_aPos[$iPos]['iElemChild'] = 0;
		if ( $iPosBefore )
		{
			$this->m_aPos[$iPos]['iElemNext'] = $this->m_aPos[$iPosBefore]['iElemNext'];
			$this->m_aPos[$iPosBefore]['iElemNext'] = $iPos;
		}
		else
		{
			$this->m_aPos[$iPos]['iElemNext'] = $this->m_aPos[$iPosParent]['iElemChild'];
			$this->m_aPos[$iPosParent]['iElemChild'] = $iPos;
		}
	
		// Create string for insert
		$strInsert = "";
		$nLenName = strlen($szName);
		$nLenValue = $szValue ? strlen($szValue) : 0;

		if ( !$nLenValue )
		{
			// <NAME/> empty element
			$strInsert = "<";
			$strInsert .= $szName;
			$strInsert .= "/>\r\n";
			
			$this->m_aPos[$iPos]['nStartR'] = $this->m_aPos[$iPos]['nStartL'] + $nLenName + 2;
			$this->m_aPos[$iPos]['nEndL'] = $this->m_aPos[$iPos]['nStartR'] - 1;
			$this->m_aPos[$iPos]['nEndR'] = $this->m_aPos[$iPos]['nEndL'] + 1;
			$this->m_aPos[$iPos]['nNext'] = $this->m_aPos[$iPos]['nEndR'] + 3;
		}
		else
		{
			// <NAME>value</NAME>
			$strValue = $this->x_TextToDoc( $szValue );
			$nLenValue = strlen($strValue);
			
			$strInsert = "<";
			$strInsert .= $szName;
			$strInsert .= ">";
			$strInsert .= $strValue;
			$strInsert .= "</";
			$strInsert .= $szName;
			$strInsert .= ">\r\n";
			
			$this->m_aPos[$iPos]['nStartR'] = $this->m_aPos[$iPos]['nStartL'] + $nLenName + 1;
			$this->m_aPos[$iPos]['nEndL'] = $this->m_aPos[$iPos]['nStartR'] + $nLenValue + 1;
			$this->m_aPos[$iPos]['nEndR'] = $this->m_aPos[$iPos]['nEndL'] + $nLenName + 2;
			$this->m_aPos[$iPos]['nNext'] = $this->m_aPos[$iPos]['nEndR'] + 3;
		}
	
		// Insert
		$nReplace = 0;
		$nLeft = $this->m_aPos[$iPos]['nStartL'];
		
		if ( $bEmptyParent )
		{
			$strParentTagName = $this->x_GetTagName($iPosParent);

			$strFormat = ">\r\n";
			$strFormat .= $strInsert;
			$strFormat .= "</";
			$strFormat .= $strParentTagName;
			$strInsert = $strFormat;
			
			$nLeft -= 3;
			$nReplace = 1;
			// x_Adjust is going to update all affected indexes by one amount
			// This will satisfy all except the empty parent
			// Here we pre-adjust for the empty parent
			// The empty tag slash is removed
			$this->m_aPos[$iPosParent]['nStartR'] -= 1;
			// For the newly created end tag, see the following example:
			// <A/> (len 4) becomes <A><B/></A> (len 11)
			// In x_Adjust everything will be adjusted 11 - 4 = 7
			// But the nEndL of element A should only be adjusted 5
			$this->m_aPos[$iPosParent]['nEndL'] -= (strlen($strParentTagName) + 1);
		}
		
		$this->x_DocChange( $nLeft, $nReplace, $strInsert );
		$this->x_Adjust( $iPos, strlen($strInsert) - $nReplace );
	
		// Return the index of the new element
		return $iPos;
	}
	
	function x_AddSubDoc( $iPosParent, $iPosBefore, $szSubDoc )
	{
		// Add subdocument, parse, and modify positions of affected elements
		// if iPosBefore is NULL, insert as first element under parent
		//
		$nParentEndLBeforeAdd = $this->m_aPos[$iPosParent]['nEndL'];
		$iPosFreeBeforeAdd = $this->m_iPosFree;

		// Subdocument may start with a version tag i.e.  < ? xml version="1.0" ? >
		// To skip version tag of subdocument, use #defined parse routine
		// SUBDOCFIND looks for a char in the subdocument, returns 0 (fail) if not found
		$szSD = $szSubDoc;
		
		$iFlagPos = strpos($szSD, '<');
		if ($iFlagPos === false && $iFlagPos != 0)
			return 0;

		$iFlagPos++;	
		if ( $szSD[$iFlagPos] == '?' )
		{
			$iFlagPos = strpos($szSD, '>', ++$iFlagPos);

			if ($iFlagPos === false)
				return 0;
				
			if ( $szSD[$iFlagPos-1] == '?' )
			{
				$iFlagPos = strpos($szSD, '<', $iFlagPos+1);

				if ($iFlagPos === false)
					return 0;
				
				$szSD = substr($szSubDoc, $iFlagPos);
			}
			else
				$szSD = $szSubDoc;
		}
		$strInsert = $szSD;

		// Determine where to insert
		$bEmptyParent = false;
		if ( $iPosBefore )
		{
			// Follow iPosBefore
			$this->m_aPos[$iPosParent]['nEndL'] = $this->m_aPos[$iPosBefore]['nNext'];
		}
		else if ( $this->m_aPos[$iPosParent]['iElemChild'] )
		{
			// Insert before first child of parent
			$this->m_aPos[$iPosParent]['nEndL'] = $this->m_aPos[$this->m_aPos[$iPosParent]['iElemChild']]['nStartL'];
		}
		else if ( $this->m_aPos[$iPosParent]['nStartR'] == $this->m_aPos[$iPosParent]['nEndL'] + 1)
		{
			// Parent has no separate end tag
			$bEmptyParent = true;
		}
	
		// Insert subdocument
		$nReplace = 0;
		$nLeft = $this->m_aPos[$iPosParent]['nEndL'];
		$strParentTagName = "";
		if ( $bEmptyParent )
		{
			$strParentTagName = $this->x_GetTagName($iPosParent);

			$strFormat = ">\r\n";
			$strFormat .= $strInsert;
			$strFormat .= "</";
			$strFormat .= $strParentTagName;
			$strInsert = $strFormat;
			$this->m_aPos[$iPosParent]['nEndL'] = $this->m_aPos[$iPosParent]['nStartR'] + 2;
			$nLeft = $this->m_aPos[$iPosParent]['nStartR'] - 1;
			$nReplace = 1;
		}
		$this->x_DocChange( $nLeft, $nReplace, $strInsert );
	
		// Parse subdocument
		$iPos = $this->x_ParseElem($iPosParent);
		$this->m_aPos[$iPosParent]['nEndL'] = $nParentEndLBeforeAdd;
		if ( !$iPos )
		{
			// Abort because not well-formed
			$strRevert = $bEmptyParent ? "/" : "";
			$this->x_DocChange( $nLeft, strlen($strInsert), $strRevert );
			$this->m_iPosFree = $iPosFreeBeforeAdd;
		}
		else
		{
			// Link in parent and siblings
			$this->m_aPos[$iPos]['iElemParent'] = $iPosParent;
			if ( $iPosBefore )
			{
				$this->m_aPos[$iPos]['iElemNext'] = $this->m_aPos[$iPosBefore]['iElemNext'];
				$this->m_aPos[$iPosBefore]['iElemNext'] = $iPos;
			}
			else
			{
				$this->m_aPos[$iPos]['iElemNext'] = $this->m_aPos[$iPosParent]['iElemChild'];
				$this->m_aPos[$iPosParent]['iElemChild'] = $iPos;
			}
	
			// Make empty parent pre-adjustment
			if ( $bEmptyParent )
			{
				$this->m_aPos[$iPosParent]['nStartR'] -= 1;
				$this->m_aPos[$iPosParent]['nEndL'] -= (strlen($strParentTagName) + 1);
			}
	
			// Adjust, but don't adjust children of iPos
			$iElemChild = $this->m_aPos[$iPos]['iElemChild'];
			$this->m_aPos[$iPos]['iElemChild'] = 0;
			$this->x_Adjust( $iPos, strlen($strInsert) - $nReplace );
			$this->m_aPos[$iPos]['iElemChild'] = $iElemChild;
		}
	
		// Return the index of the new element
		return $iPos;
	}
	
	function x_FindAttrib( &$token, $szAttrib = NULL )
	{
		// If szAttrib is NULL find next attrib, otherwise find named attrib
		// Return true if found
		$nAttrib = 0;
		for ( $nCount = 0; $this->x_FindToken($token); ++$nCount )
		{
			if ( !$token['bIsString'] )
			{
				// Is it the right angle bracket?
				if ( $this->m_strDoc[$token['nL']] == '>' )
					break; // attrib not found
	
				// Equal sign
				if ( $this->m_strDoc[$token['nL']] == '=' )
					continue;
	
				// Potential attribute
				if ( !$nAttrib && $nCount )
				{
					// Attribute name search?
					if ( $szAttrib == NULL || !$szAttrib[0] )
						return true; // return with token at attrib name
	
					if ( $this->x_GetToken( $token ) == $szAttrib )
						$nAttrib = $nCount;
				}
			}
			else if ( $nAttrib && $nCount == $nAttrib + 2 )
			{
				return true;
			}
		}
	
		// Not found
		return false;
	}

	function x_AddAttrib( $iPos, $szAttrib, $szValue )
	{
		// Add attribute to iPos element
		$strInsert = "";
		if ( $iPos )
		{
			// Insert string taking into account whether it is a single tag
			$strValue = $this->x_TextToDoc( $szValue, true );
			$strInsert = " ";
			$strInsert .= $szAttrib;
			$strInsert .= "=\"";
			$strInsert .= $strValue;
			$strInsert .= "\"";
			
			$nL = $this->m_aPos[$iPos]['nStartR'] - (($this->m_aPos[$iPos]['nStartR'] == $this->m_aPos[$iPos]['nEndL'] + 1) ? 1 : 0);
			$this->x_DocChange( $nL, 0, $strInsert );
	
			$nLen = strlen($strInsert);
			$this->m_aPos[$iPos]['nStartR'] += $nLen;
			$this->m_aPos[$iPos]['nEndL'] += $nLen;
			$this->m_aPos[$iPos]['nEndR'] += $nLen;
			$this->m_aPos[$iPos]['nNext'] += $nLen;
			$this->x_Adjust( $iPos, $nLen );
		}
		
		return strlen($strInsert);
	}
	
	function x_SetAttrib( $iPos, $szAttrib, $szValue )
	{
		$strInsert = "";
		if ( $iPos )
		{
			$token['nL'] = 0;
			$token['nR'] = -1;
			$token['bIsString'] = false;
			
			$token['nNext'] = $this->m_aPos[$iPos]['nStartL'] + 1;
			$nReplace = 0;
			if ( $this->x_FindAttrib( $token, $szAttrib ) )
			{
				// Decision: for empty value leaving attrib="" instead of removing attrib
				// Replace value only
				$strInsert = $this->x_TextToDoc( $szValue, true );
				$nL = $token['nL'];
				$nReplace = $token['nR']-$token['nL']+1;
			}
			else
			{
				// Insert string name value pair
				$strValue = $this->x_TextToDoc( $szValue, true );
				
				$strInsert = " ";
				$strInsert .= $szAttrib;
				$strInsert .= "=\"";
				$strInsert .= $strValue;
				$strInsert .= "\"";
				// take into account whether it is an empty element
				$nL = $this->m_aPos[$iPos]['nStartR'] - (($this->m_aPos[$iPos]['nStartR'] == $this->m_aPos[$iPos]['nEndL'] + 1) ? 1 : 0);
			}
	
			$this->x_DocChange( $nL, $nReplace, $strInsert );
			$nAdjust = strlen($strInsert) - $nReplace;
			$this->m_aPos[$iPos]['nStartR'] += $nAdjust;
			$this->m_aPos[$iPos]['nEndL'] += $nAdjust;
			$this->m_aPos[$iPos]['nEndR'] += $nAdjust;
			$this->m_aPos[$iPos]['nNext'] += $nAdjust;
			$this->x_Adjust( $iPos, $nAdjust );
		}
		
		return strlen($strInsert);
	}

	function x_Remove( $iPos )
	{
		// Remove element and all contained elements
		// Return new position
		//
		$iPosParent = $this->m_aPos[$iPos]['iElemParent'];
	
		// Find previous sibling and bypass removed element
		// This leaves orphan positions in m_aPos array
		$iPosLook = $this->m_aPos[$iPosParent]['iElemChild'];
		$iPosPrev = 0;
		while ( $iPosLook != $iPos )
		{
			$iPosPrev = $iPosLook;
			$iPosLook = $this->m_aPos[$iPosLook]['iElemNext'];
		}
		
		if ( $iPosPrev )
			$this->m_aPos[$iPosPrev]['iElemNext'] = $this->m_aPos[$iPos]['iElemNext'];
		else
			$this->m_aPos[$iPosParent]['iElemChild'] = $this->m_aPos[$iPos]['iElemNext'];
	
		// Remove from document
		// Links have been changed to go around removed element
		// But element position and links are still valid
		$nLen = $this->m_aPos[$iPos]['nNext'] - $this->m_aPos[$iPos]['nStartL'];
		$strTempElem = "";
		$this->x_DocChange( $this->m_aPos[$iPos]['nStartL'], $nLen, $strTempElem );
		$this->x_Adjust( $iPos, 0 - $nLen );
		
		return $iPosPrev;
	}
	
	function x_DocChange( $nLeft, $nReplace, &$strInsert )
	{
		$strDoc = substr($this->m_strDoc, 0, $nLeft);
		$strDoc .= $strInsert;
		$strDoc .= substr($this->m_strDoc, $nLeft+$nReplace);
		
		$this->m_strDoc = $strDoc;
	}
	
	function x_Adjust( $iPos, $nShift )
	{
		// Loop through affected elements and adjust indexes
		// Does not affect iPos itself
		// Algorithm:
		// 1. update next siblings and all their children
		// 2. then go up a level update end points and to step 1
		$iPosTop = $this->m_aPos[$iPos]['iElemParent'];
		while ( $iPos )
		{
			// Were we at containing parent of affected position?
			$bPosTop = false;
			if ( $iPos == $iPosTop )
			{
				// Move iPosTop up one towards root
				$iPosTop = $this->m_aPos[$iPos]['iElemParent'];
				$bPosTop = true;
			}
	
			// Traverse to the next update position
			if ( !$bPosTop && $this->m_aPos[$iPos]['iElemChild'] )
			{
				// Depth first
				$iPos = $this->m_aPos[$iPos]['iElemChild'];
			}
			else if ( $this->m_aPos[$iPos]['iElemNext'] )
			{
				$iPos = $this->m_aPos[$iPos]['iElemNext'];
			}
			else
			{
				// Look for next sibling of a parent of iPos
				// When going back up, parents have already been done except iPosTop
				while ( ($iPos = $this->m_aPos[$iPos]['iElemParent']) != 0 
					&& $iPos != $iPosTop )
					if ( $this->m_aPos[$iPos]['iElemNext'] )
					{
						$iPos = $this->m_aPos[$iPos]['iElemNext'];
						break;
					}
			}
	
			// Shift indexes at iPos
			if ( $iPos != $iPosTop )
			{
				// Move the start tag indexes
				// Don't do this for containing parent tag
				$this->m_aPos[$iPos]['nStartL'] += $nShift;
				$this->m_aPos[$iPos]['nStartR'] += $nShift;
			}
			// Move end tag indexes
			$this->m_aPos[$iPos]['nEndL'] += $nShift;
			$this->m_aPos[$iPos]['nEndR'] += $nShift;
			$this->m_aPos[$iPos]['nNext'] += $nShift;
		}
	}
	
	function x_TextToDoc( $szText, $bAttrib = false )
	{
	    $strResult = $szText;
	    $strResult = str_replace("&","&amp;",$strResult);
	    $strResult = str_replace("<","&lt;",$strResult);
	    $strResult = str_replace(">","&gt;",$strResult);
	    if ($bAttrib)
	    {
		    $strResult = str_replace("'","&apos;",$strResult);
		    $strResult = str_replace("\"","&quot;",$strResult);
	    }
	    
	    return $strResult;
	}

	function x_TextFromDoc( $nLeft, $nRight )
	{
	    $strResult = substr($this->m_strDoc, $nLeft, $nRight-$nLeft+1);
	    
	    $strResult = str_replace("&quot;","\"",$strResult);
	    $strResult = str_replace("&apos;","'",$strResult);
	    $strResult = str_replace("&gt;",">",$strResult);
	    $strResult = str_replace("&lt;","<",$strResult);
	    $strResult = str_replace("&amp;","&",$strResult);
	    
	    return $strResult;
	}

};

?>
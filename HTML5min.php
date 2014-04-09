<?

/*
	HTML5min
	HTML5 minifier as PHP class allowing for DOM modifications, like filtering or replacing content before minimize.
	
	Author:		Benio	//benio.me
	License:	CC BY 4	//creativecommons.org/licenses/by/4.0
	
	Project home:	//github.com/Benio101/HTML5min
	File spacing:	8
*/
class HTML5min{
	// string	input string (HTML5 input code)
	public $input;
	
	// array	array form of HTML5 code
	public $array;
	
	// string	string form if HTML5 code (minified input)
	public $string;
	
	// bool		treat input as HTML document (true) or an HTML fragment (false)
	public $document = true;
	
	/*
		array of tag markups
		tag markup is required to determine its syntax
		
		e	escapable raw text elements
		f	foreign elements
		n	normal elements
		r	raw text elements
		v	void elements
	*/
	private $tags_markup = array(
		'a'		=>	'n',
		'abbr'		=>	'n',
		'address'	=>	'n',
		'area'		=>	'v',
		'article'	=>	'n',
		'aside'		=>	'n',
		'audio'		=>	'n',
		'b'		=>	'n',
		'base'		=>	'v',
		'bdi'		=>	'n',
		'bdo'		=>	'n',
		'blockquote'	=>	'n',
		'body'		=>	'n',
		'br'		=>	'v',
		'button'	=>	'n',
		'canvas'	=>	'n',
		'caption'	=>	'n',
		'cite'		=>	'n',
		'code'		=>	'n',
		'col'		=>	'v',
		'colgroup'	=>	'n',
		'data'		=>	'n',
		'datalist'	=>	'n',
		'dd'		=>	'n',
		'del'		=>	'n',
		'details'	=>	'n',
		'dfn'		=>	'n',
		'dialog'	=>	'n',
		'div'		=>	'n',
		'dl'		=>	'n',
		'dt'		=>	'n',
		'em'		=>	'n',
		'embed'		=>	'v',
		'fieldset'	=>	'n',
		'figcaption'	=>	'n',
		'figure'	=>	'n',
		'footer'	=>	'n',
		'form'		=>	'n',
		'h1'		=>	'n',
		'h2'		=>	'n',
		'h3'		=>	'n',
		'h4'		=>	'n',
		'h5'		=>	'n',
		'h6'		=>	'n',
		'head'		=>	'n',
		'header'	=>	'n',
		'hr'		=>	'v',
		'html'		=>	'n',
		'i'		=>	'n',
		'iframe'	=>	'n',
		'img'		=>	'v',
		'input'		=>	'v',
		'ins'		=>	'n',
		'kbd'		=>	'n',
		'keygen'	=>	'v',
		'label'		=>	'n',
		'legend'	=>	'n',
		'li'		=>	'n',
		'link'		=>	'v',
		'main'		=>	'n',
		'map'		=>	'n',
		'mark'		=>	'n',
		'math'		=>	'f',
		'menu'		=>	'n',
		'menuitem'	=>	'v',
		'meta'		=>	'v',
		'meter'		=>	'n',
		'nav'		=>	'n',
		'noscript'	=>	'n',
		'object'	=>	'n',
		'ol'		=>	'n',
		'optgroup'	=>	'n',
		'option'	=>	'n',
		'output'	=>	'n',
		'p'		=>	'n',
		'param'		=>	'v',
		'pre'		=>	'n',
		'progress'	=>	'n',
		'q'		=>	'n',
		'rb'		=>	'n',
		'rp'		=>	'n',
		'rt'		=>	'n',
		'rtc'		=>	'n',
		'ruby'		=>	'n',
		's'		=>	'n',
		'samp'		=>	'n',
		'script'	=>	'r',
		'section'	=>	'n',
		'select'	=>	'n',
		'small'		=>	'n',
		'source'	=>	'v',
		'span'		=>	'n',
		'strong'	=>	'n',
		'style'		=>	'r',
		'sub'		=>	'n',
		'summary'	=>	'n',
		'sup'		=>	'n',
		'svg'		=>	'f',
		'table'		=>	'n',
		'tbody'		=>	'n',
		'td'		=>	'n',
		'template'	=>	'n',
		'text'		=>	'v',	// 'text' is no html5 tag, but represents text node
		'textarea'	=>	'e',
		'tfoot'		=>	'n',
		'th'		=>	'n',
		'thead'		=>	'n',
		'time'		=>	'n',
		'title'		=>	'e',
		'tr'		=>	'n',
		'track'		=>	'v',
		'u'		=>	'n',
		'ul'		=>	'n',
		'var'		=>	'n',
		'video'		=>	'n',
		'wbr'		=>	'v',
	);
	
	/*
		array of palpable content tags
		used to get rid of spaces around nonpalpable elements
	*/
	private $tags_palpable = array(
		'a',
		'abbr',
		'address',
		'article',
		'aside',
		'b',
		'bdi',
		'bdo',
		'blockquote',
		'button',
		'canvas',
		'cite',
		'code',
		'details',
		'dfn',
		'div',
		'em',
		'embed',
		'fieldset',
		'figure',
		'footer',
		'form',
		'h1',
		'h2',
		'h3',
		'h4',
		'h5',
		'h6',
		'header',
		'hgroup',
		'i',
		'iframe',
		'img',
		'ins',
		'kbd',
		'keygen',
		'label',
		'map',
		'mark',
		'math',
		'meter',
		'nav',
		'object',
		'output',
		'p',
		'pre',
		'progress',
		'q',
		'ruby',
		's',
		'samp',
		'section',
		'select',
		'small',
		'span',
		'strong',
		'sub',
		'sup',
		'svg',
		'table',
		'textarea',
		'time',
		'u',
		'var',
		'video',
	);
	
	
	/*
		array of metadata content tags
		used to parse ommited tags well
	*/
	private $tags_metadata = array(
		'base',
		'link',
		'meta',
		'noscript',
		'script',
		'style',
		'template',
		'title',
	);
	
	// set the input (unminified HTML5 code) to minify
	public function set(/* string */ $i){
		$this -> input = (string)$i;
	}
	
	// -> output() is an alternative for -> string
	public function output(/* void */){
		return $this -> string;
	}
	
	/* adds more code to input, like:
		$HTML5_minifier = new HTML5min();
		$HTML5_minifier -> set($header_code);
		$HTML5_minifier -> add($body_code);
		$HTML5_minifier -> add($footer_code);
		$HTML5_minifier -> parse();
		$HTML5_minifier -> minify();
		$HTML5_minified = $HTML5_minifier -> string;
	*/
	public function add(/* string */ $i){
		$this -> input .= (string)$i;
	}
	
	// parses HTML5 string into array form
	public function parse(){
		$i = $this -> input;		// string	input buffer
		$o = array();			// array	output array
		$n = -1;			// int		number of element (every element of o (independing on level has its own id ($n) beginning from n)
		$t = 0;				// int		the indent level (should begin from 0, grow while going inside elements and decrease at closing tag, finally end with a 0 value)
		$p = &$o;			// pointer	pointer of an o (used to insert new elements (at every n increase) in right indentation place of o array)
		$l = array(0);			// stack	stack of pointers to subsequent elements (count(l) = n) and should be empty on end of parse
		$lastClosed = '';		// string	last closed tag name (used to determine if remove space after palpable content tag or not
		$parentID = array(0);		// array	array of int, upcomming parent id (used to determine parent id on next element adding as child of current)
		$tags_open = array();		// array	array of states of tag open, true - tag is open, false - tag is closed, null - tag wasnt found yet
		
		if($this -> document){
			// skip BOM if presents (yeah, we take care of this too)
			if(substr($i, 0, 2) === chr(0xFE) . chr(0xFF)){
				// BOM
				$p[++$n] = array('name' => 'BOM');
				
				$i = substr($i, 2);
			}
			
			// doctype
			$i = substr($i, stripos($i, '<!doctype'));
			$i = substr($i, strpos($i, '>') + 1);
			$lastClosed = 'DOCTYPE';
			$p[++$n] = array('name' => 'DOCTYPE');
		}
		
		// well, that was only a warm-up, keep going
		// hey, @HTML fragment, you are late for warm-up!
		
		/*
			>>>	DESCRIPTION
			
			We`re going about cut $i (our INPUT string with HTML code)
			and every cut, we will eighter:
			
					add the tag at current tabulation level
				OR	increase tabulation level, then add SUB–tag
				OR	decrease tabulation level, then add tag to parent
				OR	just eat fragment (like comment)
			
			and always
				eat the parsed characters (we are hungry of success!)
			
			Finally, we should end when no more $i (input) to eat (it means, $i is empty)
			It means, all HTML string input is parsed into the array as described above.
		*/
		
		while(strlen($i)){
			// text
			$pos = strpos($i, '<');
			$txt = substr($i, 0, $pos);
			
			if(in_array(strtolower($lastClosed), $this -> tags_palpable)){
				$txt = preg_replace('@^[\x9\xA\xC\xD\x20]+@isuDX', ' ', $txt);
			} else {
				// get rid of spaces around nonpalpable elements
				$txt = preg_replace('@^[\x9\xA\xC\xD\x20]+@isuDX', '', $txt);
			}
			
			$txt = preg_replace('@[\x9\xA\xC\xD\x20]+$@isuDX', ' ', $txt);
			$i = substr($i, $pos);
			if($pos > 0){
				if($txt != ''){
					$lastClosed = 'TEXT';
					$p[++$n] = array(
						'name' => 'TEXT',
						'content' => $txt,
						'parent' => $parentID[$t],
					);
				}
			}
			
			// comment
			if(substr($i, 0, 4) === '<!--'){
				$i = substr($i, 4);
				$i = substr($i, strpos($i, '-->') + 3);
				continue;
			}
			
			// <
			$i = substr($i, 1);
			
			// skip space characters
			$i = preg_replace('@^[\x9\xA\xC\xD\x20]+@isuDX', '', $i);
			
			if(preg_match('@^(?<tag>[a-z0-9]+)@isuDX', $i, $m)){
				$tag = strtolower($m['tag']);		// tag name of tag we are parsing (like aside)
				
				// get rid of spaces around nonpalpable elements
				if(!in_array($tag, $this -> tags_palpable) && $p[$n]['name'] === 'TEXT'){
					$p[$n]['content'] = preg_replace('@[\x9\xA\xC\xD\x20]+$@isuDX', '', $p[$n]['content']);
					if($p[$n]['content'] === ''){
						unset($p[$n--]);
					}
				}
				
				// add html element if ommited
				if($tags_open['html'] === null && $tag != 'html'){
					$l[++$t] = &$p;
					$parentID[$t] = $n + 1;
					$p[++$n] = array(
						'name' => 'html',
						'attributes' => array(),
						'parent' => $parentID[$t - 1],
					);
					$p = &$p[$n]['content'];
					$tags_open['html'] = true;
				}
				
				// add head element if ommited
				if($tags_open['head'] === null && $tag !== 'html' && $tag !== 'head'){
					$l[++$t] = &$p;
					$parentID[$t] = $n + 1;
					$p[++$n] = array(
						'name' => 'head',
						'attributes' => array(),
						'parent' => $parentID[$t - 1],
					);
					$p = &$p[$n]['content'];
					$tags_open['head'] = true;
				}
				
				// close head element if ommited
				if($tags_open['head'] && !in_array($tag, $this -> tags_metadata) && $tag !== 'html' && $tag !== 'head'){
					$p = &$l[$t--];
					$tags_open['head'] = false;
					$lastClosed = 'head';
					array_pop($parentID);
				}
				
				// add body element if ommited
				if($tags_open['body'] === null && !in_array($tag, $this -> tags_metadata) && $tag !== 'html' && $tag !== 'head' && $tag !== 'body'){
					$l[++$t] = &$p;
					$parentID[$t] = $n + 1;
					$p[++$n] = array(
						'name' => 'body',
						'attributes' => array(),
						'parent' => $parentID[$t - 1],
					);
					$p = &$p[$n]['content'];
					$tags_open['body'] = true;
				}
				
				// open tag
				$tags_open[$tag] = true;
				
				$attrsArr = array();		// array of tag attributes (name => value)
				$i = substr($i, strlen($tag));
				
				while(strlen($i)){
					// >
					if(preg_match('@^(?<ending>/?>)@isuDX', $i, $m)){
						$i = substr($i, strlen($m['ending']));
						$tags_open[$tag] = true;
						
						break;
					}
					
					// skip space characters
					$i = preg_replace('@^[\x9\xA\xC\xD\x20]+@isuDX', '', $i);
					
					// =
					$equal_pos = strpos($i, '=');
					$brack_pos = strpos($i, '>');
					$pos = min($equal_pos, $brack_pos);
					
					$name = substr($i, 0, $pos);	// attribute name (like class)
					$i = substr($i, $pos);
					
					// skip space characters
					$i = preg_replace('@^[\x9\xA\xC\xD\x20]+@isuDX', '', $i);
					$name = preg_replace('@^[\x9\xA\xC\xD\x20]+@isuDX', '', $name);
					$name = preg_replace('@[\x9\xA\xC\xD\x20]+$@isuDX', '', $name);
					
					$value = null;			// value of attribute
					
					if($name != ''){
						// =
						if($i[0] == '='){
							$i = substr($i, 1);
							
							$i = preg_replace('@^[\x9\xA\xC\xD\x20]+@isuDX', '', $i);
							
							if($i[0] == '"'){
								$i = substr($i, 1);
								
								$pos = strpos($i, '"');
								if($pos === false){
									continue;
								}
								
								$value = substr($i, 0, $pos);
								$i = substr($i, $pos + 1);
							} else if($i[0] == "'"){
								$i = substr($i, 1);
								
								$pos = strpos($i, "'");
								if($pos === false){
									continue;
								}
								
								$value = substr($i, 0, $pos);
								$i = substr($i, $pos + 1);
							} else {
								if(preg_match('@^(?<value>[^\x9\xA\xC\xD\x20"\'=<>`]+)@isuDX', $i, $value)){
									$value = $value['value'];
									$i = substr($i, strlen($value));
								} else {
									continue;
								}
							}
							
							// skip space characters
							$i = preg_replace('@^[\x9\xA\xC\xD\x20]+@isuDX', '', $i);
						}
						
						$attrsArr[strtolower($name)] = $value;
					}
				}
				
				switch($this -> tags_markup[$tag]){
					case 'v':{
						$lastClosed = $tag;
						$p[++$n] = array(
							'name' => $tag,
							'attributes' => $attrsArr,
							'parent' => $parentID[$t - 1],
						);
						break;
					}
					case 'r':
					case 'e':
					case 'f':{
						// raw text element
						$pos = strpos($i, '</' . $tag . '>');
						$content = substr($i, 0, $pos);
						$p[$n + 1] = array(
							'name' => $tag,
							'attributes' => $attrsArr,
							'content' => array(
								($n + 2) => array(
									'name' => 'TEXT',
									'content' => $content,
								),
							),
							'parent' => $parentID[$t - 1],
						);
						$lastClosed = $tag;
						$n += 2;
						$i = substr($i, $pos + strlen($tag) + 3);
						break;
					}
					
					default:{
						// increase indentation level
						$l[++$t] = &$p;
						$parentID[$t] = $n + 1;
						$p[++$n] = array(
							'name' => $tag,
							'attributes' => $attrsArr,
							'parent' => $parentID[$t - 1],
						);
						$p = &$p[$n]['content'];
						break;
					}
				}
				
				continue;
			}
			
			if(preg_match('@^/(?<tag>[a-z0-9]+)>@isuDX', $i, $m)){
				$tag = $m['tag'];
				
				// get rid of spaces around nonpalpable elements
				if(!in_array($tag, $this -> tags_palpable) && $p[$n]['name'] === 'TEXT'){
					$p[$n]['content'] = preg_replace('@[\x9\xA\xC\xD\x20]+$@isuDX', '', $p[$n]['content']);
					if($p[$n]['content'] === ''){
						unset($p[$n--]);
					}
				}
				
				// add html element if ommited
				if($tags_open['html'] === null){
					// open html
					$l[++$t] = &$p;
					$parentID[$t] = $n + 1;
					$p[++$n] = array(
						'name' => 'html',
						'attributes' => array(),
						'parent' => $parentID[$t - 1],
					);
					$p = &$p[$n]['content'];
					$tags_open['html'] = true;
				}
				
				// add head element if ommited
				if($tags_open['head'] === null && $tag !== 'html'){
					// open head
					$l[++$t] = &$p;
					$parentID[$t] = $n + 1;
					$p[++$n] = array(
						'name' => 'head',
						'attributes' => array(),
						'parent' => $parentID[$t - 1],
					);
					$p = &$p[$n]['content'];
					$tags_open['head'] = true;
				}
				
				$i = substr($i, 1);
				
				if($t > 0){
					// decrease indentation level
					$p = &$l[$t--];
					array_pop($parentID);
				}
				
				$i = substr($i, strlen($tag) + 1);
				
				// close tag
				$lastClosed = $tag;
				$tags_open[$tag] = false;
				
				continue;
			}
			
			// assertion
			$i = substr($i, 1);
		}
		
		$this -> array = $o;
	}
	
	// parses array form of code into the string minified form of HTML5 code
	public function minify(){
		if(func_num_args() == 1){
			// recursion made with a given branch of tree
			$i = func_get_arg(0);
		} else {
			// initial, we take the whole tree as for now
			$this -> string = '';
			$i = $this -> array;
		}
		
		$len = count($i);
		$keys = array_keys($i);
		for($n = 0; $n < $len; ++$n){
			$element = $i[$keys[$n]];
			
			switch($element['name']){
				case 'DOCTYPE':{
					// we use recommended, shortest declaration
					$this -> string .= '<!doctype html>';
					break;
				}
				
				case 'TEXT':{
					// just spit the text (plain in this form)
					$this -> string .= $element['content'];
					break;
				}
				
				default:{
					// ommite open tags when possible
					$skipTagOpen = false;
					
					if(in_array($element['name'], array(
						'html', 'head', 'body'
					)) && empty($element['attributes'])){
						$skipTagOpen = true;
					} else
					
					if(in_array($element['name'], array(
						'colgroup', 'tbody'
						/* colgroup may contain only col, and since comments are ate, we dont have to check if the 1st element is col */
						/* tbody may contain only tr, and since comments are ate, we dont have to check if the 1st element is tr */
						
						/* anyway, we have to check if element isnt empty and havent attributes */
					)) && !empty($element['content']) && empty($element['attributes'])){
						$skipTagOpen = true;
					}
					
					if(!$skipTagOpen){
						$this -> string .= '<' . $element['name'];
						
						foreach($element['attributes'] as $attribute_name => $attribute_value){
							// parse tag attributes
							$this -> string .= ' ' . $attribute_name . '=';
							
							if(preg_match('@^[^\x9\xA\xC\xD\x20"\'=<>`]+$@isuDX', $attribute_value)){
								$this -> string .= $attribute_value;
							} else {
								$this -> string .= '"' . str_replace('"', '&quot;', $attribute_value) . '"';
							}
						}
						
						$this -> string .= '>';
					}
					
					// void element, skip closing fragment
					if($this -> tags_markup[$element['name']] == 'v'){
						break;
					}
					
					// recursion with a branch of tree
					$this -> minify($element['content']);
					
					// ommite close tags when possible
					$skipTagClose = false;
					
					// since we got rid of comments and spit text out directly, we can just skip these elements as soon as they have no attributes
					if(in_array($element['name'], array(
						'html', 'head', 'body'
					)) && empty($element['attributes'])){
						$skipTagClose = true;
					} else
					
					// dt may be placed only before dd and dt, so we can skip the additional requirements for dt
					// dd may be placed only before dd, dt or at the very end of dl, so we can skip the additional requirements for dd
					// rb, rtc and rp tags may be placed only inseide ruby which allows only rb, rt, rtc and rp elements, so we can skip the additional requirements for these tags
					// option may be placed only inside select, which allows only option and optgroup, so we can skip the additional requirements for option
					// since colgroup and caption tags are not palpable, we can skip the additional requirements for these tags as they are trimmed from space characters and comments
					
					// however, we still need to check if element have not attributes
					if(empty($element['attributes']) && in_array($element['name'], array('dt', 'dd', 'rb', 'rtc', 'rp', 'option', 'colgroup', 'caption'))){
						$skipTagClose = true;
					} else
					
					if(
							$element['name'] == 'li'
						&&	(
								// we need to check if element matches requirements since LI can be placed into some menu elements
								
									$i[$keys[$n + 1]]['name'] == 'li'
								||	$n == $len - 1
						)
					){
						$skipTagClose = true;
					} else
					
					if(
							$element['name'] == 'p'
						&&	(
									// check if p is followed by one of above elements
									(in_array($i[$keys[$n + 1]]['name'], array('address', 'article', 'aside', 'blockquote', 'div', 'dl', 'fieldset', 'footer', 'form', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'header', 'hgroup', 'hr', 'main', 'menu', 'nav', 'ol', 'p', 'pre', 'section', 'table', 'ul')))
								
									// or is a last child of not a tag
								||	($n == $len - 1 && $this -> parent($element)['name'] !== 'a')
						)
					){
						$skipTagClose = true;
					} else
					
					if(
							$element['name'] == 'rt'
						&&	(
								// we need to check if element matches requirements since RT can be placed before RTC element
								
									in_array($i[$keys[$n + 1]]['name'], array('rb', 'rt', 'rp'))
								||	$n == $len - 1
						)
					){
						$skipTagClose = true;
					} else
					
					if(
							$element['name'] == 'optgroup'
						&&	(
								// we need to check if element matches requirements since OPTION can be placed before OPTGROUP element
								
									$i[$keys[$n + 1]]['name'] == 'optgroup'
								||	$n == $len - 1
						)
					){
						$skipTagClose = true;
					} else
					
					if(
							$element['name'] == 'thead'
						&&	(
								// profilactic check to avoid future changes like with footer tag allowed before header tag
								in_array($i[$keys[$n + 1]]['name'], array('tbody', 'tfoot'))
						)
					){
						$skipTagClose = true;
					} else
					
					if(
							$element['name'] == 'tbody'
						&&	(
								// profilactic check to avoid future changes like with footer tag allowed before header tag
								
									in_array($i[$keys[$n + 1]]['name'], array('tbody', 'tfoot'))
								||	$n == $len - 1
						)
					){
						$skipTagClose = true;
					} else
					
					if(
							in_array($element['name'], array('tr', 'td'))
						&&	(
								// we need to check additional requirements since td or th parent can contain script-supporting elements
								
									in_array($i[$keys[$n + 1]]['name'], array('tr', 'td'))
								||	$n == $len - 1
						)
					){
						$skipTagClose = true;
					}
					
					if(!$skipTagClose){
						$this -> string .= '</' . $element['name'] . '>';
					}
				}
			}
		}
	}
	
	// returns element parent
	public function parent($id){
		$pointer = new RecursiveArrayIterator($this -> array);
		$tags = new RecursiveIteratorIterator($pointer, RecursiveIteratorIterator :: SELF_FIRST);
		
		foreach($tags as $tagid => $tag){
			if($tagid === $id['parent']){
				return $tag;
			}
		}
	}
}

?>

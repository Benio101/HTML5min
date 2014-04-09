# HTML5min
HTML5 minifier as PHP class allowing for DOM modifications, like filtering or replacing content before minimize.

## Basic usage

    $HTML5_minified = new HTML5min($HTML5_unminified);

## Methods

    $HTML5_minifier = new HTML5min();          // initializes class
    $HTML5_minifier -> set($HTML5_unminified); // set input to operate on
    $HTML5_minifier -> add($HTML5_more_code);  // add more code to input (extends set method)
    $HTML5_minifier -> parse();                // parses input string form of HTML into array form
    $HTML5_minifier -> minify();               // parses array form of code, producing minified string of HTML code
    $HTML5_minifier -> parent($id);            // returns parent of given id element in code form (array variable)
    
## Variables
    public $input;                             // input string (raw input, unminified)
    public $array;                             // array form of HTML5 code (parsed input aftet parse())
    public string;                             // string form of HTML5 code (minified HTML5 code after minify())
    public $document = true;                   // determine if treat code as HTML document or just a HTML fragment

## Example
    $HTML5_minifier = new HTML5min();
    $HTML5_minifier -> document = false;
    
    $HTML5_minifier -> set(<<<'HTML'
        <DiV CLASS = "show case">
    		<ul Id=   '_hey'>
    			<	LI data-HREF		= "self">This	</LI>
    			<	li data-true		= ''>is		</li>
    			<       Li DATA-version	= "5">HTML	</lI>
    		</ul>
    		<p>Minifier!</p>
    	</diV>
    HTML
    );
    
    $HTML5_minifier -> parse();
    $HTML5_minifier -> minify();
    
    echo $HTML5_minifier -> string;

will output:

    <div class="show case"><ul id=_hey><li data-href=self>This<li data-true="">is<li data-version=5>HTML</ul><p>Minifier!</div>

## Restrictions
1. HTML5 input code cannot be ommited asymetric.
2. HTML fragment will be always parsed as inside a normal element.

## Notes
1. This is not an `HTML parser` or `syntax checker`, even if parses `HTML5` string.
2. This minifier is not a parser for an `XHTML` or any `XML` form of HTML markup.
3. Array form of parsed code is not a `DOM tree`, which doesnt support `HTML5`, just an array form.
4. `HTML5min` is prepared to support `HTML5` only. Usage on earlier versions of `HTML` isnt supported.
    
## Author
Benio @ [Benio.me](//benio.me)

## License
[CC BY 4](//creativecommons.org/licenses/by/4.0)

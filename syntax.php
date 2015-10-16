    <?php
    /**
     * Plugin Skeleton: Displays "Hello World!"
     *
     * Syntax: <TEST> - will be replaced with "Hello World!"
     * 
     * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
     * @author     Christopher Smith <chris@jalakai.co.uk>
     */
     
    if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
    if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
    require_once(DOKU_PLUGIN.'syntax.php');
     
    /**
     * All DokuWiki plugins to extend the parser/rendering mechanism
     * need to inherit from this class
     */
    class syntax_plugin_councilinfomation extends DokuWiki_Syntax_Plugin {
     
     
     
       /**
        * Get the type of syntax this plugin defines.
        *
        * @param none
        * @return String <tt>'substition'</tt> (i.e. 'substitution').
        * @public
        * @static
        */
        function getType(){
            return 'substition';
        }
     
        /**
         * What kind of syntax do we allow (optional)
         */
    //    function getAllowedTypes() {
    //        return array();
    //    }
     
       /**
        * Define how this plugin is handled regarding paragraphs.
        *
        * <p>
        * This method is important for correct XHTML nesting. It returns
        * one of the following values:
        * </p>
        * <dl>
        * <dt>normal</dt><dd>The plugin can be used inside paragraphs.</dd>
        * <dt>block</dt><dd>Open paragraphs need to be closed before
        * plugin output.</dd>
        * <dt>stack</dt><dd>Special case: Plugin wraps other paragraphs.</dd>
        * </dl>
        * @param none
        * @return String <tt>'block'</tt>.
        * @public
        * @static
        */
        function getPType(){
            return 'block';
        }
     
       /**
        * Where to sort in?
        *
        * @param none
        * @return Integer <tt>6</tt>.
        * @public
        * @static
        */
        function getSort(){
            return 999;
        }
     
     
       /**
        * Connect lookup pattern to lexer.
        *
        * @param $aMode String The desired rendermode.
        * @return none
        * @public
        * @see render()
        */
        function connectTo($mode) {
    //      $this->Lexer->addSpecialPattern('<council>.+?</council>',$mode,'plugin_councilinformation');
          $this->Lexer->addEntryPattern('<council>',$mode,'plugin_councilinformation');
        }
     
        function postConnect() {
          $this->Lexer->addExitPattern('</council>','plugin_councilinformation');
        }
     
     
       /**
        * Handler to prepare matched data for the rendering process.
        *
        * <p>
        * The <tt>$aState</tt> parameter gives the type of pattern
        * which triggered the call to this method:
        * </p>
        * <dl>
        * <dt>DOKU_LEXER_ENTER</dt>
        * <dd>a pattern set by <tt>addEntryPattern()</tt></dd>
        * <dt>DOKU_LEXER_MATCHED</dt>
        * <dd>a pattern set by <tt>addPattern()</tt></dd>
        * <dt>DOKU_LEXER_EXIT</dt>
        * <dd> a pattern set by <tt>addExitPattern()</tt></dd>
        * <dt>DOKU_LEXER_SPECIAL</dt>
        * <dd>a pattern set by <tt>addSpecialPattern()</tt></dd>
        * <dt>DOKU_LEXER_UNMATCHED</dt>
        * <dd>ordinary text encountered within the plugin's syntax mode
        * which doesn't match any pattern.</dd>
        * </dl>
        * @param $aMatch String The text matched by the patterns.
        * @param $aState Integer The lexer state for the match.
        * @param $aPos Integer The character position of the matched text.
        * @param $aHandler Object Reference to the Doku_Handler object.
        * @return Integer The current lexer state for the match.
        * @public
        * @see render()
        * @static
        */
        function handle($match, $state, $pos, &$handler){
        /**    switch ($state) {
              case DOKU_LEXER_ENTER : 
                break;
              case DOKU_LEXER_MATCHED :
                break;
              case DOKU_LEXER_UNMATCHED :
                break;
              case DOKU_LEXER_EXIT :
                break;
              case DOKU_LEXER_SPECIAL :
                break;
            } */
            
            $paramString = substr($match,9,-10);
            
            $params = array(
                'name'      => 'N.N.',
                'adress'    => 'N.N.',
                'country'   => 'N.N.',
                'phone'     => 'N.N.',
                'email'     => 'N.N.'
            );
            
            //----- parse parameteres into name="value" pairs  
            preg_match_all("/(\w+?)=\"(.*?)\"/", $parameterStr, $regexMatches, PREG_SET_ORDER);
            
            for ($i = 0; $i < count($regexMatches); $i++) {
                $name  = strtoupper($regexMatches[$i][1]);
                $value = $regexMatches[$i][2];
                
                if(strcmp($name, "NAME")==0){
                    $params['title'] = hsc(trim($value));
                } else
                if(strcmp($name, "ADRESS")==0){
                    $params['adress'] = hsc(trim($value));
                } else
                if(strcmp($name, "COUNTRY")==0){
                    $params['country'] = hsc(trim($value));
                } else
                if(strcmp($name, "PHONE")==0){
                    $params['phone'] = hsc(trim($value));
                } else
                if(strcmp($name, "EMAIL")==0){
                    $params['email'] = hsc(trim($value));
                }
            }
            
            return $params;
        }
     
       /**
        * Handle the actual output creation.
        *
        * <p>
        * The method checks for the given <tt>$aFormat</tt> and returns
        * <tt>FALSE</tt> when a format isn't supported. <tt>$aRenderer</tt>
        * contains a reference to the renderer object which is currently
        * handling the rendering. The contents of <tt>$aData</tt> is the
        * return value of the <tt>handle()</tt> method.
        * </p>
        * @param $aFormat String The output format to generate.
        * @param $aRenderer Object A reference to the renderer object.
        * @param $aData Array The data created by the <tt>handle()</tt>
        * method.
        * @return Boolean <tt>TRUE</tt> if rendered successfully, or
        * <tt>FALSE</tt> otherwise.
        * @public
        * @see handle()
        */
        function render($mode, &$renderer, $data) {
            if($mode == 'xhtml'){
                $table = "<table>
                        <thead>
                            <tr class='row0'>
                                <th class='col0'> Name </th>
                                <th class='col1'> Address </th>
                                <th class='col2'> Country </th>
                                <th class='col3'> Phone number </th>
                                <th class='col4'> Email address </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class='row1'>
                                <th class='col0'> ".$data['name']." </th>
                                <th class='col1'> ".$data['adress']." </th>
                                <th class='col2'> ".$data['country']." </th>
                                <th class='col3'> ".$data['phone']." </th>
                                <th class='col4'> ".$data['email']." </th>
                            </tr>
                        </tbody>
                    </table>";
                
                $renderer->doc .= $table;            // ptype = 'normal'
    //            $renderer->doc .= "<p>Hello World!</p>";     // ptype = 'block'
                return true;
            }
            return false;
        }
    }
     
    //Setup VIM: ex: et ts=4 enc=utf-8 :
    ?>


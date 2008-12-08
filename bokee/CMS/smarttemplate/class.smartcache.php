<?php
    /**
    * SmartCache Class
    * 
    * Provides basic methods for abstract content reuse
    *
    *
    * Usage Example I:
    * (Cache complete page output)
    *
    * $cache  =  new SmartCache();                                         //  Instantiate SmartCache Object (If no key is given, the REQUEST_URI is referenced)
    * $cache->start();                                                     //  If valid page output is available, print it and quit execution
    * 
    * ...                                                                  //  Otherwise proceed with script execution
    *
    *
    * Usage Example II:
    * (Cache html fragments, e.g static parts of your website)
    *
    * $path  =  "./";
    * $data  =  new SmartCache( "Cache Container for Directory $path" );  //  Instantiate SmartCache Object
    * if (!$html_output = $data->read())                                  //  Check if any reusable content is available and read it
    * {
    *     $folder_array  =  read_whole_directory_into_array( $path );     //  Call some fictitious, time-consuming 
    *     $html_output   =  create_html_tree_from_array( $folder_array);  //  functions to (re-)create content
    *     ...
    *     $data->write($html_output);                                     //  For later reuse, attach content to SmartCache Object
    * }
    * echo $html_output;                                                  //  Print content
    *
    *
    * Usage Example III:
    * (Cache any kind of complex content, like Database results)
    *
    * $query  =  "select * from ... where ...";                           //  Some fictitious, database stressing query
    * $data   =  new SmartCache( $query );                                //  Instantiate SmartCache Object ($query is used as a key)
    * if (!$result = $data->read( 120 ))                                  //  Check if the query was executed within the last two minutes
    * {
    *     result  =  $db->exec( $query );                                 //  Execute query, read result
    *     ...
    *     $data->write( $result );                                        //  For later reuse, attach result to SmartCache Object
    * }
    * do_whatever_you_like_with ( $result );                              //  Proceed with database result
    *
    *
    * @author Philipp v. Criegern philipp@criegern.com
    * @version 1.02 14.06.2002
    */
    class SmartCache
    {
        /**
        * Temporary folder for content storage
        * Can be overwritten by global configuration array $_CONFIG['cache_dir']
        *
        * @access public
        */
        var $cache_dir  =  '/tmp/';

        /**
        * Default Cache Lifetime in Seconds
        * Can be overwritten by global configuration array $_CONFIG['cache_lifetime']
        *
        * @access public
        */
        var $lifetime   =  600;

        /**
        * @access private
        */
        var $filename;

        /**
        * SmartCache Constructor
        *
        * @access public
        * @param mixed $key Unique Container Key
        * @return void
        */
        function SmartCache ( $key = '' )
        {
            global $_CONFIG;

            if (!empty($_CONFIG['cache_dir']))
            {
                $this->cache_dir  =  $_CONFIG['cache_dir'];
            }
            if (is_numeric($_CONFIG['cache_lifetime']))
            {
                $this->lifetime  =  $_CONFIG['cache_lifetime'];
            }
            if (empty($key))
            {
                $key  =  $_SERVER['REQUEST_URI'];
            }
            $this->filename  =  'cache_' . md5(serialize($key)) . '.ser';
        }


        /**
        * Start Ouput Content Buffering
        *
        * @access public
        * @param int $timeout Previously stored content is only considered valid if not older than [timeout] seconds
        * @return void
        */
        function start( $timeout = 0 )
        {
            if (empty($_POST)  &&  $_SERVER['HTTP_CACHE_CONTROL'] != 'no-cache')
            {
                if ($output = $this->read($timeout))
                {
                    exit ($output);
                }
                else
                {
                    ob_start( array( &$this, 'callback' ) );
                }
            }
        }

        /**
        * Check if any reusable content is available for this specific Cache Container and read it
        *
        * @access public
        * @param int $timeout Previously stored content is only considered valid if not older than [timeout] seconds
        * @return mixed
        */
        function read ( $timeout = 0 )
        {
            if (is_numeric($timeout))
            {
                $this->lifetime  =  $timeout;
            }
            if (@is_file($this->cache_dir . $this->filename))
            {
                if ((time() - filemtime($this->cache_dir . $this->filename)) < $this->lifetime)
                {
                    if ($hd = @fopen($this->cache_dir . $this->filename, "r"))
                    {
                        $serialized  =  fread($hd, filesize($this->cache_dir . $this->filename));
                        fclose($hd);
                        return unserialize($serialized);
                    }
                }
            }
        }

        /**
        * Write Content for later reuse
        *
        * @access public
        * @param mixed $content
        * @return void
        */
        function write ( $content )
        {
            if ($hd = @fopen($this->cache_dir . $this->filename, 'w'))
            {
                fputs($hd,  serialize($content));
                fclose($hd);
            }
        }

        /**
        * Delete Cache Container to force content recreation on next call
        *
        * @access public
        * @return void
        */
        function remove ()
        {
            if (is_file($this->cache_dir . $this->filename))
            {
                unlink($this->cache_dir . $this->filename);
            }
        }

        /**
        * Output Buffer Callback Function
        *
        * @access private
        * @param string $output
        * @return string $output
        */
        function callback ( $output )
        {
            $this->write($output);
            return $output;
        }

    }


?>
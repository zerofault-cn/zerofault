<?php

    /**
    * SmartConfig Class
    * 
    * Reads an INI-Style configuration file into an array
    *
    *
    * Usage Example:
    *
    * $ini  =  new SmartConfig();
    * $_CONFIG  =  $ini->read('global_config.ini');
    * ...
    * $db_id  =  mysql_connect(
    *                $_CONFIG['database']['hostname'], 
    *                $_CONFIG['database']['username'], 
    *                $_CONFIG['database']['password']
    *            );
    * echo '<h1>' . $_CONFIG['Site-Name'] . '</h1>';
    * echo '<p> Contact: <a href="mailto:' . $_CONFIG['Contact'] . '">' . $_CONFIG['Author'] . '</a></p>';
    * ...
    *
    *
    * Sample INI-File 'global_config.ini':
    *
    * Site-Name      =  My Demo Website
    * Author         =  Philipp v. Criegern
    * Contact        =  philipp@criegern.com
    * 
    * [database]
    * hostname       =  localhost
    * username       =  testuser
    * password       =  *******
    *
    *
    * @author Philipp v. Criegern philipp@criegern.com
    * @version 1.00 08.02.2002
    */
    class SmartConfig
    {
        /**
        * Whether to store parsed INI-File as a serialized array for later reuse
        *
        * @access public
        */
        var $use_cache  =  true;

        /**
        * Name of the INI-File
        *
        * @access public
        */
        var $filename;

        /**
        * SmartConfig Constructor
        *
        * @access public
        * @param string $filename INI-File to be parsed
        */
        function SmartConfig ( $filename = '' )
        {
            if (!empty($filename))
            {
                $this->filename  =  $filename;
            }
        }

        /**
        * Read and parse INI-File
        *
        * @access public
        * @param string $template_filename Template Filename
        * @return array
        * @desc Read and parse INI-File
        */
        function read ( $filename = '' )
        {
            if (!empty($filename))
            {
                $this->filename  =  $filename;
            }
            if (is_file($this->filename))
            {
                if ($this->use_cache)
                {
                    //  Create Filename for serialized array (/path/to/config.ini -> /path/to/config.ini.ser)
                    $cache_filename  =  $this->filename . '.ser';
                    if (is_file($cache_filename))
                    {
                        if (filemtime($cache_filename) >= filemtime($this->filename))
                        {
                            if ($hd = @fopen($cache_filename, "r"))
                            {
                                $serialized  =  fread($hd, filesize($cache_filename));
                                fclose($hd);
                                return unserialize($serialized);
                            }
                        }
                    }
                }
                $cfgfile  =  file($this->filename);
                foreach ($cfgfile as $line)
                {
                    if (substr($line,  0,  1) != '#')
                    {
                        if (substr($line,  0,  1) == '[')
                        {
                            if ($rbr = strpos($line, ']'))
                            {
                                $section  =  substr($line,  1,  $rbr -1);
                            }
                        }
                        if ($tr = strpos($line, '='))
                        {
                            $k  =  trim(substr($line, 0, $tr));
                            $v  =  trim(substr($line, $tr+1));
                            if (isset($section))
                            {
                                $cfg[$section][$k]  =  $v;
                            }
                            else
                            {
                                $cfg[$k]  =  $v;
                            }
                        }
                    }
                }
                if ($this->use_cache)
                {
                    if ($hd = fopen($cache_filename, 'w'))
                    {
                        fputs($hd,  serialize($cfg));
                        fclose($hd);
                    }
                }
                return $cfg;
            }
        }
    }
?>
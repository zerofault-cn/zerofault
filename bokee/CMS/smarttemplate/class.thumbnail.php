<?php
    /**
    * Thumbnail Class
    *
    * Creates resized (preview-) images
    *
    * Usage Example:
    * $img = new Thumbnail();
    * echo $img->create_tag("../images/photos/sunflower.jpg");
    *
    * @author   Philipp v. Criegern <criegep@criegern.com>
    * @version  1.0 20.02.2002
    */
    class Thumbnail
    {
        /**
        * Directory where the created thumbnails are stored in (for PHP access)
        * e.g. '/usr/local/apache/htdocs/images/thumbnails'
        * Can be overwritten by global configuration array $_CONFIG['thumbnail_dir_internal']
        *
        * @access public
        */
        var $thumbnail_dir_internal  =  '';

        /**
        * Path to thumbnail directory for browser access
        * e.g. '/images/thumbnails'
        * Can be overwritten by global configuration array $_CONFIG['thumbnail_dir_external']
        *
        * @access public
        */
        var $thumbnail_dir_external  =  '';

        /**
        * Maximum pixel width of created thumbnail
        *
        * @access public
        */
        var $max_width               =  120;

        /**
        * Maximum pixel height of created thumbnail
        *
        * @access public
        */
        var $max_height              =  120;

        /**
        * File name of created thumbnail
        * e.g. 'sunflower.png'
        *
        * @access public
        */
        var $image_name;

        /**
        * Complete image tag for created thumbnail
        * e.g. '<img src="/images/thumbnails/sunflower.png" width="120" height="80" border="0">'
        *
        * @access public
        */
        var $image_tag;

        /**
        * Error message if creation fails
        *
        * @access public
        */
        var $error;

        /**
        * Pixel width of created thumbnail
        *
        * @access public
        */
        var $width;

        /**
        * Pixel height of created thumbnail
        *
        * @access public
        */
        var $height;


        /**
        * Thumbnail Constructor
        *
        * @access public
        */
        function Thumbnail ()
        {
            global $_CONFIG;

            if (!empty($_CONFIG['thumbnail_dir_internal']))
            {
                $this->thumbnail_dir_internal  =  $_CONFIG['thumbnail_dir_internal'];
            }
            if (!empty($_CONFIG['thumbnail_dir_external']))
            {
                $this->thumbnail_dir_external  =  $_CONFIG['thumbnail_dir_external'];
            }
        }

        /**
        * Create Thumbnail and return Image Name
        *
        * @access public
        * @param string $parameter Filename of source image
        * @return string Filename of created thumbnail
        */
        function create_name ( $parameter = '' )
        {
            $this->create( $parameter );
            return $this->image_name;
        }

        /**
        * Create Thumbnail and return Image Tag
        *
        * @access public
        * @param string $parameter Filename of source image
        * @return string Complete HTML Image-Tag of created thumbnail
        */
        function create_tag ( $parameter = '' )
        {
            $this->create( $parameter );
            return $this->image_tag;
        }

        /**
        * Create Thumbnail
        *
        * @access private
        * @param string $parameter Filename of source image
        * @return void
        */
        function create ( $imagefile )
        {
            if (strlen($this->thumbnail_dir_internal)  &&  (substr($this->thumbnail_dir_internal, -1) != '/'))
            {
                $this->thumbnail_dir_internal  .=  '/';
            }
            if (strlen($this->thumbnail_dir_external)  &&  (substr($this->thumbnail_dir_external, -1) != '/'))
            {
                $this->thumbnail_dir_external  .=  '/';
            }
            $tmp_name  =  basename($imagefile);
            if (strtolower(substr($tmp_name, -4)) == '.jpg')
            {
                $this->image_name  =  substr($tmp_name, 0, -4) . '.png';
                if (!is_file($this->thumbnail_dir_internal . $this->image_name))
                {
                    $old    =  ImageCreateFromJPEG($imagefile);
                    $old_w  =  ImageSX($old);
                    $old_h  =  ImageSY($old);
                    $this->width   =  $old_w;
                    $this->height  =  $old_h;
                    if ($this->max_width  &&  ($this->width > $this->max_width))
                    {
                        $this->height  =  round($this->height * $this->max_width / $this->width);
                        $this->width   =  $this->max_width;
                    }
                    if ($this->max_height  &&  ($this->height > $this->max_height))
                    {
                        $this->width   =  round($this->width * $this->max_height / $this->height);
                        $this->height  =  $this->max_height;
                    }
                    $new  =  imagecreate($this->width, $this->height);
                    imagecopyresized($new, $old, 0,0, 0,0, $this->width, $this->height, $old_w, $old_h);
                    ImageJPEG($new, $this->thumbnail_dir_internal . $this->image_name);
                    ImageDestroy($new);
                    ImageDestroy($old);
                }
                else
                {
                    $arr  =  getimagesize($this->thumbnail_dir_internal . $this->image_name);
                    $this->width   =  $arr[0];
                    $this->height  =  $arr[1];
                }
                $this->image_tag  =  '<IMG SRC="' . $this->thumbnail_dir_external . $this->image_name 
                                   . '" WIDTH="'  . $this->width
                                   . '" HEIGHT="' . $this->height
                                   . '" BORDER="0">';
            }
            else
            {
                $this->error  =  "Filetype not JPG";
            }
        }
    }

?>
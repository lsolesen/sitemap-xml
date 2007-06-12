<?php
/**
 * A class for generating sitemaps
 *
 * Helper class to create sitemap in the special format supported by MSN, Yahoo and Google.
 * More information can be found on {@link http://www.sitemaps.org/}.
 *
 * @package   Services_Sitemap
 * @author    Svetoslav Marinov <svetoslav.marinov@gmail.com>
 * @copyright 2005
 * @version   @package-version@
 * @link      http://devquickref.com
 */

/**
 * A class for generating simple google sitemaps
 *
 * <code>
 *
 * </code>
 *
 * @package   Services_Sitemap
 * @author    Svetoslav Marinov <svetoslav.marinov@gmail.com>
 * @copyright 2005
 * @version   @package-version@
 * @link      http://devquickref.com
 */
class Services_Sitemap
{
    private $header = "<\x3Fxml version=\"1.0\" encoding=\"UTF-8\"\x3F>\n<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">";
    public $charset = "UTF-8";
    private $footer = "</urlset>\n";
    private $items = array();

    public function __construct()
    {

    }

    /**
     * Adds a new item to the channel contents
     *
     * @param google_sitemap item $new_item
     *
     */
    public function add_item(Services_Sitemap_Item $new_item){
        $this->items[] = $new_item;
    }

    /**
     * Generates the sitemap XML data based on object properties.
     *
     * @param string $file_name ( optional ) if file name is supplied the XML data is saved in it otherwise returned as a string.
     *
     * @return [void|string]
     */
    public function build( $file_name = null )
    {
        $map = $this->header . "\n";

        foreach ($this->items as $item) {
            $item->loc = htmlentities($item->loc, ENT_QUOTES);
            $map .= "<url>\n<loc>$item->loc</loc>\n";

            // lastmod
            if ( !empty( $item->lastmod ) )
                $map .= "<lastmod>$item->lastmod</lastmod>\n";

            // changefreq
            if ( !empty( $item->changefreq ) )
                $map .= "<changefreq>$item->changefreq</changefreq>\n";

            // priority
            if ( !empty( $item->priority ) )
                $map .= "<priority>$item->priority</priority>\n";

            $map .= "</url>\n\n";
        }

        $map .= $this->footer . "\n";

        if(!is_null($file_name)){
            $fh = fopen($file_name, 'w');
            fwrite($fh, $map);
            fclose($fh);
        } else {
            return $map;
        }
    }

}

/**
 *
 * A class for storing google_sitemap items and will be added to google_sitemap objects.
 *
 * @author Svetoslav Marinov <svetoslav.marinov@gmail.com>
 * @copyright 2005
 * @access public
 * @package google_sitemap_item
 * @link http://devquickref.com
 * @version 0.1
 */
class Services_Sitemap_Item
{
  /**
   * Assigns constructor parameters to their corresponding object properties.
   *
   * @param string $loc location
   * @param string $lastmod date (optional) format in YYYY-MM-DD or in "ISO 8601" format
   * @param string $changefreq (optional)( always,hourly,daily,weekly,monthly,yearly,never )
   * @param string $priority (optional) current link's priority ( 0.0-1.0 )
   *
   * @return void
   */
    function __construct( $loc, $lastmod = '', $changefreq = '', $priority = '' )
    {
        $this->loc = $loc;
        $this->lastmod = $lastmod;
        $this->changefreq = $changefreq;
        $this->priority = $priority;
    }
}


?>
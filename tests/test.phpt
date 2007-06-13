--TEST--
Sitemap test
--FILE--
<?php
        // PHP google_sitemap Generator
require '../Sitemap.php';

        // these day may be retrieved from DB
        $cats[] = array(
                            "loc" => "php-tips.devquickref.com/php-tips.html",
                            "changefreq" => "weekly",
                            "priority"  => 0.8,
        );

        $cats[] = array(
                            "loc" => "perl-tips.devquickref.com/perl-tips.html",
                            "changefreq" => "weekly",
                            "priority"  => 0.8,
        );

        $site_map_container = new Services_Sitemap();

        for ( $i=0; $i < count( $cats ); $i++ )
        {
            $value = $cats[ $i ];

            $site_map_item =& new Services_Sitemap_Item(
                 $value[ 'loc' ]
                , ""
                , $value[ 'changefreq' ]
                , $value[ 'priority' ]
            );

            $site_map_container->add_item( $site_map_item );
        }

        header( "Content-type: application/xml; charset=\"".$site_map_container->charset . "\"", true );
        header( 'Pragma: no-cache' );

        print $site_map_container->build();


?>
--EXPECT--
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url>
<loc>php-tips.devquickref.com/php-tips.html</loc>
<changefreq>weekly</changefreq>
<priority>0.8</priority>
</url>

<url>
<loc>perl-tips.devquickref.com/perl-tips.html</loc>
<changefreq>weekly</changefreq>
<priority>0.8</priority>
</url>

</urlset>